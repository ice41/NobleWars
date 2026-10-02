<?php
/**
 * Research Automation AJAX Endpoint
 * Called periodically by JavaScript from any game page
 */

// Give the script enough time on slow servers
set_time_limit(30);

// Disable all error/warning output — any stray text would corrupt the JSON response
error_reporting(0);
ini_set('display_errors', '0');// Buffer everything so stray output from config files is discarded before we send JSON
ob_start();

// Bootstrap: defines NOBLEWARS_APP_DIR, NOBLEWARS_ROOT_DIR and loads helpers via CoreFetcher
require_once __DIR__ . '/../../app/bootstrap_ajax.php';

// Change to public directory so relative requires in config files resolve correctly
$originalDir = getcwd();
chdir(__DIR__ . '/..');

// Load server config ($conf array) and world constants (caminhos absolutos para cross-platform)
require_once(__DIR__ . '/../configs/config.php');
require_once(__DIR__ . '/../modelo/lib/world_constants.php');

chdir($originalDir);

// Discard any stray output from config loading, then set JSON header
ob_end_clean();
header('Content-Type: application/json');

use App\Core\Database;
use App\Models\SessionModel;
try {
    // Get world parameter - supports both numeric and alphanumeric world names (e.g. '1', 'casual1')
    $server = isset($_GET['world']) ? $_GET['world'] : '1';
    // Strip only characters that are not alphanumeric/underscore for safety
    $server = preg_replace('/[^a-zA-Z0-9_]/', '', $server);
    if (empty($server)) $server = '1';
    $worldDb = get_world_db_name($server);

    // The session cookie name is dynamic: 'session_<world>' (set by set_session_cookie()).
    // Try the world-specific cookie first, then fall back to generic 'session'.
    $sessionCookieValue = $_COOKIE['session_' . $server]
        ?? $_COOKIE['session']
        ?? null;

    if (!$sessionCookieValue) {
        echo json_encode(['success' => false, 'error' => 'Not authenticated - no cookie']);
        exit;
    }

    // Validate session
    $sessionModel = new SessionModel($worldDb);
    $session = $sessionModel->checkSession($sessionCookieValue);

    if (!$session) {
        echo json_encode(['success' => false, 'error' => 'Not authenticated - invalid session']);
        exit;
    }

    $userId = $session['userid'];
    $db = Database::getInstance($worldDb, get_world_db_host(get_active_world()), get_world_db_user(get_active_world()), get_world_db_pass(get_active_world()));

    // Process research
    $processed = 0;
    $started = 0;

    // 1. PROCESS COMPLETED RESEARCH
    $completedResearch = $db->fetchAll(
        "SELECT r.id, r.research, r.villageid, r.end_time 
         FROM research r
         INNER JOIN villages v ON v.id = r.villageid
         WHERE v.userid = ? AND r.end_time <= ?",
        [$userId, time()]
    );

    foreach ($completedResearch as $research) {
        $researchUnit = $research['research'];

        // Normalize unit name: strip any existing "unit_" prefix then always re-add it.
        // DB columns are always "unit_X_tec_level". The research.research column may contain
        // "unit_spear" (Smith inserts) or "spear" (legacy). Both must produce "unit_spear_tec_level".
        $unitBase   = str_replace('unit_', '', $researchUnit);
        $columnName = 'unit_' . $unitBase . '_tec_level';

        // Update tech level
        $db->query(
            "UPDATE villages SET `$columnName` = `$columnName` + 1 WHERE id = ?",
            [$research['villageid']]
        );

        // Delete completed research
        $db->query("DELETE FROM research WHERE id = ?", [$research['id']]);

        // Delete corresponding event
        $db->query(
            "DELETE FROM events WHERE event_id = ? AND event_type = 'research'",
            [$research['id']]
        );

        $processed++;
    }

    // 2. START NEW RESEARCH FROM QUEUES
    $villages = $db->fetchAll(
        "SELECT DISTINCT v.* 
         FROM villages v
         INNER JOIN research_queue rq ON rq.villageid = v.id
         WHERE v.userid = ?
         AND NOT EXISTS (
             SELECT 1 FROM research r WHERE r.villageid = v.id
         )",
        [$userId]
    );

    foreach ($villages as $village) {
        // Get first queue item
        $queueItem = $db->fetch(
            "SELECT id, unit, level FROM research_queue WHERE villageid = ? ORDER BY id ASC LIMIT 1",
            [$village['id']]
        );

        if (!$queueItem)
            continue;

        $unit = 'unit_' . $queueItem['unit'];
        $targetLevel = $queueItem['level'];
        $currentLevel = $village[$unit . '_tec_level'] ?? 0;
        $maxLevel = 10;

        // Check if max or target reached
        if ($currentLevel >= $maxLevel || $currentLevel >= $targetLevel) {
            $db->query("DELETE FROM research_queue WHERE id = ?", [$queueItem['id']]);
            continue;
        }

        // Calculate costs
        $baseCost = ['wood' => 800, 'stone' => 600, 'iron' => 1000];
        $costMultiplier = pow(1.2, $currentLevel);
        $costs = [
            'wood' => floor($baseCost['wood'] * $costMultiplier),
            'stone' => floor($baseCost['stone'] * $costMultiplier),
            'iron' => floor($baseCost['iron'] * $costMultiplier)
        ];

        // Check resources
        if (
            $village['r_wood'] < $costs['wood'] ||
            $village['r_stone'] < $costs['stone'] ||
            $village['r_iron'] < $costs['iron']
        ) {
            continue;
        }

        // Deduct resources
        $db->query(
            "UPDATE villages SET 
             r_wood = r_wood - ?,
             r_stone = r_stone - ?,
             r_iron = r_iron - ?
             WHERE id = ?",
            [$costs['wood'], $costs['stone'], $costs['iron'], $village['id']]
        );

        // Calculate duration
        $worldConfig = \App\Helpers\WorldConfig::load();
        $speed = $worldConfig['speed'] ?? 1;
        $baseTime = 3600;
        $duration = ceil(($baseTime * $costMultiplier / ($village['smith'] * 0.1 + 1)) / $speed);

        $endTime = time() + $duration;

        // Map unit name
        $dbUnit = $queueItem['unit'];
        if ($dbUnit === 'marcher') {
            $dbUnit = 'cav_archer';
        }

        // Insert research
        $db->query(
            "INSERT INTO research (research, villageid, end_time) VALUES (?, ?, ?)",
            ['unit_' . $dbUnit, $village['id'], $endTime]
        );

        $researchId = $db->lastInsertId();

        // Create event
        $db->query(
            "INSERT INTO events (event_type, event_time, event_id, villageid, user_id) 
             VALUES ('research', ?, ?, ?, ?)",
            [$endTime, $researchId, $village['id'], $userId]
        );

        $started++;
    }

    echo json_encode([
        'success' => true,
        'processed' => $processed,
        'started' => $started,
        'timestamp' => date('H:i:s')
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => explode("\n", $e->getTraceAsString())
    ]);
} catch (Error $e) {
    // Catch PHP 7+ errors
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => explode("\n", $e->getTraceAsString())
    ]);
}

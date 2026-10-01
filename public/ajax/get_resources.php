<?php
/**
 * AJAX endpoint to get updated village resources
 * Returns JSON with current resource levels (Projected)
 * READ-ONLY: Does not update database, just calculates projection
 */

// Disable error display
ini_set('display_errors', 0);
error_reporting(0);

// Bootstrap AJAX: define constantes e inicializa CoreFetcher/autoloader
require_once __DIR__ . '/../../app/bootstrap_ajax.php';

use App\Core\Database;

header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
header('Pragma: no-cache'); // HTTP 1.0.
header('Expires: 0'); // Proxies.

// Get parameters
$villageId = isset($_GET['village']) ? (int) $_GET['village'] : 0;
$world = isset($_GET['world']) ? $_GET['world'] : (\App\Core\Database::getWorldDbName());

if (!$villageId) {
    echo json_encode(['error' => 'No village ID']);
    exit;
}

try {
    // Session validation using the 'sessions' table in the WORLD Database
    $db = Database::getInstance($world);

    // Determine world number for cookie name (e.g. "lan_1" → "1")
    $worldNum = preg_replace('/[^0-9]/', '', $world ?: '1') ?: '1';

    // Try world-specific cookie first (e.g. session_1), then legacy generic cookie
    $sessionSid = $_COOKIE['session_' . $worldNum]
        ?? $_COOKIE['session']
        ?? '';

    $sessionData = $db->fetch("SELECT userid FROM sessions WHERE sid = ?", [$sessionSid]);

    if (!$sessionData) {
        echo json_encode(['error' => 'Invalid session']);
        exit;
    }

    $db = Database::getInstance($world);

    // Fetch current village data (including userid to verify ownership)
    $village = $db->fetch(
        "SELECT id, userid, r_wood, r_stone, r_iron, r_bh, storage, farm, last_prod_aktu, wood, stone, iron, bonus FROM villages WHERE id = ?",
        [$villageId]
    );

    if (!$village) {
        echo json_encode(['error' => 'Village not found']);
        exit;
    }

    // Security check: ensure the village belongs to the session user
    if ($village['userid'] !== $sessionData['userid']) {
        echo json_encode(['error' => 'Permission denied']);
        exit;
    }

    // Get world configuration for production
    global $config;
    if (!isset($config) || empty($config)) {
        $worldNum = isset($_GET['world']) ? preg_replace('/[^0-9]/', '', $_GET['world']) : '1';
        $config = require __DIR__ . '/../../app/Config/Worlds/' . $worldNum . '.php';
    }
    $speed = $config['speed'];
    $arr_production = $config['arr_production'];
    $arr_maxstorage = $config['arr_maxstorage'];

    // Override level 30 storage if needed (fix for user request)
    if (isset($arr_maxstorage[30]) && $arr_maxstorage[30] !== 400000) {
        $arr_maxstorage[30] = 400000;
    }

    // Max Storage
    $max_storage = isset($arr_maxstorage[$village['storage']]) ? (int) $arr_maxstorage[$village['storage']] : 400000;
    if ($village['storage'] === 30)
        $max_storage = 400000;

    // Calculate time difference
    $now = time();
    $last_update = (int) $village['last_prod_aktu'];
    $time_diff = $now - $last_update;

    // Initial values from DB
    $current_wood = (double) $village['r_wood'];
    $current_stone = (double) $village['r_stone'];
    $current_iron = (double) $village['r_iron'];

    // Calculate Production
    $wood_prod_level = $village['wood'];
    $stone_prod_level = $village['stone'];
    $iron_prod_level = $village['iron'];

    $wood_per_hour = $arr_production[$wood_prod_level] * $speed;
    $stone_per_hour = $arr_production[$stone_prod_level] * $speed;
    $iron_per_hour = $arr_production[$iron_prod_level] * $speed;

    // Apply Bonus if applicable (Simplified)
    if ($village['bonus'] === 1) {
        // Legacy bonus logic usually increases storage, not production directly here, 
        // but often increases production by 30%. 
        // We will stick to base calculation to match reload_vdata basic behavior.
        // If bonus affects production, logic: $wood_per_hour *= 1.3;
    }

    if ($time_diff > 0) {
        $wood_gain = ($wood_per_hour / 3600) * $time_diff;
        $stone_gain = ($stone_per_hour / 3600) * $time_diff;
        $iron_gain = ($iron_per_hour / 3600) * $time_diff;

        $current_wood += $wood_gain;
        $current_stone += $stone_gain;
        $current_iron += $iron_gain;
    }

    // Cap resources
    $current_wood = min($current_wood, $max_storage);
    $current_stone = min($current_stone, $max_storage);
    $current_iron = min($current_iron, $max_storage);

    // Return JSON (Read-Only Projection)
    echo json_encode([
        'success' => true,
        'resources' => [
            'wood' => (int) $current_wood,
            'stone' => (int) $current_stone,
            'iron' => (int) $current_iron,
            'bh' => (int) $village['r_bh'],
            'storage' => (int) $village['storage'],
            'farm' => (int) $village['farm'],
            'max_storage' => (int) $max_storage
        ],
        'production' => [
            'wood_per_sec' => round($wood_per_hour / 3600, 2),
            'stone_per_sec' => round($stone_per_hour / 3600, 2),
            'iron_per_sec' => round($iron_per_hour / 3600, 2)
        ],
        'timestamp' => $now
    ]);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
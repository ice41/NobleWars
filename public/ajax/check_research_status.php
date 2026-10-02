<?php
// AJAX endpoint to check research status
// Returns JSON with current research queue and tech levels

session_start();
session_write_close();

require_once __DIR__ . '/../../app/bootstrap_ajax.php';

// Load config
require_once(__DIR__ . '/../configs/config.php');
require_once(__DIR__ . '/../modelo/lib/world_constants.php');
require_once(__DIR__ . '/../modelo/lib/config.php');

use App\Core\Database;
use App\Models\SessionModel;

header('Content-Type: application/json');

$server = isset($_GET['world']) ? $_GET['world'] : '1';
$server = preg_replace('/[^a-zA-Z0-9_]/', '', $server);
if (empty($server)) $server = '1';
$worldDb = get_world_db_name($server);
$villageId = isset($_GET['village']) ? (int) $_GET['village'] : 0;

if (!$villageId) {
    echo json_encode(['error' => 'No village ID']);
    exit;
}

// Session cookie is dynamic: 'session_<world>' (set by set_session_cookie())
$sessionCookieValue = $_COOKIE['session_' . $server]
    ?? $_COOKIE['session']
    ?? null;

if (!$sessionCookieValue) {
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

$sessionModel = new SessionModel($worldDb);
$session = $sessionModel->checkSession($sessionCookieValue);

if (!$session) {
    echo json_encode(['error' => 'Invalid session']);
    exit;
}

$db = Database::getInstance($worldDb, get_world_db_host(get_active_world()), get_world_db_user(get_active_world()), get_world_db_pass(get_active_world()));

// CRITICAL: Process any completed events BEFORE checking status
// This ensures research completes in real-time without page reload
use App\Services\EventProcessor;

$eventProcessor = new EventProcessor($db);
$eventProcessor->processAll(150, $session['userid'], $villageId);

// Get research queue for this village
$research_queue = $db->fetchAll(
    "SELECT id, research, end_time, trwanie FROM research WHERE villageid = ? ORDER BY id",
    [$villageId]
);

// Get current tech levels
$village = $db->fetch("SELECT * FROM villages WHERE id = ?", [$villageId]);

$valid_units = [
    'unit_spear',
    'unit_sword',
    'unit_axe',
    'unit_archer',
    'unit_spy',
    'unit_light',
    'unit_cav_archer',
    'unit_heavy',
    'unit_ram',
    'unit_catapult'
];

$tech_levels = [];
foreach ($valid_units as $unit) {
    $col = $unit . '_tec_level';
    $tech_levels[$unit] = $village[$col] ?? 0;
}

// Format queue data
$queue_data = [];
foreach ($research_queue as $q) {
    $queue_data[] = [
        'id' => $q['id'],
        'unit' => $q['research'],
        'end_time' => $q['end_time'],
        'time_left' => max(0, $q['end_time'] - time())
    ];
}

echo json_encode([
    'success' => true,
    'queue' => $queue_data,
    'tech_levels' => $tech_levels,
    'current_time' => time()
]);

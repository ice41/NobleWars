<?php
/**
 * Diagnostic page for horse race AJAX response
 * Access: /ajax/diag_horse_race.php?village=X&world=lan_1
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../app/bootstrap_ajax.php';

use App\Core\Database;

header('Content-Type: application/json');

$world = $_GET['world'] ?? Database::getWorldDbName();
$worldNum = preg_replace('/[^0-9]/', '', $world ?: '1') ?: '1';
$sessionSid = $_COOKIE['session_' . $worldNum] ?? $_COOKIE['session'] ?? '';

if (empty($sessionSid)) {
    echo json_encode(['error' => 'No session cookie found', 'cookies' => array_keys($_COOKIE)]);
    exit;
}

$db = Database::getInstance($world);
$sessionData = $db->fetch("SELECT userid FROM sessions WHERE sid = ?", [$sessionSid]);

if (!$sessionData) {
    echo json_encode(['error' => 'Invalid session', 'sid_length' => strlen($sessionSid), 'world' => $world]);
    exit;
}

$userId = $sessionData['userid'];
$eventData = $db->fetch("SELECT * FROM event_horse_race WHERE user_id = ?", [$userId]);

// Test what ob_get_level is
$ob_level = ob_get_level();
$ob_contents = ob_get_contents();

echo json_encode([
    'success' => true,
    'user_id' => $userId,
    'session_cookie_found' => 'session_' . $worldNum,
    'event_data' => $eventData,
    'ob_level_at_start' => $ob_level,
    'ob_contents_length' => strlen($ob_contents ?: ''),
    'table_exists' => $eventData !== false,
    'columns' => $eventData ? array_keys($eventData) : [],
]);
exit;

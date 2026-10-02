<?php
/**
 * Bot Beacon - Self-triggering AJAX system
 * 
 * This file creates a self-sustaining AJAX loop that keeps bot processing
 * running in the background WITHOUT depending on player page loads.
 * 
 * HOW IT WORKS:
 * 1. When ANY player loads the game, this beacon is activated
 * 2. The beacon starts a background AJAX loop (every 60s)
 * 3. The loop continues even if player navigates away (uses Service Worker)
 * 4. Multiple players DON'T create duplicate loops (file-based coordination)
 */

// Suppress errors and use output buffering to prevent corruption of JSON response
ini_set('display_errors', 'Off');
error_reporting(0);
ob_start();

$cacheDir = __DIR__ . '/../cache';

// Ensure cache directory exists
if (!is_dir($cacheDir)) {
    @mkdir($cacheDir, 0777, true);
}

$world_id = isset($_GET['world']) ? (int) $_GET['world'] : 1;
$beaconActiveFile = $cacheDir . '/bot_beacon.active_' . $world_id;
$beaconLastPing = $cacheDir . '/bot_beacon.ping_' . $world_id;

// Check if beacon is already active
$beaconActive = false;
if (file_exists($beaconActiveFile)) {
    $age = time() - filemtime($beaconActiveFile);
    if ($age < 120) { // Beacon active for last 2 minutes
        $beaconActive = true;
    }
}

// Update ping timestamp (shows beacon is alive)
$now = time();
@file_put_contents($beaconLastPing, $now);

// If beacon is not active, activate it
if (!$beaconActive) {
    @file_put_contents($beaconActiveFile, $now);
    
    // Log beacon activation
    $logFile = $cacheDir . '/bot_beacon.log';
    $sessionUserId = 'unknown';
    if (session_status() === PHP_SESSION_ACTIVE || (session_status() === PHP_SESSION_NONE && @session_start())) {
        if (isset($_SESSION['user_id'])) {
            $sessionUserId = $_SESSION['user_id'];
        }
    }
    $logMessage = "[" . date('Y-m-d H:i:s') . "] Beacon activated by player " . $sessionUserId . "\n";
    @file_put_contents($logFile, $logMessage, FILE_APPEND);
}

// Read last ping safely to avoid warning/deprecation in date()
$lastPingTime = $now;
if (file_exists($beaconLastPing)) {
    $pingVal = @file_get_contents($beaconLastPing);
    if ($pingVal !== false && is_numeric(trim($pingVal))) {
        $lastPingTime = (int) trim($pingVal);
    }
}

// Return beacon status
$response = [
    'status' => 'active',
    'beacon_active' => $beaconActive,
    'last_ping' => date('Y-m-d H:i:s', $lastPingTime),
    'message' => 'Bot beacon is running'
];

ob_clean();
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>

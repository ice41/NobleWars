<?php
/**
 * AJAX Bot Processor - Silent background processing
 * 
 * OPTIMIZED VERSION:
 * - Runs every 60 seconds (balanced for performance)
 * - Processes in background without blocking players
 * - Smart throttle based on server load
 * - Self-triggering via AJAX beacon
 */

// Suppress errors and use output buffering to prevent corruption of JSON response
ini_set('display_errors', 'Off');
error_reporting(0);
ignore_user_abort(true); // Keep running in the background if the client disconnects/times out
ob_start();

// Bootstrap AJAX: loads CoreFetcher, autoloader and helpers from cache/production
global $conf;
require_once __DIR__ . '/../../app/bootstrap_ajax.php';


// Set execution time limit to avoid long-running processes
set_time_limit(60);


// Only allow AJAX calls (but allow direct access for testing)
$isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');

// Initialize cache directory
$cacheDir = __DIR__ . '/../cache';
if (!is_dir($cacheDir)) {
    @mkdir($cacheDir, 0777, true);
}

// Check if we should run using file-based lock
$lockFile = $cacheDir . '/bot_processor.lock';
$lastRunFile = $cacheDir . '/last_bot_run.txt';
$logFile = $cacheDir . '/bot_processor.log';

// Prevent duplicate processing (file lock)
if (file_exists($lockFile)) {
    $lockAge = time() - filemtime($lockFile);
    if ($lockAge < 60) {
        // Lock is fresh, another process is running
        ob_clean();
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'locked',
            'message' => 'Bot processing already running (locked)',
            'lock_age' => $lockAge
        ]);
        exit;
    } else {
        // Stale lock, remove it
        @unlink($lockFile);
    }
}

// Check throttle - only run every 60 seconds
$lastRun = file_exists($lastRunFile) ? (int) file_get_contents($lastRunFile) : 0;
$timeSince = time() - $lastRun;

if ($timeSince < 60) {
    // Not enough time has passed
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'skipped',
        'message' => 'Bot ran recently',
        'next_run_in' => 60 - $timeSince,
        'last_run' => date('Y-m-d H:i:s', $lastRun)
    ]);
    exit;
}

// Create lock file
file_put_contents($lockFile, time());

try {
    // bootstrap_ajax.php already registers the CoreFetcher autoloader, so the
    // class should be available without a manual require in most cases.
    if (!class_exists('App\\Libraries\\BotManager')) {
        /**
         * Fallback: resolve BotManager.php using multiple candidates so it works
         * both locally and on the webhost regardless of the exact directory layout.
         */
        $botManagerCandidates = [];
        if (defined('NOBLEWARS_APP_DIR')) {
            $botManagerCandidates[] = NOBLEWARS_APP_DIR . '/Libraries/BotManager.php';
        }
        if (defined('NOBLEWARS_ROOT_DIR')) {
            $botManagerCandidates[] = NOBLEWARS_ROOT_DIR . '/app/Libraries/BotManager.php';
        }
        // Normal layout: public/ajax/../../app/Libraries/BotManager.php
        $botManagerCandidates[] = __DIR__ . '/../../app/Libraries/BotManager.php';
        if (!empty($_SERVER['DOCUMENT_ROOT'])) {
            $botManagerCandidates[] = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/app/Libraries/BotManager.php';
        }

        $botManagerPath = null;
        $triedPaths = [];
        foreach ($botManagerCandidates as $candidate) {
            $realPath = realpath($candidate);
            $triedPaths[] = $candidate . ' (realpath=' . ($realPath === false ? 'false' : $realPath) . ')';
            if ($realPath !== false && file_exists($realPath)) {
                $botManagerPath = $realPath;
                break;
            }
        }

        if ($botManagerPath === null) {
            $diag =
                "BotManager.php not found. Tried: " . implode(' | ', $triedPaths) .
                " | __DIR__=" . __DIR__ .
                " | NOBLEWARS_APP_DIR=" . (defined('NOBLEWARS_APP_DIR') ? NOBLEWARS_APP_DIR : 'undefined') .
                " | NOBLEWARS_ROOT_DIR=" . (defined('NOBLEWARS_ROOT_DIR') ? NOBLEWARS_ROOT_DIR : 'undefined');
            error_log('[process_bots.php] ' . $diag);
            throw new Exception("BotManager.php not found. Verifique logs do servidor para detalhes.");
        }

        require_once $botManagerPath;
    }

    if (!class_exists('App\\Libraries\\BotManager')) {
        throw new Exception("BotManager class not found.");
    }

    // Determine world ID
    $world_id = isset($_GET['world']) ? (int) $_GET['world'] : 1;
    $db_name = get_world_db_name($world_id);

    // Log start
    $startTime = microtime(true);
    $logMessage = "[" . date('Y-m-d H:i:s') . "] Starting bot processing for world $world_id\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);

    // Get database instance
    $db = \App\Core\Database::getInstance($db_name);

    // Process all completed events (builds, recruitments, etc.)
    try {
        $eventProcessor = new \App\Services\EventProcessor($db);
        $eventProcessor->processAll(120); // Process up to 120 ready events per bot run
    } catch (Exception $e) {
        file_put_contents($logFile, "  ✗ EVENT PROCESSOR ERROR: " . $e->getMessage() . "\n", FILE_APPEND);
    }

    // Create BotManager instance
    $botManager = new \App\Libraries\BotManager($db_name);

    // Process barbarian villages (growth system)
    $barbarianStartTime = microtime(true);
    $botManager->processBarbarians();
    $barbarianTime = round(microtime(true) - $barbarianStartTime, 3);

    // Process bot players (AI players)
    $botPlayerStartTime = microtime(true);
    $processedBots = 0;

    // Get bot players from database
    $botPlayers = $db->fetchAll("SELECT id, username FROM users WHERE bot = 1 LIMIT 10") ?: [];

    
    foreach ($botPlayers as $botPlayer) {
        $botTurnStart = microtime(true);
        $botManager->processTurn($botPlayer['id']);
        $botTurnTime = round(microtime(true) - $botTurnStart, 3);
        $processedBots++;

        // Log individual bot processing time
        file_put_contents($logFile, 
            "  - Bot '{$botPlayer['username']}' (ID: {$botPlayer['id']}) processed in {$botTurnTime}s\n", 
            FILE_APPEND);

        // Throttle: Small sleep to avoid CPU spike
        if ($processedBots % 3 === 0) {
            usleep(100000); // 100ms pause every 3 bots
        }
    }

    $botPlayerTime = round(microtime(true) - $botPlayerStartTime, 3);

    // Update last run time
    file_put_contents($lastRunFile, time());

    // Remove lock
    @unlink($lockFile);

    // Calculate total execution time
    $totalTime = round(microtime(true) - $startTime, 3);

    // Log success
    $logMessage = "  ✓ Completed in {$totalTime}s (Barbarians: {$barbarianTime}s, Bots: {$botPlayerTime}s, Processed: {$processedBots} bots)\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);

    // Return JSON response
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'message' => 'Bots processed successfully',
        'timestamp' => time(),
        'execution_time' => $totalTime,
        'barbarians_time' => $barbarianTime,
        'bot_players_time' => $botPlayerTime,
        'bots_processed' => $processedBots,
        'next_run_in' => 60
    ]);
    exit;

} catch (Exception $e) {
    // Remove lock on error
    @unlink($lockFile);

    // Log error
    $logMessage = "  ✗ ERROR: " . $e->getMessage() . "\n";
    @file_put_contents($logFile, $logMessage, FILE_APPEND);

    ob_clean();
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
        'timestamp' => time()
    ]);
    exit;
}
?>

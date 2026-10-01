<?php
if ((getenv('APP_ENV') ?: 'production') !== 'development' && !isset($_SERVER['HTTP_X_DEBUG_TOKEN'])) {
    http_response_code(403);
    die('Forbidden');
}
/**
 * Run Events Diagnostics
 * Direct execution of event processor with verbose error output
 */
ini_set('display_errors', 0);
error_reporting(0);
header('Content-Type: text/plain; charset=UTF-8');
echo "=== EVENT PROCESSOR DIAGNOSTICS ===\n";
echo "Current Server Time: " . time() . " (" . date('Y-m-d H:i:s') . ")\n";
echo "PHP Version: " . PHP_VERSION . "\n";
try {
    // 1. Bootstrap AJAX: loads CoreFetcher, autoloader and helpers from cache/production
    require_once __DIR__ . '/../../app/bootstrap_ajax.php';
    $world_id = isset($_GET['world']) ? (int) $_GET['world'] : 1;
    $db_name = get_world_db_name($world_id);
    echo "Database Name: $db_name\n";
    $db = \App\Core\Database::getInstance($db_name);
    echo "Database Connection Successful.\n\n";
    // 2. Query event statistics
    $total = $db->fetch("SELECT COUNT(*) as c FROM events");
    $ready = $db->fetch("SELECT COUNT(*) as c FROM events WHERE event_time <= ?", [time()]);
    $movements = $db->fetch("SELECT COUNT(*) as c FROM movements");
    
    echo "Total events in queue: {$total['c']}\n";
    echo "Ready events (in the past): {$ready['c']}\n";
    echo "Total active movements: {$movements['c']}\n\n";
    // 3. Inspect some ready events
    if ($ready['c'] > 0) {
        echo "Listing up to 10 ready events:\n";
        $readyList = $db->fetchAll(
            "SELECT event_type, event_id, event_time, user_id, villageid FROM events WHERE event_time <= ? ORDER BY event_time LIMIT 10",
            [time()]
        );
        foreach ($readyList as $evt) {
            $diff = time() - $evt['event_time'];
            echo " - TYPE: {$evt['event_type']}, ID: {$evt['event_id']}, Time: {$evt['event_time']} (Overdue: {$diff}s), User: {$evt['user_id']}, Village: {$evt['villageid']}\n";
            
            // If movement, display movement details
            if ($evt['event_type'] === 'movement') {
                $mov = $db->fetch("SELECT * FROM movements WHERE id = ?", [$evt['event_id']]);
                if ($mov) {
                    echo "   [Movement] Type: {$mov['type']}, From Vil: {$mov['send_from_village']}, To Vil: {$mov['send_to_village']}, Start: {$mov['start_time']}, End: {$mov['end_time']}, Units: {$mov['units']}\n";
                } else {
                    echo "   [Movement] Details NOT found in movements table for ID: {$evt['event_id']}\n";
                }
            }
        }
        echo "\n";
    }
    // 4. Run event processing with verbose output
    if ($ready['c'] > 0) {
        echo "Attempting to process up to 5 events manually:\n";
        $eventProcessor = new \App\Services\EventProcessor($db);
        
        $readyList = $db->fetchAll(
            "SELECT event_type, event_id, event_time FROM events WHERE event_time <= ? ORDER BY event_time LIMIT 5",
            [time()]
        );
        
        foreach ($readyList as $event) {
            echo "Processing event TYPE: {$event['event_type']} ID: {$event['event_id']}... ";
            
            try {
                $processed = false;
                if ($event['event_type'] === 'build') {
                    $processed = $eventProcessor->checkBuilds($event['event_id']);
                }
                elseif ($event['event_type'] === 'destory') {
                    $processed = $eventProcessor->checkDestroy($event['event_id']);
                }
                elseif ($event['event_type'] === 'research') {
                    $processed = $eventProcessor->checkResearch($event['event_id']);
                }
                elseif ($event['event_type'] === 'recruit') {
                    $eventProcessor->checkRecruit($event['event_id']);
                    $processed = true;
                }
                elseif ($event['event_type'] === 'bot_action') {
                    $eventProcessor->checkBotAction($event['event_id'], $event['event_time']);
                    $processed = true;
                }
                elseif ($event['event_type'] === 'barbarian_action' || $event['event_type'] === 'barbarian_actio') {
                    $eventProcessor->checkBarbarianAction($event['event_time']);
                    $processed = true;
                }
                elseif ($event['event_type'] === 'dealers') {
                    $eventProcessor->checkDealers($event['event_id']);
                    $processed = true;
                }
                elseif ($event['event_type'] === 'movement') {
                    // Manual replication of movement logic to print errors
                    $dbName = $db->getDatabaseName();
                    
                    $helperDir = __DIR__ . '/../../app/Helpers';
                    $libDir = __DIR__ . '/../../public/modelo/lib';
                    
                    if (!function_exists('__')) {
                        \CoreFetcher::load('Helpers/language_helper.php');
                    }
                    if (!function_exists('sql')) {
                        require_once $libDir . '/functions.php';
                    }
                    if (!isset($GLOBALS['pdo_legacy_connection'])) {
                        $GLOBALS['pdo_legacy_connection'] = $db->getPdo();
                    }
                    if (!isset($GLOBALS['cl_builds'])) {
                        $GLOBALS['cl_builds'] = new \App\Models\BuildsLibrary($dbName);
                    }
                    if (!isset($GLOBALS['cl_units'])) {
                        $GLOBALS['cl_units'] = new \App\Models\UnitsLibrary($dbName);
                    }
                    if (!isset($GLOBALS['impl_units'])) {
                        $GLOBALS['impl_units'] = implode(',', $GLOBALS['cl_units']->get_array("dbname"));
                    }
                    if (!isset($GLOBALS['awards'])) {
                        $GLOBALS['awards'] = new \App\Models\AwardsLibrary($db);
                    }
                    if (!function_exists('check_mov')) {
                        require_once $libDir . '/mysql_compat.php';
                        require_once $libDir . '/events.php';
                    }
                    
                    if (function_exists('check_mov')) {
                        check_mov($event['event_id']);
                        $processed = true;
                    }
                }
                
                if ($processed) {
                    echo "SUCCESS!\n";
                } else {
                    echo "SKIPPED/NOT IMPLEMENTED\n";
                }
            } catch (\Exception $e) {
                echo "FAILED! Error: " . $e->getMessage() . "\n";
                echo "File: " . $e->getFile() . " on line " . $e->getLine() . "\n";
                echo "Trace:\n" . $e->getTraceAsString() . "\n";
            }
        }
    } else {
        echo "No ready events to process at this time.\n";
    }
    // 5. Check error log
    $logFile = __DIR__ . '/../cache/event_processor_errors.log';
    if (file_exists($logFile)) {
        echo "\n=== LAST 10 ENTRIES IN event_processor_errors.log ===\n";
        $lines = file($logFile);
        $last10 = array_slice($lines, -10);
        echo implode("", $last10);
    } else {
        echo "\nNo event_processor_errors.log file exists in cache.\n";
    }
    // 6. Check bot processor log
    $botLogFile = __DIR__ . '/../cache/bot_processor.log';
    if (file_exists($botLogFile)) {
        echo "\n=== LAST 30 ENTRIES IN bot_processor.log ===\n";
        $lines = file($botLogFile);
        $last30 = array_slice($lines, -30);
        echo implode("", $last30);
    } else {
        echo "\nNo bot_processor.log file exists in cache.\n";
    }
} catch (\Exception $e) {
    echo "\nFATAL ERROR IN DIAGNOSTICS: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " on line " . $e->getLine() . "\n";
}
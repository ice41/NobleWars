<?php
// Suppress deprecation warnings and notices - show only real errors
error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR);
ini_set('display_errors', '0');

/*****************************************/
/*     STATS.PHP - ESTATÍSTICAS         */
/*     100% FIEL AO ORIGINAL            */
/*     PHP 7+/8+ com MySQLi             */
/*****************************************/

require_once __DIR__ . '/../app/bootstrap_public.php';

// Direct Require (Autoloader bypass for stability)
require_once __DIR__ . '/../app/Controllers/Screens/StatisticsScreen.php';

session_start();
$world = get_active_world();
$worldDb = get_world_db_name($world);

// Check session
$cookieName = 'session_' . $world;
if (!isset($_COOKIE[$cookieName])) {
    header('Location: index.php');
    exit;
}

$sid = $_COOKIE[$cookieName];
$sessionModel = new \App\Models\SessionModel($worldDb);
$session = $sessionModel->checkSession($sid);

if (!$session) {
    header('Location: index.php');
    exit;
}

// Redirect to overview if accessed directly without a mode parameter
if (!isset($_GET['mode'])) {
    header('Location: game.php?screen=overview');
    exit;
}

use App\Controllers\Screens\StatisticsScreen;

try {
    $controller = new StatisticsScreen($world);
    echo $controller->render();
} catch (Exception $e) {
    // Load translation helpers
    require_once(__DIR__ . '/../app/Helpers/language_helper.php');
    init_locale();
    die(__('stats.config_load_error') . ': ' . $e->getMessage());
}

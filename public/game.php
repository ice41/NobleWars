<?php
define('NEW_ENGINE_ACTIVE', true);
// Suppress deprecation warnings and notices - show only real errors
error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR);
ini_set('display_errors', '0');
/*****************************************/
/*     GAME.PHP - MODERNIZADO            */
/*     100% FIEL AO ORIGINAL             */
/*     PHP 7+/8+ com MySQLi              */
/*             ice41                     */
/*****************************************/

session_start();

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

require_once(__DIR__ . '/../app/Helpers/helpers.php');
require_once(__DIR__ . '/../app/Helpers/language_helper.php');
require_once('configs/config.php');
require_once('modelo/lib/world_constants.php');
require_once('modelo/lib/config.php');
require_once('modelo/lib/functions.php');
require_once('modelo/lib/bonus.php');

// Initialize localization
init_locale();

// Instanciar GameController
use App\Controllers\GameController;

try {
    $controller = new GameController();
    $controller->index();
} catch (Exception $e) {
    // If it's an AJAX request, return JSON error
    if (isset($_GET['ajax'])) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        exit;
    }

    die('Erro crítico: ' . $e->getMessage());
}

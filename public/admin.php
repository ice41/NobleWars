<?php
// Suppress deprecation warnings and notices
error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR);
ini_set('display_errors', '0');

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

require_once('configs/config.php');
require_once('modelo/lib/world_constants.php');
require_once('modelo/lib/config.php');
require_once('modelo/lib/functions.php');
require_once(__DIR__ . '/../app/Helpers/helpers.php');
require_once(__DIR__ . '/../app/Helpers/language_helper.php');

// Handle language change for standalone admin
if (isset($_GET['lang'])) {
    set_locale($_GET['lang']);
}
// Initialize language system
init_locale();

use App\Controllers\AdminController;

try {
    $controller = new AdminController();
    $action = $_GET['action'] ?? 'login';

    switch ($action) {
        case 'login':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->login();
            } else {
                $controller->showLogin();
            }
            break;
        case 'logout':
            $controller->logout();
            break;
        case 'select_world':
            $controller->selectWorld();
            break;
        case 'switch_world':
            $controller->switchWorld();
            break;
        case 'dashboard':
            $controller->dashboard();
            break;
        case 'global_settings':
            $controller->globalSettings();
            break;
        case 'save_global_settings':
            $controller->saveGlobalSettings();
            break;
        default:
            $controller->showLogin();
            break;
    }
} catch (Exception $e) {
    die('Erro crítico no painel Admin: ' . $e->getMessage());
}

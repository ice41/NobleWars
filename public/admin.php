<?php
require_once __DIR__ . '/../app/bootstrap_public.php';
require_once(__DIR__ . '/configs/config.php');
require_once(__DIR__ . '/modelo/lib/world_constants.php');
require_once(__DIR__ . '/modelo/lib/config.php');
require_once(__DIR__ . '/modelo/lib/functions.php');

// Handle language change for standalone admin
if (isset($_GET['lang'])) {
    set_locale($_GET['lang']);
}

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

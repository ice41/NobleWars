<?php
// guest.php - Acesso público a informações do mundo (Hall da Fama, Estatísticas)
// Permite que visitantes sem conta vejam o progresso do mundo.

// error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR);
// ini_set('display_errors', '0');
/*****************************************/
/*            GUEST.PHP                  */
/*             GUEST                     */
/*             ice41                     */
/*****************************************/
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

// Load translation helpers
require_once(__DIR__ . '/../app/Helpers/language_helper.php');
init_locale();

$screen = isset($_GET['screen']) ? $_GET['screen'] : 'ranking';
$world = isset($_GET['world']) ? $_GET['world'] : '1';

// Mapeamento de screens permitidos para acesso de convidado
if ($screen === 'ranking' || $screen === 'hall_of_fame') {
    require_once __DIR__ . '/../app/Controllers/Screens/HallOfFameScreen.php';
    try {
        $controller = new \App\Controllers\Screens\HallOfFameScreen($world);
        echo $controller->render();
    } catch (\Exception $e) {
        die(__('stats.config_load_error') . ': ' . $e->getMessage());
    }
} elseif ($screen === 'info_player' || $screen === 'info_ally') {
    require_once __DIR__ . '/../app/Controllers/Screens/GuestInfoScreen.php';
    try {
        $controller = new \App\Controllers\Screens\GuestInfoScreen($world);
        echo $controller->render($screen, (int)($_GET['id'] ?? 0));
    } catch (\Exception $e) {
        die(__('stats.config_load_error') . ': ' . $e->getMessage());
    }
} elseif ($screen === 'statisics' || $screen === 'stats') {
    require_once __DIR__ . '/../app/Controllers/Screens/StatisticsScreen.php';
    try {
        $controller = new \App\Controllers\Screens\StatisticsScreen($world);
        echo $controller->render();
    } catch (\Exception $e) {
        die(__('stats.config_load_error') . ': ' . $e->getMessage());
    }
} else {
    // Redireciona para o Hall da Fama por padrão se a tela não for reconhecida
    require_once __DIR__ . '/../app/Controllers/Screens/HallOfFameScreen.php';
    try {
        $controller = new \App\Controllers\Screens\HallOfFameScreen($world);
        echo $controller->render();
    } catch (\Exception $e) {
        die(__('stats.config_load_error') . ': ' . $e->getMessage());
    }
}
?>
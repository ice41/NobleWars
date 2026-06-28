<?php
// Mostrar TODOS os erros
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

/*****************************************/
/*     HALL_OF_FAME.PHP                  */
/*     QUADRO DE HONRA                   */
/*             ice41                     */
/*****************************************/

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0)
        return;
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file))
        require $file;
});

// Autoloader manual para garantir carregamento
require_once __DIR__ . '/../app/Controllers/Screens/HallOfFameScreen.php';

$world = isset($_GET['world']) ? $_GET['world'] : '1';

try {
    $controller = new \App\Controllers\Screens\HallOfFameScreen($world);
    echo $controller->render();
} catch (Exception $e) {
    // Mostrar o erro real
    echo "<h1>ERRO DETETADO</h1>";
    // echo "<pre>";
    // echo "Mensagem: " . $e->getMessage() . "\n";
    // echo "Ficheiro: " . $e->getFile() . "\n";
    // echo "Linha: " . $e->getLine() . "\n";
    // echo "\nStack Trace:\n" . $e->getTraceAsString() . "\n";
    // echo "</pre>";
    exit;
}
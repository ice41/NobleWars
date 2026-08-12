<?php
// Mostrar TODOS os erros
error_reporting(E_ALL);
ini_set('display_errors', '1');

/*****************************************/
/*     HALL_OF_FAME.PHP                 */
/*     QUADRO DE HONRA                  */
/*****************************************/

require_once __DIR__ . '/../app/bootstrap_public.php';

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
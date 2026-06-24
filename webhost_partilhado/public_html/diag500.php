<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

echo "<h2>Diagnóstico Rápido - Passo a Passo</h2><pre>";

echo "1. PHP Version: " . PHP_VERSION . "\n";
echo "2. PHP >= 8.0: " . (version_compare(PHP_VERSION, '8.0', '>=') ? 'SIM' : 'NAO - pode haver incompatibilidades!') . "\n";
echo "3. PHP >= 7.4: " . (version_compare(PHP_VERSION, '7.4', '>=') ? 'SIM' : 'NAO - versao muito antiga!') . "\n\n";

// Opção A - motor fora do public_html
$engineA = dirname(__DIR__) . '/new_engine';
echo "4. ENGINE (Opcao A fora de public_html): " . $engineA . "\n";
echo "   Existe: " . (is_dir($engineA) ? 'SIM' : 'NAO') . "\n\n";

// Opção B - motor dentro do public_html  
$engineB = __DIR__ . '/new_engine';
echo "5. ENGINE (Opcao B dentro de public_html): " . $engineB . "\n";
echo "   Existe: " . (is_dir($engineB) ? 'SIM' : 'NAO') . "\n\n";

// Usar o que existir
$enginePath = is_dir($engineA) ? $engineA : (is_dir($engineB) ? $engineB : null);
echo "6. ENGINE escolhido: " . ($enginePath ?? 'NENHUM ENCONTRADO!') . "\n\n";

if (!$enginePath) {
    echo "ERRO: Motor nao encontrado! Verifica a estrutura das pastas no FTP.\n";
    exit;
}

$publicPath = $enginePath . '/public';
echo "7. public/ path: " . $publicPath . "\n";
echo "   Existe: " . (is_dir($publicPath) ? 'SIM' : 'NAO') . "\n\n";

// Testar chdir
chdir($publicPath);
echo "8. chdir() para public/: " . getcwd() . "\n\n";

// Testar se configs/config.php é acessível
echo "9. configs/config.php existe (relativo): " . (file_exists('configs/config.php') ? 'SIM' : 'NAO') . "\n\n";

// Testar carregar configs
echo "10. Tentar carregar configs/config.php...\n";
try {
    require_once 'configs/config.php';
    echo "    OK! db_host=" . ($conf['db_host'] ?? '?') . ", db_name=" . ($conf['db_name'] ?? '?') . "\n\n";
} catch (Throwable $e) {
    echo "    ERRO: " . $e->getMessage() . "\n\n";
}

// Testar str_starts_with (PHP 8.0+)
echo "11. str_starts_with() disponivel: " . (function_exists('str_starts_with') ? 'SIM' : 'NAO - PHP < 8.0!') . "\n\n";

// Testar autoloader / classes
echo "12. Testar autoloader...\n";
spl_autoload_register(function ($class) use ($enginePath) {
    $prefix = 'App\\';
    $base_dir = $enginePath . '/app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) require $file;
});

try {
    $dbName = \App\Core\Database::getGlobalDbName();
    echo "    Database::getGlobalDbName() = " . $dbName . "\n";
    $worldName = \App\Core\Database::getWorldDbName();
    echo "    Database::getWorldDbName() = " . $worldName . "\n";
    echo "    OK!\n\n";
} catch (Throwable $e) {
    echo "    ERRO: " . $e->getMessage() . " em " . $e->getFile() . ":" . $e->getLine() . "\n\n";
}

echo "=== FIM DO DIAGNOSTICO ===\n";
echo "</pre>";

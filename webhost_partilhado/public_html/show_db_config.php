<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

header('Content-Type: text/plain; charset=utf-8');

echo "=== CONFIGURAÇÃO DA BASE DE DADOS ===\n\n";

// Caminho correto para o ficheiro de config da DB
$dbConfigPath = '/home/iceptds/www/game/new_engine/app/Config/database.php';

echo "📁 FICHEIRO: $dbConfigPath\n";
echo "📏 Tamanho: " . (file_exists($dbConfigPath) ? filesize($dbConfigPath) . ' bytes' : 'NÃO EXISTE') . "\n";
echo "📅 Última modificação: " . (file_exists($dbConfigPath) ? date('Y-m-d H:i:s', filemtime($dbConfigPath)) : 'N/A') . "\n\n";

if (!file_exists($dbConfigPath)) {
    echo "❌ ERRO: Ficheiro não encontrado!\n";
    echo "\nProcurando em locais alternativos...\n\n";
    
    $alternatives = [
        '/home/iceptds/www/game/new_engine/app/config/database.php',
        '/home/iceptds/www/game/new_engine/config/database.php',
        '/home/iceptds/www/game/new_engine/app/Config/Database.php',
        '/home/iceptds/www/game/new_engine/app/Config/db.php',
    ];
    
    foreach ($alternatives as $alt) {
        if (file_exists($alt)) {
            echo "✅ ENCONTRADO: $alt\n";
            $dbConfigPath = $alt;
            break;
        }
    }
}

echo str_repeat("=", 80) . "\n\n";
echo "📋 CONTEÚDO COMPLETO:\n\n";
echo file_get_contents($dbConfigPath);
echo "\n\n" . str_repeat("=", 80) . "\n\n";

// Procurar por usernames específicos
echo "🔍 PROCURANDO USERNAMES:\n\n";
$content = file_get_contents($dbConfigPath);
$lines = explode("\n", $content);

foreach ($lines as $num => $line) {
    if (stripos($line, 'rooiceptdstwt') !== false || 
        stripos($line, 'iceptdstwt') !== false ||
        stripos($line, "'user'") !== false ||
        stripos($line, '"user"') !== false ||
        stripos($line, 'username') !== false) {
        echo "Linha " . ($num + 1) . ": " . trim($line) . "\n";
    }
}

// Verificar estrutura da pasta app/Config
echo "\n\n📂 CONTEÚDO DA PASTA app/Config/:\n\n";
$configDir = '/home/iceptds/www/game/new_engine/app/Config';
if (is_dir($configDir)) {
    $files = scandir($configDir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $type = is_dir($configDir . '/' . $file) ? '📁' : '📄';
            echo "   $type $file\n";
        }
    }
} else {
    echo "❌ Pasta não encontrada: $configDir\n";
}

// Verificar como o index.php carrega as configs
echo "\n\n🔍 COMO O INDEX.PHP CARREGA AS CONFIGS:\n\n";
$indexFile = '/home/iceptds/www/game/new_engine/public/index.php';
$indexContent = file_get_contents($indexFile);
$indexLines = explode("\n", $indexContent);

echo "Primeiras 100 linhas do index.php:\n\n";
foreach (array_slice($indexLines, 0, 100) as $num => $line) {
    echo ($num + 1) . ": " . rtrim($line) . "\n";
}
<?php
/**
 * Diagnóstico de Views — Coloca este ficheiro na raiz do projeto e acede via browser.
 * Ex: https://1.noblewars.pt/diagnose_views.php
 *
 * AVISO: Remove ou protege este ficheiro após diagnóstico.
 */

header('Content-Type: text/plain; charset=utf-8');

echo "=== NOBLEWARS VIEW DIAGNOSTIC ===\n\n";

// Caminhos base
$rootDir = dirname(__DIR__);
$appDir = $rootDir . '/app';
$cacheDir = $appDir . '/storage/core_cache';
$manifestFile = $cacheDir . '/.manifest';

echo "Root dir: $rootDir\n";
echo "App dir: $appDir\n";
echo "Cache dir: $cacheDir\n\n";

$viewsDir = $appDir . '/Views';
$screensDir = $viewsDir . '/screens';
$overviewFile = $screensDir . '/overview.php';

echo "NOBLEWARS_APP_DIR: " . (defined('NOBLEWARS_APP_DIR') ? NOBLEWARS_APP_DIR : 'NÃO DEFINIDO (script standalone)') . "\n";
echo "Diretório Views esperado: $viewsDir\n";
echo "Diretório screens esperado: $screensDir\n";
echo "Ficheiro overview.php esperado: $overviewFile\n\n";

echo "--- Existência de pastas ---\n";
echo "app/ existe: " . (is_dir($appDir) ? 'SIM' : 'NÃO') . "\n";
echo "app/Views/ existe: " . (is_dir($viewsDir) ? 'SIM' : 'NÃO') . "\n";
echo "app/Views/screens/ existe: " . (is_dir($screensDir) ? 'SIM' : 'NÃO') . "\n";
echo "app/Views/screens/overview.php existe: " . (file_exists($overviewFile) ? 'SIM' : 'NÃO') . "\n\n";

if (is_dir($screensDir)) {
    echo "--- Primeiros 20 ficheiros em app/Views/screens/ ---\n";
    $files = glob($screensDir . '/*.php');
    sort($files);
    $count = 0;
    foreach ($files as $f) {
        if ($count >= 20) break;
        echo " - " . basename($f) . "\n";
        $count++;
    }
    echo "\nTotal de ficheiros .php em screens/: " . count($files) . "\n\n";
}

echo "--- Permissões ---\n";
echo "app/Views/ readable: " . (is_readable($viewsDir) ? 'SIM' : 'NÃO') . "\n";
echo "app/Views/screens/ readable: " . (is_readable($screensDir) ? 'SIM' : 'NÃO') . "\n";
if (file_exists($overviewFile)) {
    echo "app/Views/screens/overview.php readable: " . (is_readable($overviewFile) ? 'SIM' : 'NÃO') . "\n";
    echo "app/Views/screens/overview.php size: " . filesize($overviewFile) . " bytes\n";
}

// CoreFetcher cache info
echo "\n--- CoreFetcher Cache ---\n";
echo "Cache dir existe: " . (is_dir($cacheDir) ? 'SIM' : 'NÃO') . "\n";
echo "Manifest existe: " . (file_exists($manifestFile) ? 'SIM' : 'NÃO') . "\n";
if (file_exists($manifestFile)) {
    $manifest = @json_decode(file_get_contents($manifestFile), true);
    if ($manifest) {
        echo "Cache version: " . ($manifest['version'] ?? 'N/A') . "\n";
        echo "Cache expires_at: " . ($manifest['expires_at'] ?? 'N/A') . " (" . (isset($manifest['expires_at']) ? date('Y-m-d H:i:s', $manifest['expires_at']) : 'N/A') . ")\n";
        echo "Cached core_version: " . ($manifest['core_version'] ?? 'N/A') . "\n";
        echo "Cached domain: " . ($manifest['domain'] ?? 'N/A') . "\n";
        echo "Cached files count: " . ($manifest['data']['count'] ?? 'N/A') . "\n";
    } else {
        echo "Manifest inválido/corrompido\n";
    }
}

$cacheViewFile = $cacheDir . '/Core/View.php';
echo "Cached Core/View.php existe: " . (file_exists($cacheViewFile) ? 'SIM' : 'NÃO') . "\n";
if (file_exists($cacheViewFile)) {
    echo "Cached Core/View.php size: " . filesize($cacheViewFile) . " bytes\n";
    $content = file_get_contents($cacheViewFile);
    echo "Cached Core/View.php contém 'NOBLEWARS_APP_DIR': " . (strpos($content, 'NOBLEWARS_APP_DIR') !== false ? 'SIM' : 'NÃO') . "\n";
    echo "Cached Core/View.php contém 'View file not found': " . (strpos($content, 'View file not found') !== false ? 'SIM' : 'NÃO') . "\n";
}

echo "\n=== FIM ===\n";

<?php
/**
 * Diagnóstico de Permissões do CoreFetcher
 * Coloca este ficheiro na raiz/public do servidor e acede via navegador.
 * 
 * ⚠️ ATENÇÃO: Remove ou desativa este ficheiro após o diagnóstico.
 * Acede com: ?key=noblewars_diag_2026
 */

$accessKey = 'noblewars_diag_2026'; // Altera esta chave antes de usar em produção
if (!isset($_GET['key']) || $_GET['key'] !== $accessKey) {
    http_response_code(403);
    header('Content-Type: text/plain; charset=utf-8');
    die('Acesso negado.');
}

header('Content-Type: text/plain; charset=utf-8');

echo "=== NOBLEWARS COREFETCHER DIAGNÓSTICO ===\n\n";

$appDir = dirname(__DIR__) . '/app';
$storageDir = $appDir . '/storage';
$cacheDir = $storageDir . '/core_cache';

// Informações do ambiente
echo "Utilizador PHP: " . (function_exists('posix_getpwuid') ? posix_getpwuid(posix_geteuid())['name'] : get_current_user()) . "\n";
echo "UID/GID: " . getmyuid() . "/" . getmygid() . "\n";
echo "Caminho app: {$appDir}\n";
echo "Caminho storage: {$storageDir}\n";
echo "Caminho core_cache: {$cacheDir}\n\n";

function checkPath($path) {
    echo "--- {$path} ---\n";
    echo "  Existe: " . (is_dir($path) ? 'SIM' : 'NÃO') . "\n";
    if (is_dir($path)) {
        echo "  Readable: " . (is_readable($path) ? 'SIM' : 'NÃO') . "\n";
        echo "  Writable: " . (is_writable($path) ? 'SIM' : 'NÃO') . "\n";
        $perms = fileperms($path);
        echo "  Permissões: " . substr(sprintf('%o', $perms), -4) . "\n";
        echo "  Owner: " . (function_exists('posix_getpwuid') ? (posix_getpwuid(fileowner($path))['name'] ?? fileowner($path)) : fileowner($path)) . "\n";
        echo "  Group: " . (function_exists('posix_getgrgid') ? (posix_getgrgid(filegroup($path))['name'] ?? filegroup($path)) : filegroup($path)) . "\n";
    }
    echo "\n";
}

checkPath($appDir);
checkPath($storageDir);
checkPath($cacheDir);

// Teste de escrita
if (is_dir($cacheDir)) {
    $testFile = $cacheDir . '/.write_test_' . time() . '.tmp';
    $canWrite = @file_put_contents($testFile, 'test') !== false;
    echo "Teste de escrita em core_cache: " . ($canWrite ? 'SUCESSO' : 'FALHOU') . "\n";
    if ($canWrite) {
        @unlink($testFile);
    }
} elseif (is_dir($storageDir)) {
    $canWrite = @mkdir($cacheDir, 0775, true);
    echo "Tentativa de criar core_cache: " . ($canWrite ? 'SUCESSO' : 'FALHOU') . "\n";
} else {
    echo "Tentativa de criar storage/core_cache...\n";
    $canWrite = @mkdir($cacheDir, 0775, true);
    echo "  Resultado: " . ($canWrite ? 'SUCESSO' : 'FALHOU') . "\n";
}

// Estado do manifest
$manifestFile = $cacheDir . '/.manifest';
echo "\nManifest: " . (file_exists($manifestFile) ? 'EXISTE' : 'NÃO EXISTE') . "\n";
if (file_exists($manifestFile)) {
    $manifest = @json_decode(file_get_contents($manifestFile), true);
    echo "  Domain: " . ($manifest['domain'] ?? 'N/A') . "\n";
    echo "  Expires: " . (isset($manifest['expires_at']) ? date('Y-m-d H:i:s', $manifest['expires_at']) : 'N/A') . "\n";
    echo "  Files: " . ($manifest['data']['count'] ?? 'N/A') . "\n";
}

// Teste de conectividade API
$licenseFile = $appDir . '/Config/license.php';
$license = file_exists($licenseFile) ? include $licenseFile : '';
echo "\nChave licença: " . (empty($license) ? 'NÃO ENCONTRADA' : substr($license, 0, 30) . '...') . "\n";

if (!empty($license)) {
    $ch = curl_init('https://nped.pt/api/fetch_core.php');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['key' => $license, 'domain' => 'noblewars.pt', 'version' => '1']));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    
    echo "\nConectividade API:\n";
    echo "  Resposta: " . (empty($response) ? 'VAZIA' : 'RECEBIDA (' . strlen($response) . ' bytes)') . "\n";
    echo "  Erro cURL: " . (empty($error) ? 'NENHUM' : $error) . "\n";
    
    if (!empty($response)) {
        $data = @json_decode($response, true);
        echo "  Status: " . ($data['status'] ?? 'N/A') . "\n";
        echo "  Files disponíveis: " . (isset($data['files']) ? count($data['files']) : 'N/A') . "\n";
    }
}

echo "\n=== FIM ===\n";

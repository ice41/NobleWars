<?php
/**
 * ============================================================
 *  clear_core_cache.php — LIMPEZA DE CACHE DO COREFETCHER
 * ============================================================
 * 
 * Coloca este ficheiro na raiz do projeto (new_engine/clear_core_cache.php)
 * e acede via https://noblewars.pt/clear_core_cache.php
 * 
 * Isto apaga todos os ficheiros encriptados em app/storage/core_cache/
 * e o manifesto. Na próxima requisição, o CoreFetcher fará um novo
 * fetch ao servidor central.
 * ============================================================
 */

// Proteção simples: só localhost ou token admin
function isAdminRequest() {
    $adminTokenFile = __DIR__ . '/../app/Config/diag_token.php';
    $isLocal = in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1', 'localhost']);
    if ($isLocal) return true;
    if (file_exists($adminTokenFile)) {
        $expected = include $adminTokenFile;
        $provided = $_POST['admin_token'] ?? $_GET['admin_token'] ?? '';
        if (!empty($expected) && hash_equals((string)$expected, (string)$provided)) {
            return true;
        }
    }
    return false;
}

if (!isAdminRequest()) {
    header('HTTP/1.1 403 Forbidden');
    die('Acesso negado. Deves aceder a partir de localhost ou fornecer admin_token válido.');
}

header('Content-Type: text/html; charset=utf-8');

echo '<!DOCTYPE html><html><head><title>Limpar Cache CoreFetcher</title>';
echo '<style>body{font-family:monospace;background:#1a1a1a;color:#e0e0e0;padding:30px;max-width:800px;margin:0 auto;}';
echo 'h1{color:#f44336;}p{line-height:1.6;}.ok{color:#4caf50;}.err{color:#f44336;}</style></head><body>';
echo '<h1>🗑️ Limpar Cache do CoreFetcher</h1>';

$cacheDir = __DIR__ . '/app/storage/core_cache/';
$cacheDir = str_replace('\\', '/', $cacheDir);
$deletedFiles = 0;
$errors = [];

function deleteDirectoryContents($dir, &$deleted, &$errors) {
    $items = @glob($dir . '*');
    if ($items === false) return;
    foreach ($items as $item) {
        if (is_dir($item)) {
            deleteDirectoryContents($item . '/', $deleted, $errors);
            if (!@rmdir($item)) {
                $errors[] = 'Não foi possível remover a pasta: ' . $item;
            }
        } elseif (is_file($item)) {
            if (basename($item) === '.htaccess') continue; // Não apagar proteções
            if (@unlink($item)) {
                $deleted++;
            } else {
                $errors[] = 'Não foi possível apagar: ' . $item;
            }
        }
    }
}

if (!is_dir($cacheDir)) {
    echo '<p class="err">❌ Pasta de cache não existe: ' . htmlspecialchars($cacheDir) . '</p>';
} else {
    deleteDirectoryContents($cacheDir, $deletedFiles, $errors);
    echo '<p class="ok">✅ Cache limpo. Ficheiros apagados: ' . $deletedFiles . '</p>';
    if (!empty($errors)) {
        echo '<p class="err">Erros encontrados:</p>';
        echo '<ul>';
        foreach ($errors as $err) {
            echo '<li>' . htmlspecialchars($err) . '</li>';
        }
        echo '</ul>';
    }
}

echo '<p><a href="diagnose_core_fetch.php">Ir para o diagnóstico</a></p>';
echo '</body></html>';

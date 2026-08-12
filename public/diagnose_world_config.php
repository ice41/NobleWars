<?php
/**
 * Diagnóstico de configuração do mundo
 * Coloca este ficheiro na raiz pública (public/) e acede via browser.
 * Não deixes em produção — remove após diagnóstico.
 */

set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

header('Content-Type: text/html; charset=utf-8');

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

try {
    require_once __DIR__ . '/../app/CoreFetcher.php';
} catch (Throwable $e) {
    echo '<p style="color:red">Erro ao carregar CoreFetcher: ' . htmlspecialchars($e->getMessage()) . '</p>';
}

if (class_exists('CoreFetcher')) {
    \CoreFetcher::init();
    try {
        \CoreFetcher::load('Helpers/helpers.php');
    } catch (Throwable $e) {
        echo '<p style="color:red">Erro ao carregar helpers via CoreFetcher: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
}

$worldId = $_GET['world'] ?? '1';
$worldId = basename($worldId); // safe

echo '<h1>Diagnóstico de Configuração do Mundo</h1>';
echo '<p>Mundo a testar: <strong>' . htmlspecialchars($worldId) . '</strong></p>';

// Constants
echo '<h2>Constantes</h2>';
echo '<pre>';
echo 'NOBLEWARS_APP_DIR = ' . (defined('NOBLEWARS_APP_DIR') ? NOBLEWARS_APP_DIR : 'NÃO DEFINIDO') . "\n";
echo 'NOBLEWARS_ROOT_DIR = ' . (defined('NOBLEWARS_ROOT_DIR') ? NOBLEWARS_ROOT_DIR : 'NÃO DEFINIDO') . "\n";
echo 'NOBLEWARS_DEBUG = ' . (defined('NOBLEWARS_DEBUG') ? (NOBLEWARS_DEBUG ? 'true' : 'false') : 'NÃO DEFINIDO') . "\n";
echo '</pre>';

// Environment
echo '<h2>Ambiente</h2>';
echo '<pre>';
echo '__DIR__ = ' . __DIR__ . "\n";
echo '__FILE__ = ' . __FILE__ . "\n";
echo 'SCRIPT_FILENAME = ' . ($_SERVER['SCRIPT_FILENAME'] ?? 'N/A') . "\n";
echo 'DOCUMENT_ROOT = ' . ($_SERVER['DOCUMENT_ROOT'] ?? 'N/A') . "\n";
echo 'HTTP_HOST = ' . ($_SERVER['HTTP_HOST'] ?? 'N/A') . "\n";
echo '</pre>';

// Candidate paths
$paths = [];
if (defined('NOBLEWARS_APP_DIR')) {
    $paths[] = NOBLEWARS_APP_DIR . '/Config/Worlds/' . $worldId . '.php';
}
if (defined('NOBLEWARS_ROOT_DIR')) {
    $paths[] = NOBLEWARS_ROOT_DIR . '/app/Config/Worlds/' . $worldId . '.php';
}
$paths[] = __DIR__ . '/../app/Config/Worlds/' . $worldId . '.php';
$paths[] = __DIR__ . '/../../app/Config/Worlds/' . $worldId . '.php';
if (!empty($_SERVER['DOCUMENT_ROOT'])) {
    $paths[] = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/app/Config/Worlds/' . $worldId . '.php';
}
if (!empty($_SERVER['SCRIPT_FILENAME'])) {
    $paths[] = dirname($_SERVER['SCRIPT_FILENAME']) . '/../app/Config/Worlds/' . $worldId . '.php';
}

echo '<h2>Caminhos testados</h2>';
echo '<table border="1" cellpadding="5">';
echo '<tr><th>Caminho</th><th>realpath()</th><th>file_exists()</th></tr>';
foreach ($paths as $p) {
    $rp = realpath($p);
    $exists = file_exists($p);
    echo '<tr>';
    echo '<td>' . htmlspecialchars($p) . '</td>';
    echo '<td>' . ($rp === false ? '<em>falhou</em>' : htmlspecialchars($rp)) . '</td>';
    echo '<td>' . ($exists ? '<span style="color:green">SIM</span>' : '<span style="color:red">NÃO</span>') . '</td>';
    echo '</tr>';
}
echo '</table>';

// Resolver result
if (function_exists('resolve_world_config_path')) {
    echo '<h2>Resultado do resolve_world_config_path()</h2>';
    $resolved = resolve_world_config_path($worldId, true);
    echo '<pre>';
    if ($resolved === false) {
        echo 'NÃO ENCONTRADO (ver logs/error_log para detalhes)';
    } else {
        echo 'ENCONTRADO: ' . $resolved;
    }
    echo '</pre>';
} else {
    echo '<p style="color:red">Função resolve_world_config_path() não existe. O CoreFetcher provavelmente está a usar uma cache antiga.</p>';
}

// Check core cache state
echo '<h2>Cache do CoreFetcher</h2>';
$cacheDir = __DIR__ . '/../app/storage/core_cache/';
if (is_dir($cacheDir)) {
    echo '<p>Dir cache existe: ' . $cacheDir . '</p>';
    $manifest = $cacheDir . '.manifest';
    if (file_exists($manifest)) {
        $manifestData = @json_decode(file_get_contents($manifest), true);
        echo '<p>Manifesto expira em: ' . date('Y-m-d H:i:s', $manifestData['expires_at'] ?? 0) . '</p>';
        echo '<p>Versão em cache: ' . ($manifestData['version'] ?? 'N/A') . '</p>';
    } else {
        echo '<p>Sem manifesto de cache.</p>';
    }
} else {
    echo '<p>Dir cache NÃO existe: ' . $cacheDir . '</p>';
}

// Suggested next steps
echo '<h2>Próximos passos</h2>';
echo '<ul>';
echo '<li>Se o ficheiro existir em algum dos caminhos acima mas o resolver não o encontrar, limpa a cache do CoreFetcher (apaga <code>app/storage/core_cache/</code> ou usa <code>?force_core_refresh=&lt;token&gt;</code>).</li>';
echo '<li>Se o ficheiro NÃO existir em nenhum caminho, confirma que <code>app/Config/Worlds/' . htmlspecialchars($worldId) . '.php</code> foi enviado para o webhost.</li>';
echo '</ul>';

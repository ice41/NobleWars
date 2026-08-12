<?php
/**
 * ============================================================
 *  diagnose_core_fetch.php — DIAGNÓSTICO DO COREFETCHER
 * ============================================================
 * 
 * Coloca este ficheiro na raiz do projeto (new_engine/diagnose_core_fetch.php)
 * e acede via https://noblewars.pt/diagnose_core_fetch.php
 * 
 * Este script diagnostica:
 *  1. Se a cache do CoreFetcher existe e quais ficheiros tem
 *  2. Se a API central responde correctamente
 *  3. Se a API está a devolver os ficheiros com __DIR__ corrigido
 *  4. Se o View.php em cache ainda tem __DIR__ antigo
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

echo '<!DOCTYPE html><html><head><title>Diagnóstico CoreFetcher</title>';
echo '<style>body{font-family:monospace;background:#1a1a1a;color:#e0e0e0;padding:30px;max-width:1000px;margin:0 auto;}';
echo 'h1{color:#4caf50;}h2{color:#2196f3;}.ok{color:#4caf50;}.err{color:#f44336;}.warn{color:#ff9800;}';
echo 'pre{background:#0d0d0d;padding:10px;border-radius:4px;overflow:auto;max-height:300px;}';
echo 'table{border-collapse:collapse;width:100%;}th,td{border:1px solid #444;padding:8px;text-align:left;}';
echo 'th{background:#2a2a2a;}</style></head><body>';
echo '<h1>🔍 Diagnóstico CoreFetcher</h1>';

// ============================================================
// 1. CONSTANTES E CAMINHOS
// ============================================================
$appDir = __DIR__ . '/app';
$cacheDir = $appDir . '/storage/core_cache/';
$manifestFile = $cacheDir . '.manifest';
$apiUrl = 'https://nped.pt/api/fetch_core.php';

$appDir = str_replace('\\', '/', $appDir);
$cacheDir = str_replace('\\', '/', $cacheDir);

echo '<h2>1. Caminhos</h2>';
echo '<p>APP_DIR: ' . htmlspecialchars($appDir) . '</p>';
echo '<p>CACHE_DIR: ' . htmlspecialchars($cacheDir) . '</p>';
echo '<p>API_URL: ' . htmlspecialchars($apiUrl) . '</p>';

// ============================================================
// 2. ESTADO DA CACHE LOCAL
// ============================================================
echo '<h2>2. Cache Local</h2>';
if (!is_dir($cacheDir)) {
    echo '<p class="err">❌ Pasta de cache não existe: ' . htmlspecialchars($cacheDir) . '</p>';
} else {
    echo '<p class="ok">✅ Pasta de cache existe</p>';
    $files = glob($cacheDir . '*/*/*.php');
    echo '<p>Ficheiros em cache encontrados: ' . count($files) . '</p>';
    if (count($files) > 0) {
        echo '<table><tr><th>Ficheiro</th><th>Tamanho</th><th>Modificado</th></tr>';
        foreach ($files as $f) {
            echo '<tr><td>' . htmlspecialchars(str_replace($cacheDir, '', $f)) . '</td>';
            echo '<td>' . filesize($f) . ' bytes</td>';
            echo '<td>' . date('Y-m-d H:i:s', filemtime($f)) . '</td></tr>';
        }
        echo '</table>';
    }
}

if (!file_exists($manifestFile)) {
    echo '<p class="warn">⚠️ Manifesto não encontrado</p>';
} else {
    echo '<p class="ok">✅ Manifesto existe</p>';
    $manifest = @json_decode(file_get_contents($manifestFile), true);
    if ($manifest) {
        echo '<pre>' . htmlspecialchars(json_encode($manifest, JSON_PRETTY_PRINT)) . '</pre>';
    }
}

// ============================================================
// 3. VERIFICAR View.php EM CACHE
// ============================================================
echo '<h2>3. Verificação do View.php em Cache</h2>';
$viewCache = $cacheDir . 'Core/View.php';
$licenseFile = $appDir . '/Config/license.php';
$license = '';
if (file_exists($licenseFile)) {
    $license = include $licenseFile;
}

if (empty($license)) {
    echo '<p class="err">❌ Não foi possível ler a licença em ' . htmlspecialchars($licenseFile) . '</p>';
} elseif (!file_exists($viewCache)) {
    echo '<p class="warn">⚠️ View.php não está em cache. Pode ser a primeira execução ou cache vazia.</p>';
} else {
    $encryptionKey = hash_hmac('sha256', $license, 'noblewars_core_encryption_v1', true);
    $data = base64_decode(file_get_contents($viewCache), true);
    if ($data !== false && strlen($data) >= 17) {
        $iv = substr($data, 0, 16);
        $encrypted = substr($data, 16);
        $decrypted = @openssl_decrypt($encrypted, 'aes-256-cbc', $encryptionKey, OPENSSL_RAW_DATA, $iv);
        if ($decrypted !== false) {
            echo '<p class="ok">✅ Consegui desencriptar View.php</p>';
            if (strpos($decrypted, '__DIR__') !== false) {
                echo '<p class="err">❌ View.php em cache ainda contém __DIR__ (está antigo!)</p>';
            } else {
                echo '<p class="ok">✅ View.php em cache NÃO contém __DIR__ (corrigido)</p>';
            }
            if (strpos($decrypted, 'NOBLEWARS_APP_DIR') !== false) {
                echo '<p class="ok">✅ View.php em cache contém NOBLEWARS_APP_DIR</p>';
            } else {
                echo '<p class="err">❌ View.php em cache NÃO contém NOBLEWARS_APP_DIR</p>';
            }
            echo '<pre>' . htmlspecialchars(substr($decrypted, 0, 2000)) . '</pre>';
        } else {
            echo '<p class="err">❌ Não foi possível desencriptar View.php (chave errada?)</p>';
        }
    } else {
        echo '<p class="err">❌ Ficheiro View.php em cache está vazio ou corrompido</p>';
    }
}

// ============================================================
// 4. TESTAR API
// ============================================================
echo '<h2>4. Teste à API Central</h2>';
if (empty($license)) {
    echo '<p class="err">❌ Licença não encontrada, não é possível testar API</p>';
} else {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['key' => $license, 'domain' => $_SERVER['HTTP_HOST'] ?? 'localhost', 'files' => 'Core/View.php']));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($response === false) {
        echo '<p class="err">❌ Erro de conexão com API: ' . htmlspecialchars($error) . '</p>';
    } else {
        $data = json_decode($response, true);
        if ($data === null) {
            echo '<p class="err">❌ Resposta da API não é JSON válido</p>';
            echo '<pre>' . htmlspecialchars($response) . '</pre>';
        } elseif (($data['status'] ?? '') !== 'active') {
            echo '<p class="err">❌ API devolveu status não activo: ' . htmlspecialchars($data['reason'] ?? 'desconhecido') . '</p>';
        } else {
            echo '<p class="ok">✅ API respondeu com status active</p>';
            echo '<p>Ficheiros devolvidos: ' . count($data['files'] ?? []) . '</p>';
            if (isset($data['files']['Core/View.php'])) {
                $encryptionKey = hash_hmac('sha256', $license, 'noblewars_core_encryption_v1', true);
                $encData = base64_decode($data['files']['Core/View.php'], true);
                if ($encData !== false && strlen($encData) >= 17) {
                    $iv = substr($encData, 0, 16);
                    $encrypted = substr($encData, 16);
                    $decrypted = @openssl_decrypt($encrypted, 'aes-256-cbc', $encryptionKey, OPENSSL_RAW_DATA, $iv);
                    if ($decrypted !== false) {
                        if (strpos($decrypted, '__DIR__') !== false) {
                            echo '<p class="err">❌ API está a devolver View.php com __DIR__ (não corrigido!)</p>';
                        } else {
                            echo '<p class="ok">✅ API está a devolver View.php SEM __DIR__ (corrigido)</p>';
                        }
                        if (strpos($decrypted, 'NOBLEWARS_APP_DIR') !== false) {
                            echo '<p class="ok">✅ API devolve View.php com NOBLEWARS_APP_DIR</p>';
                        }
                    }
                }
            }
        }
    }
}

// ============================================================
// 5. INFORMAÇÃO DO SERVIDOR
// ============================================================
echo '<h2>5. Informação do Servidor</h2>';
echo '<p>PHP: ' . phpversion() . '</p>';
echo '<p>HTTP_HOST: ' . htmlspecialchars($_SERVER['HTTP_HOST'] ?? 'N/A') . '</p>';
echo '<p>eval() disponível: ' . (function_exists('eval') ? 'Sim' : 'Não') . '</p>';
echo '<p>OpenSSL disponível: ' . (extension_loaded('openssl') ? 'Sim' : 'Não') . '</p>';

// Botão para limpar cache
if (is_dir($cacheDir)) {
    echo '<h2>6. Ações</h2>';
    echo '<p><a href="clear_core_cache.php" style="display:inline-block;background:#f44336;color:#fff;padding:10px 20px;text-decoration:none;border-radius:4px;">🗑️ Limpar Cache do CoreFetcher</a></p>';
}

echo '</body></html>';

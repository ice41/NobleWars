<?php
// ============================================================
// NobleWars - Ponto de Arranque Universal com Auto-Deteccao
// Versao: 2.1 (com correcao de base URL para hosts free) / webhost shared
// ============================================================

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// ============================================================
// PASSO 1: Encontrar o motor automaticamente
// ============================================================
$possiblePaths = [
    __DIR__ . '/new_engine/',
    dirname(__DIR__) . '/game/new_engine',
    __DIR__ . '/new_engine',
];

$enginePath = null;
foreach ($possiblePaths as $path) {
    if (is_dir($path) && file_exists($path . 'public/index.php')) {
        $enginePath = rtrim($path, '/');
        break;
    }
}

if (!$enginePath) {
    http_response_code(500);
    echo '<h2 style="font-family:sans-serif;color:#c0392b;">Motor nao encontrado!</h2>';
    echo '<p style="font-family:sans-serif;">Pastas testadas:</p><ul style="font-family:monospace;">';
    foreach ($possiblePaths as $p) {
        echo '<li>' . htmlspecialchars($p) . ' — ' . (is_dir($p) ? 'pasta existe' : 'NAO existe') . '</li>';
    }
    echo '</ul>';
    exit;
}

$publicPath = $enginePath . '/public';

// ============================================================
// PASSO 2: Determinar URI pedida (COM CORRECAO DE BASE URL)
// ============================================================
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
$baseUrl    = rtrim(dirname($scriptName), '/');   // ex: "/game"

$requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

$uri = $requestUri;
if ($baseUrl && $baseUrl !== '/') {
    if (strpos($uri, $baseUrl . '/') === 0) {
        $uri = substr($uri, strlen($baseUrl));
    } elseif ($uri === $baseUrl) {
        $uri = '/';
    }
}
$uri = '/' . ltrim($uri, '/');

// ============================================================
// PASSO 3: Servir assets estaticos diretamente
// ============================================================
$staticFile = $publicPath . $uri;
$ext = strtolower(pathinfo($uri, PATHINFO_EXTENSION));
$staticExts = ['css','js','png','jpg','jpeg','gif','webp','svg','ico',
               'woff','woff2','ttf','eot','mp3','ogg','map','txt'];

if ($uri !== '/' && in_array($ext, $staticExts) && is_file($staticFile)) {
    $mime = [
        'css' => 'text/css', 'js' => 'application/javascript',
        'png' => 'image/png', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg',
        'gif' => 'image/gif', 'webp' => 'image/webp', 'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon', 'woff' => 'font/woff', 'woff2' => 'font/woff2',
        'ttf' => 'font/ttf', 'eot' => 'application/vnd.ms-fontobject',
        'mp3' => 'audio/mpeg', 'ogg' => 'audio/ogg', 'map' => 'application/json',
    ];
    if (isset($mime[$ext])) header('Content-Type: ' . $mime[$ext]);
    if (in_array($ext, ['png','jpg','jpeg','gif','webp','svg','ico','woff','woff2','ttf','css','js'])) {
        header('Cache-Control: public, max-age=2592000');
    }
    readfile($staticFile);
    exit;
}

$blockedExts = ['log', 'ini', 'env', 'bat', 'sh', 'sql', 'lock'];
if (in_array($ext, $blockedExts)) {
    http_response_code(403);
    exit('Forbidden');
}

// ============================================================
// PASSO 4: Executar PHP do motor
// ============================================================
chdir($publicPath);
$_SERVER['DOCUMENT_ROOT'] = $publicPath;

if ($uri === '/' || $uri === '/index.php') {
    $targetFile = $publicPath . '/index.php';
    $scriptUri  = '/index.php';
} else {
    $candidate = $publicPath . $uri;
    if (is_file($candidate)) {
        $targetFile = $candidate;
        $scriptUri  = $uri;
    } elseif (is_file($candidate . '.php')) {
        $targetFile = $candidate . '.php';
        $scriptUri  = $uri . '.php';
    } else {
        $targetFile = $publicPath . '/index.php';
        $scriptUri  = '/index.php';
    }
}

$realTarget = realpath($targetFile);
$realPublic = realpath($publicPath);
if ($realTarget === false || strpos($realTarget, $realPublic) !== 0) {
    http_response_code(403);
    exit('Forbidden');
}

$_SERVER['PHP_SELF']        = $scriptUri;
$_SERVER['SCRIPT_NAME']     = $scriptUri;
$_SERVER['SCRIPT_FILENAME'] = $targetFile;

require $targetFile;
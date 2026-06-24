<?php
// ============================================================
// NobleWars - Ponto de Arranque Universal com Auto-Deteccao
// Versao: 2.0
// ============================================================
// Nao precisas de configurar nada - o script detecta o motor
// automaticamente.
// ============================================================

// Mostrar todos os erros para diagnostico
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// ============================================================
// PASSO 1: Encontrar o motor automaticamente
// ============================================================
$possiblePaths = [
    __DIR__ . '/new_engine',                    // game/new_engine (OVH actual)
    dirname(__DIR__) . '/new_engine',           // fora da pasta web
    __DIR__ . '/game/new_engine',               // alternativa
];

$enginePath = null;
foreach ($possiblePaths as $path) {
    if (is_dir($path) && file_exists($path . '/public/index.php')) {
        $enginePath = $path;
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
    echo '</ul><p>Coloca a pasta <code>new_engine/</code> dentro de <code>game/</code>.</p>';
    exit;
}

$publicPath = $enginePath . '/public';

// ============================================================
// PASSO 2: Determinar URI pedida
// ============================================================
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
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

// Bloquear ficheiros sensiveis
$blockedExts = ['log', 'ini', 'env', 'bat', 'sh', 'sql', 'lock'];
if (in_array($ext, $blockedExts)) {
    http_response_code(403);
    exit('Forbidden');
}

// ============================================================
// PASSO 4: Executar PHP do motor
// Chave: chdir() para public/ garante que require('configs/...')
// funciona em todos os ficheiros do motor
// ============================================================
chdir($publicPath);
$_SERVER['DOCUMENT_ROOT'] = $publicPath;

// Determinar ficheiro PHP a executar
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
        // URL nao encontrada -> router principal
        $targetFile = $publicPath . '/index.php';
        $scriptUri  = '/index.php';
    }
}

// Seguranca: garantir que o ficheiro esta dentro do public/
$realTarget = realpath($targetFile);
$realPublic = realpath($publicPath);
if ($realTarget === false || strpos($realTarget, $realPublic) !== 0) {
    http_response_code(403);
    exit('Forbidden');
}

$_SERVER['PHP_SELF']        = $scriptUri;
$_SERVER['SCRIPT_NAME']     = $scriptUri;
$_SERVER['SCRIPT_FILENAME'] = $targetFile;

// Executar o ficheiro PHP do motor
require $targetFile;
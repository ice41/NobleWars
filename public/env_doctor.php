<?php
/**
 * ============================
 *  env_doctor.php — DOUTOR DE AMBIENTE
 * ============================
 *
 * Explica porque é que o motor se comporta de forma diferente em localhost,
 * webhost (cPanel/Plesk) e VPS com Docker. Corre o MESMO código nos três e
 * compara os resultados.
 *
 * COMO USAR:
 *   https://<dominio>/env_doctor.php                      (localhost: sem token)
 *   https://<dominio>/env_doctor.php?admin_token=XXXX     (fora de localhost)
 *   php public/env_doctor.php                             (linha de comandos)
 *
 * O token é o mesmo dos outros diagnósticos (app/Config/diag_token.php).
 *
 * Verifica os pontos que tipicamente divergem entre ambientes:
 *   - caminho da app (app/ irmão de public/ vs dentro do docroot)
 *   - cache do CoreFetcher (existe? gravável? dono?)
 *   - extensões PHP exigidas (openssl, tokenizer, ...)
 *   - diferenças de sistema de ficheiros (case-sensitive, CRLF, BOM)
 *   - licença e domínio
 *   - definições de erro do PHP (display_errors, error_reporting)
 */

// ============================================================
// AUTORIZAÇÃO
// ============================================================
$isCli = (PHP_SAPI === 'cli');

if (!$isCli) {
    $isLocal = in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true);
    $authorized = $isLocal;
    if (!$authorized) {
        $tokenFile = dirname(__DIR__) . '/app/Config/diag_token.php';
        if (file_exists($tokenFile)) {
            $expected = include $tokenFile;
            $provided = $_POST['admin_token'] ?? $_GET['admin_token'] ?? '';
            if (!empty($expected) && hash_equals((string) $expected, (string) $provided)) {
                $authorized = true;
            }
        }
    }
    if (!$authorized) {
        http_response_code(403);
        header('Content-Type: text/plain; charset=utf-8');
        die("Acesso negado. Usa ?admin_token=<token de app/Config/diag_token.php>\n");
    }
    header('Content-Type: text/plain; charset=utf-8');
}

$publicDir = __DIR__;
$appDir    = dirname(__DIR__) . '/app';        // app/ é irmão de public/
$rootDir   = dirname(__DIR__);

$ok = 0;
$warn = 0;
$fail = 0;

function line(string $s = ''): void { echo $s . "\n"; }

function verdict(string $level, string $label, string $detail = ''): void
{
    global $ok, $warn, $fail;
    $tag = ['OK' => '[ OK ]', 'WARN' => '[WARN]', 'FAIL' => '[FAIL]'][$level] ?? '[????]';
    if ($level === 'OK') $ok++;
    elseif ($level === 'WARN') $warn++;
    else $fail++;
    line(sprintf('%s %-42s %s', $tag, $label, $detail));
}

function mask(?string $v): string
{
    if ($v === null || $v === '') return '(vazio)';
    if (strlen($v) <= 6) return str_repeat('*', strlen($v));
    return substr($v, 0, 3) . str_repeat('*', max(1, strlen($v) - 6)) . substr($v, -3);
}

/** Procura ficheiros de chave privada dentro de um directório. */
function findPrivateKeys(string $dir): array
{
    if (!is_dir($dir)) return [];
    $hits = [];
    try {
        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)
        );
        foreach ($it as $f) {
            if ($f->isFile() && preg_match('/(private|master).*\.(pem|key)$/i', $f->getFilename())) {
                $hits[] = $f->getPathname();
            }
        }
    } catch (\Throwable $e) {
        // ignorar
    }
    return $hits;
}

line('============================================================');
line(' NOBLEWARS — DOUTOR DE AMBIENTE');
line('============================================================');
line();

// ============================================================
// 1. RUNTIME
// ============================================================
line('--- 1. RUNTIME PHP ---');
verdict(version_compare(PHP_VERSION, '8.1.0', '>=') ? 'OK' : 'FAIL',
    'Versão PHP', PHP_VERSION . ' (' . PHP_SAPI . ')');
verdict('OK', 'Sistema operativo', PHP_OS . ' / ' . PHP_OS_FAMILY);
verdict(extension_loaded('openssl') ? 'OK' : 'FAIL',
    'Extensão openssl', extension_loaded('openssl') ? 'carregada' : 'EM FALTA (core não desencripta)');
verdict(extension_loaded('tokenizer') ? 'OK' : 'FAIL',
    'Extensão tokenizer', extension_loaded('tokenizer') ? 'carregada' : 'EM FALTA (fixMagicDir falha)');
verdict(extension_loaded('json') ? 'OK' : 'FAIL',
    'Extensão json', extension_loaded('json') ? 'carregada' : 'EM FALTA');
verdict(extension_loaded('phar') ? 'OK' : 'WARN',
    'Extensão phar', extension_loaded('phar') ? 'carregada' : 'ausente (build_release sem tar.gz)');
foreach (['pdo', 'pdo_mysql', 'mbstring', 'curl'] as $ext) {
    verdict(extension_loaded($ext) ? 'OK' : 'WARN', "Extensão $ext",
        extension_loaded($ext) ? 'carregada' : 'ausente');
}

$disableFns = array_map('trim', explode(',', (string) ini_get('disable_functions')));
$neededFns = ['eval', 'file_get_contents', 'hash_hmac', 'openssl_decrypt', 'token_get_all'];
$blocked = array_intersect($neededFns, $disableFns);
if (!empty($blocked)) {
    verdict('FAIL', 'Funções necessárias bloqueadas', implode(', ', $blocked));
} else {
    verdict('OK', 'Funções necessárias', 'disponíveis');
}

$ob = ini_get('open_basedir');
verdict($ob ? 'WARN' : 'OK', 'open_basedir', $ob ?: '(sem restrição)');
line();

// ============================================================
// 2. DEFINIÇÕES DE ERRO (divergência clássica entre ambientes)
// ============================================================
line('--- 2. ERROS PHP ---');
verdict((int) ini_get('display_errors') === 0 ? 'OK' : 'WARN', 'display_errors',
    ini_get('display_errors') ? 'ligado (não ideal em produção)' : 'desligado');
verdict('OK', 'error_reporting', ini_get('error_reporting'));
verdict(ini_get('log_errors') ? 'OK' : 'WARN', 'log_errors', ini_get('log_errors') ? 'ligado' : 'desligado');
verdict('OK', 'memory_limit', ini_get('memory_limit'));
verdict('OK', 'max_execution_time', ini_get('max_execution_time'));
line();

// ============================================================
// 3. CAMINHOS
// ============================================================
line('--- 3. CAMINHOS ---');
verdict(is_dir($appDir) ? 'OK' : 'FAIL', 'app/ irmão de public/', $appDir);
$appInside = $publicDir . '/app';
verdict(!is_dir($appInside) ? 'OK' : 'WARN', 'public/app (não deve existir)', is_dir($appInside) ? 'EXISTE — layout inesperado' : 'ausente');
verdict(is_file($appDir . '/CoreFetcher.php') ? 'OK' : 'FAIL', 'app/CoreFetcher.php', is_file($appDir . '/CoreFetcher.php') ? 'presente' : 'AUSENTE');
verdict(is_file($rootDir . '/.env') ? 'OK' : 'WARN', '.env no root', is_file($rootDir . '/.env') ? 'presente' : 'ausente (usa variáveis de ambiente?)');
line();

// ============================================================
// 4. CACHE DO COREFETCHER
// ============================================================
line('--- 4. CACHE DO COREFETCHER ---');
$cacheCandidates = [];
$envCache = getenv('NOBLEWARS_CACHE_DIR');
if (!empty($envCache)) {
    $cacheCandidates['NOBLEWARS_CACHE_DIR'] = rtrim(str_replace('\\', '/', $envCache), '/') . '/';
}
$cacheCandidates['app/storage/core_cache/ (irmão)'] = str_replace('\\', '/', $appDir . '/storage/core_cache/');
$cacheCandidates['temp'] = str_replace('\\', '/', sys_get_temp_dir())
    . '/noblewars_core_cache_' . md5($appDir) . '/';

$resolvedCache = null;
foreach ($cacheCandidates as $label => $dir) {
    $exists = is_dir($dir);
    $writable = $exists ? is_writable($dir) : null;
    $detail = $dir;
    if ($exists) {
        $detail .= '  | gravável: ' . ($writable ? 'SIM' : 'NÃO');
        if (!$writable) {
            verdict('FAIL', "cache [$label]", $detail);
        } else {
            verdict('OK', "cache [$label]", $detail);
            if ($resolvedCache === null) $resolvedCache = $dir;
        }
    } else {
        verdict('WARN', "cache [$label]", $detail . '  | não existe');
    }
}

// Teste de escrita real
if ($resolvedCache !== null) {
    $probe = $resolvedCache . '.env_doctor_write_test_' . time() . '.tmp';
    $written = @file_put_contents($probe, 'test');
    if ($written !== false) {
        @unlink($probe);
        verdict('OK', 'Teste de escrita na cache', 'sucesso');
    } else {
        verdict('FAIL', 'Teste de escrita na cache', 'FALHOU (cache não gravável de facto)');
    }
    $files = glob($resolvedCache . '*.enc');
    verdict('OK', 'Ficheiros em cache', count($files ?: []) . ' ficheiro(s) .enc');
} else {
    verdict('FAIL', 'Cache utilizável', 'nenhum directório de cache existe/gravável');
}

if (function_exists('posix_geteuid')) {
    verdict('OK', 'Utilizador PHP', (posix_getpwuid(posix_geteuid())['name'] ?? '?'));
} else {
    verdict('OK', 'Utilizador PHP', get_current_user() . ' (posix indisponível)');
}
line();

// ============================================================
// 5. SEMÂNTICA DO SISTEMA DE FICHEIROS
// ============================================================
line('--- 5. SISTEMA DE FICHEIROS ---');

// Case sensitivity: tenta abrir com maiúsculas/minúsculas trocadas
$caseProbe = $appDir . '/CoreFetcher.php';
$caseSwapped = $appDir . '/corefetcher.php';
// Case-sensitive se o ficheiro com o nome trocado NÃO for encontrado.
// (Em Windows/macOS o nome trocado resolve para o mesmo ficheiro.)
$caseSensitive = is_file($caseProbe) && !is_file($caseSwapped);
verdict($caseSensitive ? 'WARN' : 'OK', 'Sistema de ficheiros',
    $caseSensitive ? 'case-SENSITIVE (Linux) — includes com maiúsculas erradas falham'
                   : 'case-insensitive (Windows/macOS)');

// CRLF / BOM em ficheiros-chave
$checkFiles = [
    'app/CoreFetcher.php' => $appDir . '/CoreFetcher.php',
    'public/index.php'    => $publicDir . '/index.php',
];
foreach ($checkFiles as $label => $path) {
    if (!is_file($path)) { verdict('WARN', "line-endings $label", 'ficheiro ausente'); continue; }
    $raw = (string) @file_get_contents($path);
    $hasCrlf = strpos($raw, "\r\n") !== false;
    $hasBom = substr($raw, 0, 3) === "\xEF\xBB\xBF";
    if ($hasBom) {
        verdict('FAIL', "$label BOM", 'tem BOM UTF-8 (pode partir output/headers)');
    } elseif ($hasCrlf) {
        verdict('WARN', "$label line-endings", 'CRLF (dá problemas em Docker/Linux)');
    } else {
        verdict('OK', "$label line-endings", 'LF, sem BOM');
    }
}

// Permissões de pastas críticas
foreach ([$appDir, $appDir . '/Config', $appDir . '/storage'] as $p) {
    if (!is_dir($p)) { verdict('WARN', 'perms ' . basename($p), 'não existe'); continue; }
    $perm = substr(sprintf('%o', fileperms($p)), -4);
    verdict('OK', 'perms ' . str_replace($rootDir, '', $p), $perm);
}
line();

// ============================================================
// 6. LICENÇA E DOMÍNIO
// ============================================================
line('--- 6. LICENÇA ---');
$licenseFile = getenv('NOBLEWARS_LICENSE_FILE') ?: ($appDir . '/Config/license.php');
if (is_file($licenseFile)) {
    $raw = include $licenseFile;
    $decoded = base64_decode((string) $raw, true);
    if ($decoded !== false && strpos($decoded, ':') !== false) {
        [$licDomain] = explode(':', $decoded, 2);
        $host = strtolower(preg_replace('/^www\./', '', $_SERVER['HTTP_HOST'] ?? 'cli'));
        $match = ($licDomain === $host)
            || (substr($host, -strlen('.' . $licDomain)) === '.' . $licDomain)
            || (PHP_SAPI === 'cli');
        verdict($match ? 'OK' : 'FAIL', 'Domínio da licença',
            "licença=$licDomain | actual=$host");
    } else {
        verdict('WARN', 'Licença', 'formato não reconhecido');
    }
} else {
    verdict('WARN', 'Ficheiro de licença', "ausente: $licenseFile");
}
line();

// ============================================================
// 7. VARIÁVEIS DE AMBIENTE / .env
// ============================================================
line('--- 7. VARIÁVEIS NOBLEWARS_* ---');
foreach ([
    'NOBLEWARS_API_URL',
    'NOBLEWARS_LICENSE_KEY',
    'NOBLEWARS_LICENSE_FILE',
    'NOBLEWARS_CACHE_DIR',
    'NOBLEWARS_LOCAL_DEV',
    'NOBLEWARS_LICENSE_SECRET',
    'NOBLEWARS_REFRESH_TOKEN',
] as $var) {
    $val = getenv($var);
    $present = ($val !== false && $val !== '');
    $isSecret = in_array($var, ['NOBLEWARS_LICENSE_KEY', 'NOBLEWARS_LICENSE_SECRET', 'NOBLEWARS_REFRESH_TOKEN'], true);
    verdict($present ? 'OK' : 'WARN', $var, $present ? ($isSecret ? mask((string) $val) : (string) $val) : 'não definida');
}
line();

// ============================================================
// 8. SEGURANÇA (assinaturas RSA)
// ============================================================
line('--- 8. SEGURANÇA (assinaturas) ---');
$pubFile = $appDir . '/Config/license_public.pem';
if (is_file($pubFile)) {
    $pem = (string) file_get_contents($pubFile);
    verdict(strpos($pem, '-----BEGIN PUBLIC KEY-----') !== false ? 'OK' : 'FAIL',
        'license_public.pem', 'presente (' . substr(hash('sha256', $pem), 0, 16) . '…)');
} else {
    verdict('WARN', 'license_public.pem', 'ausente — assinaturas RSA desligadas (corre gen_license_keys.php)');
}
verdict(file_exists($appDir . '/Config/LicenseCrypto.php') ? 'OK' : 'FAIL',
    'LicenseCrypto.php', file_exists($appDir . '/Config/LicenseCrypto.php') ? 'presente' : 'EM FALTA');

// Uma chave PRIVADA dentro do docroot web é uma fuga crítica.
$leaked = array_merge(findPrivateKeys($publicDir), findPrivateKeys($appDir));
if (!empty($leaked)) {
    verdict('FAIL', 'Chave privada no directório web',
        implode(', ', array_map(function ($p) use ($rootDir) { return str_replace($rootDir, '', $p); }, $leaked)));
} else {
    verdict('OK', 'Chave privada fora do código web', 'nenhuma chave privada encontrada');
}
line();

// ============================================================
// RESUMO
// ============================================================
line('============================================================');
line(" RESUMO: $ok OK | $warn avisos | $fail falhas");
if ($fail > 0) {
    line(' Corrige as linhas [FAIL] — são as causas prováveis das diferenças');
    line(' entre localhost e webhost/VPS.');
} elseif ($warn > 0) {
    line(' Sem falhas. Os [WARN] podem explicar comportamentos diferentes');
    line(' entre ambientes (ex.: CRLF vs LF, cache ausente).');
} else {
    line(' Ambiente saudável. Se algo difere, compara este output nos');
    line(' dois ambientes lado a lado.');
}
line('============================================================');

exit($fail > 0 ? 1 : 0);

<?php
define('NEW_ENGINE_ACTIVE', true);
/*****************************************/
/*     INDEX.PHP - MODERNIZADO          */
/*     100% FIEL AO ORIGINAL            */
/*     PHP 7+/8+ com MySQLi             */
/*****************************************/

// Erro handler global: captura TUDO, incluindo erros fatais do bootstrap
set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

try {
    // Configuração de cookies de sessão para suportar subdomínios
    require_once(__DIR__ . '/configs/config.php');
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $isLocalhost = ($host === 'localhost' || str_starts_with($host, 'localhost:') || $host === '127.0.0.1' || str_starts_with($host, '127.0.0.1:') || $host === '[::1]' || str_starts_with($host, '[::1]:'));

    if (!empty($conf['base_domain']) && !$isLocalhost) {
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'domain' => '.' . $conf['base_domain'],
            'secure' => $conf['is_https'] ?? false,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    }
    session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// CoreFetcher: carrega ficheiros críticos do servidor central
require_once(__DIR__ . '/../app/CoreFetcher.php');
if (!class_exists('CoreFetcher')) {
    throw new Exception('Classe CoreFetcher não encontrada. Verificar: (1) eval() desativado? (2) .ice41 existe? (3) Ofuscação correta?');
}
\CoreFetcher::init();

// ============================================================
// FALLBACK LOCAL: Lê todas as credenciais do ficheiro do mundo
// (Definido ANTES do CoreFetcher::load() para garantir que
//  a versão com __DIR__ correto (public/) é usada)
// ============================================================
if (!function_exists('get_world_db_config')) {
function get_world_db_config($world) {
    $world = (string)$world;

    // ============================================================
    // 1. Obter credenciais padrão do $conf global ou do database.php
    // ============================================================
    global $conf;
    $defaultHost = $conf['db_host'] ?? null;
    $defaultUser = $conf['db_user'] ?? null;
    $defaultPass = $conf['db_pass'] ?? null;
    $defaultDb   = $conf['db_name'] ?? null;

    if ($defaultHost === null) {
        // Tenta carregar o database.php usando caminhos alternativos
        $dbPaths = [
            __DIR__ . '/../app/Config/database.php',
        ];
        foreach ($dbPaths as $dbConfigFile) {
            if (file_exists($dbConfigFile)) {
                $savedConf = $conf;
                @include $dbConfigFile;
                $defaultHost = $conf['db_host'] ?? 'localhost';
                $defaultUser = $conf['db_user'] ?? 'root';
                $defaultPass = $conf['db_pass'] ?? '';
                $defaultDb   = $conf['db_name'] ?? '';
                $conf = $savedConf;
                break;
            }
        }
        if ($defaultHost === null) {
            $defaultHost = 'localhost';
            $defaultUser = 'root';
            $defaultPass = '';
            $defaultDb   = '';
        }
    }

    // ============================================================
    // 2. Extrair prefixo do hosting (db_prefix explícito > extração automática)
    // ============================================================
    $prefix = $conf['db_prefix'] ?? '';
    
    // Fallback: extrair prefixo do nome da base de dados principal
    if (empty($prefix) && !empty($defaultDb)) {
        if (str_ends_with($defaultDb, 'index_tw')) {
            $prefix = substr($defaultDb, 0, -strlen('index_tw'));
        } elseif (str_ends_with($defaultDb, 'index')) {
            $prefix = substr($defaultDb, 0, -strlen('index'));
        } else {
            $lastUnderscore = strrpos($defaultDb, '_');
            if ($lastUnderscore !== false) {
                $prefix = substr($defaultDb, 0, $lastUnderscore + 1);
            }
        }
    }

    // ============================================================
    // 3. Validar world ID (prevenir path traversal)
    // ============================================================
    if (!preg_match('/^[a-zA-Z0-9_-]+$/', $world)) {
        return [
            'host' => $defaultHost,
            'user' => $defaultUser,
            'pass' => $defaultPass,
            'name' => $prefix . 'lan_invalid',
        ];
    }

    // ============================================================
    // 4. Tentar vários caminhos para o ficheiro de configuração do mundo
    // ============================================================
    $worldDbName = $prefix . 'lan_' . $world;

    $pathsToTry = [
        __DIR__ . '/../app/Config/Worlds/' . $world . '.php',
    ];

    $worldConfigFile = null;
    foreach ($pathsToTry as $p) {
        $realPath = realpath($p);
        if ($realPath !== false && file_exists($realPath)) {
            $worldConfigFile = $realPath;
            break;
        }
    }

    $defaultConfig = [
        'host' => $defaultHost,
        'user' => $defaultUser,
        'pass' => $defaultPass,
        'name' => $worldDbName,
    ];

    if ($worldConfigFile !== null) {
        $config = @include $worldConfigFile;
        if (is_array($config)) {
            return [
                'host' => $config['db_host'] ?? $defaultConfig['host'],
                'user' => $config['db_user'] ?? $defaultConfig['user'],
                'pass' => $config['db_pw'] ?? ($config['db_pass'] ?? $defaultConfig['pass']),
                'name' => $config['db_name'] ?? $defaultConfig['name'],
            ];
        }
        error_log('[get_world_db_config] world config file loaded but not array: ' . $worldConfigFile);
    } else {
        error_log('[get_world_db_config] world config file NOT FOUND for world=' . $world . '. Tried: ' . implode(', ', $pathsToTry) . ' | prefix=' . $prefix . ' | fallback=' . $worldDbName);
    }
    
    return $defaultConfig;
}
}

\CoreFetcher::load('Helpers/helpers.php');
\CoreFetcher::load('Helpers/language_helper.php');

// Set Security Headers
\App\Helpers\SecurityHelper::setHeaders();

// Initialize language system
if (function_exists('init_locale')) {
    init_locale();
} else {
    throw new Exception('init_locale() não definida — CoreFetcher não carregou language_helper.php');
}

// Conectar BD
$conn = @mysqli_connect($conf['db_host'], $conf['db_user'], $conf['db_pass'], $conf['db_name']);
if (!$conn)
    $conn = @mysqli_connect($conf['db_host'], $conf['db_user'], '', $conf['db_name']);
if (!$conn)
    die(__('stats.config_load_error') . ': ' . mysqli_connect_error());

mysqli_set_charset($conn, 'utf8');
mysqli_query($conn, "SET SESSION sql_mode = ''");

// Funções auxiliares
function sql($query, $type = 'array')
{
    global $conn;
    $result = mysqli_query($conn, $query);
    if (!$result)
        return $type == 'array' ? 0 : array();
    if ($type == 'array') {
        $row = mysqli_fetch_row($result);
        return $row ? $row[0] : 0;
    } elseif ($type == 'assoc') {
        return mysqli_fetch_assoc($result);
    }
    return $result;
}

<<<<<<< Updated upstream
=======
/**
 * Helper para prepared statements MySQLi.
 * Suporta SELECT, INSERT, UPDATE e DELETE com bind dinâmico de parâmetros.
 */
function sql_prepare($conn, $query, $params = [], $type = 'array')
{
    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        return $type == 'array' ? 0 : ($type == 'assoc' ? [] : false);
    }

    if (!empty($params)) {
        $types = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // INSERT, UPDATE, DELETE não retornam result set
    if ($result === false) {
        $affected = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        return $affected;
    }

    $ret = null;
    if ($type == 'array') {
        $row = mysqli_fetch_row($result);
        $ret = $row ? $row[0] : 0;
    } elseif ($type == 'assoc') {
        $ret = mysqli_fetch_assoc($result);
    } else {
        $ret = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    mysqli_stmt_close($stmt);
    return $ret;
}

/**
 * Garante que a tabela de rate limiting por IP existe.
 */
function ensureLoginAttemptsTable($conn)
{
    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS login_attempts (
        ip VARCHAR(45) PRIMARY KEY,
        attempts INT NOT NULL DEFAULT 0,
        last_attempt INT NOT NULL DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

/**
 * Garante que a tabela de sessões do mundo existe.
 * Cria a tabela automaticamente se faltar (útil em bases novas ou Docker).
 */
function ensureSessionsTable($conn)
{
    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS sessions (
        id INT NOT NULL AUTO_INCREMENT,
        userid INT NOT NULL,
        sid VARCHAR(32) NOT NULL,
        hkey VARCHAR(4) NOT NULL DEFAULT '',
        is_vacation INT NOT NULL DEFAULT 0,
        PRIMARY KEY (id),
        KEY idx_sid (sid),
        KEY idx_userid (userid)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
}

/**
 * Verifica se o IP está bloqueado devido a tentativas falhadas.
 * Retorna mensagem de erro ou string vazia se não estiver bloqueado.
 */
function checkIpRateLimit($conn, $ip)
{
    ensureLoginAttemptsTable($conn);
    $now = time();
    $blockTime = 15 * 60; // 15 minutos

    $rateData = sql_prepare($conn, "SELECT attempts, last_attempt FROM login_attempts WHERE ip = ?", [$ip], 'assoc');

    if ($rateData && (int)$rateData['attempts'] >= 5) {
        $elapsed = $now - (int)$rateData['last_attempt'];
        if ($elapsed < $blockTime) {
            $remaining = ceil(($blockTime - $elapsed) / 60);
            return __('public.index.error_too_many_attempts', ['minutes' => $remaining])
                ?: "Demasiadas tentativas falhadas. Tente novamente em {$remaining} minuto(s).";
        } else {
            // Bloqueio expirou, resetar
            sql_prepare($conn, "DELETE FROM login_attempts WHERE ip = ?", [$ip]);
        }
    }

    return '';
}

/**
 * Regista uma tentativa de login falhada por IP (incremento atómico).
 */
function recordFailedLogin($conn, $ip)
{
    ensureLoginAttemptsTable($conn);
    $now = time();

    // Incremento atómico para evitar race conditions entre pedidos concorrentes
    sql_prepare(
        $conn,
        "INSERT INTO login_attempts (ip, attempts, last_attempt) VALUES (?, 1, ?)
         ON DUPLICATE KEY UPDATE attempts = attempts + 1, last_attempt = ?",
        [$ip, $now, $now]
    );
}

/**
 * Limpa as tentativas de login falhadas por IP (login bem-sucedido).
 */
function clearFailedLogins($conn, $ip)
{
    ensureLoginAttemptsTable($conn);
    sql_prepare($conn, "DELETE FROM login_attempts WHERE ip = ?", [$ip]);
}

>>>>>>> Stashed changes
function GetClientIP()
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        return '127.0.0.1';
    }
    return $ip;
}

<<<<<<< Updated upstream
// ============================================================
// NOVA FUNÇÃO: Lê todas as credenciais do ficheiro do mundo
// ============================================================
function get_world_db_config($world) {
    $worldConfigFile = __DIR__ . '/../app/Config/Worlds/' . $world . '.php';
    
    $defaultConfig = [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '',
        'name' => 'lan_' . $world,
    ];

    if (file_exists($worldConfigFile)) {
        // Captura o array retornado pelo ficheiro (return [...])
        $config = @include $worldConfigFile;
        
        if (is_array($config)) {
            return [
                'host' => $config['db_host'] ?? $defaultConfig['host'],
                'user' => $config['db_user'] ?? $defaultConfig['user'],
                'pass' => $config['db_pw'] ?? ($config['db_pass'] ?? $defaultConfig['pass']),
                'name' => $config['db_name'] ?? $defaultConfig['name'],
            ];
        }
    }
    
    return $defaultConfig;
}

=======
>>>>>>> Stashed changes
// Variáveis
$error = '';
$speedlogin = false;
$can_log = true;
$wybierz_swiat = false;

// Processar logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    if (!isset($_GET['csrf_token']) || $_GET['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        die("Token CSRF inválido.");
    }
    $ip = mysqli_real_escape_string($conn, GetClientIP());
    mysqli_query($conn, "DELETE FROM conecoes WHERE client_ip = '$ip'");
    session_destroy();

    // Limpar cookie de sessão do mundo ativo
    $currentWorld = get_active_world();
    setcookie('session_' . $currentWorld, '', [
        'expires' => time() - 3600,
        'path' => '/',
        'domain' => get_cookie_domain(),
        'secure' => $conf['is_https'] ?? false,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    
    setcookie('session', '', [
        'expires' => time() - 3600,
        'path' => '/',
        'domain' => get_cookie_domain(),
        'secure' => $conf['is_https'] ?? false,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    header('Location: index.php');
    exit;
}

// ============================================================
// RECUPERAÇÃO DE SENHA — passo 1: enviar token por email
// ============================================================
if (isset($_GET['action']) && $_GET['action'] == 'forgot_password' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        die("Token CSRF inválido.");
    }
    $recoveryEmail = strtolower(trim($_POST['recovery_email'] ?? ''));
    $recoveryMsg   = '';
    // Sempre mostrar mensagem genérica (não revelar se email existe)
    $recoveryMsg = __('public.index.recovery_sent', []) ?: "Se o e-mail estiver registado, receberá uma mensagem em instantes.";

    if (filter_var($recoveryEmail, FILTER_VALIDATE_EMAIL)) {
        $foundUser = sql("SELECT * FROM conta WHERE LOWER(email) = '" . mysqli_real_escape_string($conn, $recoveryEmail) . "' LIMIT 1", 'assoc');
        if ($foundUser) {
            $token     = bin2hex(random_bytes(20));
            $expiresAt = time() + 900; // 15 minutos
            // Guardar token na sessão (sem cronjob, sem tabela extra)
            $_SESSION['pw_recovery'] = [
                'token'      => $token,
                'user_id'    => $foundUser['id'],
                'expires_at' => $expiresAt,
            ];

            $baseUrl   = ((!empty($conf['is_https']) && $conf['is_https']) ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . strtok($_SERVER['REQUEST_URI'] ?? '/index.php', '?');
            $resetLink = $baseUrl . "?action=reset_password_form&token=" . urlencode($token);

            $emailBody = "
<html><body style='font-family:Arial,sans-serif;background:#1a0a00;color:#d4a445;padding:30px;'>
<div style='max-width:500px;margin:0 auto;background:#2a1a00;border:1px solid #8B6914;border-radius:8px;padding:30px;'>
<h2 style='color:#FFD700;'>⚔️ NobleWars — Recuperação de Senha</h2>
<p>Olá, <b>" . htmlspecialchars($foundUser['nazwa']) . "</b>!</p>
<p>Recebemos um pedido de recuperação de senha para a sua conta.</p>
<p>Clique no botão abaixo para redefinir a sua senha <strong>(válido por 15 minutos)</strong>:</p>
<div style='text-align:center;margin:25px 0;'>
<a href='" . htmlspecialchars($resetLink) . "' style='background:#8B6914;color:#FFD700;padding:12px 28px;border-radius:5px;text-decoration:none;font-weight:bold;font-size:16px;'>Redefinir Senha</a>
</div>
<p style='font-size:12px;color:#999;'>Se não pediu a recuperação da senha, ignore este email.<br>O link expira em 15 minutos.</p>
</div></body></html>";

            \App\Helpers\MailHelper::send(
                $recoveryEmail,
                'NobleWars — Recuperação de Senha',
                $emailBody
            );
        }
    }
    $error = ''; // limpar erros
    $recovery_message = $recoveryMsg;
}

// ============================================================
// RECUPERAÇÃO DE SENHA — passo 2: validar token e redefinir
// ============================================================
if (isset($_GET['action']) && $_GET['action'] == 'do_reset_password' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        die("Token CSRF inválido.");
    }
    $token         = trim($_POST['reset_token'] ?? '');
    $newPassword   = $_POST['new_password'] ?? '';
    $confirmPass   = $_POST['confirm_password'] ?? '';
    $resetError    = '';
    $resetSuccess  = false;

    $storedRecovery = $_SESSION['pw_recovery'] ?? null;
    if (!$storedRecovery || $storedRecovery['token'] !== $token || time() > $storedRecovery['expires_at']) {
        $resetError = "Link de recuperação inválido ou expirado. Solicite um novo.";
    } elseif (strlen($newPassword) < 6) {
        $resetError = "A nova senha deve ter pelo menos 6 caracteres.";
    } elseif ($newPassword !== $confirmPass) {
        $resetError = "As senhas não coincidem.";
    } else {
        $newHash   = \App\Helpers\SecurityHelper::hashPassword($newPassword);
        $userId    = (int)$storedRecovery['user_id'];
        mysqli_query($conn, "UPDATE conta SET haslo = '" . mysqli_real_escape_string($conn, $newHash) . "' WHERE id = $userId");
        unset($_SESSION['pw_recovery']); // invalidar token após uso
        $resetSuccess = true;
    }
}

// Processar seleção de mundo
if (isset($_GET['action']) && $_GET['action'] == 'select_world') {
    if (!isset($_GET['csrf_token']) || $_GET['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        die("Token CSRF inválido.");
    }
    $ip = mysqli_real_escape_string($conn, GetClientIP());
    $userid = sql("SELECT client_id FROM conecoes WHERE client_ip = '$ip' LIMIT 1", 'array');

    if ($userid) {
        $world = $_GET['world'] ?? get_active_world();
        $world = mysqli_real_escape_string($conn, $world);

        // OBTER CREDENCIAIS COMPLETAS DO MUNDO
        $worldDbConfig = get_world_db_config($world);

        // Conectar à base de dados do mundo usando as SUAS credenciais
        $worldConn = @mysqli_connect(
            $worldDbConfig['host'], 
            $worldDbConfig['user'], 
            $worldDbConfig['pass'], 
            $worldDbConfig['name']
        );
        
        if (!$worldConn) {
            $worldConn = @mysqli_connect(
                $worldDbConfig['host'], 
                $worldDbConfig['user'], 
                '', 
                $worldDbConfig['name']
            );
        }

        if ($worldConn) {
            mysqli_query($worldConn, "SET SESSION sql_mode = ''");
            mysqli_set_charset($worldConn, 'utf8');

            $sid = bin2hex(random_bytes(16));

<<<<<<< Updated upstream
            $query = "INSERT INTO sessions (sid, userid, hkey) VALUES ('$sid', '$userid', '')";
            if (!mysqli_query($worldConn, $query)) {
=======
            // Garantir que a tabela de sessões existe antes de inserir
            ensureSessionsTable($worldConn);

            if (sql_prepare($worldConn, "INSERT INTO sessions (sid, userid, hkey) VALUES (?, ?, '')", [$sid, $userid]) === false) {
>>>>>>> Stashed changes
                $error = __('public.index.error_world_connection', ['world' => $world]) . ': ' . mysqli_error($worldConn);
                mysqli_close($worldConn);
            } else {
                mysqli_close($worldConn);

                set_session_cookie($sid, 7200, $world);
                $_SESSION['world'] = $world;

                header('Location: ' . get_world_url($world, 'game.php?screen=overview'));
                exit;
            }
        } else {
            $error = __('public.index.error_world_db_not_found', ['world' => $world, 'db' => $worldDbConfig['name']]);
        }
    } else {
        header('Location: index.php');
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'login' && isset($_POST['user'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        $error = "Token CSRF inválido.";
    } else {
        // ── RATE LIMITING (sem cronjob — usa sessão PHP) ─────────────────────
        $now = time();
        if (!isset($_SESSION['login_attempts'])) $_SESSION['login_attempts'] = 0;
        if (!isset($_SESSION['login_block_until'])) $_SESSION['login_block_until'] = 0;

        if ($now < $_SESSION['login_block_until']) {
            $remaining = ceil(($_SESSION['login_block_until'] - $now) / 60);
            $error = __('public.index.error_too_many_attempts', ['minutes' => $remaining])
                     ?: "Demasiadas tentativas falhadas. Tente novamente em {$remaining} minuto(s).";
        } else {
            // Reset counter if block expired
            if ($_SESSION['login_block_until'] > 0 && $now >= $_SESSION['login_block_until']) {
                $_SESSION['login_attempts']   = 0;
                $_SESSION['login_block_until'] = 0;
            }
            // ─────────────────────────────────────────────────────────────────

        $username = mysqli_real_escape_string($conn, trim($_POST['user']));
        $password = $_POST['password'] ?? '';

        $user = sql("SELECT * FROM conta WHERE nazwa = '$username' LIMIT 1", 'assoc');

        if ($user && \App\Helpers\SecurityHelper::verifyPassword($password, $user['haslo'])) {
            // Login com sucesso — reset contadores de brute force
            $_SESSION['login_attempts']   = 0;
            $_SESSION['login_block_until'] = 0;

            if (substr($user['haslo'], 0, 4) !== '$2y$') {
                $newHash = \App\Helpers\SecurityHelper::hashPassword($password);
                $user_id_esc = (int)$user['id'];
                mysqli_query($conn, "UPDATE conta SET haslo = '$newHash' WHERE id = $user_id_esc");
                $user['haslo'] = $newHash;
            }

            $_SESSION['user_id'] = $user['id'];
            $ip = mysqli_real_escape_string($conn, GetClientIP());
            mysqli_query($conn, "DELETE FROM conecoes WHERE client_ip = '$ip'");
            mysqli_query($conn, "INSERT INTO conecoes (client_ip, client_id) VALUES ('$ip', '{$user['id']}')");

            $user_agent = mysqli_real_escape_string($conn, $_SERVER['HTTP_USER_AGENT'] ?? '');
            $login_time = time();

            $worlds = array_filter(explode(';', $user['serwery_gry']));
            foreach ($worlds as $world) {
                $cleanWorld = trim($world);
                
                // OBTER CREDENCIAIS COMPLETAS DO MUNDO
                $worldDbConfig = get_world_db_config($cleanWorld);
                
                $worldConn = @mysqli_connect(
                    $worldDbConfig['host'], 
                    $worldDbConfig['user'], 
                    $worldDbConfig['pass'], 
                    $worldDbConfig['name']
                );
                
                if ($worldConn) {
                    mysqli_query($worldConn, "SET SESSION sql_mode = ''");
                    $ip_world = mysqli_real_escape_string($worldConn, GetClientIP());
                    mysqli_query($worldConn, "INSERT INTO logins (userid, username, time, ip) VALUES ('{$user['id']}', '{$user['nazwa']}', '$login_time', '$ip_world')");
                    mysqli_close($worldConn);
                }
            }

            $speedlogin = true;
            $can_log = false;
            $wybierz_swiat = true;
            $user_info = $user;
            $user_info['serwery_gry'] = $worlds;
        } else {
            // Login falhado — incrementar contador de brute force
            $_SESSION['login_attempts']++;
            if ($_SESSION['login_attempts'] >= 5) {
                $_SESSION['login_block_until'] = time() + (15 * 60); // bloquear 15 minutos
                $_SESSION['login_attempts']    = 0;
                $remaining = 15;
                $error = __('public.index.error_too_many_attempts', ['minutes' => $remaining])
                         ?: "Demasiadas tentativas falhadas. Conta bloqueada por {$remaining} minutos.";
            } else {
                $left = 5 - $_SESSION['login_attempts'];
                $error = $user ? __('public.index.error_password') : __('public.index.error_user_not_found');
                if ($left <= 2) {
                    $error .= " (" . $left . " tentativa(s) restante(s) antes do bloqueio temporário)";
                }
            }
        }
        } // fim do bloco de rate limiting
    }
}

// Verificar se já logado
$ip_check = mysqli_real_escape_string($conn, GetClientIP());
$counts = sql("SELECT COUNT(id) FROM conecoes WHERE client_ip = '$ip_check'", 'array');
if ($counts > 0 && !$speedlogin) {
    $can_log = false;
    $userid = sql("SELECT client_id FROM conecoes WHERE client_ip = '$ip_check' LIMIT 1", 'array');
    $user_info = sql("SELECT * FROM conta WHERE id = '$userid'", 'assoc');
    if (is_array($user_info)) {
        $val = isset($user_info['serwery_gry']) ? $user_info['serwery_gry'] : '';
        $user_info['serwery_gry'] = array_filter(explode(';', (string) $val));
        $wybierz_swiat = true;
    } else {
        $can_log = true;
    }
}

// Estatísticas
$players = sql("SELECT COUNT(*) FROM conta", 'array');

// Anúncios
$news = array();
$query = mysqli_query($conn, "SELECT * FROM news ORDER BY data DESC LIMIT 5");
if ($query) {
    while ($og = mysqli_fetch_assoc($query)) {
        $timestamp = !empty($og['data']) && is_numeric($og['data']) ? (int) $og['data'] : time();

        $news[] = array(
            'text' => urldecode($og['text']),
            'nazwa' => urldecode($og['nazwa']),
            'data' => date("d.m.Y", $timestamp)
        );
    }
}

// Navigation menu
$linki = [
    'index.php' => __('public.index.title'),
    'rules.php' => __('public.rules.title'),
    'team.php' => __('public.team.title'),
    'hall_of_fame.php' => __('public.hall_of_fame.title'),
    'help.php' => __('public.help.title'),
];

$current_theme = $conf['index_theme'] ?? 'classic';

mysqli_close($conn);

$active_worlds = [];
$world_files = glob(__DIR__ . '/../app/Config/Worlds/*.php');
sort($world_files);
foreach ($world_files as $file) {
    $worldId = basename($file, '.php');
    if (!empty($worldId)) {
        if (\App\Core\Database::getLicenseType() === 'free' && !empty($active_worlds)) {
            continue;
        }
        $active_worlds[] = $worldId;
    }
}

$user_worlds = [];
if (isset($user_info) && !empty($user_info['serwery_gry'])) {
    foreach ($user_info['serwery_gry'] as $w) {
        if (!empty(trim($w))) { $user_worlds[] = trim($w); }
    }
}

if ($current_theme == 'modern') {
    include __DIR__ . '/../app/Views/index_modern.php';
} else {
    include __DIR__ . '/../app/Views/index_classic.php';
}
} catch (Throwable $e) {
    error_log('[INDEX.PHP] ' . get_class($e) . ': ' . $e->getMessage() . ' em ' . $e->getFile() . ':' . $e->getLine());
    header('HTTP/1.1 500 Internal Server Error');
    ?>
    <!DOCTYPE html>
    <html><head><title>Erro — NobleWars</title>
    <style>body{font-family:monospace;background:#1a1a1a;color:#e0e0e0;padding:30px;max-width:800px;margin:0 auto;}
    h1{color:#f44336;border-bottom:2px solid #f44336;padding-bottom:8px;}
    .error{background:#2a1a1a;border:1px solid #f44336;border-radius:6px;padding:15px;margin:15px 0;}
    .error h2{color:#ff8a80;margin:0 0 10px 0;}
    .error p{margin:5px 0;color:#e0e0e0;}
    .trace{background:#1a1a2a;padding:10px;border-radius:4px;font-size:0.8em;overflow:auto;max-height:300px;}</style>
    </head><body>
    <h1>⚔️ Erro no Motor (Index)</h1>
    <div class="error">
        <h2><?= get_class($e) ?></h2>
        <p><strong>Mensagem:</strong> <?= htmlspecialchars($e->getMessage()) ?></p>
        <p><strong>Ficheiro:</strong> <?= basename($e->getFile()) ?> (linha <?= $e->getLine() ?>)</p>
        <p><strong>Path:</strong> <?= htmlspecialchars($e->getFile()) ?></p>
    </div>
    <h3>Stack Trace:</h3>
    <div class="trace"><?= htmlspecialchars($e->getTraceAsString()) ?></div>
    </body></html>
    <?php
}
restore_error_handler();
?>
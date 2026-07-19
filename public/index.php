<?php
define('NEW_ENGINE_ACTIVE', true);
/*****************************************/
/*     INDEX.PHP - MODERNIZADO          */
/*     100% FIEL AO ORIGINAL            */
/*     PHP 7+/8+ com MySQLi             */
/*****************************************/

// Configuração de cookies de sessão para suportar subdomínios
require_once('configs/config.php');
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

// Configuração original
require_once(__DIR__ . '/../app/Helpers/helpers.php');

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Set Security Headers
\App\Helpers\SecurityHelper::setHeaders();

// Load translation helpers
require_once(__DIR__ . '/../app/Helpers/language_helper.php');

// Initialize language system
init_locale();

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

function GetClientIP()
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        return '127.0.0.1';
    }
    return $ip;
}

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
    $ip = GetClientIP();
    sql_prepare($conn, "DELETE FROM conecoes WHERE client_ip = ?", [$ip]);
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
        $foundUser = sql_prepare($conn, "SELECT * FROM conta WHERE LOWER(email) = ? LIMIT 1", [$recoveryEmail], 'assoc');
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
        sql_prepare($conn, "UPDATE conta SET haslo = ? WHERE id = ?", [$newHash, $userId]);
        unset($_SESSION['pw_recovery']); // invalidar token após uso
        $resetSuccess = true;
    }
}

// Processar seleção de mundo
if (isset($_GET['action']) && $_GET['action'] == 'select_world') {
    if (!isset($_GET['csrf_token']) || $_GET['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        die("Token CSRF inválido.");
    }
<<<<<<< Updated upstream
    $ip = mysqli_real_escape_string($conn, GetClientIP());
    $userid = sql("SELECT client_id FROM conecoes WHERE client_ip = '$ip' LIMIT 1", 'array');
=======
    $ip = GetClientIP();
    $userid = (int)sql_prepare($conn, "SELECT client_id FROM conecoes WHERE client_ip = ? LIMIT 1", [$ip], 'array');
>>>>>>> Stashed changes

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

            if (sql_prepare($worldConn, "INSERT INTO sessions (sid, userid, hkey) VALUES (?, ?, '')", [$sid, $userid]) === false) {
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
        // ── RATE LIMITING POR IP ─────────────────────
        $clientIp = GetClientIP();
        $rateLimitError = checkIpRateLimit($conn, $clientIp);

        if ($rateLimitError) {
            $error = $rateLimitError;
        } else {

        $username = trim($_POST['user']);
        $password = $_POST['password'] ?? '';

        $user = sql_prepare($conn, "SELECT * FROM conta WHERE nazwa = ? LIMIT 1", [$username], 'assoc');

        if ($user && \App\Helpers\SecurityHelper::verifyPassword($password, $user['haslo'])) {
            // Login com sucesso — limpar tentativas falhadas por IP
            clearFailedLogins($conn, $clientIp);

            if (substr($user['haslo'], 0, 4) !== '$2y$') {
                $newHash = \App\Helpers\SecurityHelper::hashPassword($password);
                $userIdHash = (int)$user['id'];
                sql_prepare($conn, "UPDATE conta SET haslo = ? WHERE id = ?", [$newHash, $userIdHash]);
                $user['haslo'] = $newHash;
            }

            $_SESSION['user_id'] = $user['id'];
<<<<<<< Updated upstream
            $ip = mysqli_real_escape_string($conn, GetClientIP());
            mysqli_query($conn, "DELETE FROM conecoes WHERE client_ip = '$ip'");
            mysqli_query($conn, "INSERT INTO conecoes (client_ip, client_id) VALUES ('$ip', '{$user['id']}')");
=======
            $userIdVal = (int)$user['id'];
            sql_prepare($conn, "DELETE FROM conecoes WHERE client_ip = ?", [$clientIp]);
            sql_prepare($conn, "INSERT INTO conecoes (client_ip, client_id) VALUES (?, ?)", [$clientIp, $userIdVal]);
>>>>>>> Stashed changes

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
<<<<<<< Updated upstream
                    $ip_world = mysqli_real_escape_string($worldConn, GetClientIP());
                    mysqli_query($worldConn, "INSERT INTO logins (userid, username, time, ip) VALUES ('{$user['id']}', '{$user['nazwa']}', '$login_time', '$ip_world')");
=======
                    $userIdValWorld = (int)$user['id'];
                    $usernameWorld = $user['nazwa'];
                    sql_prepare($worldConn, "INSERT INTO logins (userid, username, time, ip) VALUES (?, ?, ?, ?)", [$userIdValWorld, $usernameWorld, $login_time, $clientIp]);
>>>>>>> Stashed changes
                    mysqli_close($worldConn);
                }
            }

            $speedlogin = true;
            $can_log = false;
            $wybierz_swiat = true;
            $user_info = $user;
            $user_info['serwery_gry'] = $worlds;
        } else {
            // Login falhado — registar tentativa por IP
            recordFailedLogin($conn, $clientIp);
            $rateData = sql_prepare($conn, "SELECT attempts FROM login_attempts WHERE ip = ?", [$clientIp], 'assoc');
            $attempts = $rateData ? (int)$rateData['attempts'] : 1;

            if ($attempts >= 5) {
                $remaining = 15;
                $error = __('public.index.error_too_many_attempts', ['minutes' => $remaining])
                         ?: "Demasiadas tentativas falhadas. Conta bloqueada por {$remaining} minutos.";
            } else {
                $left = 5 - $attempts;
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
$ip_check = GetClientIP();
$counts = sql_prepare($conn, "SELECT COUNT(id) FROM conecoes WHERE client_ip = ?", [$ip_check], 'array');
if ($counts > 0 && !$speedlogin) {
    $can_log = false;
<<<<<<< Updated upstream
    $userid = sql("SELECT client_id FROM conecoes WHERE client_ip = '$ip_check' LIMIT 1", 'array');
    $user_info = sql("SELECT * FROM conta WHERE id = '$userid'", 'assoc');
=======
    $userid = (int)sql_prepare($conn, "SELECT client_id FROM conecoes WHERE client_ip = ? LIMIT 1", [$ip_check], 'array');
    $user_info = sql_prepare($conn, "SELECT * FROM conta WHERE id = ?", [$userid], 'assoc');
>>>>>>> Stashed changes
    if (is_array($user_info)) {
        $val = isset($user_info['serwery_gry']) ? $user_info['serwery_gry'] : '';
        $user_info['serwery_gry'] = array_filter(explode(';', (string) $val));
        $wybierz_swiat = true;
    } else {
        $can_log = true;
    }
}

// Estatísticas
$players = sql_prepare($conn, "SELECT COUNT(*) FROM conta", [], 'array');

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
?>
<?php
session_start();
require_once('configs/config.php');

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0)
        return;
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file))
        require $file;
});

$conn = @mysqli_connect($conf['db_host'], $conf['db_user'], $conf['db_pass'], $conf['db_name']);
if (!$conn)
    die(__('stats.config_load_error') . ': ' . mysqli_connect_error());
mysqli_set_charset($conn, 'utf8');
mysqli_query($conn, "SET SESSION sql_mode = ''");

// Load translation helpers
require_once(__DIR__ . '/../app/Helpers/language_helper.php');

// Initialize language system
init_locale();

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, trim($_POST['email'] ?? ''));

    if (empty($email)) {
        $error = __('public.password_recovery.error_empty_email');
    } else {
        // Check if email exists
        $query = "SELECT id, nazwa FROM conta WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Generate reset token
            $token = bin2hex(random_bytes(32));
            $expires = time() + 3600; // 1 hour
            $created = time();

            // Store token
            $query = "INSERT INTO password_resets (user_id, token, expires, created_at) VALUES ('{$user['id']}', '$token', '$expires', '$created')
                       ON DUPLICATE KEY UPDATE token = '$token', expires = '$expires', created_at = '$created'";
            mysqli_query($conn, $query);

            // Send recovery email
            $resetLink = "http://" . $_SERVER['HTTP_HOST'] . "/reset_password.php?token=$token";
            
            $subject = "NobleWars - Recuperação de Senha";
            
            // Load secure HTML email template
            $templateFunc = require(__DIR__ . '/../app/Views/emails/password_recovery.php');
            $emailMessage = $templateFunc($user['nazwa'], $resetLink);

            \App\Helpers\MailHelper::send($email, $subject, $emailMessage);

            $message = __('public.password_recovery.success_sent');
        } else {
            $error = __('public.password_recovery.error_email_not_found');
        }
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

// Determinar tema atual (Decidido pelo Admin no config.php)
$current_theme = $conf['index_theme'] ?? 'classic';

mysqli_close($conn);

// Carregar a vista correspondente
if ($current_theme == 'modern') {
    include __DIR__ . '/../app/Views/password_recovery_modern.php';
} else {
    include __DIR__ . '/../app/Views/password_recovery_classic.php';
}
?>
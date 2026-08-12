<?php
require_once __DIR__ . '/../app/bootstrap_public.php';
require_once(__DIR__ . '/configs/config.php');

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
$valid_token = false;
$user_id = null;

// Verify token
if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($conn, $_GET['token']);

    $query = "SELECT user_id, expires FROM password_resets WHERE token = '$token' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $reset = mysqli_fetch_assoc($result);

        if ($reset['expires'] > time()) {
            $valid_token = true;
            $user_id = $reset['user_id'];
        } else {
            $error = __('public.reset_password.error_expired_token');
        }
    } else {
        $error = __('public.reset_password.error_invalid_token');
    }
}

// Process password reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $valid_token) {
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (empty($password)) {
        $error = __('public.reset_password.error_empty');
    } elseif (strlen($password) < 6) {
        $error = __('public.reset_password.error_too_short');
    } elseif ($password !== $confirm) {
        $error = __('public.reset_password.error_mismatch');
    } else {
        // Update password
        $hashed = \App\Helpers\SecurityHelper::hashPassword($password);
        $query = "UPDATE conta SET haslo = '$hashed' WHERE id = '$user_id'";

        if (mysqli_query($conn, $query)) {
            $log_msg = date('[Y-m-d H:i:s] ') . "Password RESET SUCCESS: user_id='$user_id', new_hash='$hashed'\n";
            @file_put_contents(__DIR__ . '/../public/cache/login_debug.log', $log_msg, FILE_APPEND);

            // Delete used token
            mysqli_query($conn, "DELETE FROM password_resets WHERE user_id = '$user_id'");

            $message = __('public.reset_password.success_message');
            $valid_token = false;
        } else {
            $log_msg = date('[Y-m-d H:i:s] ') . "Password RESET FAILED: user_id='$user_id', error='" . mysqli_error($conn) . "'\n";
            @file_put_contents(__DIR__ . '/../public/cache/login_debug.log', $log_msg, FILE_APPEND);

            $error = __('public.reset_password.error_update_failed');
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
    include __DIR__ . '/../app/Views/reset_password_modern.php';
} else {
    include __DIR__ . '/../app/Views/reset_password_classic.php';
}
?>
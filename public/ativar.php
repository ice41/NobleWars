<?php
/*****************************************/
/*     ATIVAR.PHP - CONTROLLER           */
/*     Ativação de Conta                 */
/*             ice41                     */
/*****************************************/

ini_set('display_errors', 0);
error_reporting(E_ALL);

session_start();

// Carregar configurações
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

// Load translation helpers
require_once(__DIR__ . '/../app/Helpers/language_helper.php');

// Initialize language system
init_locale();

// Conexão MySQLi
$conn = new mysqli($conf['db_host'], $conf['db_user'], $conf['db_pass'], $conf['db_name']);

// Verificar conexão
if ($conn->connect_error) {
    die(__('stats.config_load_error') . " (Activation DB)");
}
$conn->set_charset("utf8");

$error = '';
$success = '';
$activated = false;

// Main Activation Logic
$akcja = $_REQUEST['akcja'] ?? '';
$input_user = $_REQUEST['user'] ?? '';
$input_kod = $_REQUEST['kod'] ?? $_REQUEST['password'] ?? '';

if (($akcja == 'aktywuj' || (!empty($input_user) && !empty($input_kod) && isset($_GET['user']))) && !empty($input_user) && !empty($input_kod)) {

    $user = $conn->real_escape_string($input_user);
    $kod = $conn->real_escape_string($input_kod);

    $sql_check = "SELECT id, activated, kod FROM conta WHERE nazwa = '$user' LIMIT 1";
    $result = $conn->query($sql_check);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($row['activated'] == 1) {
            $error = __('public.activation.already_activated');
            $activated = true;
        } elseif (trim($row['kod']) !== trim($input_kod)) {
            $error = __('public.activation.invalid_code');
        } else {
            $update = $conn->query("UPDATE conta SET activated = '1' WHERE id = '" . $row['id'] . "'");

            if ($update) {
                $success = __('public.activation.success');
                $activated = true;
            } else {
                $error = __('public.activation.technical_error');
            }
        }
    } else {
        $error = __('public.activation.user_not_found');
    }
}

$conn->close();

// Determinar tema atual
$current_theme = $conf['index_theme'] ?? 'classic';

// Carregar a vista correspondente
if ($current_theme == 'modern') {
    include __DIR__ . '/../app/Views/ativar_modern.php';
} else {
    include __DIR__ . '/../app/Views/ativar_classic.php';
}
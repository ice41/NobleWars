<?php
/*****************************************/
/*     REGISTER.PHP - MODERNIZADO       */
/*     100% FIEL AO ORIGINAL            */
/*     PHP 7+/8+ com MySQLi             */
/*****************************************/

require_once __DIR__ . '/../app/bootstrap_public.php';

if (isset($_GET['invite'])) {
    $_SESSION['invite_code'] = trim($_GET['invite']);
}

require_once(__DIR__ . '/configs/config.php');

// Conectar BD
$conn = @mysqli_connect($conf['db_host'], $conf['db_user'], $conf['db_pass'], $conf['db_name']);
if (!$conn)
	$conn = @mysqli_connect($conf['db_host'], $conf['db_user'], '', $conf['db_name']);
if (!$conn)
	die(__('stats.config_load_error') . ': ' . mysqli_connect_error());

mysqli_query($conn, "SET SESSION sql_mode = ''");
mysqli_set_charset($conn, 'utf8');

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

function cmp_str($str, $min, $max)
{
	$len = strlen($str);
	if ($len < $min)
		return "\005SHORT";
	if ($len > $max)
		return "\005LONG";
	return $str;
}

function Kod($length)
{
	try {
		return bin2hex(random_bytes($length / 2));
	} catch (\Exception $e) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for ($i = 0; $i < $length; $i++) {
			$str .= $chars[rand(0, strlen($chars) - 1)];
		}
		return $str;
	}
}

// Variáveis
$mode = $_GET['mode'] ?? 'rejestracja';
$error = '';
$success = false;
$new_user_id = 0;
$new_username = '';
$activation_code = '';

// Processar Registo
if ($mode == 'rejestracja' && isset($_GET['action']) && $_GET['action'] == 'create') {
	$name = trim($_POST['name'] ?? '');
	$pass = $_POST['password'] ?? '';
	$pass_confirm = $_POST['password_confirm'] ?? '';
	$email = trim($_POST['email'] ?? '');
	$agb = $_POST['agb'] ?? 0;

	if ($agb != 1) {
		$error = __('public.register.errors.confirm_rules');
	} elseif (strlen($pass) < 4) {
		$error = __('public.register.errors.pass_too_short', ['min' => 4]);
	} elseif ($pass !== $pass_confirm) {
		$error = __('public.register.errors.pass_mismatch');
	} else {
		$check_name = cmp_str($name, 4, 24);
		if ($check_name === "\005SHORT")
			$error = __('public.register.errors.name_too_short', ['min' => 4]);
		elseif ($check_name === "\005LONG")
			$error = __('public.register.errors.name_too_long', ['max' => 24]);

		if (empty($error)) {
			if (strlen($email) < 4) {
				$error = __('public.register.errors.email_invalid');
			} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$error = __('public.register.errors.email_invalid');
			} else {
				$domain = substr(strrchr($email, "@"), 1);
				$dnsActive = @checkdnsrr("gmail.com", "MX");
				if ($dnsActive && !@checkdnsrr($domain, "MX")) {
					$error = __('public.register.errors.email_host_invalid');
				}
			}
		}

		if (empty($error)) {
			// Verificar duplicados
			$name_esc = mysqli_real_escape_string($conn, $name);
			$email_esc = mysqli_real_escape_string($conn, $email);

			$count_name = sql("SELECT COUNT(id) FROM conta WHERE nazwa = '$name_esc'", 'array');
			$count_email = sql("SELECT COUNT(id) FROM conta WHERE email = '$email_esc'", 'array');

			if ($count_name > 0) {
				$error = __('public.register.errors.name_taken');
			} elseif ($count_email > 0) {
				$error = __('public.register.errors.email_taken');
			} else {
				// Criar conta
				$pass_hash = \App\Helpers\SecurityHelper::hashPassword($pass);
				$date_reg = time();
				$ip_reg = $_SERVER['REMOTE_ADDR'];

				// Gerar código de ativação (32 caracteres)
				$kod_caly = Kod(32);

				// SECURITY FIX: Explicitly set admin = 0 to prevent privilege escalation
				$sql = "INSERT INTO conta (nazwa, haslo, email, date_reg, ip_reg, kod, admin, activated) VALUES ('$name_esc', '$pass_hash', '$email_esc', '$date_reg', '$ip_reg', '$kod_caly', 0, 0)";
				if (mysqli_query($conn, $sql)) {
					$new_user_id = mysqli_insert_id($conn);
					header("Location: register.php?mode=powodzenie&gracz=$new_user_id");
					exit;
				} else {
					$error = __('public.register.errors.create_error', ['error' => mysqli_error($conn)]);
				}
			}
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

// Modo Sucesso
if ($mode == 'powodzenie' && isset($_GET['gracz'])) {
	$uid = (int) $_GET['gracz'];
	$user = sql("SELECT nazwa, kod FROM conta WHERE id = $uid", 'assoc');
	if ($user) {
		$success = true;
		$new_username = $user['nazwa'];
		$activation_code = $user['kod'];
	}
}

// Determinar tema atual (Decidido pelo Admin no config.php)
$current_theme = $conf['index_theme'] ?? 'classic';

mysqli_close($conn);

// Carregar a vista correspondente
if ($current_theme == 'modern') {
    include __DIR__ . '/../app/Views/register_modern.php';
} else {
    include __DIR__ . '/../app/Views/register_classic.php';
}
?>
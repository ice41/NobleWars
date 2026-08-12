<?php
/**
 * app/bootstrap_public.php
 *
 * Bootstrap partilhado para todos os pontos de entrada públicos.
 * Inicializa o CoreFetcher, carrega os helpers essenciais e
 * configura o sistema de localização.
 */

// Configuração de segurança de erro por defeito (pode ser sobrescrita depois)
// Permite ativar debug via constante NOBLEWARS_DEBUG ou variável de ambiente NOBLEWARS_DEBUG=1
if (!defined('NOBLEWARS_DEBUG')) {
    $debugEnv = getenv('NOBLEWARS_DEBUG');
    define('NOBLEWARS_DEBUG', $debugEnv === '1' || $debugEnv === 'true');
}

if (NOBLEWARS_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
} else {
    error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR);
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
}

// Iniciar sessão uma única vez
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Carregar e inicializar o CoreFetcher
require_once __DIR__ . '/CoreFetcher.php';

if (!class_exists('CoreFetcher')) {
    throw new Exception('CoreFetcher não encontrado. Verifica a ofuscação ou o ficheiro .ice41.');
}

\CoreFetcher::init();

// Carregar helpers essenciais
\CoreFetcher::load('Helpers/helpers.php');
\CoreFetcher::load('Helpers/language_helper.php');

// Inicializar localização
if (function_exists('init_locale')) {
    init_locale();
} else {
    throw new Exception('init_locale() não definida — CoreFetcher não carregou language_helper.php.');
}

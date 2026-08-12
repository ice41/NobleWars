<?php
/**
 * app/bootstrap_ajax.php
 *
 * Bootstrap partilhado para endpoints AJAX.
 *
 * Inicializa o CoreFetcher (que define NOBLEWARS_APP_DIR, NOBLEWARS_ROOT_DIR
 * e regista o autoloader de classes App\\*) e carrega os helpers essenciais.
 *
 * Ao contrário do bootstrap_public.php, este não inicia sessão nem carrega
 * language_helper, uma vez que muitos endpoints AJAX não precisam de localização
 * e a sessão já é gerida pelo frontend/jogo.
 */

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

require_once __DIR__ . '/CoreFetcher.php';

if (!class_exists('CoreFetcher')) {
    throw new Exception('CoreFetcher não encontrado. Verifica a ofuscação ou o ficheiro .ice41.');
}

\CoreFetcher::init();

// Alguns endpoints AJAX necessitam de funções dos helpers (ex: get_world_db_config)
\CoreFetcher::load('Helpers/helpers.php');

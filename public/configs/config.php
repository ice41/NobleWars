<?php
require (__DIR__ . '/../../app/Config/database.php');
require (__DIR__ . '/../../app/Config/mail.php');

$conf['db_edit'] = '1';
$conf['primeiro_id_de_administrador'] = '1';
$conf['nazwa_serwera'] = 'NobleWars';

//Linki na top menu:
$linki = array (
	
		"index.php" => "Iníciosss",
		"rules.php" => "Regras",
		"team.php" => "Equipa",
		"hall_of_fame.php" => "Hall da Fama",
		"help.php" => "Ajuda",
		);
//Engine version:
$conf['version'] = '1.8.6'; 

//Admin Action Key:
$conf['admin_key'] = 'actions_massiv';

$conf['publico'] = 'true';
$conf['index_theme'] = 'modern'; // 'classic' ou 'modern'
$conf['ingame_theme'] = 'modern'; // 'classic', 'modern', 'obsidian', 'viking', 'nexon'
$conf['maintenance_mode'] = 'false'; // 'true' ou 'false'
$conf['maintenance_start'] = 0; // Timestamp de início da manutenção

// --- Configuração de Subdomínios ---
// Domínio base usado em produção (ex: noblewars.ice41.pt).
// Em testes locais (localhost), a deteção por subdomínio é ignorada automaticamente.
$conf['base_domain'] = 'noblewars.pt'; // deixar vazio caso queira desativar o dns dinamico

// Detetar automaticamente se a ligação é HTTPS (para cookies Secure e URLs corretos).
$conf['is_https'] = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
                    || (($_SERVER['SERVER_PORT'] ?? 80) == 443)
                    || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
                    || (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] === 'on')
                    || (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && $_SERVER['HTTP_FRONT_END_HTTPS'] === 'on');

// Intercetar páginas se o modo manutenção estiver ativo
if (isset($conf['maintenance_mode']) && $conf['maintenance_mode'] === 'true') {
    $currentScript = basename($_SERVER['SCRIPT_NAME']);
    if ($currentScript !== 'admin.php' && php_sapi_name() !== 'cli') {
        require_once __DIR__ . '/../../app/Views/maintenance.php';
        exit;
    }
}



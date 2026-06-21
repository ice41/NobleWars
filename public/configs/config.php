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
//Wersja silnika:
$conf['version'] = '1.9'; 

//Klucz akcji admina:
$conf['admin_key'] = 'actions_massiv';

$conf['publico'] = 'true';
$conf['index_theme'] = 'modern'; // 'classic' ou 'modern'
$conf['ingame_theme'] = 'modern'; // 'classic', 'modern', 'obsidian', 'viking', 'nexon'

// --- Configuração de Subdomínios ---
// Domínio base usado em produção (ex: noblewars.ice41.pt).
// Em testes locais (localhost), a deteção por subdomínio é ignorada automaticamente.
$conf['base_domain'] = 'noblewars.ice41.pt';

// Detetar automaticamente se a ligação é HTTPS (para cookies Secure).
$conf['is_https'] = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
                    || (($_SERVER['SERVER_PORT'] ?? 80) == 443);



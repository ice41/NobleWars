<?php
require (__DIR__ . '/../../app/Config/database.php');
require (__DIR__ . '/../../app/Config/mail.php');

$conf['db_edit'] = '1'; // '1' para permitir edição de base de dados via painel de administração, '0' para desativar.
$conf['primeiro_id_de_administrador'] = '1'; // ID do primeiro jogador que será considerado administrador (geralmente o primeiro jogador criado no banco de dados).
$conf['nazwa_serwera'] = 'NobleWars'; // Nome do servidor (aparece no título da página e em outros lugares).

//Linki na top menu:
$linki = array (
	
		"index.php" => "Início", // Página inicial
		"rules.php" => "Regras", // Página de regras
		"team.php" => "Equipa", // Página da equipa
		"hall_of_fame.php" => "Hall da Fama", // Página do Hall da Fama
		"help.php" => "Ajuda", // Página de ajuda
		);
//Engine version:
$conf['version'] = '1.8.6';  // Versão do motor do jogo (não altere manualmente, a menos que saiba o que está a fazer).

//Admin Action Key:
$conf['admin_key'] = 'actions_massiv'; // Chave de ação do administrador (não altere manualmente, a menos que saiba o que está a fazer).

$conf['publico'] = 'true'; // 'true' para permitir que qualquer pessoa se registre, 'false' para desativar o registro público.
$conf['index_theme'] = 'modern'; // 'classic' ou 'modern' // Tema da página inicial (index.php)
$conf['ingame_theme'] = 'modern'; // 'classic', 'modern', 'obsidian', 'viking', 'nexon' // Tema do jogo (páginas internas, como mapa.php, profile.php, etc.)
$conf['maintenance_mode'] = 'false'; // 'true' ou 'false' // Ativar ou desativar o modo de manutenção. Quando ativado, apenas administradores podem acessar o site.
$conf['maintenance_start'] = 0; // Timestamp de início da manutenção // Exemplo: 1672531200 (1 de janeiro de 2023, 00:00:00 UTC)

// --- Configuração de Subdomínios ---
// Domínio base usado em produção (ex: noblewars.ice41.pt).
// Em testes locais (localhost), a deteção por subdomínio é ignorada automaticamente.
$conf['base_domain'] = 'noblewars.pt'; // Substitua pelo seu domínio real (sem "www" ou subdomínios).

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



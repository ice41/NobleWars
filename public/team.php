<?php
require_once __DIR__ . '/../app/bootstrap_public.php';
require_once(__DIR__ . '/configs/config.php');

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

// Carregar a vista correspondente
if ($current_theme == 'modern') {
    include __DIR__ . '/../app/Views/team_modern.php';
} else {
    include __DIR__ . '/../app/Views/team_classic.php';
}
?>
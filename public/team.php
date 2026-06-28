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

// Load translation helpers
require_once(__DIR__ . '/../app/Helpers/language_helper.php');

// Initialize language system
init_locale();

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
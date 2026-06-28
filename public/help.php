<?php
/*****************************************/
/*     HELP.PHP - AJAX GAME HELP        */
/*****************************************/

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

// Basic Requires
require_once('configs/config.php');
require_once(__DIR__ . '/../app/Helpers/language_helper.php');
require_once('modelo/lib/world_constants.php');
require_once('modelo/lib/config.php');
require_once('modelo/lib/functions.php');

// Initialize language system
init_locale();

// Iniciar sessão para verificar se o utilizador está logado
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Core\Database;

// Initialize Environment
$server = 1; // Default to world 1
$worldDb = get_world_db_name($server);

try {
    $db = Database::getInstance($worldDb, get_world_db_host(get_active_world()), get_world_db_user(get_active_world()), get_world_db_pass(get_active_world()));
    $pdo = $db->getPdo();

    // Initialize Global Libraries
    $cl_builds = new \App\Models\BuildsLibrary($worldDb, $config);
    $cl_units = new \App\Models\UnitsLibrary($worldDb, $config);

    // Globals for views
    global $config, $cl_builds, $cl_units;

} catch (Exception $e) {
    die(__('stats.config_load_error') . " (Help DB)");
}

$mode = $_GET['mode'] ?? 'main';
?>
<!DOCTYPE html>
<html lang="pt">
<link id="favicon" rel="shortcut icon" href="graphic/icons/nwfavicon.ico">
<head>
    <title><?= __('public.help.title') ?> - Noblewars</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/game_new.css" />
    <link rel="stylesheet" type="text/css" href="css/admin.css" />
    <style>
        /* Overrides to make help specific content look good in admin theme */
        #admin_content h1 {
            color: #5c0909;
            border-bottom: 2px solid #cfaa7d;
            padding-bottom: 10px;
            margin-top: 0;
            font-family: "Times New Roman", Times, serif;
            font-size: 24px;
        }
    </style>
</head>

<body>

    <div id="admin_panel">
        <!-- Sidebar Navigation -->
        <div id="admin_sidebar">
            <h2><?= __('public.help.sidebar.title') ?></h2>

            <a href="help.php?mode=main" class="admin-nav-item <?= $mode == 'main' ? 'active' : '' ?>">
                <i class="fas fa-home"></i> <?= __('public.help.sidebar.main') ?>
            </a>

            <a href="help.php?mode=premium" class="admin-nav-item <?= $mode == 'premium' ? 'active' : '' ?>">
                <i class="fas fa-crown"></i> <?= __('public.help.sidebar.premium') ?>
            </a>

            <a href="help.php?mode=flags" class="admin-nav-item <?= $mode == 'flags' ? 'active' : '' ?>">
                <i class="fas fa-flag"></i> <?= __('public.help.sidebar.flags') ?>
            </a>

            <a href="help.php?mode=buildings" class="admin-nav-item <?= $mode == 'buildings' ? 'active' : '' ?>">
                <i class="fas fa-dungeon"></i> <?= __('public.help.sidebar.buildings') ?>
            </a>

            <a href="help.php?mode=units" class="admin-nav-item <?= $mode == 'units' ? 'active' : '' ?>">
                <i class="fas fa-chess-knight"></i> <?= __('public.help.sidebar.units') ?>
            </a>

            <a href="help.php?mode=paladin" class="admin-nav-item <?= $mode == 'paladin' ? 'active' : '' ?>">
                <i class="fas fa-shield-alt"></i> <?= __('public.help.sidebar.paladin') ?>
            </a>

            <a href="help.php?mode=combat" class="admin-nav-item <?= $mode == 'combat' ? 'active' : '' ?>">
                <i class="fas fa-hand-fist"></i> <?= __('public.help.sidebar.combat') ?>
            </a>

            <a href="help.php?mode=market" class="admin-nav-item <?= $mode == 'market' ? 'active' : '' ?>">
                <i class="fas fa-balance-scale"></i> <?= __('public.help.sidebar.market') ?>
            </a>

            <a href="help.php?mode=map" class="admin-nav-item <?= $mode == 'map' ? 'active' : '' ?>">
                <i class="fas fa-map-marked-alt"></i> <?= __('public.help.sidebar.map') ?>
            </a>

            <a href="help.php?mode=bb_codes" class="admin-nav-item <?= $mode == 'bb_codes' ? 'active' : '' ?>">
                <i class="fas fa-code"></i> <?= __('public.help.sidebar.bb_codes') ?>
            </a>

            <a href="help.php?mode=points" class="admin-nav-item <?= $mode == 'points' ? 'active' : '' ?>">
                <i class="fas fa-chart-line"></i> <?= __('public.help.sidebar.points') ?>
            </a>

            <a href="help.php?mode=changelog" class="admin-nav-item <?= $mode == 'changelog' ? 'active' : '' ?>">
                <i class="fas fa-history"></i> <?= __('public.help.sidebar.changelog') ?>
            </a>

            <div style="margin-top: auto; border-top: 1px solid #5c3a1e; padding-top: 10px;">
                <!-- Language Selector -->
                <div style="padding: 10px; text-align: center;">
                    <?php include __DIR__ . '/../app/Views/components/language_selector_public.php'; ?>
                </div>

                <?php 
                $activeWorld = get_active_world();
                $worldCookie = 'session_' . $activeWorld;
                if (isset($_SESSION['user_id']) || isset($_COOKIE[$worldCookie])): 
                ?>
                    <a href="<?= get_world_url($activeWorld, 'game.php') ?>" class="admin-nav-item"
                        style="background: linear-gradient(to bottom, #2b4a1c, #1e3e15); border-color: #3e5c2e;">
                        <i class="fas fa-arrow-left"></i> <?= __('public.help.sidebar.back_to_game') ?>
                    </a>
                <?php else: ?>
                    <a href="index.php" class="admin-nav-item"
                        style="background: linear-gradient(to bottom, #2b4a1c, #1e3e15); border-color: #3e5c2e;">
                        <i class="fas fa-arrow-left"></i> <?= __('public.help.sidebar.back_to_game') ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div id="admin_content">
            <?php
            $allowed_modes = ['main', 'server_info', 'buildings', 'units', 'bb_codes', 'points', 'flags', 'premium', 'paladin', 'map', 'combat', 'market', 'changelog'];
            if (in_array($mode, $allowed_modes)) {
                $file_path = __DIR__ . '/../app/Views/help/' . $mode . '.php';
                if (file_exists($file_path)) {
                    // Wrap content in admin-card for styling
                    echo '<div class="admin-card">';
                    include $file_path;
                    echo '</div>';
                } else {
                    echo '<div class="admin-alert error"><h3>' . __('public.help.error.title') . '</h3><p>' . __('public.help.error.not_found') . '</p></div>';
                }
            } else {
                include __DIR__ . '/../app/Views/help/main.php';
            }
            ?>
        </div>
    </div>

</body>

</html>
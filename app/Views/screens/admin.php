<?php
// Admin Panel Main View
$allowed_screens = $allow_screens ?? [];
$current_mode = $_GET['mode'] ?? 'index';
?>
<!-- FontAwesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- Custom Medieval Admin CSS -->
<link rel="stylesheet" href="css/admin.css">

<div id="admin_panel">
    <!-- Sidebar Navigation -->
    <div id="admin_sidebar">
        <h2><?= __('admin.dashboard.panel_title') ?></h2>
        <?php if (isset($is_standalone) && $is_standalone): ?>
            <div style="text-align: center; color: #cbb286; font-size: 11px; margin-bottom: 15px;">
                <?= htmlspecialchars($_SESSION['admin_current_world'] ?? '') ?>
            </div>
        <?php endif; ?>

        <?php
        $baseUrl = (isset($is_standalone) && $is_standalone)
            ? 'admin.php?action=dashboard'
            : 'game.php?village=' . ($village['id'] ?? '') . '&screen=admin';
        ?>

        <a href="<?= $baseUrl ?>" class="admin-nav-item <?= $current_mode == 'index' ? 'active' : '' ?>">
            <i class="fas fa-tachometer-alt"></i> <?= __('admin.menu.dashboard') ?>
        </a>

        <a href="<?= $baseUrl ?>&mode=avisos" class="admin-nav-item <?= $current_mode == 'avisos' ? 'active' : '' ?>">
            <i class="fas fa-bullhorn"></i> <?= __('admin.menu.announcements') ?>
        </a>

        <a href="<?= $baseUrl ?>&mode=news" class="admin-nav-item <?= $current_mode == 'news' ? 'active' : '' ?>">
            <i class="fas fa-scroll"></i> <?= __('admin.menu.news') ?>
        </a>

        <a href="<?= $baseUrl ?>&mode=rules" class="admin-nav-item <?= $current_mode == 'rules' ? 'active' : '' ?>">
            <i class="fas fa-balance-scale"></i> <?= __('admin.menu.rules') ?>
        </a>

        <a href="<?= $baseUrl ?>&mode=uzytkownicy"
            class="admin-nav-item <?= $current_mode == 'uzytkownicy' ? 'active' : '' ?>">
            <i class="fas fa-users"></i> <?= __('admin.menu.players') ?>
        </a>

        <a href="<?= $baseUrl ?>&mode=builds" class="admin-nav-item <?= $current_mode == 'builds' ? 'active' : '' ?>">
            <i class="fas fa-hammer"></i> <?= __('admin.menu.buildings') ?>
        </a>

        <a href="<?= $baseUrl ?>&mode=bot" class="admin-nav-item <?= $current_mode == 'bot' ? 'active' : '' ?>">
            <i class="fas fa-robot"></i> <?= __('admin.menu.bot') ?>
        </a>

        <a href="<?= $baseUrl ?>&mode=map"
            class="admin-nav-item <?= ($current_mode == 'map' || $current_mode == 'decoration') ? 'active' : '' ?>">
            <i class="fas fa-map-marked-alt"></i> <?= __('admin.menu.map_tools') ?>
        </a>

        <a href="<?= $baseUrl ?>&mode=configs" class="admin-nav-item <?= $current_mode == 'configs' ? 'active' : '' ?>">
            <i class="fas fa-cogs"></i> <?= __('admin.menu.settings') ?>
        </a>

        <a href="<?= $baseUrl ?>&mode=bonus_config"
            class="admin-nav-item <?= $current_mode == 'bonus_config' ? 'active' : '' ?>">
            <i class="fas fa-gift"></i> <?= __('admin.menu.daily_bonus') ?>
        </a>

        <a href="<?= $baseUrl ?>&mode=events"
            class="admin-nav-item <?= $current_mode == 'events' ? 'active' : '' ?>">
            <i class="fas fa-calendar-alt"></i> Eventos
        </a>

        <a href="<?= $baseUrl ?>&mode=mail" class="admin-nav-item <?= $current_mode == 'mail' ? 'active' : '' ?>">
            <i class="fas fa-envelope"></i> <?= __('admin.menu.tickets') ?>
        </a>

        <a href="<?= $baseUrl ?>&mode=massmail" class="admin-nav-item <?= $current_mode == 'massmail' ? 'active' : '' ?>">
            <i class="fas fa-paper-plane"></i> Mass Mail
        </a>

        <a href="<?= $baseUrl ?>&mode=bany" class="admin-nav-item <?= $current_mode == 'bany' ? 'active' : '' ?>">
            <i class="fas fa-gavel"></i> <?= __('admin.menu.bans') ?>
        </a>

        <a href="<?= $baseUrl ?>&mode=changelog" class="admin-nav-item <?= $current_mode == 'changelog' ? 'active' : '' ?>">
            <i class="fas fa-history"></i> Changelog
        </a>

        <?php
        $isDiamond = (\App\Core\Database::getLicenseType() === 'diamond');
        ?>
        <a href="<?= $baseUrl ?>&mode=diamond_tools"
            class="admin-nav-item <?= $current_mode == 'diamond_tools' ? 'active' : '' ?>">
            <i class="fas fa-tools"></i> Ferramentas<?= !$isDiamond ? '<span style="color:#ffaa00; font-size:10px;">🔒</span>' : '' ?>
        </a>

        <a href="<?= $baseUrl ?>&mode=reset" class="admin-nav-item <?= $current_mode == 'reset' ? 'active' : '' ?>">
            <i class="fas fa-undo"></i> <?= __('admin.menu.shutdown') ?>
        </a>

        <div style="margin-top: auto; border-top: 1px solid #5c3a1e; padding-top: 10px;">
            <?php if (isset($is_standalone) && $is_standalone): ?>
                <a href="admin.php?action=select_world" class="admin-nav-item">
                    <i class="fas fa-globe"></i> <?= __('admin.menu.change_world') ?>
                </a>
                <a href="admin.php?action=logout" class="admin-nav-item">
                    <i class="fas fa-sign-out-alt"></i> <?= __('admin.menu.logout') ?>
                </a>
            <?php else: ?>
                <a href="game.php?village=<?= $village['id'] ?>&screen=overview" class="admin-nav-item">
                    <i class="fas fa-arrow-left"></i> <?= __('admin.login.back_to_game') ?>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Main Content Area -->
    <div id="admin_content">
        <?php
        $mode = $_GET['mode'] ?? 'index';

        // Sanitize mode to prevent LFI (though logic handled by string concatenation, better safe)
        $mode = preg_replace('/[^a-zA-Z0-9_]/', '', $mode);

        $view_file = __DIR__ . '/admin_modes/admin_' . $mode . '.php';

        if (file_exists($view_file)) {
            // Check if template exists, otherwise fallback
            include $view_file;
        } else {
            echo '<div class="admin-alert error">
                <h3><i class="fas fa-exclamation-triangle"></i> ' . __('admin.dashboard.not_found') . '</h3>
                <p>' . sprintf(__('admin.dashboard.not_found_desc'), htmlspecialchars($mode)) . '</p>
            </div>';
        }
        ?>
    </div>
</div>

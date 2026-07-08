<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('admin.dashboard.title') ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>
    <div id="admin_panel">
        <!-- Sidebar Navigation -->
        <div id="admin_sidebar">
            <h2><?= __('admin.dashboard.panel_title') ?></h2>
            <div style="text-align: center; color: #cbb286; font-size: 11px; margin-bottom: 15px;">
                <?= htmlspecialchars($_SESSION['admin_current_world'] ?? '') ?>
            </div>

            <a href="admin.php?action=dashboard&mode=index"
                class="admin-nav-item <?= ($_GET['mode'] ?? 'index') == 'index' ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i> <?= __('admin.menu.dashboard') ?>
            </a>

            <a href="admin.php?action=dashboard&mode=avisos"
                class="admin-nav-item <?= ($_GET['mode'] ?? '') == 'avisos' ? 'active' : '' ?>">
                <i class="fas fa-bullhorn"></i> <?= __('admin.menu.announcements') ?>
            </a>

            <a href="admin.php?action=dashboard&mode=rules"
                class="admin-nav-item <?= ($_GET['mode'] ?? '') == 'rules' ? 'active' : '' ?>">
                <i class="fas fa-balance-scale"></i> <?= __('admin.menu.rules') ?>
            </a>

            <a href="admin.php?action=dashboard&mode=jogadores"
                class="admin-nav-item <?= ($_GET['mode'] ?? '') == 'jogadores' ? 'active' : '' ?>">
                <i class="fas fa-users"></i> <?= __('admin.menu.players') ?>
            </a>

            <a href="admin.php?action=dashboard&mode=builds"
                class="admin-nav-item <?= ($_GET['mode'] ?? '') == 'builds' ? 'active' : '' ?>">
                <i class="fas fa-hammer"></i> <?= __('admin.menu.buildings') ?>
            </a>

            <a href="admin.php?action=dashboard&mode=bot"
                class="admin-nav-item <?= ($_GET['mode'] ?? '') == 'bot' ? 'active' : '' ?>">
                <i class="fas fa-robot"></i> <?= __('admin.menu.bot') ?>
            </a>

            <a href="admin.php?action=dashboard&mode=configs"
                class="admin-nav-item <?= ($_GET['mode'] ?? '') == 'configs' ? 'active' : '' ?>">
                <i class="fas fa-cogs"></i> <?= __('admin.menu.settings') ?>
            </a>

            <a href="admin.php?action=dashboard&mode=mail"
                class="admin-nav-item <?= ($_GET['mode'] ?? '') == 'mail' ? 'active' : '' ?>">
                <i class="fas fa-envelope"></i> <?= __('admin.menu.tickets') ?>
            </a>

            <?php
            $isDiamond = (\App\Core\Database::getLicenseType() === 'diamond');
            ?>
            <a href="admin.php?action=dashboard&mode=diamond_tools"
                class="admin-nav-item <?= ($_GET['mode'] ?? '') == 'diamond_tools' ? 'active' : '' ?>">
                <i class="fas fa-tools"></i> Ferramentas<?= !$isDiamond ? '<span style="color:#ffaa00; font-size:10px;">🔒</span>' : '' ?>
            </a>

            <a href="admin.php?action=dashboard&mode=changelog"
                class="admin-nav-item <?= ($_GET['mode'] ?? '') == 'changelog' ? 'active' : '' ?>">
                <i class="fas fa-history"></i> Changelog
            </a>

            <div style="margin-top: auto; border-top: 1px solid #5c3a1e; padding-top: 10px;">
                <div style="text-align: center; margin-bottom: 10px;">
                    <div class="lang-selector">
                        <?php
                        $currentLocale = current_locale();
                        $localeName = locale_name($currentLocale);
                        $flagCode = strtolower($currentLocale === 'en_US' ? 'gb' : substr($currentLocale, 0, 2));
                        ?>
                        <div class="lang-current"
                            onclick="document.getElementById('dash-lang-drop').style.display = document.getElementById('dash-lang-drop').style.display === 'block' ? 'none' : 'block'">
                            <img src="graphic/new/country/<?= $flagCode ?>.png" style="height: 11px;">
                            <?= $localeName ?> <span style="font-size: 8px;">&#9650;</span>
                        </div>
                        <div class="lang-dropdown" id="dash-lang-drop"
                            style="bottom: 100%; margin-bottom: 2px; margin-left: -5px;">
                            <?php foreach (available_locales() as $loc):
                                $locName = locale_name($loc);
                                $fc = strtolower($loc === 'en_US' ? 'gb' : substr($loc, 0, 2));
                                $modeParams = isset($_GET['mode']) ? '&mode=' . htmlspecialchars($_GET['mode']) : '&mode=index';
                                ?>
                                <a href="admin.php?action=dashboard<?= $modeParams ?>&lang=<?= $loc ?>"
                                    class="lang-item <?= $currentLocale === $loc ? 'active' : '' ?>">
                                    <img src="graphic/new/country/<?= $fc ?>.png" style="height: 11px;">
                                    <?= $locName ?>
                                    <?php if ($currentLocale === $loc): ?>
                                        <span class="lang-check">&#10003;</span>
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <a href="admin.php?action=select_world" class="admin-nav-item">
                    <i class="fas fa-globe"></i> <?= __('admin.menu.change_world') ?>
                </a>
                <a href="admin.php?action=logout" class="admin-nav-item">
                    <i class="fas fa-sign-out-alt"></i> <?= __('admin.menu.logout') ?>
                </a>
            </div>
        </div>

        <!-- Main Content Area -->
        <div id="admin_content">
            <?php
            $mode = $_GET['mode'] ?? 'index';

            if ($mode == 'index'):
                ?>
                <h2><i class="fas fa-tachometer-alt"></i> <?= __('admin.menu.dashboard') ?></h2>

                <div class="stat-grid">
                    <div class="stat-box">
                        <div class="count"><?= number_format($stats['total_users']) ?></div>
                        <div class="label"><?= __('admin.stats.total_players') ?></div>
                    </div>

                    <div class="stat-box">
                        <div class="count"><?= number_format($stats['total_villages']) ?></div>
                        <div class="label"><?= __('admin.stats.total_villages') ?></div>
                    </div>

                    <div class="stat-box">
                        <div class="count"><?= number_format($stats['total_allies']) ?></div>
                        <div class="label"><?= __('admin.stats.total_tribes') ?></div>
                    </div>

                    <div class="stat-box">
                        <div class="count" style="color: #2d7a2d;"><?= number_format($stats['online_users']) ?></div>
                        <div class="label"><?= __('admin.stats.online_players') ?></div>
                    </div>
                </div>

                <div class="admin-card">
                    <h3><?= __('admin.dashboard.welcome') ?></h3>
                    <p><?= __('admin.dashboard.welcome_desc') ?></p>
                </div>
                <?php
            else:
                $viewPath = __DIR__ . '/screens/admin_modes/admin_' . $mode . '.php';
                if (file_exists($viewPath)) {
                    require $viewPath;
                } else {
                    echo '<div class="admin-alert error">Módulo não encontrado.</div>';
                }
            endif;
            ?>
        </div>
    </div>
</body>

</html>
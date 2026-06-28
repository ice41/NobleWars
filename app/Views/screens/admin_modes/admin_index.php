<h2><i class="fas fa-tachometer-alt"></i> <?= __('admin.dashboard.welcome_in_game') ?></h2>
<p style="color: #5c3a1e;"><?= __('admin.dashboard.welcome_in_game') ?></p>

<div class="admin-card">
    <div class="stat-grid">
        <div class="stat-box">
            <div class="count"><?= format_number($stats['total_users'] ?? 0) ?></div>
            <div class="label"><i class="fas fa-users"></i> <?= __('admin.stats.players_short') ?></div>
        </div>
        <div class="stat-box">
            <div class="count"><?= format_number($stats['online_users'] ?? 0) ?></div>
            <div class="label"><i class="fas fa-signal"></i> <?= __('admin.stats.online_5m') ?></div>
        </div>
        <div class="stat-box">
            <div class="count"><?= format_number($stats['total_villages'] ?? 0) ?></div>
            <div class="label"><i class="fas fa-home"></i> <?= __('admin.stats.villages_short') ?></div>
        </div>
        <div class="stat-box">
            <div class="count"><?= format_number($stats['total_allies'] ?? 0) ?></div>
            <div class="label"><i class="fas fa-shield-alt"></i> <?= __('admin.stats.tribes_short') ?></div>
        </div>
    </div>
</div>

<div class="admin-card">
    <h3><i class="fas fa-server"></i> <?= __('admin.system_info.title') ?></h3>
    <table class="vis" width="100%">
        <tr>
            <td width="200"><strong><?= __('admin.system_info.server_date') ?></strong></td>
            <td><?= date('d.m.Y H:i:s') ?></td>
        </tr>
        <tr>
            <td><strong><?= __('admin.system_info.php_version') ?></strong></td>
            <td><?= phpversion() ?></td>
        </tr>
        <tr>
            <td><strong><?= __('admin.system_info.server_software') ?></strong></td>
            <td><?= $_SERVER['SERVER_SOFTWARE'] ?? __('admin.system_info.unknown') ?></td>
        </tr>
        <tr>
            <td><strong><?= __('admin.system_info.database') ?></strong></td>
            <td>MariaDB</td>
        </tr>
        <tr>
            <td><strong><?= __('admin.system_info.version') ?></strong></td>
            <td><?= htmlspecialchars($GLOBALS['conf']['version'] ?? '1.8.6') ?></td>
        </tr>
        <tr>
            <td><strong><?= __('admin.system_info.dev') ?></strong></td>
            <td><a href="https://github.com/Ice41" target="_blank">Ice41</a></td>
        </tr>
    </table>
</div>
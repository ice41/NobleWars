<h2><i class="fas fa-robot"></i> <?= __('admin.bot.title') ?></h2>
<p style="color: #5c3a1e;"><?= __('admin.bot.desc') ?></p>

<?php if (!empty($error)): ?>
    <div class="admin-alert error">
        <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="admin-alert success">
        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<div class="admin-card">
    <h3><i class="fas fa-plus-circle"></i> <?= __('admin.bot.add_bot') ?></h3>
    <form method="post" action="<?= $adminBaseUrl ?>&mode=bot&action=add_bot">
        <table class="vis" width="100%">
            <tr>
                <td width="200"><strong><?= __('admin.bot.username') ?></strong></td>
                <td>
                    <input type="text" name="username" placeholder="<?= __('admin.bot.placeholder') ?>" style="width: 300px;"
                        required>
                    <button type="submit" class="btn" style="margin-left: 10px; background: #4caf50; border-color: #388e3c; color: white;">
                        <i class="fas fa-robot"></i> <?= __('admin.bot.mark_bot') ?>
                    </button>
                </td>
            </tr>
        </table>
    </form>
</div>

<div class="admin-card">
    <h3><i class="fas fa-list"></i> <?= __('admin.bot.active_bots') ?></h3>

    <?php if (!empty($botUsers)): ?>
        <table class="vis" width="100%">
            <tr>
                <th><?= __('admin.bot.col_id') ?></th>
                <th><?= __('admin.bot.col_name') ?></th>
                <th><?= __('admin.bot.col_points') ?></th>
                <th><?= __('admin.bot.col_villages') ?></th>
                <th><?= __('admin.bot.col_ally') ?></th>
                <th><?= __('admin.bot.col_actions') ?></th>
            </tr>
            <?php foreach ($botUsers as $bot): ?>
                <tr>
                    <td><?= $bot['id'] ?></td>
                    <td>
                        <i class="fas fa-robot" style="color: #999;"></i>
                        <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $bot['id'] ?>">
                            <?= htmlspecialchars($bot['username']) ?>
                        </a>
                    </td>
                    <td><?= number_format($bot['points'] ?? 0, 0, ',', '.') ?></td>
                    <td><?= $bot['villages'] ?? 0 ?></td>
                    <td><?= $bot['ally'] > 0 ? $bot['ally'] : '-' ?></td>
                    <td align="center">
                        <a href="<?= $adminBaseUrl ?>&mode=bot&action=remove_bot&id=<?= $bot['id'] ?>"
                            class="btn" style="padding: 2px 8px; font-size: 10px; background: #f44336;"
                            onclick="return confirm('<?= sprintf(__('admin.bot.remove_confirm'), addslashes(htmlspecialchars($bot['username']))) ?>');">
                            <i class="fas fa-times"></i> <?= __('admin.bot.remove_bot') ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p style="text-align: center; padding: 20px; color: #999;">
            <i class="fas fa-info-circle" style="font-size: 24px;"></i><br><br>
            <?= __('admin.bot.no_bots') ?>
        </p>
    <?php endif; ?>
</div>

<div class="admin-card">
    <h3><i class="fas fa-info-circle"></i> <?= __('admin.bot.info_title') ?></h3>
    <p><strong><?= __('admin.bot.info_q') ?></strong></p>
    <ul>
        <li><?= __('admin.bot.info_1') ?></li>
        <li><?= __('admin.bot.info_2') ?></li>
        <li><?= __('admin.bot.info_3') ?></li>
        <li><?= __('admin.bot.info_4') ?></li>
    </ul>
</div>

<style>
    .admin-alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
        border-left: 4px solid;
    }

    .admin-alert.error {
        background: #ffebee;
        border-color: #f44336;
        color: #c62828;
    }

    .admin-alert.success {
        background: #e8f5e9;
        border-color: #4caf50;
        color: #2e7d32;
    }
</style>
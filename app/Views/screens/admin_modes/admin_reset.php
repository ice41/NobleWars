<h2><i class="fas fa-trophy"></i> <?= __('admin.reset.title') ?></h2>
<p style="color: #5c3a1e;"><?= __('admin.reset.desc') ?></p>

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

<div class="admin-card" style="border-left: 4px solid #ff9800;">
    <h3><i class="fas fa-exclamation-triangle"></i> <?= __('admin.reset.info_title') ?></h3>
    <p style="font-size: 14px; line-height: 1.6;">
        <?= __('admin.reset.info_desc') ?>
    </p>
    <ul style="margin-left: 20px; line-height: 1.8;">
        <li><?= __('admin.reset.info_1') ?></li>
        <li><?= __('admin.reset.info_2') ?></li>
        <li><?= __('admin.reset.info_3') ?></li>
    </ul>
    <p style="color: #f44336; font-weight: bold; margin-top: 15px;">
        <i class="fas fa-exclamation-circle"></i> <?= __('admin.reset.warning') ?>
    </p>
</div>

<div class="admin-card">
    <h3><i class="fas fa-medal"></i> <?= __('admin.reset.top_players') ?></h3>
    <table class="vis" width="100%">
        <tr>
            <th width="50"><?= __('admin.reset.col_rank') ?></th>
            <th><?= __('admin.reset.col_player') ?></th>
            <th width="150"><?= __('admin.reset.col_points') ?></th>
            <th width="100"><?= __('admin.reset.col_villages') ?></th>
        </tr>
        <?php if (!empty($top_players)): ?>
            <?php foreach ($top_players as $rank => $player): ?>
                <tr>
                    <td align="center">
                        <?php if ($rank == 0): ?>
                            <i class="fas fa-trophy" style="color: gold; font-size: 20px;"></i>
                        <?php elseif ($rank == 1): ?>
                            <i class="fas fa-trophy" style="color: silver; font-size: 18px;"></i>
                        <?php else: ?>
                            <i class="fas fa-trophy" style="color: #cd7f32; font-size: 16px;"></i>
                        <?php endif; ?>
                        #<?= $rank + 1 ?>
                    </td>
                    <td><strong><?= htmlspecialchars($player['username']) ?></strong></td>
                    <td align="right"><?= number_format($player['points'], 0, ',', '.') ?></td>
                    <td align="center"><?= $player['villages'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" align="center" style="padding: 20px; color: #999;">
                    <?= __('admin.reset.no_players') ?>
                </td>
            </tr>
        <?php endif; ?>
    </table>
</div>

<div class="admin-card">
    <h3><i class="fas fa-users"></i> <?= __('admin.reset.top_tribes') ?></h3>
    <table class="vis" width="100%">
        <tr>
            <th width="50"><?= __('admin.reset.col_rank') ?></th>
            <th><?= __('admin.reset.col_tribe') ?></th>
            <th width="150"><?= __('admin.reset.col_points') ?></th>
            <th width="100"><?= __('admin.reset.col_members') ?></th>
        </tr>
        <?php if (!empty($top_tribes)): ?>
            <?php foreach ($top_tribes as $rank => $tribe): ?>
                <tr>
                    <td align="center">
                        <?php if ($rank == 0): ?>
                            <i class="fas fa-trophy" style="color: gold; font-size: 20px;"></i>
                        <?php elseif ($rank == 1): ?>
                            <i class="fas fa-trophy" style="color: silver; font-size: 18px;"></i>
                        <?php else: ?>
                            <i class="fas fa-trophy" style="color: #cd7f32; font-size: 16px;"></i>
                        <?php endif; ?>
                        #<?= $rank + 1 ?>
                    </td>
                    <td><strong><?= htmlspecialchars($tribe['name']) ?></strong></td>
                    <td align="right"><?= number_format($tribe['points'], 0, ',', '.') ?></td>
                    <td align="center"><?= $tribe['members'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" align="center" style="padding: 20px; color: #999;">
                    <?= __('admin.reset.no_tribes') ?>
                </td>
            </tr>
        <?php endif; ?>
    </table>
</div>

<div class="admin-card" style="background: #fff3cd; border-left: 4px solid #ff9800;">
    <h3><i class="fas fa-lock"></i> <?= __('admin.reset.confirm_title') ?></h3>
    <p style="margin-bottom: 15px;">
        <?= sprintf(__('admin.reset.confirm_desc_1'), htmlspecialchars($world_name)) ?><br>
        <?= __('admin.reset.confirm_desc_2') ?>
    </p>

    <form method="post"
        onsubmit="return confirm('<?= addslashes(__('admin.reset.confirm_alert')) ?>');">
        <div style="margin-bottom: 15px;">
            <label for="confirm_closure" style="display: block; margin-bottom: 5px; font-weight: bold;">
                <?= __('admin.reset.confirm_label') ?>
            </label>
            <input type="text" name="confirm_closure" id="confirm_closure"
                style="padding: 10px; width: 300px; font-size: 14px; border: 2px solid #ff9800;" placeholder="<?= __('admin.reset.confirm_placeholder') ?>"
                required>
        </div>

        <button type="submit" class="btn"
            style="background: #f44336; color: white; padding: 12px 30px; font-size: 16px; font-weight: bold;">
            <i class="fas fa-flag-checkered"></i> <?= __('admin.reset.btn_close') ?>
        </button>
    </form>
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
<h3><?= __('screens.settings_move.title') ?></h3>
<p><?= __('screens.settings_move.description') ?></p>

<p><?= __('screens.settings_move.cooldown_info') ?></p>

<?php if (!$can_restart): ?>
    <p><b><?= sprintf(__('screens.settings_move.village_count_error'), $village_count) ?></b></p>
<?php elseif (!$can_restart_time): ?>
    <p><b><?= __('screens.settings_move.possible_in') ?>     <?= $mozliwe_o ?></b></p>
    <p><?= __('screens.settings_move.wait_3_days') ?></p>
<?php elseif ($form ?? false): ?>
    <form action="game.php?village=<?= $village['id'] ?>&screen=settings&mode=move&action=move&h=<?= $hkey ?>"
        method="post">
        <?= __('screens.settings_move.enter_password') ?> <input name="password" type="password">
        <input value="OK" type="submit">
    </form>
<?php else: ?>
    <p><b><?= __('screens.settings_move.possible_in') ?>     <?= $mozliwe_o ?></b></p>
<?php endif; ?>
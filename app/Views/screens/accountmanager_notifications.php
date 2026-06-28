<?php
/**
 * Account Manager - Notifications Mode
 * Configure attack and event notifications
 */
?>

<h3><?= __('screens.am_notifications.attack_notifications') ?></h3>

<form method="post"
    action="game.php?village=<?= $village['id'] ?>&screen=accountmanager&mode=notifications&action=save">
    <table class="vis" width="100%">
        <tr>
            <td width="30">
                <input type="checkbox" name="activate_attack_notification" id="activate_attack_notification"
                    <?= !empty($notifications['activate_attack_notification']) ? 'checked' : '' ?>>
            </td>
            <td>
                <label for="activate_attack_notification">
                    <strong><?= __('screens.am_notifications.activate_attack_notification') ?></strong>
                </label>
                <span style="color: #666; font-size: 11px;">
                    <?= __('screens.am_notifications.requires_premium') ?>
                </span>
            </td>
        </tr>
    </table>

    <br>

    <h4><?= __('screens.am_notifications.when_receive_notifications') ?></h4>
    <table class="vis" width="100%">
        <tr>
            <td width="30">
                <input type="radio" name="notification_timing" value="first_attack" id="first_attack"
                    <?= ($notifications['notification_timing'] ?? 'first_attack') === 'first_attack' ? 'checked' : '' ?>>
            </td>
            <td>
                <label for="first_attack"><?= __('screens.am_notifications.after_first_attack') ?></label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="radio" name="notification_timing" value="every_x_attacks" id="every_x_attacks"
                    <?= ($notifications['notification_timing'] ?? '') === 'every_x_attacks' ? 'checked' : '' ?>>
            </td>
            <td>
                <label for="every_x_attacks"><?= __('screens.am_notifications.after_every_x_attacks') ?>
                    <input type="number" name="attack_count" value="<?= $notifications['attack_count'] ?? 3 ?>" min="1"
                        max="100" style="width: 50px;"> <?= __('screens.am_notifications.new_attacks') ?>
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="radio" name="notification_timing" value="notify_event" id="notify_event"
                    <?= ($notifications['notification_timing'] ?? '') === 'notify_event' ? 'checked' : '' ?>>
            </td>
            <td>
                <label for="notify_event"><?= __('screens.am_notifications.notify_always') ?>
                    <input type="number" name="notify_minutes" value="<?= $notifications['notify_minutes'] ?? 60 ?>"
                        min="1" max="1440" style="width: 60px;"> <?= __('screens.am_notifications.minutes_before') ?>
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="radio" name="notification_timing" value="only_logged_out" id="only_logged_out"
                    <?= ($notifications['notification_timing'] ?? '') === 'only_logged_out' ? 'checked' : '' ?>>
            </td>
            <td>
                <label for="only_logged_out"><?= __('screens.am_notifications.only_logged_out') ?></label>
            </td>
        </tr>
    </table>

    <br>

    <h4><?= __('screens.am_notifications.how_group_attacks') ?></h4>
    <table class="vis" width="100%">
        <tr>
            <td width="30">
                <input type="radio" name="grouping" value="no_grouping" id="no_grouping" <?= ($notifications['grouping'] ?? 'no_grouping') === 'no_grouping' ? 'checked' : '' ?>>
            </td>
            <td>
                <label for="no_grouping"><?= __('screens.am_notifications.no_grouping') ?></label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="radio" name="grouping" value="by_attacker" id="by_attacker" <?= ($notifications['grouping'] ?? '') === 'by_attacker' ? 'checked' : '' ?>>
            </td>
            <td>
                <label for="by_attacker"><?= __('screens.am_notifications.by_attacker') ?></label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="radio" name="grouping" value="by_village" id="by_village" <?= ($notifications['grouping'] ?? '') === 'by_village' ? 'checked' : '' ?>>
            </td>
            <td>
                <label for="by_village"><?= __('screens.am_notifications.by_village') ?></label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="radio" name="grouping" value="only_total" id="only_total" <?= ($notifications['grouping'] ?? '') === 'only_total' ? 'checked' : '' ?>>
            </td>
            <td>
                <label for="only_total"><?= __('screens.am_notifications.only_total') ?>
                    <input type="number" name="total_attacks" value="<?= $notifications['total_attacks'] ?? 5 ?>"
                        min="1" max="1000" style="width: 60px;"> <?= __('screens.am_notifications.attacks_per_group') ?>
                </label>
            </td>
        </tr>
    </table>

    <br>

    <div style="text-align: center;">
        <input type="hidden" name="h" value="<?= $hkey ?>">
        <button type="submit" class="btn"><?= __('screens.am_notifications.save') ?></button>
    </div>
</form>
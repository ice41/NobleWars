<?php if (!empty($error)): ?>
    <div class="error_box"><?= $error ?></div>
<?php elseif (!empty($success)): ?>
    <div class="success_box"><?= $success ?></div>
<?php endif; ?>

<h3><?= __('screens.settings_command_sharing.title') ?></h3>

<p><?= __('screens.settings_command_sharing.description') ?></p>

<?php if (!$user['premium_p']): ?>
    <div class="info_box">
        <img src="graphic/new/premium/Premium_large.webp" width="20" height="20" align="absmiddle">
        <?= __('screens.settings_command_sharing.premium_required') ?>
    </div>
<?php endif; ?>

<h4><?= __('screens.settings_command_sharing.tribe') ?></h4>

<form method="post"
    action="game.php?village=<?= $village['id'] ?>&screen=settings&mode=command_sharing&action=save&h=<?= $hkey ?>">
    <table class="vis" style="width: 100%;">
        <tr>
            <th><?= __('screens.settings_command_sharing.player') ?></th>
            <th width="200"><?= __('screens.settings_command_sharing.share_my_commands') ?></th>
        </tr>
        <?php foreach ($tribe_members as $member): ?>
            <tr>
                <td>
                    <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $member['id'] ?>">
                        <?= $member['username'] ?>
                    </a>
                </td>
                <td>
                    <input type="checkbox" name="shared_with[]" value="<?= $member['id'] ?>" <?= $member['is_shared'] ? 'checked' : '' ?> class="share_checkbox">
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <th><b><?= __('screens.settings_command_sharing.select_all') ?></b></th>
            <th><input type="checkbox" id="select_all" onclick="selectAll(this)"></th>
        </tr>
    </table>

    <br>
    <input type="submit" value="<?= __('screens.common.save') ?>">
</form>

<script>
    function selectAll(source) {
        checkboxes = document.getElementsByClassName('share_checkbox');
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = source.checked;
        }
    }
</script>
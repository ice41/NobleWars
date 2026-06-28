<?php if (!$is_leader): ?>
    <p class="error">
        <?= __('screens.ally.mass_mail_no_permission') ?>
    </p>
<?php else: ?>

    <?php if (!empty($success)): ?>
        <p class="success">
            <?= htmlspecialchars($success) ?>
        </p>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <p class="error">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <h3>
        <?= __('screens.ally.mass_mail_title') ?>
    </h3>

    <form action="game.php?village=<?= $village['id'] ?>&screen=ally&mode=mass_mail&action=send&h=<?= $session['hkey'] ?>"
        method="post">
        <table class="vis" width="100%">
            <tr>
                <th colspan="2">
                    <?= __('screens.ally.mass_mail_send') ?>
                </th>
            </tr>
            <tr>
                <td width="150">
                    <?= __('screens.ally.mass_mail_subject') ?>
                </td>
                <td>
                    <input type="text" name="subject" size="50" maxlength="200"
                        value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>" required />
                </td>
            </tr>
            <tr>
                <td>
                    <?= __('screens.ally.mass_mail_message') ?>
                </td>
                <td>
                    <textarea name="message" rows="10" cols="60"
                        required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="center">
                    <input type="submit" value="<?= __('screens.ally.mass_mail_submit') ?>" class="btn" />
                </td>
            </tr>
        </table>
    </form>

    <br />

    <table class="vis" width="100%">
        <tr>
            <th colspan="2">
                <?= __('screens.ally.mass_mail_info_title') ?>
            </th>
        </tr>
        <tr>
            <td>
                <?= __('screens.ally.mass_mail_recipients') ?>
            </td>
            <td>
                <?= ($ally['members'] ?? 0) > 0 ? (int)$ally['members'] . ' ' . __('screens.ally.menu_members') : __('screens.ally.mass_mail_all_members') ?>
            </td>
        </tr>
    </table>

<?php endif; ?>
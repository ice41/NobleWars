<?php if (!empty($error)): ?>

    <div class="admin-alert error"><i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <div class="admin-alert success"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<div class="admin-card">
    <h3><i class="fas fa-envelope-open-text"></i> <?= __('admin.massmail.title') ?></h3>
    <p><?= __('admin.massmail.desc') ?></p>
</div>

<div class="admin-card">
    <h3><i class="fas fa-paper-plane"></i> <?= __('admin.massmail.compose') ?></h3>
    <form action="<?= $adminBaseUrl ?>&mode=massmail" method="post">
        <table class="vis" width="100%">
            <tr>
                <td width="150"><strong><?= __('admin.massmail.subject') ?></strong></td>
                <td>
                    <input type="text" name="subject" style="width: 100%; max-width: 600px;"
                        placeholder="<?= __('admin.massmail.subject_placeholder') ?>" required />
                </td>
            </tr>
            <tr>
                <td width="150" valign="top">
                    <strong><?= __('admin.massmail.message') ?></strong><br><small><?= __('admin.massmail.bb_codes') ?></small>
                </td>
                <td>
                    <?php
                    $textareaId = 'message';
                    $prefix = 'amm_';
                    include dirname(dirname(__DIR__)) . '/components/bbcode_toolbar.php';
                    ?>

                    <textarea id="message" name="message" rows="10"
                        style="width: 100%; max-width: 600px; margin-top: 5px;"
                        placeholder="<?= __('admin.massmail.message_placeholder') ?>" required></textarea>
                </td>

            </tr>
            <tr>
                <td colspan="2" align="center">
                    <button type="submit" name="send_massmail" class="btn btn-success"
                        style="padding: 10px 20px; font-weight: bold;">
                        <i class="fas fa-paper-plane"></i> <?= __('admin.massmail.send_btn') ?>
                    </button>
                </td>
            </tr>
        </table>
    </form>
</div>
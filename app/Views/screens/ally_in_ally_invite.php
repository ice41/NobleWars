<?php
/**
 * Ally Invite Screen — screen=ally&mode=invite
 * Layout: left column (invites list + invite form + recruitment settings)
 *         right column (welcome message)
 */
$baseUrl = 'game.php?village=' . $village['id'] . '&screen=ally&mode=invite';
$hkey    = $session['hkey'];

// Current recruitment type (passed from controller, default 'apply')
$joinType      = $join_type      ?? 'apply';
$applyTemplate = $apply_template ?? '';
?>

<?php if (!empty($error)): ?>
    <div  style="padding:6px 8px; background:#ffe0e0; border:1px solid #c00; margin-bottom:8px; font-size:11px;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <div  style="padding:6px 8px; background:#ddffd7; border:1px solid #070; margin-bottom:8px; font-size:11px;">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<!-- ══ 2-column layout ══ -->
<table width="100%" cellpadding="0" cellspacing="10"  style="border:0;">
<tr valign="top">

    <!-- ══ LEFT COLUMN ══ -->
    <td width="50%">

        <!-- ── Convites ── -->
        <table class="vis" width="100%">
            <tr>
                <th colspan="3"><?= __('screens.ally.invite_pending_title') ?></th>
            </tr>
            <?php if (empty($pending_invites)): ?>
                <tr>
                    <td colspan="3"  style="padding:6px 8px; font-style:italic; font-size:11px;">
                        <?= __('screens.ally.no_pending_invites') ?>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($pending_invites as $inv): ?>
                    <tr class="row_b">
                        <td  style="padding:3px 6px;"><?= htmlspecialchars($inv['username']) ?></td>
                        <td  style="padding:3px 6px; color:#888; font-size:10px;">
                            <?= date('d/m/Y H:i', $inv['time']) ?>
                        </td>
                        <td  style="padding:3px 6px;">
                            <a href="<?= $baseUrl ?>&action=cancel&id=<?= $inv['id'] ?>&h=<?= $hkey ?>"
                               onclick="return confirm('<?= __('screens.ally.cancel_invite_confirm') ?>')"
                               style="font-size:11px;">
                                <?= __('screens.ally.cancel') ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>

        <br>

        <!-- ── Convidar ── -->
        <table class="vis" width="100%">
            <tr>
                <th colspan="2"><?= __('screens.ally.invite_section_title') ?></th>
            </tr>
            <tr class="row_b">
                <td  style="padding:5px 8px; width:60px;"><b><?= __('screens.ally.player_name') ?>:</b></td>
                <td  style="padding:5px 8px;">
                    <form method="post" action="<?= $baseUrl ?>&action=invite&h=<?= $hkey ?>" style="display:inline;">
                        <input type="text" name="username" size="20"
                                style="border:1px solid #b0955a; padding:2px 4px; font-size:11px;">
                        <input type="submit" value="<?= __('screens.ally.send_invite') ?>" class="btn" style="font-size:11px;">
                    </form>
                </td>
            </tr>
            <tr>
                <td colspan="2"  style="padding:5px 8px; font-size:11px; color:#444;">
                    <?= __('screens.ally.invite_friends_msg') ?><br>
                    <a href="game.php?village=<?= $village['id'] ?>&screen=profile&mode=invite"
                       style="font-weight:bold; font-size:11px;"><?= __('screens.ally.invite_friends_link') ?></a>
                </td>
            </tr>
        </table>

        <br>

        <!-- ── Recrutamento ── -->
        <form method="post" action="<?= $baseUrl ?>&action=save_recruitment&h=<?= $hkey ?>">
            <table class="vis" width="100%">
                <tr>
                    <th><?= __('screens.ally.recruitment_title') ?></th>
                </tr>
                <tr class="row_b">
                    <td  style="padding:6px 10px;">
                        <label  style="display:block; margin-bottom:4px;">
                            <input type="radio" name="join_type" value="open"
                                <?= ($joinType === 'open') ? 'checked' : '' ?>>
                            <?= __('screens.ally.recruitment_open') ?>
                        </label>
                        <label  style="display:block; margin-bottom:4px;">
                            <input type="radio" name="join_type" value="apply"
                                <?= ($joinType === 'apply') ? 'checked' : '' ?>>
                            <?= __('screens.ally.recruitment_apply') ?>
                        </label>

                        <!-- application template textarea — only relevant when 'apply' -->
                        <div  style="margin-left:18px; margin-bottom:6px;">
                            <b  style="font-size:11px;"><?= __('screens.ally.recruitment_template') ?>:</b><br>
                            <textarea name="apply_text" rows="6" cols="38"
                                 style="border:1px solid #b0955a; padding:3px; font-size:11px; resize:vertical;"
                                ><?= htmlspecialchars($applyTemplate) ?></textarea>
                        </div>

                        <label  style="display:block; margin-bottom:6px;">
                            <input type="radio" name="join_type" value="invite_only"
                                <?= ($joinType === 'invite_only') ? 'checked' : '' ?>>
                            <?= __('screens.ally.recruitment_invite_only') ?>
                        </label>

                        <input type="submit" value="<?= __('screens.ally.recruitment_save') ?>" class="btn">
                    </td>
                </tr>
            </table>
        </form>

    </td>

    <!-- ══ RIGHT COLUMN ══ -->
    <td>

        <!-- ── Mensagem de boas-vindas ── -->
        <table class="vis" width="100%">
            <tr>
                <th><?= __('screens.ally.welcome_message_title') ?></th>
            </tr>
            <tr class="row_b">
                <td  style="padding:6px 10px;">
                    <?php if (isset($_GET['edit_welcome'])): ?>
                        <form method="post" action="<?= $baseUrl ?>&action=save_welcome&h=<?= $hkey ?>">
                            <textarea name="welcome_message" rows="8" cols="40"
                                 class="w-100" style="border:1px solid #b0955a; padding:3px; font-size:11px;"
                                ><?= htmlspecialchars($ally['intern_text'] ?? '') ?></textarea><br>
                            <input type="submit" value="<?= __('screens.ally.recruitment_save') ?>" class="btn" style="margin-top:4px;">
                            <a href="<?= $baseUrl ?>" class="btn" style="margin-left:4px;"><?= __('screens.ally.cancel') ?></a>
                        </form>
                    <?php else: ?>
                        <?php if (!empty($ally['intern_text'])): ?>
                            <div  style="font-size:11px; margin-bottom:8px;"><?= nl2br(htmlspecialchars($ally['intern_text'])) ?></div>
                        <?php endif; ?>
                        <a href="<?= $baseUrl ?>&edit_welcome=1" class="btn"><?= __('screens.ally.welcome_edit_btn') ?></a>
                    <?php endif; ?>
                </td>
            </tr>
        </table>

    </td>

</tr>
</table>

<?php
// Show inline edit if requested
if (isset($_GET['edit_welcome'])):
?>
<script>
// Refresh page to show textarea (simple approach — toggle via GET param)
</script>
<?php endif; ?>
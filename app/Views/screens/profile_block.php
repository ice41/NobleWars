<?php if (!empty($error)): ?>
    <div class="error"><?= $error ?></div>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <div class="success"><?= $success ?></div>
<?php endif; ?>

<!-- Tabs Navigation Container -->
<table class="content-border" width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td>
            <table class="main" width="100%" align="center">
                <tr>
                    <td id="content_value">
                        <!-- Navigation Tabs -->
                        <table class="vis" width="100%">
                            <tr>
                                <?php foreach ($tabs as $key => $label): ?>
                                    <?php
                                    $is_active = ($key === $current_tab);
                                    $bg_color = $is_active ? '#e5c389' : '#f4e4bc';
                                    $label_display = ($key === 'profile') ? \App\Helpers\CosmeticHelper::formatUsername($user['username'], $user['id']) : htmlspecialchars($label);
                                    ?>
                                    <td align="center"
                                         style="background-color: <?= $bg_color ?>; padding: 4px 10px; border: 1px solid #7d510f;">
                                        <a href="game.php?village=<?= $village['id'] ?>&screen=profile&mode=<?= $key ?>"
                                            style="text-decoration: none; font-weight: bold; color: #5d2f09;">
                                            <?= $label_display ?>
                                        </a>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        </table>

                        <!-- Main Content -->
                        <div
                             class="p-10 mt-5" style="background-color: #fceec4; border: 1px solid #c1a264;">

                            <table class="vis" width="100%">
                                <tr>
                                    <th colspan="2"><?= __('screens.profile.block_player') ?></th>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <p><?= __('screens.profile.block_description') ?></p>
                                        <ul>
                                            <li><?= __('screens.profile.block_send_messages') ?></li>
                                            <li><?= __('screens.profile.block_friend_requests') ?></li>
                                            <li><?= __('screens.profile.block_temp_replacement') ?></li>
                                            <li><?= __('screens.profile.block_forward_reports') ?></li>
                                            <li><?= __('screens.profile.block_tribe_invite') ?></li>
                                            <li><?= __('screens.profile.block_become_apprentice') ?></li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <form
                                            action="game.php?village=<?= $village['id'] ?>&screen=profile&mode=block&action=add&h=<?= $hkey ?>"
                                            method="post" style="margin: 10px 0;">
                                            <label for="username"><?= __('screens.profile.player_label') ?></label>
                                            <input type="text" name="username" id="username"
                                                placeholder="<?= __('screens.profile.player_name') ?>" size="20"
                                                required>
                                            <input type="submit" value="<?= __('screens.profile.block_player') ?>"
                                                class="btn btn-cancel">
                                        </form>
                                    </td>
                                </tr>
                            </table>

                            <br>

                            <?php if (!empty($blocked_players)): ?>
                                <table class="vis" width="100%">
                                    <tr>
                                        <th><?= __('screens.profile.player') ?></th>
                                        <th><?= __('screens.profile.points') ?></th>
                                        <th><?= __('screens.profile.villages') ?></th>
                                        <th><?= __('screens.profile.tribe') ?></th>
                                        <th><?= __('screens.profile.block_date') ?></th>
                                        <th><?= __('screens.profile.actions') ?></th>
                                    </tr>
                                    <?php foreach ($blocked_players as $blocked): ?>
                                        <tr>
                                            <td>
                                                <a
                                                    href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $blocked['blocked_id'] ?>">
                                                    <?= htmlspecialchars($blocked['username']) ?>
                                                </a>
                                            </td>
                                            <td><?= number_format($blocked['points']) ?></td>
                                            <td><?= number_format($blocked['villages']) ?></td>
                                            <td>
                                                <?php if ($blocked['ally'] != 0): ?>
                                                    <a
                                                        href="game.php?village=<?= $village['id'] ?>&screen=info_ally&id=<?= $blocked['ally'] ?>">
                                                        <?= __('screens.profile.tribe') ?>
                                                    </a>
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                            <td><?= date('d.m.Y H:i', strtotime($blocked['blocked_date'])) ?></td>
                                            <td>
                                                <a href="game.php?village=<?= $village['id'] ?>&screen=profile&mode=block&action=remove&id=<?= $blocked['blocked_id'] ?>&h=<?= $hkey ?>"
                                                    class="btn">
                                                    <?= __('screens.profile.unblock') ?>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            <?php else: ?>
                                <table class="vis" width="100%">
                                    <tr>
                                        <td align="center"><?= __('screens.profile.no_blocked_players') ?></td>
                                    </tr>
                                </table>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

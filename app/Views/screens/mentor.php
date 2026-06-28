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
                            style="background-color: #fceec4; padding: 10px; border: 1px solid #c1a264; margin-top: 5px;">

                            <h3><?= __('screens.profile.mentorship') ?></h3>

                            <?php if (empty($mentor_data['is_mentor']) && empty($mentor_data['has_mentor'])): ?>
                                <!-- Not a mentor and doesn't have a mentor -->

                                <p><?= __('screens.profile.mentor_welcome') ?></p>

                                <p><?= __('screens.profile.mentor_description_1') ?></p>

                                <p><?= __('screens.profile.mentor_description_2') ?></p>

                                <p><?= __('screens.profile.mentor_description_3') ?></p>

                                <p><?= __('screens.profile.mentor_description_4') ?></p>

                                <p><?= __('screens.profile.mentor_description_5') ?></p>

                                <table class="vis" width="100%">
                                    <tr>
                                        <th><?= __('screens.profile.requirements') ?></th>
                                        <th><?= __('screens.profile.status') ?></th>
                                    </tr>
                                    <tr>
                                        <td><?= __('screens.profile.minimum_1000_points') ?></td>
                                        <td><?= $user['points'] >= 1000 ? '✓' : '✗' ?>
                                            (<?= format_number($user['points']) ?>)</td>
                                    </tr>
                                    <tr>
                                        <td><?= __('screens.profile.account_7_days_old') ?></td>
                                        <td>
                                            <?php
                                            $accountAge = time() - $user['create_date'];
                                            $daysOld = floor($accountAge / 86400);
                                            echo $daysOld >= 7 ? '✓' : '✗';
                                            echo " ($daysOld " . __('screens.profile.days') . ")";
                                            ?>
                                        </td>
                                    </tr>
                                </table>

                                <br>

                                <form
                                    action="game.php?village=<?= $village['id'] ?>&screen=profile&mode=mentor&action=register"
                                    method="post">
                                    <input type="submit" value="<?= __('screens.profile.register') ?>"
                                        class="btn btn-confirm-yes" <?= ($user['points'] < 1000 || $daysOld < 7) ? 'disabled' : '' ?>>
                                </form>

                            <?php elseif ($mentor_data['is_mentor']): ?>
                                <!-- User is a mentor -->
                                <h4><?= __('screens.profile.mentor_statistics') ?></h4>
                                <table class="vis" width="100%">
                                    <tr>
                                        <th><?= __('screens.profile.total_mentees') ?></th>
                                        <td><?= $mentor_data['total_mentees'] ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= __('screens.profile.completed_mentees') ?></th>
                                        <td><?= $mentor_data['completed_mentees'] ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= __('screens.profile.active_mentees') ?></th>
                                        <td><?= count($mentor_data['mentees']) ?> /
                                            <?= $mentor_data['mentor_info']['max_mentees'] ?>
                                        </td>
                                    </tr>
                                </table>

                                <br>

                                <h4><?= __('screens.profile.active_mentees') ?></h4>
                                <table class="vis" width="100%">
                                    <tr>
                                        <th><?= __('screens.profile.name') ?></th>
                                        <th><?= __('screens.profile.points') ?></th>
                                        <th><?= __('screens.profile.villages') ?></th>
                                        <th><?= __('screens.profile.assigned_on') ?></th>
                                        <th><?= __('screens.profile.actions') ?></th>
                                    </tr>
                                    <?php if (!empty($mentor_data['mentees'])): ?>
                                        <?php foreach ($mentor_data['mentees'] as $mentee): ?>
                                            <tr>
                                                <td>
                                                    <a
                                                        href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $mentee['id'] ?>">
                                                        <?= htmlspecialchars($mentee['username']) ?>
                                                    </a>
                                                </td>
                                                <td><?= format_number($mentee['points']) ?></td>
                                                <td><?= format_number($mentee['villages']) ?></td>
                                                <td><?= date('d/m/Y H:i', $mentee['assigned_at']) ?></td>
                                                <td>
                                                    <a
                                                        href="game.php?village=<?= $village['id'] ?>&screen=mail&mode=new&to=<?= urlencode($mentee['username']) ?>">
                                                        <?= __('screens.profile.send_message') ?>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" align="center"><?= __('screens.profile.no_mentees_assigned') ?></td>
                                        </tr>
                                    <?php endif; ?>
                                </table>

                                <br>

                                <a href="game.php?village=<?= $village['id'] ?>&screen=profile&mode=mentor&action=unregister&h=<?= $hkey ?>"
                                    onclick="return confirm('<?= __('screens.profile.confirm_cancel_mentor') ?>')">
                                    <?= __('screens.profile.cancel_mentor_registration') ?>
                                </a>

                            <?php elseif ($mentor_data['has_mentor']): ?>
                                <!-- User has a mentor (is a mentee) -->
                                <p><?= __('screens.profile.you_have_mentor') ?></p>

                                <table class="vis" width="100%">
                                    <tr>
                                        <th><?= __('screens.profile.your_mentor') ?></th>
                                        <th><?= __('screens.profile.actions') ?></th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a
                                                href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $mentor_data['mentor_assignment']['mentor_id'] ?>">
                                                <?= htmlspecialchars($mentor_data['mentor_assignment']['mentor_name']) ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a
                                                href="game.php?village=<?= $village['id'] ?>&screen=mail&mode=new&to=<?= urlencode($mentor_data['mentor_assignment']['mentor_name']) ?>">
                                                <?= __('screens.profile.send_message') ?>
                                            </a>
                                        </td>
                                    </tr>
                                </table>

                                <p><?= __('screens.profile.assigned_on') ?>:
                                    <?= date('d/m/Y H:i', $mentor_data['mentor_assignment']['assigned_at']) ?>
                                </p>

                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
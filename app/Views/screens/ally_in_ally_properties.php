<?php if (!$is_leader): ?>
    <p class="error"><?= __('screens.ally.only_leader_can_edit_properties') ?></p>
<?php else: ?>
    <?php if (!empty($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <table width="100%">
        <tr>
            <td valign="top" width="50%">
                <!-- Perfil Section -->
                <form
                    action="game.php?village=<?= $village['id'] ?>&screen=ally&mode=properties&action=update&h=<?= $session['hkey'] ?>"
                    method="post">
                    <table class="vis" width="100%">
                        <tr>
                            <th colspan="2"><?= __('screens.ally.profile') ?></th>
                        </tr>
                        <tr>
                            <td width="180"><?= __('screens.ally.tribe_name') ?></td>
                            <td><input type="text" name="name" value="<?= htmlspecialchars($ally['name']) ?>" size="30"
                                    maxlength="30" required /></td>
                        </tr>
                        <tr>
                            <td><?= __('screens.ally.tribe_tag') ?><br><small><?= __('screens.ally.max_6_letters') ?></small>
                            </td>
                            <td><input type="text" name="short" value="<?= htmlspecialchars($ally['short']) ?>" size="10"
                                    maxlength="6" required /></td>
                        </tr>
                        <tr>
                            <td><?= __('screens.ally.homepage') ?></td>
                            <td><input type="text" name="homepage" value="<?= htmlspecialchars($ally['homepage'] ?? '') ?>"
                                    size="30" /></td>
                        </tr>
                        <tr>
                            <td><?= __('screens.ally.number_of_members') ?></td>
                            <td><?= $ally['members'] ?></td>
                        </tr>
                        <tr>
                            <td><?= __('screens.ally.points_top_40') ?></td>
                            <td><?= number_format($ally['best_points'] ?? 0) ?></td>
                        </tr>
                        <tr>
                            <td><?= __('screens.ally.total_points') ?></td>
                            <td><?= number_format($ally['points']) ?></td>
                        </tr>
                        <tr>
                            <td><?= __('screens.ally.average_points') ?></td>
                            <td><?= $ally['members'] > 0 ? number_format(round($ally['points'] / $ally['members'])) : 0 ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?= __('screens.ally.position') ?></td>
                            <td><?= $ally['rank'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right">
                                <input type="submit" value="<?= __('screens.ally.change') ?>" class="btn" />
                            </td>
                        </tr>
                    </table>
                </form>

                <br>

                <!-- Dissolver Tribo Section -->
                <table class="vis" width="100%">
                    <tr>
                        <th><?= __('screens.ally.dissolve_tribe') ?></th>
                    </tr>
                    <tr>
                        <td align="center">
                            <form
                                action="game.php?village=<?= $village['id'] ?>&screen=ally&mode=properties&action=dissolve&h=<?= $session['hkey'] ?>"
                                method="post" onsubmit="return confirm('<?= __('screens.ally.dissolve_confirm') ?>');">
                                <input type="submit" value="<?= __('screens.ally.dissolve_tribe') ?>" class="btn"
                                    style="background-color: #a00; color: white;" />
                            </form>
                        </td>
                    </tr>
                </table>
            </td>

            <td valign="top" width="50%"  style="padding-left: 10px;">
                <!-- Descrição Section -->
                <form
                    action="game.php?village=<?= $village['id'] ?>&screen=ally&mode=profile&action=update&h=<?= $session['hkey'] ?>"
                    method="post">
                    <table class="vis" width="100%">
                        <tr>
                            <th><?= __('screens.ally.description') ?></th>
                        </tr>
                        <tr>
                            <td align="center">
                                <?php $bbParser = new \App\Helpers\BBCodeParser(); ?>
                                <?= $bbParser->parse($ally['description'] ?? '') ?>
                                <br><br>
                                <i><?= __('screens.ally.description_edit_note') ?></i>
                                <br><br>
                                <a
                                    href="game.php?village=<?= $village['id'] ?>&screen=ally&mode=profile"><?= __('screens.ally.edit') ?></a>
                            </td>
                        </tr>
                    </table>
                </form>

                <br>

                <!-- Brasão da tribo Section -->
                <form
                    action="game.php?village=<?= $village['id'] ?>&screen=ally&mode=properties&action=update_image&h=<?= $session['hkey'] ?>"
                    method="post">
                    <table class="vis" width="100%">
                        <tr>
                            <th><?= __('screens.ally.tribe_emblem') ?></th>
                        </tr>
                        <tr>
                            <td align="center">
                                <?php if (!empty($ally['image'])): ?>
                                    <img src="<?= htmlspecialchars($ally['image']) ?>" alt="<?= __('screens.ally.emblem') ?>"
                                        style="max-width: 200px; max-height: 200px;">
                                    <br><br>
                                <?php endif; ?>

                                <p><b><?= __('screens.ally.image_url') ?></b></p>
                                <input type="url" name="image_url" value="<?= htmlspecialchars($ally['image'] ?? '') ?>"
                                    size="40" placeholder="<?= __('screens.ally.image_url_placeholder') ?>">
                                <br><br>
                                <small><?= __('screens.ally.paste_direct_link') ?></small>
                                <br><small><?= __('screens.ally.recommended_size') ?></small>
                                <br><br>
                                <input type="submit" value="<?= __('screens.ally.update_emblem') ?>" class="btn">
                            </td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>
<?php endif; ?>
<?php if ($res_disabled ?? false): ?>

    <!-- System disabled -->
    <p><?= __('screens.ally.res_disabled_msg') ?></p>
    <?php if ($is_leader): ?>
        <a href="game.php?village=<?= $village['id'] ?>&screen=ally&mode=reservations&action=enable&h=<?= $session['hkey'] ?>"
            class="btn">
            <?= __('screens.ally.res_enable') ?>
        </a>
    <?php endif; ?>

<?php elseif ($config_mode ?? false): ?>

    <!-- Edit Config (leader only) -->
    <h3><?= __('screens.ally.res_config_title') ?></h3>
    <form
        action="game.php?village=<?= $village['id'] ?>&screen=ally&mode=reservations&action=config&h=<?= $session['hkey'] ?>"
        method="post">
        <table class="vis" width="100%">
            <tr>
                <th colspan="2"><?= __('screens.ally.res_config_title') ?></th>
            </tr>
            <tr>
                <td><?= __('screens.ally.res_config_max') ?></td>
                <td><input type="number" name="max_reservations" min="1" max="50"
                        value="<?= (int) ($config['max_reservations'] ?? 5) ?>"></td>
            </tr>
            <tr>
                <td><?= __('screens.ally.res_config_days') ?></td>
                <td><input type="number" name="max_days" min="1" max="30" value="<?= (int) ($config['max_days'] ?? 3) ?>">
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="<?= __('screens.ally.res_config_save') ?>" class="btn">
                </td>
            </tr>
        </table>
    </form>

<?php elseif ($partners_mode ?? false): ?>

    <!-- Partners (placeholder) -->
    <h3><?= __('screens.ally.res_partners_title') ?></h3>
    <table class="vis" width="100%">
        <tr>
            <th><?= __('screens.ally.res_partners_title') ?></th>
        </tr>
        <tr>
            <td align="center"><i><?= __('screens.ally.res_partners_info') ?></i></td>
        </tr>
    </table>
    <br>
    <a href="game.php?village=<?= $village['id'] ?>&screen=ally&mode=reservations">&laquo;
        <?= __('screens.ally.res_show_log') ?></a>

<?php else: ?>

    <p><?= __('screens.ally.res_intro') ?></p>

    <form action="game.php?village=<?= $village['id'] ?>&screen=ally&mode=reservations&h=<?= $session['hkey'] ?>"
        method="post" id="reservations_form">
        <table class="vis" width="100%">
            <tr>
                <th width="20"><input type="checkbox" id="select_all_res" onclick="toggleAllReservations(this)"></th>
                <th><?= __('screens.ally.res_village_name') ?></th>
                <th><?= __('screens.ally.res_points') ?></th>
                <th><?= __('screens.ally.res_owner') ?></th>
                <th><?= __('screens.ally.res_reserved_by') ?></th>
                <th><?= __('screens.ally.res_expires') ?></th>
                <th width="60"><?= __('screens.ally.res_actions') ?></th>
            </tr>
            <?php if (empty($reservations)): ?>
                <tr>
                    <td colspan="7" align="center"><i><?= __('screens.ally.res_no_reservations') ?></i></td>
                </tr>
            <?php else: ?>
                <?php foreach ($reservations as $res): ?>
                    <tr>
                        <td align="center">
                            <input type="checkbox" name="res[]" value="<?= $res['id'] ?>">
                        </td>
                        <td>
                            <a href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $res['village_id'] ?>">
                                <?= htmlspecialchars($res['village_name']) ?>
                            </a>
                        </td>
                        <td align="center"><?= number_format($res['points']) ?></td>
                        <td><?= htmlspecialchars($res['owner_name'] ?? __('screens.ally.res_barbarian')) ?></td>
                        <td><?= htmlspecialchars($res['reserved_by']) ?></td>
                        <td align="center"><?= date('d.m.Y H:i', $res['expires_at']) ?></td>
                        <td align="center">
                            <?php if ($res['user_id'] == $user['id'] || $is_leader): ?>
                                <a href="game.php?village=<?= $village['id'] ?>&screen=ally&mode=reservations&action=delete&id=<?= $res['id'] ?>&h=<?= $session['hkey'] ?>"
                                    onclick="return confirm('<?= __('screens.ally.res_cancel_confirm') ?>');">
                                    <img src="graphic/icons/delete.png" alt="X" title="<?= __('screens.ally.res_cancel_title') ?>"
                                        style="width: 12px;">
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>

        <div  class="mt-5">
            <input type="submit" name="delete_selected" value="<?= __('screens.ally.res_delete_selected') ?>" class="btn">
            <input type="submit" name="export_selected" value="<?= __('screens.ally.res_export_selected') ?>" class="btn">
        </div>
    </form>

    <script>
        function toggleAllReservations(checkbox) {
            const checkboxes = document.querySelectorAll('input[name="res[]"]');
            checkboxes.forEach(cb => cb.checked = checkbox.checked);
        }
    </script>

    <br>

    <a href="javascript:void(0);" onclick="document.getElementById('reservation_log').style.display='block';">&raquo;
        <?= __('screens.ally.res_show_log') ?></a>

    <div id="reservation_log"  style="display:none;">
        <br>
        <table class="vis" width="100%">
            <tr>
                <th><?= __('screens.ally.res_log_date') ?></th>
                <th><?= __('screens.ally.res_log_event') ?></th>
            </tr>
            <tr>
                <td colspan="2" align="center"><i><?= __('screens.ally.res_no_events') ?></i></td>
            </tr>
        </table>
    </div>

    <br>

    <table width="100%">
        <tr>
            <td valign="top" width="50%">
                <!-- Add new reservation -->
                <form
                    action="game.php?village=<?= $village['id'] ?>&screen=ally&mode=reservations&action=reserve&h=<?= $session['hkey'] ?>"
                    method="post">
                    <table class="vis" width="100%">
                        <tr>
                            <th colspan="2"><?= __('screens.ally.res_add_new') ?></th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="radio" name="search_type" value="coords" id="coords" checked>
                                <label for="coords"><?= __('screens.ally.res_search_coords') ?></label>

                                <input type="radio" name="search_type" value="village" id="village_name">
                                <label for="village_name"><?= __('screens.ally.res_search_village') ?></label>

                                <input type="radio" name="search_type" value="player" id="player_name">
                                <label for="player_name"><?= __('screens.ally.res_search_player') ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="text" name="search_value" size="30" placeholder="123456" required>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <input type="submit" value="<?= __('screens.ally.res_reserve_btn') ?>" class="btn">
                            </td>
                        </tr>
                    </table>
                </form>
            </td>

            <td valign="top" width="50%"  style="padding-left: 10px;">
                <!-- Search reservations -->
                <form action="game.php?village=<?= $village['id'] ?>&screen=ally&mode=reservations&action=search"
                    method="post">
                    <table class="vis" width="100%">
                        <tr>
                            <th colspan="2"><?= __('screens.ally.res_search_title') ?></th>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="search" size="20">
                                <select name="search_field">
                                    <option value="name"><?= __('screens.ally.res_search_by_name') ?></option>
                                    <option value="player"><?= __('screens.ally.res_search_by_player') ?></option>
                                    <option value="reserved_by"><?= __('screens.ally.res_search_by_reserver') ?></option>
                                </select>
                            </td>
                            <td width="100">
                                <input type="submit" value="<?= __('screens.ally.res_search_btn') ?>" class="btn">
                            </td>
                        </tr>
                    </table>
                </form>

                <br>

                <!-- Settings -->
                <table class="vis" width="100%">
                    <tr>
                        <th><?= __('screens.ally.res_settings') ?></th>
                    </tr>
                    <tr>
                        <td>
                            <b><?= __('screens.ally.res_limit') ?>:</b> <?= $config['max_reservations'] ?? 5 ?>
                            <?= __('screens.ally.res_villages') ?><br>
                            <b><?= __('screens.ally.res_time_limit') ?>:</b> <?= $config['max_days'] ?? 3 ?>
                            <?= __('screens.ally.res_days') ?><br>
                            <b><?= __('screens.ally.res_wait_time') ?>:</b> <?= $config['wait_days'] ?? 3 ?>
                            <?= __('screens.ally.res_days') ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <?php if ($is_leader): ?>
                                <a href="game.php?village=<?= $village['id'] ?>&screen=ally&mode=reservations&action=config">&raquo;
                                    <?= __('screens.ally.res_edit_settings') ?></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>

                <br>

                <!-- Shared reservation system -->
                <table class="vis" width="100%">
                    <tr>
                        <th><?= __('screens.ally.res_shared_with') ?></th>
                    </tr>
                    <tr>
                        <td align="center">
                            <i><?= __('screens.ally.res_none') ?></i>
                            <?php if ($is_leader): ?>
                                <br><br>
                                <a href="game.php?village=<?= $village['id'] ?>&screen=ally&mode=reservations&action=partners">&raquo;
                                    <?= __('screens.ally.res_edit_partners') ?></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <?php if ($is_leader): ?>
        <br>
        <a href="game.php?village=<?= $village['id'] ?>&screen=ally&mode=reservations&action=disable&h=<?= $session['hkey'] ?>"
            onclick="return confirm('<?= __('screens.ally.res_disable_confirm') ?>');">
            &raquo; <?= __('screens.ally.res_disable') ?>
        </a>
    <?php endif; ?>

<?php endif; ?>
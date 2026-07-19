<?php
/**
 * Info Village View - Village information screen
 * Shows village details, owner, tribe, and admin features
 */
?>

<?php if ($noob): ?>
    <span class="error"><?= sprintf(__('screens.ally.protection_until'), htmlspecialchars($noob_end)) ?></span>
<?php endif; ?>

<h2><?php echo htmlspecialchars($info_village['name']); ?></h2>

<table>
    <tr>
        <td valign="top">
            <table class="vis">
                <tr>
                    <th colspan="2">
                        <?php echo htmlspecialchars($info_village['name']); ?>
                        <?php if ($noob): ?>
                            <br>
                            <span class="error">
                                <img src="graphic/ochpocz.png" alt="<?= __('screens.ally.protection_against_attack') ?>">
                                <?= __('screens.ally.protection_against_attack') ?>
                            </span>
                        <?php endif; ?>
                    </th>
                </tr>
                <tr>
                    <td width="80"><?= __('screens.ally.coordinates') ?></td>
                    <td><?php echo $info_village['x']; ?>|<?php echo $info_village['y']; ?></td>
                </tr>
                <tr>
                    <td><?= __('screens.ally.points') ?></td>
                    <td width="180"><?php echo format_number($info_village['points']); ?></td>
                </tr>
                <?php if (empty($info_user['username'])): ?>
                    <tr>
                        <td><?= __('screens.ally.player') ?: 'Jogador:' ?></td>
                        <td><a href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_player&amp;id=0"></a>
                        </td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td><?= __('screens.ally.player') ?: 'Jogador:' ?></td>
                        <td><a
                                href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_player&amp;id=<?php echo $info_village['userid']; ?>"><?php echo htmlspecialchars($info_user['username']); ?></a>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (empty($info_ally['short'])): ?>
                    <tr>
                        <td><?= __('screens.ally.tribe') ?: 'Tribo:' ?></td>
                        <td><a href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_ally&amp;id=0"></a></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td><?= __('screens.ally.tribe') ?: 'Tribo:' ?></td>
                        <td><a
                                href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_ally&amp;id=<?php echo $info_ally['id']; ?>"><?php echo htmlspecialchars($info_ally['short']); ?></a>
                        </td>
                    </tr>
                <?php endif; ?>

                <tr>
                    <td colspan="2"><a
                            href="game.php?village=<?php echo $village['id']; ?>&amp;screen=map&amp;x=<?php echo $info_village['x']; ?>&amp;y=<?php echo $info_village['y']; ?>">&raquo;
                            <?= __('screens.ally.center_on_map') ?></a></td>
                </tr>
                <tr>
                    <td colspan="2"><a
                            href="game.php?village=<?php echo $village['id']; ?>&amp;screen=place&amp;mode=command&amp;target=<?php echo $info_village['id']; ?>">&raquo;
                            <?= __('screens.ally.send_troops') ?></a></td>
                </tr>
                <?php if ($can_send_ress): ?>
                    <tr>
                        <td colspan="2"><a
                                href="game.php?village=<?php echo $village['id']; ?>&amp;screen=market&amp;mode=send&amp;target=<?php echo $info_village['id']; ?>">&raquo;
                                <?= __('screens.ally.send_resources') ?></a></td>
                    </tr>
                <?php endif; ?>
                <?php if ($can_res): ?>
                    <tr>
                        <td colspan="2">
                            <form name="rezerwacje"
                                action="game.php?village=<?php echo $village['id']; ?>&amp;screen=ally&amp;mode=reservations&amp;action=new_reservations&amp;h=<?php echo $_SESSION['hkey'] ?? ''; ?>"
                                method="post">
                                <input type="hidden" value="none" name="typ_akcji" />
                                <a href="game.php?village=<?php echo $village['id']; ?>&screen=info_village&id=<?php echo $info_village['id']; ?>&action=reserve&h=<?php echo $user['hkey']; ?>"
                                    class="btn" onclick="return confirm('<?= __('screens.ally.confirm_reserve_village') ?>');">
                                    <?= __('screens.ally.reserve_village') ?>
                                </a>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if ($user['id'] == $info_village['userid']): ?>
                    <tr>
                        <td colspan="2"><a
                                href="game.php?village=<?php echo $info_village['id']; ?>&amp;screen=overview">&raquo; <?= __('screens.ally.view_village') ?></a></td>
                    </tr>
                <?php endif; ?>
                <?php if ($mozna_lubiec): ?>
                    <tr>
                        <td colspan="2"><a
                                href="game.php?village=<?php echo $village['id']; ?>&amp;screen=favorite&amp;action=dodaj_do_ulub&amp;h=<?php echo $_SESSION['hkey'] ?? ''; ?>&amp;id=<?php echo $info_village['id']; ?>">&raquo;
                                <?= __('screens.ally.add_to_favorites') ?></a></td>
                    </tr>
                <?php endif; ?>
            </table>
        </td>
        <td valign="top">
            <?php if (isset($last_attacks) && is_array($last_attacks) && count($last_attacks) > 0): ?>
                <table class="vis">
                    <tr>
                        <th><?= __('screens.ally.last_10_attacks_title') ?: 'Título (Seus últimos 10 ataques nesta aldeia)' ?></th>
                        <th><?= __('screens.ally.date') ?: 'Data' ?></th>
                    </tr>
                    <?php foreach ($last_attacks as $report): ?>
                        <tr>
                            <td>
                                <img src="<?php echo htmlspecialchars($report['title_image']); ?>" />&nbsp;<a
                                    href='game.php?village=<?php echo $village['id']; ?>&amp;screen=report&amp;mode=all&amp;view=<?php echo $report['id']; ?>'><?php echo htmlspecialchars($report['title']); ?></a>
                            </td>
                            <td>
                                <?php echo format_date($report['time']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </td>
    </tr>
</table>

<?php if (($info_village['bonus'] ?? 0) > 0 && isset($bonus_data) && isset($bonus_data[$info_village['bonus']])): ?>
<table>
    <tr>
        <td>
            <table class="vis">
                <tr>
                    <th colspan="2"><?= __('screens.ally.village_bonus') ?: 'Bônus desta aldeia' ?></th>
                </tr>
                <tr>
                    <td  class="text-center" style="width:40px; padding:6px;">
                        <img src="graphic/bonus/<?= htmlspecialchars($bonus_data[$info_village['bonus']]['grafika']) ?>" alt="bonus">
                    </td>
                    <td  style="padding:6px;">
                        <?= htmlspecialchars($bonus_data[$info_village['bonus']]['opis']) ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php endif; ?>


<?php if ($user['admin'] != 0): ?>
    <div id="show_prod" class="vis moveable widget" size="500">
        <h4 class="head">
            <img  class="float-right pointer" onclick="return VillageOverview.toggleWidget( 'show_prod', this );"
                src="graphic/icons/minus.png"><?= __('screens.ally.bonus_for_village') ?: 'Bônus para esta aldeia:' ?>
        </h4>
        <div class="widget_content" >
            <table class="vis" width="100%">
                <tr>
                    <th><?= __('screens.ally.bonus_id') ?: 'ID bonusu' ?></th>
                    <th><?= __('screens.ally.bonus_graphics') ?: 'Grafika bonusu' ?></th>
                    <th><?= __('screens.ally.set_bonus') ?: 'Ustaw bonus' ?></th>
                </tr>
                <tr>
                    <td><?= __('screens.ally.none') ?: 'Brak' ?></td>
                    <td><?= __('screens.ally.no_bonus') ?: 'Sem bônus' ?></td>
                    <td><a
                            href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_village&amp;id=<?php echo $info_village['id']; ?>&amp;action=bonus&amp;oid=<?php echo $info_village['id']; ?>&amp;bonus=0"><?= __('screens.ally.set') ?: 'Definir' ?></a>
                    </td>
                </tr>
                <tr>
                    <td>1</td>
                    <td><img src="graphic/bonus/storage.png" alt="storage"></td>
                    <td><a
                            href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_village&amp;id=<?php echo $info_village['id']; ?>&amp;action=bonus&amp;oid=<?php echo $info_village['id']; ?>&amp;bonus=1"><?= __('screens.ally.set') ?: 'Definir' ?></a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><img src="graphic/bonus/all.png" alt="all"></td>
                    <td><a
                            href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_village&amp;id=<?php echo $info_village['id']; ?>&amp;action=bonus&amp;oid=<?php echo $info_village['id']; ?>&amp;bonus=2"><?= __('screens.ally.set') ?: 'Definir' ?></a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td><img src="graphic/bonus/wood.png" alt="storage"></td>
                    <td><a
                            href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_village&amp;id=<?php echo $info_village['id']; ?>&amp;action=bonus&amp;oid=<?php echo $info_village['id']; ?>&amp;bonus=3"><?= __('screens.ally.set') ?: 'Definir' ?></a>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td><img src="graphic/bonus/stone.png" alt="storage"></td>
                    <td><a
                            href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_village&amp;id=<?php echo $info_village['id']; ?>&amp;action=bonus&amp;oid=<?php echo $info_village['id']; ?>&amp;bonus=4"><?= __('screens.ally.set') ?: 'Definir' ?></a>
                    </td>
                </tr>
                <tr>
                    <td>5</td>
                    <td><img src="graphic/bonus/iron.png" alt="storage"></td>
                    <td><a
                            href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_village&amp;id=<?php echo $info_village['id']; ?>&amp;action=bonus&amp;oid=<?php echo $info_village['id']; ?>&amp;bonus=5"><?= __('screens.ally.set') ?: 'Definir' ?></a>
                    </td>
                </tr>
                <tr>
                    <td>6</td>
                    <td><img src="graphic/bonus/barracks.png" alt="storage"></td>
                    <td><a
                            href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_village&amp;id=<?php echo $info_village['id']; ?>&amp;action=bonus&amp;oid=<?php echo $info_village['id']; ?>&amp;bonus=6"><?= __('screens.ally.set') ?: 'Definir' ?></a>
                    </td>
                </tr>
                <tr>
                    <td>7</td>
                    <td><img src="graphic/bonus/stable.png" alt="storage"></td>
                    <td><a
                            href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_village&amp;id=<?php echo $info_village['id']; ?>&amp;action=bonus&amp;oid=<?php echo $info_village['id']; ?>&amp;bonus=7"><?= __('screens.ally.set') ?: 'Definir' ?></a>
                    </td>
                </tr>
                <tr>
                    <td>8</td>
                    <td><img src="graphic/bonus/garage.png" alt="storage"></td>
                    <td><a
                            href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_village&amp;id=<?php echo $info_village['id']; ?>&amp;action=bonus&amp;oid=<?php echo $info_village['id']; ?>&amp;bonus=8"><?= __('screens.ally.set') ?: 'Definir' ?></a>
                    </td>
                </tr>
                <tr>
                    <td>9</td>
                    <td><img src="graphic/bonus/farm.png" alt="storage"></td>
                    <td><a
                            href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_village&amp;id=<?php echo $info_village['id']; ?>&amp;action=bonus&amp;oid=<?php echo $info_village['id']; ?>&amp;bonus=9"><?= __('screens.ally.set') ?: 'Definir' ?></a>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div id="show_unit" class="vis moveable widget">
        <h4 class="head">
            <img  class="float-right pointer" onclick="return VillageOverview.toggleWidget( 'show_unit', this );"
                src="graphic/icons/minus.png"><?= __('screens.ally.units_of_village') ?: 'Tropas desta aldeia:' ?>
        </h4>
        <div class="widget_content" >
            <table class="vis">
                <tr>
                    <th><img src="graphic/unit/unit_spear.png"></th>
                    <th><img src="graphic/unit/unit_sword.png"></th>
                    <th><img src="graphic/unit/unit_axe.png"></th>
                    <th><img src="graphic/unit/unit_archer.png"></th>
                    <th><img src="graphic/unit/unit_spy.png"></th>
                    <th><img src="graphic/unit/unit_light.png"></th>
                    <th><img src="graphic/unit/unit_cav_archer.png"></th>
                    <th><img src="graphic/unit/unit_heavy.png"></th>
                    <th><img src="graphic/unit/unit_ram.png"></th>
                    <th><img src="graphic/unit/unit_catapult.png"></th>
                    <th><img src="graphic/unit/unit_snob.png"></th>
                    <th><img src="graphic/unit/unit_paladin.png"></th>
                    <th><img src="graphic/unit/unit_mnich.png"></th>
                </tr>
                <tr>
                    <td><?php echo (int)($info_village['all_unit_spear'] ?? 0); ?></td>
                    <td><?php echo (int)($info_village['all_unit_sword'] ?? 0); ?></td>
                    <td><?php echo (int)($info_village['all_unit_axe'] ?? 0); ?></td>
                    <td><?php echo (int)($info_village['all_unit_archer'] ?? 0); ?></td>
                    <td><?php echo (int)($info_village['all_unit_spy'] ?? 0); ?></td>
                    <td><?php echo (int)($info_village['all_unit_light'] ?? 0); ?></td>
                    <td><?php echo (int)($info_village['all_unit_cav_archer'] ?? 0); ?></td>
                    <td><?php echo (int)($info_village['all_unit_heavy'] ?? 0); ?></td>
                    <td><?php echo (int)($info_village['all_unit_ram'] ?? 0); ?></td>
                    <td><?php echo (int)($info_village['all_unit_catapult'] ?? 0); ?></td>
                    <td><?php echo (int)($info_village['all_unit_snob'] ?? 0); ?></td>
                    <td><?php echo (int)($info_village['all_unit_paladin'] ?? 0); ?></td>
                    <td><?php echo (int)($info_village['all_unit_mnich'] ?? 0); ?></td>
                </tr>
            </table>

            <?php if (isset($unit_place) && is_array($unit_place) && count($unit_place) > 0): ?>
                <table class="vis">
                    <tr>
                        <th colspan="14"><?= __('screens.ally.units_stationed_here') ?: 'As tropas estacionadas nesta aldeia:' ?></th>
                    </tr>
                    <tr>
                        <th><img src="graphic/unit/unit_spear.png"></th>
                        <th><img src="graphic/unit/unit_sword.png"></th>
                        <th><img src="graphic/unit/unit_axe.png"></th>
                        <th><img src="graphic/unit/unit_archer.png"></th>
                        <th><img src="graphic/unit/unit_spy.png"></th>
                        <th><img src="graphic/unit/unit_light.png"></th>
                        <th><img src="graphic/unit/unit_cav_archer.png"></th>
                        <th><img src="graphic/unit/unit_heavy.png"></th>
                        <th><img src="graphic/unit/unit_ram.png"></th>
                        <th><img src="graphic/unit/unit_catapult.png"></th>
                        <th><img src="graphic/unit/unit_snob.png"></th>
                        <th><img src="graphic/unit/unit_paladin.png"></th>
                        <th><img src="graphic/unit/unit_mnich.png"></th>
                        <th><?= __('screens.ally.from_village') ?: 'da aldeia' ?></th>
                    </tr>
                    <?php foreach ($unit_place as $unit): ?>
                        <tr>
                            <td><?php echo $unit['unit_spear']; ?></td>
                            <td><?php echo $unit['unit_sword']; ?></td>
                            <td><?php echo $unit['unit_axe']; ?></td>
                            <td><?php echo $unit['unit_archer']; ?></td>
                            <td><?php echo $unit['unit_spy']; ?></td>
                            <td><?php echo $unit['unit_light']; ?></td>
                            <td><?php echo $unit['unit_cav_archer']; ?></td>
                            <td><?php echo $unit['unit_heavy']; ?></td>
                            <td><?php echo $unit['unit_ram']; ?></td>
                            <td><?php echo $unit['unit_catapult']; ?></td>
                            <td><?php echo $unit['unit_snob']; ?></td>
                            <td><?php echo $unit['unit_paladin']; ?></td>
                            <td><?php echo $unit['unit_mnich']; ?></td>
                            <td><a
                                    href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_village&amp;id=<?php echo $unit['villages_from_id']; ?>"><?php echo $unit['villages_from_id']; ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>


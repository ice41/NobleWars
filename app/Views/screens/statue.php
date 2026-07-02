<?php
// Calculate building image suffix based on level
$current_level = $village[$screen] ?? 0;
$max_stage = $cl_builds->get_maxstage($screen);
$percent = $max_stage > 0 ? $current_level / $max_stage : 0;
$img_suffix = '1';

if ($max_stage > 3) {
    if ($percent > 0.5) {
        $img_suffix = '3';
    } elseif ($percent > 0.2) {
        $img_suffix = '2';
    }
}
?>
<table>
    <tr>
        <td>
            <img src="graphic/big_buildings/<?= $screen . $img_suffix ?>.png"
                title="<?= $cl_builds->get_name($screen) ?>" alt="" />
        </td>
        <td>
            <h2><?= $cl_builds->get_name($screen) ?> (<?php if ($current_level > 0): ?><?= __('screens.common.level') ?>
                    <?= $current_level ?><?php else: ?><?= __('screens.common.not_built') ?><?php endif; ?>)
            </h2>
            <?= $cl_builds->get_description_bydbname($screen) ?>
        </td>
    </tr>
</table>
<br />

<?php if ($current_level > 0): ?>
    <table class="vis modemenu">
        <tbody>
            <tr>
                <?php foreach ($modes as $mname => $amode): ?>
                    <?php if ($mname == $mode): ?>
                        <td class="selected" width="100">
                            <a href="game.php?village=<?= $village['id'] ?>&screen=statue&mode=<?= $mname ?>"><?= $amode ?> </a>
                        </td>
                    <?php else: ?>
                        <td width="100">
                            <a href="game.php?village=<?= $village['id'] ?>&screen=statue&mode=<?= $mname ?>"><?= $amode ?> </a>
                        </td>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table>

    <?php if (!empty($error)): ?>
        <span class="error"><?= $error ?></span>
    <?php endif; ?>

    <?php if ($mode == 'inventory'): ?>
        <div style="width: 840px; float: left;">
            <div style="float: right; width: 210px; padding-right: 5px;">
                <p><?= __('screens.statue.items_work_when_equipped') ?></p>
                <?php if (!$pala_all_items): ?>
                    <?php if ($pala_none_items): ?>
                        <p><?= __('screens.statue.no_items_found') ?></p>
                    <?php else: ?>
                        <p><?= __('screens.statue.items_found') ?></p>
                        <p>
                            <?php foreach ($user_pala_arr as $pala_item): ?>
                                <?= $pala_bonuses[$pala_item][2] ?><br>
                            <?php endforeach; ?>
                        </p>
                    <?php endif; ?>
                <?php else: ?>
                    <p><?= __('screens.statue.all_items_found') ?></p>
                <?php endif; ?>
                <?php if (!empty($user['pala_aktu_item'])): ?>
                    <br>
                    <div style="margin-top: 15px; text-align: center; border: 1px solid #804000; background-color: #f7eed3; padding: 10px; border-radius: 4px; box-shadow: inset 0 0 5px rgba(0,0,0,0.1);">
                        <b><?= __('screens.statue.your_paladin_equipped_with') ?></b><br>
                        <span style="font-weight: bold; color: #804000;"><?= $pala_bonuses[$user['pala_aktu_item']][2] ?></span><br><br>
                        <img src="graphic/inventory/<?= $user['pala_aktu_item'] ?>_rep.png" alt="<?= $pala_bonuses[$user['pala_aktu_item']][2] ?>" style="max-width: 170px; border: 1px solid #7d510f; box-shadow: 0 0 5px rgba(0,0,0,0.2); border-radius: 3px;" />
                    </div>
                <?php endif; ?>
            </div>

            <div style="float: left; position: relative; z-index: 9996; width: 605px; padding-left: 2px;">
                <div style="padding: 0pt; width: 600px; height: 430px; margin-right: 10px; position: relative;">
                    <!-- Background inventory image -->
                    <img src="graphic/inventory/inventory.jpg?1" alt="" title=""
                        style="position: absolute; top: 0; left: 0;" />

                    <!-- Item images positioned absolutely -->
                    <?php foreach ($user_pala_arr as $pala_item): ?>
                        <?php
                        $left = $pala_positions[$pala_item][0] ?? 0;
                        $top = $pala_positions[$pala_item][1] ?? 0;
                        // Remove 'unit_' prefix from filename
                        $image_name = str_replace('unit_', '', $pala_item);
                        ?>
                        <img style="position: absolute; left: <?= $left ?>px; top: <?= $top ?>px; z-index: 10;"
                            src="graphic/inventory/<?= $image_name ?>.png" title="<?= $pala_bonuses[$pala_item][2] ?>" />
                    <?php endforeach; ?>

                    <!-- Transparent image with clickable map areas -->
                    <img src="graphic/map/empty.png?1" alt="" title="" usemap="#inv"
                        style="position: absolute; top: 0; left: 0; width: 600px; height: 430px; z-index: 20;" />
                    <map id="inv" name="inv">
                        <?php foreach ($user_pala_arr as $pala_item): ?>
                            <area shape="poly" coords="<?= $pala_coords[$pala_item] ?>"
                                href="game.php?village=<?= $village['id'] ?>&screen=statue&mode=inventory&action=change_pala_item&item_name=<?= $pala_item ?>"
                                alt="" title="<?= $pala_bonuses[$pala_item][2] ?>" />
                        <?php endforeach; ?>
                    </map>
                </div>

                <br style="clear: both;">

                <?php if (!$pala_all_items): ?>
                    <table style="margin: 0pt; padding: 0pt;">
                        <tbody>
                            <tr>
                                <th colspan="3"><?= __('screens.statue.progress_next_item') ?>:</th>
                            </tr>
                            <tr>
                                <td>0%</td>
                                <td style="border: 1px solid rgb(128, 64, 0); margin: 0pt; padding: 0pt; width: 390px;">
                                    <div style="width: <?= $img_width ?>px; background-color: rgb(128, 64, 0);">&nbsp;</div>
                                </td>
                                <td>100%</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: center;"><?= $proc_to_next_item ?>%</td>
                            </tr>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <br>
        <?php if (count($jed_produkcja) > 0): ?>
            <table class="vis">
                <tr>
                    <th width="150"><?= __('screens.statue.education') ?></th>
                    <th width="120"><?= __('screens.statue.duration') ?></th>
                    <th width="150"><?= __('screens.statue.ready') ?></th>
                    <th width="100"><?= __('screens.statue.finish') ?> *</th>
                </tr>

                <?php foreach ($jed_produkcja as $key => $value): ?>
                    <tr <?php if ($value['lit']): ?>class="lit" <?php endif; ?>>
                        <td><?= $value['num_unit'] ?>                 <?= $cl_units->get_name($value['unit']) ?></td>
                        <?php if ($value['lit']): ?>
                            <?php if ($value['countdown'] > 0): ?>
                                <td><span class="timer"><?= format_time($value['countdown']) ?></span></td>
                            <?php else: ?>
                                <td><?= format_time($value['countdown']) ?></td>
                            <?php endif; ?>
                        <?php else: ?>
                            <td><?= format_time($value['trwanie']) ?></td>
                        <?php endif; ?>
                        <td><?= format_date($value['time_finished']) ?></td>
                        <td><a
                                href="game.php?village=<?= $village['id'] ?>&screen=<?= $dbname ?>&action=cancelar&id=<?= $key ?>&h=<?= $hkey ?>"><?= __('screens.statue.cancel') ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <div style="font-size: 7pt;"><?= __('screens.statue.cancel_refund_note') ?></div>
            <br>
        <?php endif; ?>

        <table class="vis">
            <tbody>
                <tr>
                    <th><?= __('screens.statue.unit') ?></th>
                    <th colspan="4"><?= __('screens.statue.cost') ?></th>
                    <th><?= __('screens.statue.time') ?><br>(hh:mm:ss)</th>
                    <th><?= __('screens.statue.choose_paladin') ?></th>
                </tr>
                <?php foreach ($units as $unit => $name): ?>
                    <tr>
                        <td>
                        <a href="javascript:showUnitModal('<?= $unit ?>')"> <img
                                src="graphic/unit/<?= $unit ?>.png" alt="" /> <?= $name ?></a>
                    </td>
                        <td>
                            <img src="graphic/wood.png" title="Madeira" alt="" />
                            <?= $cl_units->get_woodprice($unit) ?>
                        </td>
                        <td>
                            <img src="graphic/stone.png" title="Argila" alt="" />
                            <?= $cl_units->get_stoneprice($unit) ?>
                        </td>
                        <td>
                            <img src="graphic/iron.png" title="Ferro" alt="" />
                            <?= $cl_units->get_ironprice($unit) ?>
                        </td>
                        <td>
                            <img src="graphic/icons/face.png" title="populacao" alt="" />
                            <?= $cl_units->get_bhprice($unit) ?>
                        </td>

                        <td>
                            <?= format_time($cl_units->get_time_round($village[$screen], $unit, $village['bonus'], $village['userid'], $village['id'])) ?>
                        </td>

                        <td>
                            <?php if ($village['r_wood'] >= $cl_units->get_woodprice($unit) && $village['r_stone'] >= $cl_units->get_stoneprice($unit) && $village['r_iron'] >= $cl_units->get_ironprice($unit)): ?>
                                <?php if ($wolni_osadnicy >= $cl_units->get_bhprice($unit)): ?>
                                    <?php if ($user['paladins'] > 0): ?>
                                        <span class="inactive"><?= __('screens.statue.only_one_paladin') ?></span>
                                    <?php else: ?>
                                        <?php if ($user['pala_train'] > 0): ?>
                                            <span class="inactive"><?= __('screens.statue.paladin_in_training') ?></span>
                                        <?php else: ?>
                                            <a
                                                href="game.php?village=<?= $village['id'] ?>&screen=statue&action=train&unit=<?= $unit ?>&h=<?= $hkey ?>"><?= __('screens.statue.appoint_knight') ?></a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="inactive"><?= __('screens.statue.not_enough_farm_space') ?></span>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="inactive"><?= __('screens.statue.not_enough_resources') ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <?php if ($user['paladins'] == 1): ?>
            <div style="display: flex; gap: 20px; align-items: flex-start; max-width: 800px; margin-top: 15px;">
                <!-- Rename Form -->
                <form action="game.php?village=<?= $village['id'] ?>&screen=statue&mode=main&action=change_pala_name&h=<?= $hkey ?>"
                    method="post" style="flex-grow: 1;">
                    <table class="vis" width="100%">
                        <tr>
                            <th colspan="2"><?= __('screens.statue.rename_your_paladin') ?></th>
                        </tr>
                        <tr>
                            <td>
                                <?= __('screens.statue.name') ?>: <input type="text" value="<?= $pala_name ?>" name="nazwa" />
                            </td>
                            <td>
                                <input type="submit" value="<?= __('screens.statue.rename') ?>" class="btn btn-submit" name="tbutton" />
                            </td>
                        </tr>
                    </table>
                </form>

                <!-- Equipped Weapon Info -->
                <?php if (!empty($user['pala_aktu_item'])): ?>
                    <table class="vis" style="width: 320px; flex-shrink: 0;">
                        <tr>
                            <th><?= __('screens.profile.item_equipped') ?></th>
                        </tr>
                        <tr>
                            <td align="center" style="background-color: #f7eed3; padding: 15px; border: 1px solid #7d510f;">
                                <span style="font-weight: bold; color: #804000; font-size: 11pt;"><?= $pala_bonuses[$user['pala_aktu_item']][2] ?></span><br><br>
                                <img src="graphic/inventory/<?= $user['pala_aktu_item'] ?>_rep.png" 
                                     alt="<?= $pala_bonuses[$user['pala_aktu_item']][2] ?>" 
                                     style="max-width: 280px; border: 1px solid #7d510f; box-shadow: 0 0 5px rgba(0,0,0,0.2); border-radius: 3px;" />
                            </td>
                        </tr>
                    </table>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Unit Info Modal -->
        <div id="unit_info_modal"
            style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.6);">
            <div id="unit_modal_container"
                style="background-color: #f7eed3; border: 2px solid #804000; width: 700px; margin: 100px auto; padding: 10px; position: relative; box-shadow: 0px 0px 15px #000; cursor: move;">
                <div id="unit_modal_header"
                    style="background-color: #c1a264; padding: 5px; border: 1px solid #7d510f; color: #fff; font-weight: bold; margin-bottom: 10px; cursor: move;">
                    <span id="modal_unit_title"><?= __('screens.statue.unit') ?></span>
                    <span onclick="closeUnitModal()"
                        style="float: right; cursor: pointer; color: #5c0d0d; background: #e3d5b3; border: 1px solid #804000; padding: 0 5px;">X</span>
                </div>
                <div id="modal_unit_desc"
                    style="padding: 10px; font-style: italic; border-bottom: 1px solid #804000; margin-bottom: 10px;"></div>
                <div id="modal_unit_content" style="padding: 10px; display: flex; gap: 20px;">
                    <div id="modal_unit_tables" style="flex-grow: 1;">
                        <table class="vis" width="100%">
                            <tr>
                                <th width="100"><?= __('screens.statue.cost') ?></th>
                                <td id="modal_unit_cost"></td>
                            </tr>
                            <tr>
                                <th><?= __('screens.statue.population') ?></th>
                                <td id="modal_unit_pop"></td>
                            </tr>
                            <tr>
                                <th><?= __('screens.statue.speed') ?></th>
                                <td id="modal_unit_speed"></td>
                            </tr>
                            <tr>
                                <th><?= __('screens.statue.carry_capacity') ?></th>
                                <td id="modal_unit_booty"></td>
                            </tr>
                            <tr>
                                <th><?= __('screens.statue.attack') ?></th>
                                <td id="modal_unit_att"></td>
                            </tr>
                            <tr>
                                <th><?= __('screens.statue.defense') ?></th>
                                <td id="modal_unit_def"></td>
                            </tr>
                        </table>
                    </div>
                    <div id="modal_unit_img_container" style="flex-shrink: 0;">
                        <img id="modal_unit_img" src="" alt="" />
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            // Unit definitions for modal
            var unit_info = {
                <?php
                $u_infos = [];
                foreach ($units as $u_db => $u_name) {
                    $u_infos[] = "'$u_db': {
                        name: '" . addslashes($u_name) . "',
                        desc: '" . addslashes($cl_units->get_description($u_db)) . "',
                        wood: " . $cl_units->get_woodprice($u_db) . ",
                        stone: " . $cl_units->get_stoneprice($u_db) . ",
                        iron: " . $cl_units->get_ironprice($u_db) . ",
                        pop: " . $cl_units->get_bhprice($u_db) . ",
                        speed: " . ($cl_units->get_speed($u_db) / 60) . ",
                        booty: " . $cl_units->get_booty($u_db) . ",
                        att: " . $cl_units->get_att($u_db, 1) . ",
                        def: " . $cl_units->get_def($u_db, 1) . ",
                        def_cav: " . $cl_units->get_defcav($u_db, 1) . ",
                        def_arch: " . $cl_units->get_defarcher($u_db, 1) . "
                    }";
                }
                echo implode(",\n", $u_infos);
                ?>
            };

            function showUnitModal(unit) {
                var info = unit_info[unit];
                if (!info) return;

                var imgOverrides = {
                    'unit_cav_archer': 'marcher',
                    'unit_mnich': 'monge'
                };
                var imgBase = imgOverrides[unit] || unit.replace('unit_', '');

                document.getElementById('modal_unit_title').innerHTML = info.name;
                document.getElementById('modal_unit_img').src = 'graphic/unit_big/' + imgBase + '_b.png';
                document.getElementById('modal_unit_desc').innerHTML = info.desc;

                var costStr = '<img src="graphic/icons/wood.png"/> ' + info.wood + ' <img src="graphic/icons/stone.png"/> ' + info.stone + ' <img src="graphic/icons/iron.png"/> ' + info.iron;
                document.getElementById('modal_unit_cost').innerHTML = costStr;
                document.getElementById('modal_unit_pop').innerHTML = '<img src="graphic/icons/face.png"/> ' + info.pop;
                document.getElementById('modal_unit_speed').innerHTML = info.speed + ' <?= __('screens.statue.min_per_field') ?>';
                document.getElementById('modal_unit_booty').innerHTML = info.booty;

                document.getElementById('modal_unit_att').innerHTML = '<img src="graphic/unit/att.png"/> ' + info.att;
                document.getElementById('modal_unit_def').innerHTML =
                    '<img src="graphic/unit/def.png" title="<?= __('screens.statue.general') ?>"/> ' + info.def +
                    ' <img src="graphic/unit/def_cav.png" title="<?= __('screens.statue.cavalry') ?>"/> ' + info.def_cav +
                    ' <img src="graphic/unit/def_archer.png" title="<?= __('screens.statue.archers') ?>"/> ' + info.def_arch;

                document.getElementById('unit_info_modal').style.display = 'block';
            }

            function closeUnitModal() {
                document.getElementById('unit_info_modal').style.display = 'none';
            }

            // Make modal draggable with vanilla JS since jQuery UI might not be loaded
            (function () {
                var modal = document.getElementById('unit_modal_container');
                var header = document.getElementById('unit_modal_header');
                var isDragging = false;
                var currentX;
                var currentY;
                var initialX;
                var initialY;
                var xOffset = 0;
                var yOffset = 0;

                if (header && modal) {
                    header.addEventListener('mousedown', dragStart);
                    document.addEventListener('mousemove', drag);
                    document.addEventListener('mouseup', dragEnd);
                }

                function dragStart(e) {
                    if (e.target === header || header.contains(e.target)) {
                        initialX = e.clientX - xOffset;
                        initialY = e.clientY - yOffset;
                        isDragging = true;
                    }
                }

                function drag(e) {
                    if (isDragging) {
                        e.preventDefault();
                        currentX = e.clientX - initialX;
                        currentY = e.clientY - initialY;
                        xOffset = currentX;
                        yOffset = currentY;
                        setTranslate(currentX, currentY, modal);
                    }
                }

                function dragEnd(e) {
                    initialX = currentX;
                    initialY = currentY;
                    isDragging = false;
                }

                function setTranslate(xPos, yPos, el) {
                    el.style.transform = 'translate(' + xPos + 'px, ' + yPos + 'px)';
                }
            })();
        </script>
    <?php endif; ?>
<?php endif; ?>
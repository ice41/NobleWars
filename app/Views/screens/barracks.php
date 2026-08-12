<?php
/**
 * Barracks/Train Screen View
 * Faithful migration of game_recruit_template.tpl
 */

// Calculate building image stage
$dbname = $screen;
$maxstage = $cl_builds->get_maxstage($dbname);
$aktu_build_prc = ($maxstage > 0) ? $village[$dbname] / $maxstage : 0;
?>

<table>
    <tr>
        <td>
            <?php if ($cl_builds->get_maxstage($dbname) > 3): ?>
                <?php if ($aktu_build_prc > 0.5): ?>
                    <img src="graphic/big_buildings/<?= $dbname ?>3.png" title="<?= $cl_builds->get_name($dbname) ?>" alt="" />
                <?php else: ?>
                    <?php if ($aktu_build_prc > 0.2): ?>
                        <img src="graphic/big_buildings/<?= $dbname ?>2.png" title="<?= $cl_builds->get_name($dbname) ?>" alt="" />
                    <?php else: ?>
                        <img src="graphic/big_buildings/<?= $dbname ?>1.png" title="<?= $cl_builds->get_name($dbname) ?>" alt="" />
                    <?php endif; ?>
                <?php endif; ?>
            <?php else: ?>
                <img src="graphic/big_buildings/<?= $dbname ?>1.png" title="<?= $cl_builds->get_name($dbname) ?>" alt="" />
            <?php endif; ?>
        </td>
        <td>
            <h2><?= $cl_builds->get_name($dbname) ?>
                (<?php if ($village[$dbname] > 0): ?><?= __('screens.recruitment.level') ?>
                    <?= $village[$dbname] ?><?php else: ?>     <?= __('screens.recruitment.not_built') ?><?php endif; ?>)
            </h2>
            <?= $cl_builds->get_description_bydbname($dbname) ?>
        </td>
    </tr>
</table>
<br />



<?php if ($show_build): ?>
    <?php if (count($recruit_units) > 0): ?>
        <div class="current_prod_wrapper">
            <div id="replace_<?= $dbname ?>">
                <?php if ($first_unit['is']): ?>
                    <table class="vis">
                        <tbody>
                            <tr>
                                <th width="250"><?= __('screens.recruitment.training_next_unit') ?>
                                    (<?= $first_unit['unitname'] ?>):</th>
                                <th><span class="timer"><?= format_time($first_unit['time_to_train']) ?></span></th>
                            </tr>
                        </tbody>
                    </table>
                <?php endif; ?>

                <div class="trainqueue_wrap" id="trainqueue_wrap_<?= $dbname ?>">
                    <table class="vis">
                        <tr>
                            <th width="190"><?= __('screens.recruitment.education') ?></th>
                            <th width="120"><?= __('screens.recruitment.duration') ?></th>
                            <th width="150"><?= __('screens.recruitment.ready') ?></th>
                            <th width="100"><?= __('screens.recruitment.cancel') ?> *</th>
                        </tr>

                        <?php foreach ($recruit_units as $key => $value): ?>
                            <tr <?php if ($recruit_units[$key]['lit']): ?>class="lit" <?php endif; ?>>
                                <td><?= $recruit_units[$key]['num_unit'] ?>             <?= $cl_units->get_name($recruit_units[$key]['unit']) ?>
                                </td>
                                <?php if ($recruit_units[$key]['lit'] && $recruit_units[$key]['countdown'] > -1): ?>
                                    <td><span class="timer"><?= format_time($recruit_units[$key]['countdown']) ?></span></td>
                                <?php else: ?>
                                    <td><?= format_time($recruit_units[$key]['countdown']) ?></td>
                                <?php endif; ?>
                                <td><?= format_date($recruit_units[$key]['time_finished']) ?></td>
                                <td><a class="btn btn-cancel"
                                        href="game.php?village=<?= $village['id'] ?>&screen=<?= $dbname ?>&action=cancel&id=<?= $key ?>&h=<?= $hkey ?>"><?= __('screens.recruitment.cancel') ?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <div style="font-size: 7pt;"><?= __('screens.recruitment.cancel_note') ?></div>
                <br>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <font class="error"><?= $error ?></font>
    <?php endif; ?>

    <form action="game.php?village=<?= $village['id'] ?>&screen=<?= $dbname ?>&action=train&h=<?= $hkey ?>" method="post"
        onsubmit="this.submit.disabled=true;">
        <table class="vis">
            <tr>
                <th width="180"><?= __('screens.recruitment.units') ?></th>
                <th colspan="4" width="120"><?= __('screens.recruitment.cost') ?></th>
                <th width="130"><?= __('screens.recruitment.time') ?></th>
                <th><?= __('screens.recruitment.in_village') ?></th>
                <th><?= __('screens.recruitment.recruitment') ?></th>
            </tr>

            <?php foreach ($units as $unit_dbname => $name): ?>
                <tr>
                    <td><a href="javascript:showUnitModal('<?= $unit_dbname ?>')"> <img
                                src="graphic/unit/<?= $unit_dbname ?>.png" alt="" /> <?= $name ?></a></td>
                    <td><img src="graphic/icons/wood.png" title="Madeira" alt="" /> <?= $cl_units->get_woodprice($unit_dbname) ?>
                    </td>
                    <td><img src="graphic/icons/stone.png" title="Argila" alt="" /> <?= $cl_units->get_stoneprice($unit_dbname) ?>
                    </td>
                    <td><img src="graphic/icons/iron.png" title="Ferro" alt="" /> <?= $cl_units->get_ironprice($unit_dbname) ?>
                    </td>
                    <td><img src="graphic/icons/face.png" title="População" alt="" /> <?= $cl_units->get_bhprice($unit_dbname) ?>
                    </td>
                    <td><?= format_time($cl_units->get_time_round($village[$dbname], $unit_dbname, $village['bonus'], $village['userid'], $village['id'])) ?></td>
                    <td><?= format_number($units_in_village[$unit_dbname]) ?>/<?= format_number($units_all[$unit_dbname]) ?>
                    </td>

                    <?php
                    $cl_units->check_needed($unit_dbname, $village);
                    if ($cl_units->last_error == 'not_tec'):
                        ?>
                        <td class="inactive"><?= __('screens.recruitment.unit_not_researched') ?></td>
                    <?php elseif ($cl_units->last_error == 'not_needed'): ?>
                        <td class="inactive"><?= __('screens.recruitment.requirements_not_met') ?></td>
                    <?php elseif ($cl_units->last_error == 'not_enough_ress'): ?>
                        <td class="inactive"><?= __('screens.recruitment.not_enough_resources') ?></td>
                    <?php elseif ($cl_units->last_error == 'not_enough_bh'): ?>
                        <td class="inactive"><?= __('screens.recruitment.not_enough_farm') ?></td>
                    <?php else: ?>
                        <td class="nowrap">
                            <input style="color: black;" name="<?= $unit_dbname ?>" class="recruit_unit" id="<?= $unit_dbname ?>_0"
                                size="5" maxlength="5" tabindex="1" type="text">
                            <a id="<?= $unit_dbname ?>_0_a"
                                href="javascript:unit_build_block.set_max('<?= $unit_dbname ?>')">(<?= $cl_units->last_error ?>)</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>

            <tr>
                <td colspan="8" align="right"><input name="submit" class="btn btn-recruit" type="submit"
                        value="<?= __('screens.recruitment.recruit') ?>" style="font-size: 10pt;" /></td>
            </tr>
        </table>
    </form>

    <!-- Unit Info Modal -->
    <div id="unit_info_modal"
        style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.6);">
        <div id="unit_modal_container"
            style="background-color: #f7eed3; border: 2px solid #804000; width: 700px; margin: 100px auto; padding: 10px; position: relative; box-shadow: 0px 0px 15px #000; cursor: move;">
            <div id="unit_modal_header"
                style="background-color: #c1a264; padding: 5px; border: 1px solid #7d510f; color: #fff; font-weight: bold; margin-bottom: 10px; cursor: move;">
                <span id="modal_unit_title"><?= __('screens.recruitment.unit') ?></span>
                <span onclick="closeUnitModal()"
                    style="float: right; cursor: pointer; color: #5c0d0d; background: #e3d5b3; border: 1px solid #804000; padding: 0 5px;">X</span>
            </div>
            <div id="modal_unit_desc"
                style="padding: 10px; font-style: italic; border-bottom: 1px solid #804000; margin-bottom: 10px;"></div>
            <div id="modal_unit_content" style="padding: 10px; display: flex; gap: 20px;">
                <div id="modal_unit_tables" style="flex-grow: 1;">
                    <table class="vis" width="100%">
                        <tr>
                            <th width="100"><?= __('screens.recruitment.cost') ?></th>
                            <td id="modal_unit_cost"></td>
                        </tr>
                        <tr>
                            <th><?= __('screens.recruitment.population') ?></th>
                            <td id="modal_unit_pop"></td>
                        </tr>
                        <tr>
                            <th><?= __('screens.recruitment.speed') ?></th>
                            <td id="modal_unit_speed"></td>
                        </tr>
                        <tr>
                            <th><?= __('screens.recruitment.carry_capacity') ?></th>
                            <td id="modal_unit_booty"></td>
                        </tr>
                        <tr>
                            <th><?= __('screens.recruitment.attack') ?></th>
                            <td id="modal_unit_att"></td>
                        </tr>
                        <tr>
                            <th><?= __('screens.recruitment.defense') ?></th>
                            <td id="modal_unit_def"></td>
                        </tr>
                    </table>

                    <div id="modal_unit_requirements" style="margin-top: 15px; display: none;">
                        <table class="vis" width="100%">
                            <tr>
                                <th colspan="2"><?= __('screens.recruitment.requirements') ?></th>
                            </tr>
                            <tbody id="modal_unit_req_body">
                            </tbody>
                        </table>
                    </div>
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
                // Get requirements
                $needed = $cl_units->get_needed($u_db);
                $req_str = '[]';
                if (count($needed) > 0) {
                    $req_arr = [];
                    foreach ($needed as $build => $level) {
                        $buildName = $cl_builds->get_name($build);
                        error_log("DEBUG: build=$build, buildName=$buildName, level=$level");
                        $req_arr[] = "{building: '" . addslashes($buildName) . "', level: $level}";
                    }
                    $req_str = '[' . implode(',', $req_arr) . ']';
                }

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
                    def_arch: " . $cl_units->get_defarcher($u_db, 1) . ",
                    requirements: $req_str
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
            document.getElementById('modal_unit_speed').innerHTML = info.speed + ' <?= __('screens.recruitment.min_per_field') ?>';
            document.getElementById('modal_unit_booty').innerHTML = info.booty;

            document.getElementById('modal_unit_att').innerHTML = '<img src="graphic/unit/att.png"/> ' + info.att;
            document.getElementById('modal_unit_def').innerHTML =
                '<img src="graphic/unit/def.png" title="Geral"/> ' + info.def +
                ' <img src="graphic/unit/def_cav.png" title="Cavalaria"/> ' + info.def_cav +
                ' <img src="graphic/unit/def_archer.png" title="Arqueiros"/> ' + info.def_arch;

            // Display requirements
            var reqDiv = document.getElementById('modal_unit_requirements');
            var reqBody = document.getElementById('modal_unit_req_body');
            if (info.requirements && info.requirements.length > 0) {
                reqBody.innerHTML = '';
                info.requirements.forEach(function (req) {
                    var row = '<tr><td><b>' + req.building + '</b></td><td><?= __('screens.common.level') ?> ' + req.level + '</td></tr>';
                    reqBody.innerHTML += row;
                });
                reqDiv.style.display = 'block';
            } else {
                reqDiv.style.display = 'none';
            }

            document.getElementById('unit_info_modal').style.display = 'block';
        }

        function closeUnitModal() {
            document.getElementById('unit_info_modal').style.display = 'none';
        }

        $(document).ready(function () {
            TrainOverview.init();
            TrainOverview.train_link = "";
            TrainOverview.cancel_link = "";
            TrainOverview.pop_max = <?= $village['r_bh'] ?>;
        });
    </script>

    <!-- Make modal draggable with vanilla JS since jQuery UI might not be loaded -->
    <script type="text/javascript">
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

        unit_managers = {};
        unit_managers.units = {
            <?php $i = 0; ?>
                                                                                            <?php foreach ($units as $unit_dbname => $name): ?>
                                                                                                                                                                                <?php $i++; ?>
                                                                                                                                                                                <?= $unit_dbname ?>: { wood: <?= $cl_units->get_woodprice($unit_dbname) ?>, stone: <?= $cl_units->get_stoneprice($unit_dbname) ?>, iron: <?= $cl_units->get_ironprice($unit_dbname) ?>, pop: <?= $cl_units->get_bhprice($unit_dbname) ?> }<?php if ($i != count($units)): ?>, <?php endif; ?>
                                                                                            <?php endforeach; ?>
        };

        var unit_build_block = new UnitBuildManager(0, {
            res: { wood: <?= $village['r_wood'] ?>, stone: <?= $village['r_stone'] ?>, iron: <?= $village['r_iron'] ?>, pop: <?= $max_bh - $village['r_bh'] ?> }
        });
        unit_build_block._onchange();
    </script>
<?php endif; ?>
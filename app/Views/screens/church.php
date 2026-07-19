<?php
// Calculate building image stage
$dbname = $screen;
$current_level = $village[$dbname] ?? 0;
$maxstage = $cl_builds->get_maxstage($dbname);
$aktu_build_prc = ($maxstage > 0) ? $current_level / $maxstage : 0;

// Determine image suffix
$img_suffix = '1';
if ($maxstage > 3) {
    if ($aktu_build_prc > 0.5) {
        $img_suffix = '3';
    } elseif ($aktu_build_prc > 0.2) {
        $img_suffix = '2';
    }
} else {
    // For buildings with maxstage <= 3, use the actual level
    if ($current_level >= 3) {
        $img_suffix = '3';
    } elseif ($current_level >= 2) {
        $img_suffix = '2';
    }
}
?>

<table>
    <tr>
        <td>
            <img src="graphic/big_buildings/<?= $dbname . $img_suffix ?>.png"
                title="<?= $cl_builds->get_name($dbname) ?>" alt="" />
        </td>
        <td>
            <h2><?= $cl_builds->get_name($dbname) ?>
                (<?php if ($current_level > 0): ?><?= __('screens.recruitment.level') ?>
                    <?= $current_level ?><?php else: ?>     <?= __('screens.recruitment.not_built') ?><?php endif; ?>)
            </h2>
            <?= $cl_builds->get_description_bydbname($dbname) ?>
        </td>
    </tr>
</table>
<br />

<?php if ($current_level > 0): ?>
    <br>
    <?php if (count($jed_produkcja) > 0): ?>
        <table class="vis">
            <tr>
                <th width="150"><?= __('screens.recruitment.education') ?></th>
                <th width="120"><?= __('screens.recruitment.duration') ?></th>
                <th width="150"><?= __('screens.recruitment.ready') ?></th>
                <th width="100"><?= __('screens.recruitment.cancel') ?> *</th>
            </tr>

            <?php foreach ($jed_produkcja as $key => $value): ?>
                <tr <?php if ($value['lit']): ?>class="lit" <?php endif; ?>>
                    <td><?= $value['num_unit'] ?>             <?= $cl_units->get_name($value['unit']) ?></td>
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
                            href="game.php?village=<?= $village['id'] ?>&screen=<?= $dbname ?>&action=cancel&id=<?= $key ?>&h=<?= $hkey ?>">Cancelar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div style="font-size: 7pt;"><?= __('screens.recruitment.cancel_note') ?></div>
        <br>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <span class="error"><?= $error ?></span>
    <?php endif; ?>

    <form action="game.php?village=<?= $village['id'] ?>&screen=church&action=train&h=<?= $hkey ?>" method="post"
        onsubmit="this.submit.disabled=true;">
        <table class="vis">
            <tbody>
                <tr>
                    <th><?= __('screens.recruitment.unit') ?></th>
                    <th colspan="4"><?= __('screens.recruitment.cost') ?></th>
                    <th><?= __('screens.recruitment.time') ?></th>
                    <th><?= __('screens.recruitment.in_village') ?></th>
                    <th><?= __('screens.recruitment.recruitment') ?></th>
                </tr>
                <?php
                ?>
                <?php foreach ($units as $unit => $name): ?>
                    <tr>
                        <td>
                            <a href="javascript:showUnitModal('<?= $unit ?>')"> <img src="graphic/unit/<?= $unit ?>.png"
                                    alt="" /> <?= $name ?></a>
                        </td>
                        <td>
                            <img src="graphic/icons/wood.png" title="Madeira" alt="" />
                            <?= $cl_units->get_woodprice($unit) ?>
                        </td>
                        <td>
                            <img src="graphic/icons/stone.png" title="Argila" alt="" />
                            <?= $cl_units->get_stoneprice($unit) ?>
                        </td>
                        <td>
                            <img src="graphic/icons/iron.png" title="Ferro" alt="" />
                            <?= $cl_units->get_ironprice($unit) ?>
                        </td>
                        <td>
                            <img src="graphic/icons/face.png" title="População" alt="" />
                            <?= $cl_units->get_bhprice($unit) ?>
                        </td>

                        <td>
                            <?= format_time($cl_units->get_time_round($village[$screen], $unit, $village['bonus'])) ?>
                        </td>

                        <td><?= format_number($village['all_' . $unit] ?? 0) ?></td>

                        <td>
                            <?php if ($village['r_wood'] >= $cl_units->get_woodprice($unit) && $village['r_stone'] >= $cl_units->get_stoneprice($unit) && $village['r_iron'] >= $cl_units->get_ironprice($unit)): ?>
<<<<<<< Updated upstream
                                <?php if ($wolni_osadnicy >= $cl_units->get_bhprice($unit)): ?>
                                    <input style="color: black;" name="<?= $unit ?>" size="5" maxlength="5" type="text">
=======
                                <?php if ($free_population >= $cl_units->get_bhprice($unit)): ?>
                                    <input class="text-black" name="<?= $unit ?>" size="5" maxlength="5" type="text">
>>>>>>> Stashed changes
                                <?php else: ?>
                                    <span class="inactive"><?= __('screens.recruitment.not_enough_farm') ?></span>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="inactive"><?= __('screens.recruitment.not_enough_resources') ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <tr>
                    <td colspan="8" align="right"><input name="submit" class="btn btn-recruit" type="submit"
                            value="<?= __('screens.recruitment.recruit') ?>" style="font-size: 10pt;" /></td>
                </tr>
            </tbody>
        </table>
    </form>

    <!-- Unit Info Modal -->
    <div id="unit_info_modal"
        style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.6);">
        <div
            style="background-color: #f7eed3; border: 2px solid #804000; width: 500px; margin: 100px auto; padding: 10px; position: relative; box-shadow: 0px 0px 15px #000;">
            <div
                style="background-color: #c1a264; padding: 5px; border: 1px solid #7d510f; color: #fff; font-weight: bold; margin-bottom: 10px;">
                <span id="modal_unit_title"><?= __('screens.recruitment.unit') ?></span>
                <span onclick="closeUnitModal()"
                    style="float: right; cursor: pointer; color: #5c0d0d; background: #e3d5b3; border: 1px solid #804000; padding: 0 5px;">X</span>
            </div>
            <div id="modal_unit_content" style="padding: 10px;">
                <div id="modal_unit_desc" style="margin-bottom: 15px; font-style: italic;"></div>
                <hr style="border: 0; border-top: 1px solid #804000; margin-bottom: 15px;" />
                
                <div style="display: flex; gap: 15px;">
                    <!-- Left: Stats & Requirements -->
                    <div style="flex: 1;">
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
                    
                    <!-- Right: Big Image -->
                    <div style="width: 160px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                        <img id="modal_unit_img" src="" alt="" style="max-width: 100%; max-height: 250px; object-fit: contain;" />
                    </div>
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
                        $req_arr[] = "{building: '" . addslashes($cl_builds->get_name($build)) . "', level: $level}";
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

            // Special image filename overrides (unit_db_key => filename without extension)
            var imgOverrides = {
                'unit_mnich': 'monge_b3'
            };
            var imgBase = imgOverrides[unit] || (unit.replace('unit_', '') + '_b');
            document.getElementById('modal_unit_title').innerHTML = info.name;
            document.getElementById('modal_unit_img').src = 'graphic/unit_big/' + imgBase + '.png';
            document.getElementById('modal_unit_desc').innerHTML = info.desc;

            var costStr = '<img src="graphic/icons/wood.png"/> ' + info.wood + ' <img src="graphic/icons/stone.png"/> ' + info.stone + ' <img src="graphic/icons/iron.png"/> ' + info.iron;
            document.getElementById('modal_unit_cost').innerHTML = costStr;
            document.getElementById('modal_unit_pop').innerHTML = '<img src="graphic/icons/face.png"/> ' + info.pop;
            document.getElementById('modal_unit_speed').innerHTML = info.speed + ' min/campo';
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
    </script>
<?php else: ?>
    <div class="error_box">
        A igreja ainda não foi construída nesta aldeia.
    </div>
<?php endif; ?>
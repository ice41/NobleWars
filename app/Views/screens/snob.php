<<<<<<< Updated upstream
<?php
/**
 * Snob/Academy Screen View - Replicated
 */

$dbname = 'snob';
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
    <?php if ($ag_style == 1): ?>
        <table class="vis">
            <tr>
                <?php foreach ($links as $f_name => $f_mode): ?>
                    <?php if ($f_mode == $mode): ?>
                        <td class="selected" width="120">
                            <a href="game.php?village=<?= $village['id'] ?>&screen=snob&mode=<?= $f_mode ?>"><?= $f_name ?></a>
                        </td>
                    <?php else: ?>
                        <td width="120">
                            <a href="game.php?village=<?= $village['id'] ?>&screen=snob&mode=<?= $f_mode ?>"><?= $f_name ?></a>
                        </td>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        </table>
        <br>
    <?php endif; ?>

    <?php if ($mode == 'poj_monety'): ?>
        <?php if (count($recruit_units) > 0): ?>
            <!-- Recruitment Queue logic here -->
            <div class="current_prod_wrapper">
                <div class="trainqueue_wrap" id="trainqueue_wrap_snob">
                    <table class="vis">
                        <tr>
                            <th width="150"><?= __('screens.recruitment.education') ?></th>
                            <th width="120"><?= __('screens.recruitment.duration') ?></th>
                            <th width="150"><?= __('screens.recruitment.ready') ?></th>
                            <th width="100"><?= __('screens.recruitment.cancel') ?> *</th>
                        </tr>
                        <?php foreach ($recruit_units as $key => $value): ?>
                            <tr>
                                <td><?= $value['num_unit'] ?>                 <?= $cl_units->get_name($value['unit']) ?></td>
                                <td><span class="timer"><?= format_time($value['countdown']) ?></span></td>
                                <td><?= format_date($value['time_finished']) ?></td>
                                <td><a
                                        href="game.php?village=<?= $village['id'] ?>&screen=<?= $dbname ?>&action=cancel&id=<?= $key ?>&h=<?= $hkey ?>"><?= __('screens.recruitment.cancel') ?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <div style="font-size: 7pt;"><?= __('screens.recruitment.cancel_note') ?></div>
                <br>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <font class="error"><?= $error ?></font><br>
        <?php endif; ?>

        <form action="game.php?village=<?= $village['id'] ?>&screen=<?= $dbname ?>&action=train&h=<?= $hkey ?>" method="post"
            onsubmit="this.submit.disabled=true;">
            <table class="vis">
                <tr>
                    <th width="150"><?= __('screens.recruitment.unit') ?></th>
                    <th colspan="4" width="120"><?= __('screens.recruitment.cost') ?></th>
                    <th width="130"><?= __('screens.recruitment.time') ?></th>
                    <th><?= __('screens.recruitment.in_village') ?></th>
                    <th><?= __('screens.recruitment.recruit') ?></th>
                </tr>
                <?php foreach ($units as $unit_dbname => $name): ?>
                        <td><a href="javascript:showUnitModal('<?= $unit_dbname ?>')" style="color:#5c3317;"> <img src="graphic/unit/<?= $unit_dbname ?>.png" alt="" />
                                <?= $name ?></a></td>
                        <td><img src="graphic/icons/wood.png" title="<?= __('screens.recruitment.wood') ?>" alt="" />
                            <?= number_format($cl_units->get_woodprice($unit_dbname)) ?></td>
                        <td><img src="graphic/icons/stone.png" title="<?= __('screens.recruitment.stone') ?>" alt="" />
                            <?= number_format($cl_units->get_stoneprice($unit_dbname)) ?></td>
                        <td><img src="graphic/icons/iron.png" title="<?= __('screens.recruitment.iron') ?>" alt="" />
                            <?= number_format($cl_units->get_ironprice($unit_dbname)) ?></td>
                        <td><img src="graphic/icons/face.png" title="<?= __('screens.recruitment.pop') ?>" alt="" />
                            <?= number_format($cl_units->get_bhprice($unit_dbname)) ?></td>
                        <td><?= format_time($cl_units->get_time_round($village[$dbname], $unit_dbname, $village['bonus'], $village['userid'], $village['id'])) ?></td>
                        <td><?= $units_in_village[$unit_dbname] ?>/<?= $units_all[$unit_dbname] ?></td>

                        <?php if ($snobs_canpr > 0): ?>
                            <td>
                                <input id="<?= $unit_dbname ?>" name="atren_<?= $unit_dbname ?>" type="text" style="width:50px;" />
                                <a href="#"
                                    onclick="$('#<?= $unit_dbname ?>').val(<?= $units_can_prod[$unit_dbname] ?? 0 ?>); return false;"
                                    style="font-weight:bold; color: #804000;">(max. <?= $units_can_prod[$unit_dbname] ?? 0 ?>)</a>
                            </td>
                        <?php else: ?>
                            <td class="inactive"><?= __('screens.snob.nobles_limit_reached') ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="8" align="right">
                        <input class="btn" name="submit" type="submit" value="<?= __('screens.recruitment.recruit') ?>"
                            style="font-size: 10pt;" />
                    </td>
                </tr>
            </table>
        </form>
        <br />

        <?php if ($ag_style == 1): ?>
            <table class="vis">
                <tr>
                    <td><?= __('screens.snob.noble_limit') ?>:</td>
                    <td><?= number_format($snobs_stage) ?></td>
                </tr>
                <tr>
                    <td><?= __('screens.snob.nobles_available') ?>:</td>
                    <td><?= number_format($snobs_dostepne) ?></td>
                </tr>
                <tr>
                    <td><?= __('screens.snob.nobles_in_production') ?>:</td>
                    <td><?= number_format($snobs_produkcja) ?></td>
                </tr>
                <tr>
                    <td><?= __('screens.snob.conquered_villages') ?>:</td>
                    <td><?= number_format($snobs_in_vgs) ?></td>
                </tr>
                <tr>
                    <th><?= __('screens.snob.can_produce') ?>:</th>
                    <th><?= number_format($snobs_canpr) ?></th>
                </tr>
            </table>
            <br>

            <table>
                <tbody>
                    <tr>
                        <td><img alt="Moeda" src="graphic/icons/gold_big.png" /></td>
                        <td>
                            <h4><?= __('screens.snob.gold_coins') ?></h4>
                            <p><?= __('screens.snob.gold_coins_desc') ?></p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="vis">
                <tbody>
                    <tr>
                        <td><?= __('screens.snob.minted_coins') ?>:</td>
                        <td><?= number_format($all_coins) ?></td>
                    </tr>
                    <tr>
                        <td><?= __('screens.snob.coins_needed_next') ?>:</td>
                        <td><?= number_format($coins_next) ?></td>
                    </tr>
                    <tr>
                        <td><?= __('screens.snob.coins_accumulated') ?>:</td>
                        <td><?= number_format($coins_zgr) ?></td>
                    </tr>
                    <tr>
                        <td><?= __('screens.snob.noble_limit') ?>:</td>
                        <td><?= number_format($snobs_stage) ?></td>
                    </tr>
                </tbody>
            </table>
            <br>

            <table class="vis">
                <tbody>
                    <tr>
                        <th><?= __('screens.snob.cost_per_coin') ?></th>
                        <th><?= __('screens.snob.produce_coin') ?></th>
                    </tr>
                    <tr>
                        <td>
                            <img alt="" title="<?= __('screens.recruitment.wood') ?>" src="graphic/icons/wood.png" /> <?= number_format($custo_moedas['wood']) ?>
                            <img alt="" title="<?= __('screens.recruitment.stone') ?>" src="graphic/icons/stone.png" /> <?= number_format($custo_moedas['stone']) ?>
                            <img alt="" title="<?= __('screens.recruitment.iron') ?>" src="graphic/icons/iron.png" /> <?= number_format($custo_moedas['iron']) ?>
                        </td>
                        <td class="inactive">
                            <?php if ($twoz_monete && isset($_GET['action']) != 'wybij_monete'): ?>
                                <a href="game.php?village=<?= $village['id'] ?>&screen=snob&action=wybij_monete&mode=poj_monety"><span
                                        class="btn btn-target-action"><img alt="Moeda" src="graphic/icons/gold.png"
                                            style="position: relative;top: 3px;"> <?= __('screens.snob.mint') ?></span></a>
                            <?php else: ?>
                                <span><?= __('screens.snob.resources_available_in') ?> <span
                                        class="timer"><?= format_time($czekanie) ?></span></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>

    <?php endif; ?>

    <?php if ($mode == 'mass_monety'): ?>
        <h3><?= __('screens.snob.mint_gold_coins') ?></h3>
        <p><?= __('screens.snob.mint_coins_desc') ?></p>

        <?php if (!empty($minted_count)): ?>
            <h3 style="color:green;"><?= $minted_count ?>             <?= __('screens.snob.coins_minted_success') ?></h3>
        <?php endif; ?>

        <form action="game.php?village=<?= $village['id'] ?>&screen=snob&mode=mass_monety&action=mint_all" method="post">
            <table class="vis" width="100%">
                <tr>
                    <th><?= __('screens.snob.village') ?></th>
                    <th><img src="graphic/icons/wood.png" title="<?= __('screens.recruitment.wood') ?>" /></th>
                    <th><img src="graphic/icons/stone.png" title="<?= __('screens.recruitment.clay') ?>" /></th>
                    <th><img src="graphic/icons/iron.png" title="<?= __('screens.recruitment.iron') ?>" /></th>
                    <th><?= __('screens.snob.current_storage') ?></th>
                    <th><?= __('screens.snob.possible_coins') ?></th>
                    <th><?= __('screens.snob.mint') ?></th>
                </tr>
                <?php $total_max = 0; ?>
                <?php foreach ($villages_list as $v): ?>
                    <?php
                    $max_storage = $v['max_storage'] ?? 400000;
                    $total_max += $v['max_coins'];
                    $row_class = $v['id'] == $village['id'] ? 'selected' : '';
                    ?>
                    <tr class="<?= $row_class ?>">
                        <td>
                            <a href="game.php?village=<?= $v['id'] ?>&screen=snob"><?= $v['name'] ?> (<?= $v['x'] ?>|<?= $v['y'] ?>)
                                K<?= floor($v['y'] / 100) * 10 + floor($v['x'] / 100) ?></a>
                        </td>
                        <td><span id="wood_<?= $v['id'] ?>" data-vid="<?= $v['id'] ?>" data-max="<?= $v['max_storage'] ?>"
                                data-prod="<?= $v['wood_prod'] ?>"
                                class="res-counter"><?= number_format(floor($v['r_wood'])) ?></span>
                        </td>
                        <td><span id="stone_<?= $v['id'] ?>" data-max="<?= $v['max_storage'] ?>" data-prod="<?= $v['stone_prod'] ?>"
                                class="res-counter"><?= number_format(floor($v['r_stone'])) ?></span></td>
                        <td><span id="iron_<?= $v['id'] ?>" data-max="<?= $v['max_storage'] ?>" data-prod="<?= $v['iron_prod'] ?>"
                                class="res-counter"><?= number_format(floor($v['r_iron'])) ?></span></td>
                        <td><?= number_format($max_storage) ?></td>
                        <td><span id="coins_<?= $v['id'] ?>"><?= $v['max_coins'] ?></span></td>
                        <td>
                            <select name="coin_mint_<?= $v['id'] ?>">
                                <option value="0">0</option>
                                <?php for ($i = 1; $i <= $v['max_coins'] && $i <= 50; $i++): ?>
                                    <option value="<?= $i ?>" <?= ($i == $v['max_coins'] ? 'selected' : '') ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <tr>
                    <td colspan="5" align="right"><b><?= __('screens.snob.total_possible') ?>:</b></td>
                    <td><b><?= $total_max ?></b></td>
                    <td><input type="submit" value="<?= __('screens.snob.mint_coins') ?>" class="btn" /></td>
                </tr>
            </table>
        </form>
    <?php endif; ?>

<?php endif; ?>

<!-- Unit Info Modal (Snob/Academy) -->
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
                <!-- Left: Stats -->
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
    var unit_info_snob = {
        <?php
        $u_infos = [];
        foreach ($units as $u_db => $u_name) {
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

    // Image overrides: unit_db_key => filename (without .png)
    var snobImgOverrides = {
        'unit_snob': 'snob_b'
    };

    function showUnitModal(unit) {
        var info = unit_info_snob[unit];
        if (!info) return;

        var imgBase = snobImgOverrides[unit] || (unit.replace('unit_', '') + '_b');
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

        document.getElementById('unit_info_modal').style.display = 'block';
    }

    function closeUnitModal() {
        document.getElementById('unit_info_modal').style.display = 'none';
    }
=======
<?php
/**
 * Snob/Academy Screen View - Replicated
 */

$dbname = 'snob';
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
    <?php if ($noble_style == 1): ?>
        <table class="vis">
            <tr>
                <?php foreach ($links as $f_name => $f_mode): ?>
                    <?php if ($f_mode == $mode): ?>
                        <td class="selected" width="120">
                            <a href="game.php?village=<?= $village['id'] ?>&screen=snob&mode=<?= $f_mode ?>"><?= $f_name ?></a>
                        </td>
                    <?php else: ?>
                        <td width="120">
                            <a href="game.php?village=<?= $village['id'] ?>&screen=snob&mode=<?= $f_mode ?>"><?= $f_name ?></a>
                        </td>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        </table>
        <br>
    <?php endif; ?>

    <?php if ($mode == 'poj_monety'): ?>
        <?php if (count($recruit_units) > 0): ?>
            <!-- Recruitment Queue logic here -->
            <div class="current_prod_wrapper">
                <div class="trainqueue_wrap" id="trainqueue_wrap_snob">
                    <table class="vis">
                        <tr>
                            <th width="150"><?= __('screens.recruitment.education') ?></th>
                            <th width="120"><?= __('screens.recruitment.duration') ?></th>
                            <th width="150"><?= __('screens.recruitment.ready') ?></th>
                            <th width="100"><?= __('screens.recruitment.cancel') ?> *</th>
                        </tr>
                        <?php foreach ($recruit_units as $key => $value): ?>
                            <tr>
                                <td><?= $value['num_unit'] ?>                 <?= $cl_units->get_name($value['unit']) ?></td>
                                <td><span class="timer"><?= format_time($value['countdown']) ?></span></td>
                                <td><?= format_date($value['time_finished']) ?></td>
                                <td><a
                                        href="game.php?village=<?= $village['id'] ?>&screen=<?= $dbname ?>&action=cancel&id=<?= $key ?>&h=<?= $hkey ?>"><?= __('screens.recruitment.cancel') ?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <div  style="font-size: 7pt;"><?= __('screens.recruitment.cancel_note') ?></div>
                <br>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <font class="error"><?= $error ?></font><br>
        <?php endif; ?>

        <form action="game.php?village=<?= $village['id'] ?>&screen=<?= $dbname ?>&action=train&h=<?= $hkey ?>" method="post"
            onsubmit="this.submit.disabled=true;">
            <table class="vis">
                <tr>
                    <th width="150"><?= __('screens.recruitment.unit') ?></th>
                    <th colspan="4" width="120"><?= __('screens.recruitment.cost') ?></th>
                    <th width="130"><?= __('screens.recruitment.time') ?></th>
                    <th><?= __('screens.recruitment.in_village') ?></th>
                    <th><?= __('screens.recruitment.recruit') ?></th>
                </tr>
                <?php foreach ($units as $unit_dbname => $name): ?>
                        <td><a href="javascript:showUnitModal('<?= $unit_dbname ?>')" style="color:#5c3317;"> <img src="graphic/unit/<?= $unit_dbname ?>.png" alt="" />
                                <?= $name ?></a></td>
                        <td><img src="graphic/icons/wood.png" title="<?= __('screens.recruitment.wood') ?>" alt="" />
                            <?= number_format($cl_units->get_woodprice($unit_dbname)) ?></td>
                        <td><img src="graphic/icons/stone.png" title="<?= __('screens.recruitment.stone') ?>" alt="" />
                            <?= number_format($cl_units->get_stoneprice($unit_dbname)) ?></td>
                        <td><img src="graphic/icons/iron.png" title="<?= __('screens.recruitment.iron') ?>" alt="" />
                            <?= number_format($cl_units->get_ironprice($unit_dbname)) ?></td>
                        <td><img src="graphic/icons/face.png" title="<?= __('screens.recruitment.pop') ?>" alt="" />
                            <?= number_format($cl_units->get_bhprice($unit_dbname)) ?></td>
                        <td><?= format_time($cl_units->get_time_round($village[$dbname], $unit_dbname, $village['bonus'], $village['userid'], $village['id'])) ?></td>
                        <td><?= $units_in_village[$unit_dbname] ?>/<?= $units_all[$unit_dbname] ?></td>

                        <?php if ($snobs_canpr > 0): ?>
                            <td>
                                <input id="<?= $unit_dbname ?>" name="atren_<?= $unit_dbname ?>" type="text" style="width:50px;" />
                                <a href="#"
                                    onclick="$('#<?= $unit_dbname ?>').val(<?= $units_can_prod[$unit_dbname] ?? 0 ?>); return false;"
                                    style="font-weight:bold; color: #804000;">(max. <?= $units_can_prod[$unit_dbname] ?? 0 ?>)</a>
                            </td>
                        <?php else: ?>
                            <td class="inactive"><?= __('screens.snob.nobles_limit_reached') ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="8" align="right">
                        <input class="btn" name="submit" type="submit" value="<?= __('screens.recruitment.recruit') ?>"
                            style="font-size: 10pt;" />
                    </td>
                </tr>
            </table>
        </form>
        <br />

        <?php if ($noble_style == 1): ?>
            <table class="vis">
                <tr>
                    <td><?= __('screens.snob.noble_limit') ?>:</td>
                    <td><?= number_format($snobs_stage) ?></td>
                </tr>
                <tr>
                    <td><?= __('screens.snob.nobles_available') ?>:</td>
                    <td><?= number_format($snobs_dostepne) ?></td>
                </tr>
                <tr>
                    <td><?= __('screens.snob.nobles_in_production') ?>:</td>
                    <td><?= number_format($snobs_produkcja) ?></td>
                </tr>
                <tr>
                    <td><?= __('screens.snob.conquered_villages') ?>:</td>
                    <td><?= number_format($snobs_in_vgs) ?></td>
                </tr>
                <tr>
                    <th><?= __('screens.snob.can_produce') ?>:</th>
                    <th><?= number_format($snobs_canpr) ?></th>
                </tr>
            </table>
            <br>

            <table>
                <tbody>
                    <tr>
                        <td><img alt="Moeda" src="graphic/icons/gold_big.png" /></td>
                        <td>
                            <h4><?= __('screens.snob.gold_coins') ?></h4>
                            <p><?= __('screens.snob.gold_coins_desc') ?></p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="vis">
                <tbody>
                    <tr>
                        <td><?= __('screens.snob.minted_coins') ?>:</td>
                        <td><?= number_format($all_coins) ?></td>
                    </tr>
                    <tr>
                        <td><?= __('screens.snob.coins_needed_next') ?>:</td>
                        <td><?= number_format($coins_next) ?></td>
                    </tr>
                    <tr>
                        <td><?= __('screens.snob.coins_accumulated') ?>:</td>
                        <td><?= number_format($coins_zgr) ?></td>
                    </tr>
                    <tr>
                        <td><?= __('screens.snob.noble_limit') ?>:</td>
                        <td><?= number_format($snobs_stage) ?></td>
                    </tr>
                </tbody>
            </table>
            <br>

            <table class="vis">
                <tbody>
                    <tr>
                        <th><?= __('screens.snob.cost_per_coin') ?></th>
                        <th><?= __('screens.snob.produce_coin') ?></th>
                    </tr>
                    <tr>
                        <td>
                            <img alt="" title="<?= __('screens.recruitment.wood') ?>" src="graphic/icons/wood.png" /> <?= number_format($coin_cost['wood']) ?>
                            <img alt="" title="<?= __('screens.recruitment.stone') ?>" src="graphic/icons/stone.png" /> <?= number_format($coin_cost['stone']) ?>
                            <img alt="" title="<?= __('screens.recruitment.iron') ?>" src="graphic/icons/iron.png" /> <?= number_format($coin_cost['iron']) ?>
                        </td>
                        <td class="inactive">
                            <?php if ($twoz_monete && isset($_GET['action']) != 'wybij_monete'): ?>
                                <a href="game.php?village=<?= $village['id'] ?>&screen=snob&action=wybij_monete&mode=poj_monety"><span
                                        class="btn btn-target-action"><img alt="Moeda" src="graphic/icons/gold.png"
                                             style="position: relative; top: 3px;"> <?= __('screens.snob.mint') ?></span></a>
                            <?php else: ?>
                                <span><?= __('screens.snob.resources_available_in') ?> <span
                                        class="timer"><?= format_time($czekanie) ?></span></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>

    <?php endif; ?>

    <?php if ($mode == 'mass_monety'): ?>
        <h3><?= __('screens.snob.mint_gold_coins') ?></h3>
        <p><?= __('screens.snob.mint_coins_desc') ?></p>

        <?php if (!empty($minted_count)): ?>
            <h3  class="text-green"><?= $minted_count ?>             <?= __('screens.snob.coins_minted_success') ?></h3>
        <?php endif; ?>

        <form action="game.php?village=<?= $village['id'] ?>&screen=snob&mode=mass_monety&action=mint_all" method="post">
            <table class="vis" width="100%">
                <tr>
                    <th><?= __('screens.snob.village') ?></th>
                    <th><img src="graphic/icons/wood.png" title="<?= __('screens.recruitment.wood') ?>" /></th>
                    <th><img src="graphic/icons/stone.png" title="<?= __('screens.recruitment.clay') ?>" /></th>
                    <th><img src="graphic/icons/iron.png" title="<?= __('screens.recruitment.iron') ?>" /></th>
                    <th><?= __('screens.snob.current_storage') ?></th>
                    <th><?= __('screens.snob.possible_coins') ?></th>
                    <th><?= __('screens.snob.mint') ?></th>
                </tr>
                <?php $total_max = 0; ?>
                <?php foreach ($villages_list as $v): ?>
                    <?php
                    $max_storage = $v['max_storage'] ?? 400000;
                    $total_max += $v['max_coins'];
                    $row_class = $v['id'] == $village['id'] ? 'selected' : '';
                    ?>
                    <tr class="<?= $row_class ?>">
                        <td>
                            <a href="game.php?village=<?= $v['id'] ?>&screen=snob"><?= $v['name'] ?> (<?= $v['x'] ?>|<?= $v['y'] ?>)
                                K<?= floor($v['y'] / 100) * 10 + floor($v['x'] / 100) ?></a>
                        </td>
                        <td><span id="wood_<?= $v['id'] ?>" data-vid="<?= $v['id'] ?>" data-max="<?= $v['max_storage'] ?>"
                                data-prod="<?= $v['wood_prod'] ?>"
                                class="res-counter"><?= number_format(floor($v['r_wood'])) ?></span>
                        </td>
                        <td><span id="stone_<?= $v['id'] ?>" data-max="<?= $v['max_storage'] ?>" data-prod="<?= $v['stone_prod'] ?>"
                                class="res-counter"><?= number_format(floor($v['r_stone'])) ?></span></td>
                        <td><span id="iron_<?= $v['id'] ?>" data-max="<?= $v['max_storage'] ?>" data-prod="<?= $v['iron_prod'] ?>"
                                class="res-counter"><?= number_format(floor($v['r_iron'])) ?></span></td>
                        <td><?= number_format($max_storage) ?></td>
                        <td><span id="coins_<?= $v['id'] ?>"><?= $v['max_coins'] ?></span></td>
                        <td>
                            <select name="coin_mint_<?= $v['id'] ?>">
                                <option value="0">0</option>
                                <?php for ($i = 1; $i <= $v['max_coins'] && $i <= 50; $i++): ?>
                                    <option value="<?= $i ?>" <?= ($i == $v['max_coins'] ? 'selected' : '') ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <tr>
                    <td colspan="5" align="right"><b><?= __('screens.snob.total_possible') ?>:</b></td>
                    <td><b><?= $total_max ?></b></td>
                    <td><input type="submit" value="<?= __('screens.snob.mint_coins') ?>" class="btn" /></td>
                </tr>
            </table>
        </form>
    <?php endif; ?>

<?php endif; ?>

<!-- Unit Info Modal (Snob/Academy) -->
<div id="unit_info_modal"
     class="w-100" style="display:none; position:fixed; z-index:9999; left:0; top:0; height:100%; background-color:rgba(0,0,0,0.6);">
    <div
         class="p-10" style="background-color: #f7eed3; border: 2px solid #804000; width: 500px; margin: 100px auto; position: relative; box-shadow: 0px 0px 15px #000;">
        <div
             class="p-5 bold mb-10" style="background-color: #c1a264; border: 1px solid #7d510f; color: #fff;">
            <span id="modal_unit_title"><?= __('screens.recruitment.unit') ?></span>
            <span onclick="closeUnitModal()"
                 class="float-right pointer" style="color: #5c0d0d; background: #e3d5b3; border: 1px solid #804000; padding: 0 5px;">X</span>
        </div>
        <div id="modal_unit_content"  class="p-10">
            <div id="modal_unit_desc"  class="mb-15" style="font-style: italic;"></div>
            <hr  class="mb-15" style="border: 0; border-top: 1px solid #804000;" />
            
            <div  style="display: flex; gap: 15px;">
                <!-- Left: Stats -->
                <div  style="flex: 1;">
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
                </div>
                
                <!-- Right: Big Image -->
                <div  class="text-center" style="width: 160px; display: flex; flex-direction: column; justify-content: center;">
                    <img id="modal_unit_img" src="" alt=""  style="max-width: 100%; max-height: 250px; object-fit: contain;" />
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var unit_info_snob = {
        <?php
        $u_infos = [];
        foreach ($units as $u_db => $u_name) {
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

    // Image overrides: unit_db_key => filename (without .png)
    var snobImgOverrides = {
        'unit_snob': 'snob_b'
    };

    function showUnitModal(unit) {
        var info = unit_info_snob[unit];
        if (!info) return;

        var imgBase = snobImgOverrides[unit] || (unit.replace('unit_', '') + '_b');
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

        document.getElementById('unit_info_modal').style.display = 'block';
    }

    function closeUnitModal() {
        document.getElementById('unit_info_modal').style.display = 'none';
    }
>>>>>>> Stashed changes
</script>
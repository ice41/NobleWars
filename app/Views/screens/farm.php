<table>
    <tr>
        <td>
            <img src="graphic/big_buildings/farm1.png" title="<?= __('screens.farm.farm') ?>" alt="" />
        </td>
        <td>
            <h2><?= __('screens.farm.farm') ?> (<?= __('screens.common.level') ?> <?php echo $village['farm']; ?>)</h2>
            <p><?= __('screens.farm.farm_description') ?>
            </p>
        </td>
    </tr>
</table>
<br />

<table width="100%">
    <tr>
        <td valign="top" width="300">
            <img src="graphic/reports/militia.jpg" alt="Milícia">
        </td>
        <td valign="top">
            <table class="vis" width="100%">
                <tr>
                    <th colspan="2"></span><?= __('screens.farm.max_population') ?></th>
                </tr>
                <tr>
                    <td width="80%"><span class="icon header population"></span><?= __('screens.farm.max_population') ?>
                    </td>
                    <td align="right"><b><?php echo $max_bh; ?></b></td>
                </tr>
                <tr>
                    <td><span class="icon header population"></span><?= __('screens.farm.max_population_at_level') ?>
                        <?php echo $village['farm'] + 1; ?>
                    </td>
                    <td align="right"><b><?php echo $max_bh_next; ?></b></td>
                </tr>
            </table>
            <br />
            <table class="vis" width="100%">
                <tr>
                    <th colspan="2"><?= __('screens.farm.current_population') ?></th>
                </tr>
                <tr>
                    <td width="80%"><?= __('screens.farm.buildings_construction_included') ?></td>
                    <td align="right"><b><?php echo $buildings_bh; ?></b></td>
                </tr>
                <tr>
                    <td><?= __('screens.farm.troops') ?></td>
                    <td align="right"><b><?php echo $units_bh; ?></b></td>
                </tr>
                <tr>
                    <td><?= __('screens.farm.troops_in_production') ?></td>
                    <td align="right"><b>0</b></td>
                </tr>
                <tr>
                    <th><?= __('screens.farm.all') ?></th>
                    <th align="right"><?php echo $current_bh; ?></th>
                </tr>
            </table>
            <br />
            <table>
                <tr>
                    <th colspan="2"><a href="javascript:showUnitModal('unit_militia')"><img src="graphic/unit/unit_militia.png" style="cursor:pointer;"></a>
                        <?= __('screens.farm.militia_in_village') ?></th>
                </tr>
                <td class="vis" width="100%">
                    <table class="vis" width="100%">
                        <td valign="top" width="100%">
                            <p><?= __('screens.farm.militia_description') ?></p>
                            <ul>
                                <li><?= __('screens.farm.militia_effect_1') ?></li>
                                <li><?= __('screens.farm.militia_effect_2') ?></li>
                                <li><?= __('screens.farm.militia_effect_3') ?></li>
                                <li style="color: #aa0000; font-weight: bold;">
                                    <?= __('screens.farm.militia_effect_4') ?></li>
                            </ul>

                            <div style="text-align: center; margin-top: 10px;">
                                <?php if ($error): ?>
                                    <div class="error"><?php echo $error; ?></div>
                                <?php endif; ?>

                                <?php if ($militia_active): ?>
                                    <p style="font-weight: bold; color: green;"><?= __('screens.farm.militia_active') ?></p>
                                    <p><?= __('screens.farm.production_returns_in') ?> <span
                                            class="timer"><?php echo format_time($militia_end_time - time()); ?></span></p>
                                <?php else: ?>
                                    <?php if ($villages_count > 2): ?>
                                        <span class="inactive"><?= __('screens.farm.cannot_call_militia') ?></span>
                                    <?php else: ?>
                                        <form
                                            action="game.php?village=<?php echo $village['id']; ?>&screen=farm&action=call_militia&h=<?php echo $hkey; ?>"
                                            method="post">
                                            <input type="submit" value="<?= __('screens.farm.call_militia') ?>" class="btn"
                                                onclick="return confirm('<?= __('screens.farm.call_militia_confirm') ?>');">
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </td>
                </td>
            </table>

        </td>
</table>
</td>
</tr>
</table>
<br />

<!-- Militia Section -->

</div>

<!-- Unit Info Modal -->
<div id="unit_info_modal" class="unit-modal-overlay">
    <div class="unit-modal-box">
        <div class="unit-modal-header">
            <span id="modal_unit_title"><?= __('screens.recruitment.unit') ?></span>
            <span onclick="closeUnitModal()" class="unit-modal-close">X</span>
        </div>
        <div id="modal_unit_content" class="p-10">
            <div id="modal_unit_desc" class="unit-modal-desc"></div>
            <hr class="unit-modal-divider" />
            <div class="unit-modal-flex">
                <div class="unit-modal-stats-col">
                    <table class="vis" width="100%">
                        <tr><th width="100"><?= __('screens.recruitment.cost') ?></th><td id="modal_unit_cost"></td></tr>
                        <tr><th><?= __('screens.recruitment.population') ?></th><td id="modal_unit_pop"></td></tr>
                        <tr><th><?= __('screens.recruitment.speed') ?></th><td id="modal_unit_speed"></td></tr>
                        <tr><th><?= __('screens.recruitment.carry_capacity') ?></th><td id="modal_unit_booty"></td></tr>
                        <tr><th><?= __('screens.recruitment.attack') ?></th><td id="modal_unit_att"></td></tr>
                        <tr><th><?= __('screens.recruitment.defense') ?></th><td id="modal_unit_def"></td></tr>
                    </table>
                </div>
                <div class="unit-modal-image-col">
                    <img id="modal_unit_img" src="" alt="" class="unit-modal-image" />
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var unit_info = {
        'unit_militia': {
            name: " . json_encode($cl_units->get_name('unit_militia')) . ",
            desc: " . json_encode($cl_units->get_description('unit_militia')) . ",
            wood: " . $cl_units->get_woodprice('unit_militia') . ",
            stone: " . $cl_units->get_stoneprice('unit_militia') . ",
            iron: " . $cl_units->get_ironprice('unit_militia') . ",
            pop: " . $cl_units->get_bhprice('unit_militia') . ",
            speed: " . ($cl_units->get_speed('unit_militia') / 60) . ",
            booty: " . $cl_units->get_booty('unit_militia') . ",
            att: " . $cl_units->get_att('unit_militia', 1) . ",
            def: " . $cl_units->get_def('unit_militia', 1) . ",
            def_cav: " . $cl_units->get_defcav('unit_militia', 1) . ",
            def_arch: " . $cl_units->get_defarcher('unit_militia', 1) . "
        }
    };

    function showUnitModal(unit) {
        var info = unit_info[unit];
        if (!info) return;

        var imgBase = 'militia_b';
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
</script>
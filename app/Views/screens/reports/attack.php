<?php
/**
 * Attack Report View - 100% Faithful to Original Engine
 * Only difference: Building display uses improved visual from new engine
 */

// Calculate additional variables (matching original engine logic)
$spy_id = isset($spy_id) ? $spy_id : array_search('spy', array_keys($units));
$pala_id = isset($pala_id) ? $pala_id : array_search('paladin', array_keys($units));

// Check if scouts survived (OR_SPY)
$OR_SPY = false;
if ($spy_id !== false && isset($report['a_units'][$spy_id]) && isset($report['b_units'][$spy_id])) {
    $OR_SPY = ((int)$report['a_units'][$spy_id] - (int)$report['b_units'][$spy_id]) > 0;
}

// Check if there were troops outside the village
$po_za_wioska = false;
if (isset($report['e_units']) && is_array($report['e_units'])) {
    foreach ($report['e_units'] as $count) {
        if ($count > 0) {
            $po_za_wioska = true;
            break;
        }
    }
}

// Parse loot data
$loot = [
    'wood' => 0,
    'stone' => 0,
    'iron' => 0,
    'sum' => 0,
    'max' => $max_loot ?? 0
];

if (isset($report['hives']) && is_array($report['hives'])) {
    $loot['wood'] = $report['hives'][0] ?? 0;
    $loot['stone'] = $report['hives'][1] ?? 0;
    $loot['iron'] = $report['hives'][2] ?? 0;
    $loot['sum'] = $report['hives'][3] ?? 0;
}

// Parse ram/catapult/agreement data
$ram_from = $report['ram'][0] ?? 0;
$ram_to = $report['ram'][1] ?? 0;

$catapult_from = $report['catapult'][0] ?? 0;
$catapult_to = $report['catapult'][1] ?? 0;
$catapult_building = $report['catapult'][2] ?? '';

$agreement_from = $report['agreement'][0] ?? 0;
$agreement_to = $report['agreement'][1] ?? 0;

// Get paladin names and items from extra data
$att_pala_name = $extra_data['att_pala_name'] ?? '';
$def_pala_name = $extra_data['def_pala_name'] ?? '';
$att_pala_item = $extra_data['att_pala_item'] ?? '';
$def_pala_item = $extra_data['def_pala_item'] ?? '';
$pala_find_item = $extra_data['pala_find_item'] ?? '';
$bonus_noc = $extra_data['bonus_noc'] ?? 0;
$allyname = $extra_data['allyname'] ?? '';

// BB code
$bb_report = base64_encode($report['id']);

// Detect if this is a spy report (only spies sent)
$is_spy_report = true;
foreach ($report['a_units'] as $unit_index => $count) {
    if ($unit_index != $spy_id && $count > 0) {
        $is_spy_report = false;
        break;
    }
}
// Spy report is successful if spies survived
$spy_success = $is_spy_report && $OR_SPY;
?>

<!-- Report Container (constrained width with border) -->
<div  class="p-10" style="max-width: 600px; margin: 0 auto; background: #F4E4BC; border: 2px solid #DED3B9;">

    <!-- Victory Header (OUTSIDE image) -->
    <?php if ($is_spy_report): ?>
        <?php if ($spy_success): ?>
            <h3><?= __('screens.report.attacker_spied') ?></h3>
        <?php else: ?>
            <h3><?= __('screens.report.attacker_spied_failed') ?></h3>
        <?php endif; ?>
    <?php else: ?>
        <?php if ($report['wins'] == 'att'): ?>
            <h3><?= __('screens.report.attacker_won') ?></h3>
        <?php else: ?>
            <h3><?= __('screens.report.defender_won') ?></h3>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Report Image with Overlay (matching original engine structure) -->
    <?php
    // Determine battle image based on report type
    if ($is_spy_report) {
        $battle_class = $spy_success ? 'battle_scout_own_success' : 'battle_scout_own_fail';
    } else {
        $battle_class = $report['wins'] == 'att' ? 'battle_attacker_won' : 'battle_defender_won';
    }
    ?>

    <div class="report_image <?= $battle_class ?>" style="background-image: url('graphic/reports/<?= $battle_class ?>.jpg'); 
           background-size: cover; 
           background-position: center; 
           position: relative; 
           min-height: 300px;
           display: flex;
           align-items: flex-end;">
        <div class="report_transparent_overlay" style="background: rgba(255, 248, 220, 0.85); 
               padding: 15px; 
               width: 100%;
               box-sizing: border-box;">

            <!-- Luck Bar -->
            <h4><?= __('screens.report.luck_from_attacker') ?></h4>
            <table id="attack_luck">
                <?php if ($report['luck'] < 0): ?>
                    <tr>
                        <td class="nobg"  style="padding: 0pt;"><b><?= $report['luck'] ?>%</b></td>
                        <td class="nobg"><img src="graphic/icons/rabe.png" alt="<?= __('screens.common.bad_luck') ?>"></td>
                        <td class="nobg">
                            <table class="luck" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <?php
                                        $bad_luck_width = abs($report['luck']) * 2;
                                        $empty_width = 50 - $bad_luck_width;
                                        ?>
                                        <td class="luck-item nobg" height="12" width="<?= $empty_width ?>"></td>
                                        <td class="luck-item nobg"
                                             style="border-right: 1px solid rgb(0, 0, 0); background-image: url(graphic/balken_pech.png);"
                                            width="<?= $bad_luck_width ?>"></td>
                                        <td class="luck-item nobg" width="50"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td class="nobg"><img src="graphic/icons/klee.png" alt="<?= __('screens.common.good_luck') ?>"></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td class="nobg"  style="padding: 0pt;"></td>
                        <td class="nobg"><img src="graphic/icons/rabe.png" alt="<?= __('screens.common.bad_luck') ?>"></td>
                        <td class="nobg">
                            <table class="luck" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <?php
                                        $good_luck_width = $report['luck'] * 2;
                                        $empty_width = 50 - $good_luck_width;
                                        ?>
                                        <td class="luck-item nobg" height="12" width="50"></td>
                                        <td class="luck-item nobg"
                                             style="border-left: 1px solid rgb(0, 0, 0); background-image: url(graphic/balken_glueck.png);"
                                            width="<?= $good_luck_width ?>"></td>
                                        <td class="luck-item nobg" width="<?= $empty_width ?>"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td class="nobg"><img src="graphic/icons/klee.png" alt="<?= __('screens.common.good_luck') ?>"></td>
                        <td class="nobg"><b><?= $report['luck'] ?>%</b></td>
                    </tr>
                <?php endif; ?>
            </table>

            <!-- Moral -->
            <?php if (($config['moral_activ'] ?? 'false') == 'true'): ?>
                <h4><?= __('screens.report.morale') ?>: <?= $report['moral'] ?>%</h4>
            <?php endif; ?>

            <!-- Night Bonus -->
            <?php if ($bonus_noc == 1): ?>
                <h4><?= __('screens.report.night_bonus_active') ?></h4>
            <?php endif; ?>

        </div>
    </div>


    <!-- Attacker -->
    <table width="100%"  style="border: 1px solid #DED3B9;">
        <tr>
            <th width="100"><?= __('screens.report.attacker') ?></th>
            <th><a
                    href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $report['from_user'] ?>"><?= htmlspecialchars($report['from_username']) ?></a>
            </th>
        </tr>
        <tr>
            <td><?= __('screens.report.origin') ?></td>
            <td><a href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $report['from_village'] ?>"><?= htmlspecialchars($report['from_villagename']) ?>
                    (<?= $report['from_x'] ?>|<?= $report['from_y'] ?>)</a></td>
        </tr>

        <tr>
            <td colspan="2">
                <table class="vis">
                    <tr class="center">
                        <td></td>
                        <?php foreach ($units as $unit_name => $unit_label): ?>
                            <td width="35"><img src="graphic/unit/<?= $unit_name ?>.png" title="<?= $unit_label ?>"
                                    alt="" />
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="center">
                        <td><?= __('screens.report.quantity') ?>:</td>
                        <?php
                        $unit_index = 0;
                        foreach ($units as $unit_name => $unit_label):
                            $count = $report['a_units'][$unit_index] ?? 0;
                            $unit_index++;
                            ?>
                            <?php if ($count > 0): ?>
                                <td><?= $count ?></td>
                            <?php else: ?>
                                <td class="hidden">0</td>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="center">
                        <td><?= __('screens.report.casualties') ?>:</td>
                        <?php
                        $unit_index = 0;
                        foreach ($units as $unit_name => $unit_label):
                            $count = $report['b_units'][$unit_index] ?? 0;
                            $unit_index++;
                            ?>
                            <?php if ($count > 0): ?>
                                <td><?= $count ?></td>
                            <?php else: ?>
                                <td class="hidden">0</td>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tr>

                    <!-- Attacker Paladin -->
                    <?php if (($report['a_units'][$pala_id] ?? 0) > 0): ?>
                        <tr class="center">
                            <td><?= __('screens.report.paladin_title') ?>:</td>
                            <td colspan="<?= count($units) ?>">
                                <?php if ($report['a_units'][$pala_id] == $report['b_units'][$pala_id]): ?>
                                    <?php if ($report['from_user'] == $user['id']): ?>
                                        <?= __('screens.report.paladin_will_die') ?>
                                    <?php else: ?>
                                        <?= __('screens.report.paladin_died') ?>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?= sprintf(__('screens.report.paladin_named'), htmlspecialchars($att_pala_name)) ?>,
                                    <?php if (!empty($att_pala_item)): ?>
                                        <?= sprintf(__('screens.report.equipped_with'), htmlspecialchars($att_pala_item)) ?>
                                    <?php else: ?>
                                        <?= __('screens.report.without_item') ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </table>
            </td>
        </tr>
    </table><br />

    <!-- Defender -->
    <table width="100%"  style="border: 1px solid #DED3B9;">
        <tr>
            <th width="100"><?= __('screens.report.defender') ?></th>
            <th><a
                    href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $report['to_user'] ?>"><?= htmlspecialchars($report['to_username']) ?></a>
            </th>
        </tr>
        <tr>
            <td><?= __('screens.report.destination') ?></td>
            <td><a href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $report['to_village'] ?>"><?= htmlspecialchars($report['to_villagename']) ?>
                    (<?= $report['to_x'] ?>|<?= $report['to_y'] ?>)</a></td>
        </tr>
        <tr>
            <td colspan="2">
                <?php if ($see_def_units || $OR_SPY): ?>
                    <table class="vis">
                        <tr class="center">
                            <td></td>
                            <?php foreach ($units as $unit_name => $unit_label): ?>
                                <td width="35"><img src="graphic/unit/<?= $unit_name ?>.png" title="<?= $unit_label ?>"
                                        alt="" />
                                </td>
                            <?php endforeach; ?>
                        </tr>
                        <tr class="center">
                            <td><?= __('screens.report.quantity') ?>:</td>
                            <?php
                            $unit_index = 0;
                            foreach ($units as $unit_name => $unit_label):
                                $count = $report['c_units'][$unit_index] ?? 0;
                                $unit_index++;
                                ?>
                                <?php if ($count > 0): ?>
                                    <td><?= $count ?></td>
                                <?php else: ?>
                                    <td class="hidden">0</td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                        <tr class="center">
                            <td><?= __('screens.report.casualties') ?>:</td>
                            <?php
                            $unit_index = 0;
                            foreach ($units as $unit_name => $unit_label):
                                $count = $report['d_units'][$unit_index] ?? 0;
                                $unit_index++;
                                ?>
                                <?php if ($count > 0): ?>
                                    <td><?= $count ?></td>
                                <?php else: ?>
                                    <td class="hidden">0</td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>

                        <!-- Defender Paladin -->
                        <?php if (($report['c_units'][$pala_id] ?? 0) > 0): ?>
                            <tr class="center">
                                <td><?= __('screens.report.paladin_title') ?>:</td>
                                <td colspan="<?= count($units) ?>">
                                    <?php if ($report['c_units'][$pala_id] == $report['d_units'][$pala_id]): ?>
                                        <?php if ($report['to_user'] == $user['id']): ?>
                                            <?= __('screens.report.paladin_will_die') ?>
                                        <?php else: ?>
                                            <?= __('screens.report.paladin_died') ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?= sprintf(__('screens.report.paladin_named'), htmlspecialchars($def_pala_name)) ?>,
                                        <?php if (!empty($def_pala_item)): ?>
                                            <?= sprintf(__('screens.report.equipped_with'), htmlspecialchars($def_pala_item)) ?>
                                        <?php else: ?>
                                            <?= __('screens.report.without_item') ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </table>
                <?php else: ?>
                    <?php if ($report['from_user'] == $user['id']): ?>
                        <p><?= __('screens.report.all_troops_died') ?></p>
                    <?php else: ?>
                        <p><?= __('screens.report.no_defender_info') ?></p>
                    <?php endif; ?>
                <?php endif; ?>
            </td>
        </tr>
    </table><br />

    <!-- Espionage Section (Unified) -->
    <?php if ($def_out_units_see || (isset($report['budynki']) && is_array($report['budynki']) && count($report['budynki']) > 1) || $def_out_res_see): ?>
        <h4><?= __('screens.report.espionage') ?></h4>
        <table id="attack_spy"  class="w-100" style="border: 1px solid rgb(222, 211, 185); table-layout: fixed; border-collapse: collapse;">
            <!-- Resources -->
            <?php if ($def_out_res_see): ?>
                <tr>
                    <th><?= __('screens.report.resources_spied') ?></th>
                    <td colspan="4">
                        <?php if (($report['sorowce_poz'][0] ?? 0) > 0): ?>
                            <img src="graphic/icons/wood.png" title="<?= __('screens.common.wood') ?>" />
                            <?= number_format($report['sorowce_poz'][0]) ?>
                        <?php endif; ?>
                        <?php if (($report['sorowce_poz'][1] ?? 0) > 0): ?>
                            <img src="graphic/icons/stone.png" title="<?= __('screens.common.stone') ?>" />
                            <?= number_format($report['sorowce_poz'][1]) ?>
                        <?php endif; ?>
                        <?php if (($report['sorowce_poz'][2] ?? 0) > 0): ?>
                            <img src="graphic/icons/iron.png" title="<?= __('screens.common.iron') ?>" />
                            <?= number_format($report['sorowce_poz'][2]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endif; ?>

            <!-- Spacer row -->
            <tr>
                <td colspan="5"  style="height: 15px;"></td>
            </tr>

            <!-- Buildings (TABLE FORMAT like troops) -->
            <?php if (isset($report['budynki']) && is_array($report['budynki']) && count($report['budynki']) > 1): ?>
                <?php
                // Check if there are any buildings with level > 0
                $has_buildings = false;
                foreach ($report['budynki'] as $level) {
                    if ($level > 0) {
                        $has_buildings = true;
                        break;
                    }
                }
                ?>
                <?php if ($has_buildings): ?>
                    <tr>
                        <th  class="text-center" colspan="5"><?= __('screens.report.spied_buildings') ?></th>
                    </tr>
                    <tr>
                        <td colspan="5"  style="height: 1px;"></td>
                    </tr>
                    <?php
                    // Collect buildings with levels > 0
                    $buildings_with_levels = [];
                    $building_index = 0;
                    foreach ($buildings as $bname => $blabel):
                        $level = isset($report['budynki'][$building_index]) ? $report['budynki'][$building_index] : 0;
                        if ($level > 0):
                            $buildings_with_levels[] = ['name' => $bname, 'label' => $blabel, 'level' => $level];
                        endif;
                        $building_index++;
                    endforeach;

                    // Split into two columns
                    $half = ceil(count($buildings_with_levels) / 2);
                    $left_buildings = array_slice($buildings_with_levels, 0, $half);
                    $right_buildings = array_slice($buildings_with_levels, $half);
                    ?>

                    <tr>
                        <th width="42%"  class="text-left" style="padding-left: 5px;"><?= __('screens.common.building') ?></th>
                        <th width="6%"  class="text-right" style="padding-right: 5px;"><?= __('screens.common.level') ?></th>
                        <th width="4%"> </th>
                        <th width="42%"  class="text-left" style="padding-left: 5px;"><?= __('screens.common.building') ?></th>
                        <th width="6%"  class="text-right" style="padding-right: 5px;"><?= __('screens.common.level') ?></th>
                    </tr>

                    <?php
                    for ($i = 0; $i < $half; $i++):
                        ?>
                        <tr>
                            <?php if (isset($left_buildings[$i])): ?>
                                <td  class="nowrap" style="padding-left: 5px;">
                                    <img src="graphic/buildings/<?= $left_buildings[$i]['name'] ?>.png"
                                        title="<?= $left_buildings[$i]['label'] ?>" alt="" />
                                    <?= $left_buildings[$i]['label'] ?>
                                </td>
                                <td  class="text-right" style="padding-right: 5px;"><b><?= $left_buildings[$i]['level'] ?></b></td>
                            <?php else: ?>
                                <td></td>
                                <td></td>
                            <?php endif; ?>

                            <td></td>

                            <?php if (isset($right_buildings[$i])): ?>
                                <td  class="nowrap" style="padding-left: 5px;">
                                    <img src="graphic/buildings/<?= $right_buildings[$i]['name'] ?>.png"
                                        title="<?= $right_buildings[$i]['label'] ?>" alt="" />
                                    <?= $right_buildings[$i]['label'] ?>
                                </td>
                                <td  class="text-right" style="padding-right: 5px;"><b><?= $right_buildings[$i]['level'] ?></b></td>
                            <?php else: ?>
                                <td></td>
                                <td></td>
                            <?php endif; ?>
                        </tr>
                        <?php
                    endfor;
                    ?>
                <?php endif; ?>
            <?php endif; ?>
            <!-- Units Outside Village -->
            <?php if ($def_out_units_see): ?>
                <tr>
                    <th colspan="2"><?= __('screens.report.units_outside') ?></th>
                </tr>
                <tr>
                    <td colspan="2">
                        <table class="vis">
                            <tr>
                                <?php foreach ($units as $unit_name => $unit_label): ?>
                                    <th width="35">
                                        <img src="graphic/unit/<?= $unit_name ?>.png" title="<?= $unit_label ?>" alt="" />
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <?php
                                $unit_index = 0;
                                foreach ($units as $unit_name => $unit_label):
                                    $count = $report['f_units'][$unit_index] ?? 0;
                                    $unit_index++;
                                    ?>
                                    <?php if ($count > 0): ?>
                                        <td><?= $count ?></td>
                                    <?php else: ?>
                                        <td class="hidden">0</td>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tr>
                        </table>
                    </td>
                </tr>
            <?php endif; ?>
        </table>
        <br>
    <?php endif; ?>

    <!-- Troops that were outside the village -->
    <?php if (count($report['e_units']) > 1 && $po_za_wioska): ?>
        <h4><?= __('screens.report.troops_outside') ?></h4>
        <table>
            <tr>
                <?php foreach ($units as $unit_name => $unit_label): ?>
                    <th width="35">
                        <img src="graphic/unit/<?= $unit_name ?>.png" title="<?= $unit_label ?>" alt="" />
                    </th>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php
                $unit_index = 0;
                foreach ($units as $unit_name => $unit_label):
                    $count = $report['e_units'][$unit_index] ?? 0;
                    $unit_index++;
                    ?>
                    <?php if ($count > 0): ?>
                        <td><?= $count ?></td>
                    <?php else: ?>
                        <td class="hidden">0</td>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        </table>
        <br>
    <?php endif; ?>

    <!-- Loot, Ram, Catapult, Paladin Item -->
    <table width="100%"  style="border: 1px solid #DED3B9;">
        <!-- Loot -->
        <?php if ($loot['wood'] > 0 || $loot['stone'] > 0 || $loot['iron'] > 0): ?>
            <tr>
                <th><?= __('screens.report.loot') ?></th>
                <td width="220">
                    <?php if ($loot['wood'] > 0): ?><img src="graphic/icons/wood.png" title="<?= __('screens.common.wood') ?>" />
                        <?= number_format($loot['wood']) ?>     <?php endif; ?>
                    <?php if ($loot['stone'] > 0): ?><img src="graphic/icons/stone.png"
                            title="<?= __('screens.common.stone') ?>" />
                        <?= number_format($loot['stone']) ?>     <?php endif; ?>
                    <?php if ($loot['iron'] > 0): ?><img src="graphic/icons/iron.png"
                            title="<?= __('screens.common.iron') ?>" />
                        <?= number_format($loot['iron']) ?>     <?php endif; ?>
                </td>
                <td><?= $loot['sum'] ?>/<?= $loot['max'] ?></td>
            </tr>
        <?php endif; ?>

        <!-- Warning about detected troops -->
        <?php if ($report['to_user'] == $user['id'] && $def_out_units_see): ?>
            <tr>
                <th><?= __('screens.report.warning') ?></th>
                <td><?= __('screens.report.troops_detected') ?></td>
            </tr>
        <?php endif; ?>

        <!-- Paladin found item -->
        <?php if (!empty($pala_find_item)): ?>
            <tr>
                <th><?= __('screens.report.paladin_title') ?: 'Paladino:' ?></th>
                <td><?= __('screens.report.paladin_found_item') ?> <b><?= htmlspecialchars($pala_find_item) ?></b></td>
            </tr>
        <?php endif; ?>

        <!-- Ram damage -->
        <?php if ($ram_from != $ram_to): ?>
            <tr>
                <th><?= __('screens.report.wall_damage') ?></th>
                <td colspan="2"><?= __('screens.report.wall_damage_msg', ['from' => $ram_from, 'to' => $ram_to]) ?></td>
            </tr>
        <?php endif; ?>

        <!-- Agreement change -->
        <?php if ($agreement_from != $agreement_to): ?>
            <tr>
                <th><?= __('screens.report.loyalty_change') ?: 'Lealdade:' ?></th>
                <td colspan="2">
                    <?= __('screens.report.loyalty_decreased', ['from' => number_format($agreement_from), 'to' => number_format($agreement_to)]) ?: 'caiu de <b>' . number_format($agreement_from) . '</b> sobre <b>' . number_format($agreement_to) . '</b>' ?>
                </td>
            </tr>
        <?php endif; ?>

        <!-- Catapult damage -->
        <?php if ($catapult_from != $catapult_to): ?>
            <tr>
                <th><?= __('screens.report.building_damage') ?></th>
                <td colspan="2">
                    <?= __('screens.report.building_damage_msg', ['building' => ($buildings[$catapult_building] ?? $catapult_building), 'from' => $catapult_from, 'to' => $catapult_to]) ?>
                </td>
            </tr>
        <?php endif; ?>
    </table>

    <br>

    <!-- Publish Report Link -->
    <?php if (!isset($is_public_view) || !$is_public_view): ?>
        <div  class="text-center" width="100%">
            <a href="game.php?village=<?= $village['id'] ?>&screen=report&mode=publish&report_id=<?= $report['id'] ?>">
                &raquo; <?= __('screens.report.publish') ?>
            </a>
        </div>

        <br>
    <?php endif; ?>

    <!-- BB Code -->
    <!-- <table class="vis" width="100%">
        <tr>
            <th><span class="link" onclick="switchDisplay('bb_report_send')">Ver este relatorio em bb-code</span></th>
        </tr>
        <tr>
            <td>
                <div id="bb_report_send"  style="display:none;">
                    <p>[report_display]<?= $bb_report ?>[/report_display]</p>
                </div>
            </td>
        </tr>
    </table> -->

</div> <!-- End Report Container -->

<script>
    function switchDisplay(id) {
        var elem = document.getElementById(id);
        if (elem.style.display == 'none') {
            elem.style.display = 'block';
        } else {
            elem.style.display = 'none';
        }
    }
</script>
<?php
$modes = [
    'all' => __('screens.report.mode_all'),
    'attack' => __('screens.report.mode_attack'),
    'defense' => __('screens.report.mode_defense'),
    'support' => __('screens.report.mode_support'),
    'trade' => __('screens.report.mode_trade'),
    'other' => __('screens.report.mode_other'),
    'public' => __('screens.report.mode_public')
];
?>
<h2><?= __('screens.report.title') ?></h2>

<table>
    <tr>
        <td valign="top">
            <table class="vis" width="100">
                <?php foreach ($modes as $key => $label): ?>
                    <tr>
                        <td class="<?= $mode === $key ? 'selected' : '' ?>" width="120">
                            <a
                                href="game.php?village=<?= $village['id'] ?>&screen=report&mode=<?= $key ?>"><?= $label ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </td>
        <td valign="top" width="100%">
            <?php if ($mode === 'view' && isset($report)): ?>
                <!-- Report View -->
                <?php
                // Determine the report image class
                $report_image_class = 'image_attack_won'; // Default
                $isinfo = false; // logic for info/scout/etc if needed
            
                // Check if this is a spy-only attack
                $is_spy_only = false;
                if (isset($report['a_units']) && is_array($report['a_units'])) {
                    $total_units = array_sum($report['a_units']);
                    $spy_count = isset($report['a_units'][4]) ? $report['a_units'][4] : 0; // unit_spy is index 4
                    $is_spy_only = ($total_units == $spy_count && $spy_count > 0);
                }

                // Set image based on report type
                if ($is_spy_only) {
                    // Spy report - check if spy mission succeeded (got information)
                    // Success = has building or resource data
                    $has_spy_data = (!empty($report['budynki']) && is_array($report['budynki']) && array_sum($report['budynki']) > 0) ||
                        (!empty($report['sorowce_poz']) && is_array($report['sorowce_poz']) && array_sum($report['sorowce_poz']) > 0);

                    if ($has_spy_data) {
                        // Got spy information = SUCCESS
                        $report_image_class = 'graphic/reports/battle_scout_own_success.jpg';
                    } else {
                        // No spy information = FAIL
                        $report_image_class = 'graphic/reports/battle_scout_own_fail.jpg';
                    }
                } elseif ($report['type'] === 'attack') {
                    if ($report['wins'] === 'att') {
                        $report_image_class = 'image_attack_won';
                    } else {
                        // If attack lost
                        $report_image_class = 'image_attack_lost';
                    }
                }
                ?>

                <table width="100%">
                    <tr>
                        <td>
                            <table class="vis" width="100%">
                                <tr>
                                    <th width="140"><?= __('screens.report.subject') ?></th>
                                    <th width="400"><?= $report['title'] ?></th>
                                </tr>
                                <tr>
                                    <td><?= __('screens.report.sent_on') ?></td>
                                    <td><?= date('d/m/Y H:i:s', $report['time']) ?></td>
                                </tr>
                            </table>


                            <?php if ($is_spy_only): ?>
                                <!-- SPY REPORT LAYOUT - ORIGINAL DESIGN -->
                                <table width="100%" style="border: 1px solid #7D510F;" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <?php
                                                // Prepare background image
                                                $bg_style = "background: url('{$report_image_class}') center center no-repeat; background-size: cover; height: 250px;";
                                                ?>
                                                <div style="<?= $bg_style ?>; position: relative;">
                                                    <div
                                                        style="position: absolute; bottom: 10px; left: 10px; right: 10px; color: #fff; background-color: rgba(0,0,0,0.6); padding: 10px; border-radius: 3px;">
                                                        <h4 style="color: #fff; margin: 0 0 5px 0;">
                                                            <?= __('screens.report.attacker_luck') ?>
                                                        </h4>
                                                        <table style="width: 100%; border-collapse: collapse;" cellspacing="0">
                                                            <tr>
                                                                <td style="width: 50%; text-align: right; padding-right: 5px;">
                                                                    <?php if (($report['luck'] ?? 0) < 0): ?>
                                                                        <img src="graphic/balken_pech.png"
                                                                            style="width: <?= min(100, abs($report['luck']) * 4) ?>%; height: 12px;" />
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td style="width: 0; padding: 0;">
                                                                    <div style="width: 1px; height: 12px; background: #fff;">
                                                                    </div>
                                                                </td>
                                                                <td style="width: 50%; text-align: left; padding-left: 5px;">
                                                                    <?php if (($report['luck'] ?? 0) >= 0): ?>
                                                                        <img src="graphic/balken_glueck.png"
                                                                            style="width: <?= min(100, ($report['luck'] ?? 0) * 4) ?>%; height: 12px;" />
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <div style="text-align: center; margin-top: 2px;">
                                                            <?= ($report['luck'] ?? 0) > 0 ? '+' : '' ?>
                                                            <?= $report['luck'] ?? 0 ?>%
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Attacker Info -->
                                                <table class="vis" width="100%" cellspacing="0">
                                                    <tbody>
                                                                    style="border: none; margin: 0;">
                                                                    <tr>
                                                                        <td></td>
                                                                        <?php foreach ($units as $uname => $ulabel): ?>
                                                                            <td width="35"
                                                                                style="text-align: center; padding: 2px;">
                                                                                <img src="graphic/unit/unit_<?= $uname ?>.png"
                                                                                    title="<?= $ulabel ?>">
                                                                            </td>
                                                                        <?php endforeach; ?>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><?= __('screens.report.quantity') ?></td>
                                                                        <?php
                                                                        $unit_index = 0;
                                                                        foreach ($units as $uname => $ulabel):
                                                                            $count = $report['a_units'][$unit_index] ?? 0;
                                                                            ?>
                                                                            <td style="text-align: center;"><?= $count ?></td>
                                                                            <?php
                                                                            $unit_index++;
                                                                        endforeach;
                                                                        ?>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><?= __('screens.report.losses') ?></td>
                                                                        <?php
                                                                        $unit_index = 0;
                                                                        foreach ($units as $uname => $ulabel):
                                                                            // Use b_units (pre-calculated losses) instead of sent - survived
                                                                            $losses = $report['b_units'][$unit_index] ?? 0;
                                                                            ?>
                                                                            <td style="text-align: center;"><?= $losses ?></td>
                                                                            <?php
                                                                            $unit_index++;
                                                                        endforeach;
                                                                        ?>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <!-- Defender Info (Complete Table) -->
                                                <table class="vis" width="100%" cellspacing="0">
                                                    <tbody>
                                                        <tr>
                                                            <th width="100"><?= __('screens.report.defender') ?></th>
                                                            <th>
                                                                <a
                                                                    href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $report['to_user'] ?>">
                                                                    <?= htmlspecialchars($report['to_username'] ?? __('screens.report.unknown')) ?>
                                                                </a>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td><?= __('screens.report.destination') ?></td>
                                                            <td>
                                                                <a
                                                                    href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $report['to_village'] ?>">
                                                                    <?= htmlspecialchars($report['to_villagename'] ?? '') ?>
                                                                    (<?= $report['to_x'] ?? 0 ?>|<?= $report['to_y'] ?? 0 ?>)
                                                                    K<?= floor(($report['to_y'] ?? 0) / 100) . floor(($report['to_x'] ?? 0) / 100) ?>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="padding: 0;">
                                                                <table class="vis" width="100%"
                                                                    style="border: none; margin: 0;">
                                                                    <tr class="center">
                                                                        <td></td>
                                                                        <?php foreach ($units as $unitKey => $unitName): ?>
                                                                            <td width="35"><img
                                                                                    src="graphic/unit/<?= $unitKey ?>.png"
                                                                                    title="<?= $unitName ?>" alt="" /></td>
                                                                        <?php endforeach; ?>
                                                                    </tr>
                                                                    <tr class="center">
                                                                        <td><?= __('screens.report.quantity') ?></td>
                                                                        <?php
                                                             $unit_index = 0;
                                                             foreach ($units as $unitKey => $unitName):
                                                                 $count = $report['c_units'][$unit_index] ?? 0;
                                                                 $unit_index++;
                                                                 ?>
                                                                 <td class="<?= $count == 0 ? 'hidden' : '' ?>"><?= $count ?>
                                                                 </td>
                                                             <?php endforeach; ?>
                                                                    </tr>
                                                                    <tr class="center">
                                                                        <td><?= __('screens.report.losses') ?></td>
                                                                        <?php
                                                             $unit_index = 0;
                                                             foreach ($units as $unitKey => $unitName):
                                                                 $count = $report['d_units'][$unit_index] ?? 0;
                                                                 $unit_index++;
                                                                 ?>
                                                                 <td class="<?= $count == 0 ? 'hidden' : '' ?>"><?= $count ?>
                                                                 </td>
                                                             <?php endforeach; ?>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th><?= __('screens.report.loot') ?></th>
                                                            <td>
                                                                <?php
                                                                // For spy-only attacks, loot is always 0 (scouts have 0 carry capacity)
                                                                // sorowce_poz contains spy resources for display, not actual loot
                                                                if ($is_spy_only) {
                                                                    $loot_wood = 0;
                                                                    $loot_stone = 0;
                                                                    $loot_iron = 0;
                                                                } else {
                                                                    $loot_wood = isset($report['sorowce_poz'][0]) ? (int) $report['sorowce_poz'][0] : 0;
                                                                    $loot_stone = isset($report['sorowce_poz'][1]) ? (int) $report['sorowce_poz'][1] : 0;
                                                                    $loot_iron = isset($report['sorowce_poz'][2]) ? (int) $report['sorowce_poz'][2] : 0;
                                                                }
                                                                $loot_total = $loot_wood + $loot_stone + $loot_iron;
                                                                $max_loot_val = isset($max_loot) ? $max_loot : 0;
                                                                ?>

                                                                <?php if ($loot_total > 0 || $max_loot_val > 0): ?>
                                                                    <span class="icon header wood"></span> <?= $loot_wood ?>
                                                                    <span class="icon header stone"></span> <?= $loot_stone ?>
                                                                    <span class="icon header iron"></span> <?= $loot_iron ?>
                                                                    <span
                                                                        style="float:right;"><?= $loot_total ?>/<?= $max_loot_val ?></span>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>


                                                    <!-- Reconnaissance Section - MOVED TO AFTER DEFENDER -->
                                                    <!-- <h3>Reconhecimento</h3> -->

                                                    <!-- Resources -->
                                                    <?php if (!empty($report['sorowce_poz']) && is_array($report['sorowce_poz']) && count($report['sorowce_poz']) >= 3): ?>
                                                        <!-- <h4>Recursos detetados:</h4> -->
                                                        <table class="vis" width="100%" cellspacing="0">
                                                            <tr>
                                                                <td style="text-align: center; padding: 5px;">
                                                                    <img src="graphic/icons/wood.png">
                                                                    <?= number_format($report['sorowce_poz'][0] ?? 0) ?>
                                                                </td>
                                                                <td style="text-align: center; padding: 5px;">
                                                                    <img src="graphic/icons/stone.png">
                                                                    <?= number_format($report['sorowce_poz'][1] ?? 0) ?>
                                                                </td>
                                                                <td style="text-align: center; padding: 5px;">
                                                                    <img src="graphic/icons/iron.png">
                                                                    <?= number_format($report['sorowce_poz'][2] ?? 0) ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <br>
                                                    <?php endif; ?>

                                                    <!-- Buildings in Two Columns -->
                                                    <?php if (!empty($report['budynki']) && is_array($report['budynki'])): ?>
                                                        <?php
                                                        $buildings_with_levels = array();
                                                        $building_index = 0;
                                                        foreach ($buildings as $bname => $label) {
                                                            $level = $report['budynki'][$building_index] ?? 0;
                                                            if ($level > 0) {
                                                                $buildings_with_levels[] = array('name' => $bname, 'label' => $label, 'level' => $level);
                                                            }
                                                            $building_index++;
                                                        }

                                                        if (count($buildings_with_levels) > 0):
                                                            $half = ceil(count($buildings_with_levels) / 2);
                                                            $left_buildings = array_slice($buildings_with_levels, 0, $half);
                                                            $right_buildings = array_slice($buildings_with_levels, $half);
                                                            ?>
                                                            <!-- Left Column -->
                                                            <table id="attack_spy_buildings_left"
                                                                style="border: 1px solid #DED3B9; width:50%; margin-top:5px; margin-bottom:5px; float:left; background-color:#EDDEB9;">
                                                                <tr>
                                                                    <th style="width: 60%"><?= __('screens.report.building') ?></th>
                                                                    <th><?= __('screens.common.level') ?></th>
                                                                </tr>
                                                                <?php foreach ($left_buildings as $building): ?>
                                                                    <tr>
                                                                        <td nowrap style="vertical-align:middle;">
                                                                            <img src="graphic/buildings/<?= $building['name'] ?>.png"
                                                                                style="max-height:16px;" alt="" class="middle">
                                                                            <span class="middle"><?= $building['label'] ?></span>
                                                                        </td>
                                                                        <td class="middle"><?= $building['level'] ?></td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </table>

                                                            <!-- Right Column -->
                                                            <table id="attack_spy_buildings_right"
                                                                style="border: 1px solid #DED3B9; width:50%; margin-top:5px; margin-bottom:5px; float:left; background-color:#EDDEB9;">
                                                                <tr>
                                                                    <th style="width: 60%"><?= __('screens.report.building') ?></th>
                                                                    <th><?= __('screens.common.level') ?></th>
                                                                </tr>
                                                                <?php foreach ($right_buildings as $building): ?>
                                                                    <tr>
                                                                        <td nowrap style="vertical-align:middle;">
                                                                            <img src="graphic/buildings/<?= $building['name'] ?>.png"
                                                                                style="max-height:16px;" alt="" class="middle">
                                                                            <span class="middle"><?= $building['label'] ?></span>
                                                                        </td>
                                                                        <td class="middle"><?= $building['level'] ?></td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </table>
                                                            <div style="clear:both;"></div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>

                                                    <!-- Units Outside Village - Horizontal Table -->
                                                    <?php if (!empty($report['d_units']) && is_array($report['d_units'])): ?>
                                                        <?php
                                                        $has_units_outside = false;
                                                        foreach ($report['d_units'] as $count) {
                                                            if ($count > 0) {
                                                                $has_units_outside = true;
                                                                break;
                                                            }
                                                        }
                                                        ?>
                                                        <?php if ($has_units_outside): ?>
                                                            <table id="attack_spy_away"
                                                                style="border: 1px solid #DED3B9; width:100%; margin-top:5px;">
                                                                <tr>
                                                                    <th colspan="2"><?= __('screens.report.units_outside') ?></th>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <table class="vis">
                                                                            <tr>
                                                                                <?php
                                                                                $unit_index = 0;
                                                                                foreach ($units as $uname => $ulabel):
                                                                                    $unit_count = $report['d_units'][$unit_index] ?? 0;
                                                                                    ?>
                                                                                    <th width="35">
                                                                                        <div class="">
                                                                                            <a href="#" class="unit_link"
                                                                                                data-unit="<?= $uname ?>">
                                                                                                <img src="graphic/unit/unit_<?= $uname ?>.png"
                                                                                                    style="width: 18px; height: 18px"
                                                                                                    data-title="<?= $ulabel ?>">
                                                                                            </a>
                                                                                        </div>
                                                                                    </th>
                                                                                    <?php
                                                                                    $unit_index++;
                                                                                endforeach;
                                                                                ?>
                                                                            </tr>
                                                                            <tr>
                                                                                <?php
                                                                                $unit_index = 0;
                                                                                foreach ($units as $uname => $ulabel):
                                                                                    $unit_count = $report['d_units'][$unit_index] ?? 0;
                                                                                    ?>
                                                                                    <td data-unit-count="<?= $unit_count ?>"
                                                                                        class="unit-item unit-item-<?= $uname ?> <?= $unit_count == 0 ? 'hidden' : '' ?>">
                                                                                        <?= $unit_count ?>
                                                                                    </td>
                                                                                    <?php
                                                                                    $unit_index++;
                                                                                endforeach;
                                                                                ?>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        <?php endif; ?>
                                                    <?php endif; ?>

                                                    <!-- Units PRESENT in Village (Defending troops at home) -->
                                                    <?php if (!empty($report['e_units']) && is_array($report['e_units'])): ?>
                                                        <?php
                                                        $has_units_present = false;
                                                        foreach ($report['e_units'] as $count) {
                                                            if ($count > 0) {
                                                                $has_units_present = true;
                                                                break;
                                                            }
                                                        }
                                                        ?>
                                                        <?php if ($has_units_present): ?>
                                                            <h4><?= __('screens.report.units_present_in_village') ?></h4>
                                                            <table class="vis" width="100%" cellspacing="0">
                                                                <tr>
                                                                    <?php
                                                                    $unit_index = 0;
                                                                    foreach ($units as $uname => $ulabel):
                                                                        $unit_count = $report['e_units'][$unit_index] ?? 0;
                                                                        if ($unit_count > 0):
                                                                            ?>
                                                                            <th style="text-align: center;">
                                                                                <img src="graphic/unit/unit_<?= $uname ?>.png">
                                                                            </th>
                                                                            <?php
                                                                        endif;
                                                                        $unit_index++;
                                                                    endforeach;
                                                                    ?>
                                                                </tr>
                                                                <tr>
                                                                    <?php
                                                                    $unit_index = 0;
                                                                    foreach ($units as $uname => $ulabel):
                                                                        $unit_count = $report['e_units'][$unit_index] ?? 0;
                                                                        if ($unit_count > 0):
                                                                            ?>
                                                                            <td style="text-align: center;"><?= $unit_count ?></td>
                                                                            <?php
                                                                        endif;
                                                                        $unit_index++;
                                                                    endforeach;
                                                                    ?>
                                                                </tr>
                                                            </table>
                                                            <br>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                            </td>
                                        </tr>
                                </table>
                                <br>
                                </tbody>
                    </table>
                <?php elseif ($report['type'] === 'trade'): ?>
                    <?php
                    $tradeData = json_decode((string) $report['hives'], true);
                    if ($tradeData):
                        ?>
                        <table width="100%" style="border: 1px solid #7D510F; margin: 0 auto; background-color: #F4E4BC;">
                            <tr>
                                <td style="padding: 5px;">
                                    <table class="vis" width="100%" cellspacing="0">
                                        <tr>
                                            <th width="20%"><?= __('screens.report.origin') ?></th>
                                            <th width="100%"><a
                                                    href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $report['from_user'] ?>">
                                                    <?= htmlspecialchars($report['from_username'] ?? __('screens.report.unknown')) ?>
                                                </a></th>
                                        </tr>
                                        <tr>
                                            <td><?= __('screens.train.village') ?>:</td>
                                            <td>
                                                <a
                                                    href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $report['from_village'] ?>">
                                                    <?= htmlspecialchars($tradeData['from_village_name'] ?? '') ?>
                                                    (<?= $tradeData['from_x'] ?? 0 ?>|<?= $tradeData['from_y'] ?? 0 ?>)
                                                    K<?= floor(($tradeData['from_y'] ?? 0) / 100) . floor(($tradeData['from_x'] ?? 0) / 100) ?>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr style="height: 20%;">
                                            <td colspan="2"></td>
                                            <td colspan="3"></td>
                                        </tr>
                                        <tr>
                                            <th width="20%"><?= __('screens.report.destination') ?></th>
                                            <th width="100%">
                                                <a
                                                    href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $report['to_user'] ?>">
                                                    <?= htmlspecialchars($report['to_username'] ?? __('screens.report.unknown')) ?>
                                                </a>
                                            </th>

                                        </tr>
                                        <tr>
                                            <td><?= __('screens.train.village') ?>:</td>
                                            <td>
                                                <a
                                                    href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $report['to_village'] ?>">
                                                    <?= htmlspecialchars($tradeData['to_village_name'] ?? '') ?>
                                                    (<?= $tradeData['to_x'] ?? 0 ?>|<?= $tradeData['to_y'] ?? 0 ?>)
                                                    K<?= floor(($tradeData['to_y'] ?? 0) / 100) . floor(($tradeData['to_x'] ?? 0) / 100) ?>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>

                                    <h4 style="margin-top: 15px; margin-bottom: 5px;"><?= __('screens.train.resources') ?>:</h4>
                                    <table class="vis" width="100%">
                                        <tr>
                                            <td style="padding: 5px;">
                                                <?php if (($tradeData['wood'] ?? 0) > 0): ?>
                                                    <span class="icon header wood"></span> <?= number_format($tradeData['wood']) ?>
                                                <?php endif; ?>
                                                <?php if (($tradeData['stone'] ?? 0) > 0): ?>
                                                    <span class="icon header stone"></span> <?= number_format($tradeData['stone']) ?>
                                                <?php endif; ?>
                                                <?php if (($tradeData['iron'] ?? 0) > 0): ?>
                                                    <span class="icon header iron"></span> <?= number_format($tradeData['iron']) ?>
                                                <?php endif; ?>
                                                <?php if (empty($tradeData['wood']) && empty($tradeData['stone']) && empty($tradeData['iron'])): ?>
                                                    0
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    <?php else: ?>
                        <p align="center"><?= __('screens.report.no_reports_available') ?></p>
                    <?php endif; ?>
                    <br>
                <?php elseif ($report['type'] === 'attack'): ?>
                    <table width="462" style="border: 1px solid #7D510F; margin: 0 auto;">
                        <tr>
                            <td style="padding:0;">
                                <h3 style="text-align: center; margin: 10px 0; color: #7D510F;">
                                    <?= ($report['wins'] === 'att') ? __('screens.report.attacker_won') : __('screens.report.defender_won') ?>
                                </h3>

                                <?php
                                // Determine if we're using a CSS class or direct URL
                                $use_inline_bg = (strpos($report_image_class, '/') !== false);
                                $bg_style = $use_inline_bg
                                    ? "background: url('{$report_image_class}') center center no-repeat; background-size: cover; min-height: 200px;"
                                    : "";
                                $div_class = $use_inline_bg ? "report_image" : "report_image {$report_image_class}";
                                ?>
                                <div class="<?= $div_class ?>"
                                    style="width: 100%; margin: 0; border-top: 1px solid #7D510F; border-bottom: 1px solid #7D510F; <?= $bg_style ?>">
                                    <div class="report_transparent_overlay" style="color: #ffffff;">
                                        <h4 style="color: #ffffff; padding-left: 10px; padding-top: 10px;">
                                            <?= __('screens.report.luck') ?>
                                            (<?= __('screens.report.from_attacker_perspective') ?>)
                                        </h4>

                                        <table id="attack_luck" class="vis"
                                            style="width: 100%; border: none; margin: 0; padding: 0 10px; background: transparent;">
                                            <tr>
                                                <td class="nobg"
                                                    style="width: 50%; text-align: right; vertical-align: middle; padding: 0;">
                                                    <?php if ($report['luck'] < 0): ?>
                                                        <b><?= $report['luck'] ?>%</b>
                                                        <img src="graphic/balken_pech.png"
                                                            style="width: <?= min(100, abs($report['luck']) * 4) ?>%; height: 12px; vertical-align: middle;" />
                                                    <?php endif; ?>
                                                </td>
                                                <td class="nobg" style="width: 0; padding: 0; position: relative;">
                                                    <div style="width: 1px; height: 12px; background: #999; margin: 0 auto;">
                                                    </div>
                                                </td>
                                                <td class="nobg"
                                                    style="width: 50%; text-align: left; vertical-align: middle; padding: 0;">
                                                    <?php if ($report['luck'] >= 0): ?>
                                                        <img src="graphic/balken_glueck.png"
                                                            style="width: <?= min(100, $report['luck'] * 4) ?>%; height: 12px; vertical-align: middle;" />
                                                        <b><?= $report['luck'] ?>%</b>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        </table>

                                        <h4 style="color: #ffffff;"><?= __('screens.report.morale') ?>: <?= $report['moral'] ?>%
                                        </h4>
                                    </div>
                                </div>
                                <div style="padding: 10px;">
                                    <br />

                                    <!-- Attacker -->
                                    <table width="100%" class="vis">
                                        <tr>
                                            <th width="100"><?= __('screens.report.attacker') ?></th>
                                            <th><a
                                                    href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $report['from_user'] ?>"><?= $report['from_username'] ?></a>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td><?= __('screens.report.origin') ?></td>
                                            <td><a
                                                    href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $report['from_village'] ?>"><?= $report['from_villagename'] ?>
                                                    (<?= $report['from_x'] ?>|<?= $report['from_y'] ?>)</a></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding: 0;">
                                                <table class="vis" width="100%" style="border: none; margin: 0;">
                                                    <tr class="center">
                                                        <td width="50"></td>
                                                        <?php foreach ($units as $unitKey => $unitName): ?>
                                                            <td width="35"><img src="graphic/unit/<?= $unitKey ?>.png"
                                                                    title="<?= $unitName ?>" alt="" /></td>
                                                        <?php endforeach; ?>
                                                    <tr class="center">
                                                        <td><?= __('screens.report.quantity') ?></td>
                                                        <?php
                                                        $unit_index = 0;
                                                        foreach ($units as $unitKey => $unitName):
                                                            $count = $report['a_units'][$unit_index] ?? 0;
                                                            $unit_index++;
                                                            ?>
                                                            <td class="<?= $count == 0 ? 'hidden' : '' ?>"><?= $count ?>
                                                            </td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                    <tr class="center">
                                                        <td><?= __('screens.report.losses') ?></td>
                                                        <?php
                                                        $unit_index = 0;
                                                        foreach ($units as $unitKey => $unitName):
                                                            $count = $report['b_units'][$unit_index] ?? 0;
                                                            $unit_index++;
                                                            ?>
                                                            <td class="<?= $count == 0 ? 'hidden' : '' ?>"><?= $count ?>
                                                            </td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><?= __('screens.report.religion_blessed') ?></td>
                                        </tr>
                                    </table>
                                    <br />

                                    <!-- Defender -->
                                    <table width="100%" class="vis">
                                        <tr>
                                            <th width="100"><?= __('screens.report.defender') ?></th>
                                            <th><a
                                                    href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $report['to_user'] ?>"><?= $report['to_username'] ?></a>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td><?= __('screens.report.destination') ?></td>
                                            <td><a
                                                    href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $report['to_village'] ?>"><?= $report['to_villagename'] ?>
                                                    (<?= $report['to_x'] ?>|<?= $report['to_y'] ?>)</a></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding: 0;">
                                                <?php if ($report['see_def_units'] == 1): ?>
                                                    <table class="vis" width="100%" style="border: none; margin: 0;">
                                                        <tr class="center">
                                                            <td></td>
                                                            <?php foreach ($units as $unitKey => $unitName): ?>
                                                                <td width="35"><img src="graphic/unit/<?= $unitKey ?>.png"
                                                                        title="<?= $unitName ?>" alt="" /></td>
                                                            <?php endforeach; ?>
                                                        </tr>
                                                        <tr class="center">
                                                            <td><?= __('screens.report.quantity') ?></td>
                                                            <?php
                                                             $unit_index = 0;
                                                             foreach ($units as $unitKey => $unitName):
                                                                 $count = $report['c_units'][$unit_index] ?? 0;
                                                                 $unit_index++;
                                                                 ?>
                                                                 <td class="<?= $count == 0 ? 'hidden' : '' ?>"><?= $count ?>
                                                                 </td>
                                                             <?php endforeach; ?>
                                                        </tr>
                                                        <tr class="center">
                                                            <td><?= __('screens.report.losses') ?></td>
                                                            <?php
                                                             $unit_index = 0;
                                                             foreach ($units as $unitKey => $unitName):
                                                                 $count = $report['d_units'][$unit_index] ?? 0;
                                                                 $unit_index++;
                                                                 ?>
                                                                 <td class="<?= $count == 0 ? 'hidden' : '' ?>"><?= $count ?>
                                                                 </td>
                                                             <?php endforeach; ?>
                                                        </tr>
                                                    </table>
                                                <?php else: ?>
                                                    <p style="padding: 5px;"><?= __('screens.report.all_troops_died') ?></p>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <?php if (!empty($report['hives']) && count($report['hives']) >= 3 && ($report['hives'][0] > 0 || $report['hives'][1] > 0 || $report['hives'][2] > 0)): ?>
                                                <table class="vis" width="100%">
                                                    <tr>
                                                        <th width="100"><?= __('screens.report.loot') ?></th>
                                                        <td width="220">
                                                            <?php if ($report['hives'][0] > 0): ?><img src="graphic/icons/wood.png"
                                                                    title="<?= __('screens.report.wood') ?>" />
                                                                <?= $report['hives'][0] ?>             <?php endif; ?>
                                                            <?php if ($report['hives'][1] > 0): ?><img src="graphic/icons/stone.png"
                                                                    title="<?= __('screens.report.clay') ?>" />
                                                                <?= $report['hives'][1] ?>             <?php endif; ?>
                                                            <?php if ($report['hives'][2] > 0): ?><img src="graphic/icons/iron.png"
                                                                    title="<?= __('screens.report.iron') ?>" />
                                                                <?= $report['hives'][2] ?>             <?php endif; ?>
                                                        </td>
                                                        <td><?= $report['hives'][3] ?? 0 ?>/<?= $report['hives'][4] ?? 0 ?></td>
                                                    </tr>
                                                    <?php if (isset($report['agreement']) && is_array($report['agreement']) && count($report['agreement']) > 1): ?>
                                                        <tr>
                                                            <th><?= __('screens.report.loyalty_change') ?></th>
                                                            <td colspan="2">
                                                                <?= __('screens.report.loyalty_decreased', ['from' => $report['agreement'][0], 'to' => $report['agreement'][1]]) ?>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </table>
                                            <?php endif; ?>
                                    </table>
                                    <br />


                                    <!-- Ram Damage -->
                                    <?php if (!empty($report['ram'])): ?>
                                        <?php
                                        // Handle both string and array formats
                                        $ram_value = is_array($report['ram']) ? $report['ram'][0] : $report['ram'];
                                        $ram_parts = explode('/', $ram_value);
                                        if (count($ram_parts) == 2 && ($ram_parts[0] != $ram_parts[1])):
                                            ?>
                                            <table class="vis" width="100%">
                                                <tr>
                                                    <th><?= __('screens.report.wall_damage') ?></th>
                                                    <td><?= __('screens.report.wall_damage_msg', ['from' => $ram_parts[0], 'to' => $ram_parts[1]]) ?>
                                                    </td>
                                                </tr>
                                            </table>
                                            <br />
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <!-- Catapult Damage -->
                                    <?php if (!empty($report['catapult'])): ?>
                                        <?php
                                        // Handle both string and array formats
                                        $catapult_value = is_array($report['catapult']) ? $report['catapult'][0] : $report['catapult'];
                                        $catapult_parts = explode('/', $catapult_value);
                                        if (count($catapult_parts) == 2 && ($catapult_parts[0] != $catapult_parts[1])):
                                            ?>
                                            <table class="vis" width="100%">
                                                <tr>
                                                    <th><?= __('screens.report.building_damage') ?></th>
                                                    <td>
                                                        <?php if (!empty($report['budynki'])): ?>
                                                            <?= __('screens.report.building_damage_msg', ['from' => $catapult_parts[0], 'to' => $catapult_parts[1]]) ?>
                                                        <?php else: ?>
                                                            <?= __('screens.report.building_damage_msg', ['from' => $catapult_parts[0], 'to' => $catapult_parts[1]]) ?>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            </table>
                                            <br />
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <!-- Espionage Section (Unified) -->
                                    <?php
                                    // Use visibility flags from controller (matching old engine logic)
                                    $show_spy_section = ($def_out_units_see ?? false) ||
                                        (isset($report['budynki']) && is_array($report['budynki']) && count($report['budynki']) > 1) ||
                                        ($def_out_res_see ?? false);
                                    ?>

                                    <?php if ($show_spy_section): ?>
                                        <h4><?= __('screens.report.espionage') ?></h4>
                                        <table id="attack_spy"
                                            style="border: 1px solid rgb(222, 211, 185); padding: 0px 0px 0px 0px;">
                                            <!-- Resources -->
                                            <?php if ($def_out_res_see): ?>
                                                <tr>
                                                    <th><?= __('screens.report.resources_spied') ?></th>
                                                    <td>
                                                        <?php if (($report['sorowce_poz'][0] ?? 0) > 0): ?>
                                                            <img src="graphic/icons/wood.png" title="<?= __('screens.report.wood') ?>" />
                                                            <?= number_format($report['sorowce_poz'][0]) ?>
                                                        <?php endif; ?>
                                                        <?php if (($report['sorowce_poz'][1] ?? 0) > 0): ?>
                                                            <img src="graphic/icons/stone.png" title="<?= __('screens.report.clay') ?>" />
                                                            <?= number_format($report['sorowce_poz'][1]) ?>
                                                        <?php endif; ?>
                                                        <?php if (($report['sorowce_poz'][2] ?? 0) > 0): ?>
                                                            <img src="graphic/icons/iron.png" title="<?= __('screens.report.iron') ?>" />
                                                            <?= number_format($report['sorowce_poz'][2]) ?>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

                                            <!-- Buildings -->
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
                                                        <th><?= __('screens.report.buildings') ?></th>
                                                        <td>
                                                            <?php
                                                            $building_index = 0;
                                                            foreach ($buildings as $bname => $blabel):
                                                                $level = isset($report['budynki'][$building_index]) ? $report['budynki'][$building_index] : 0;
                                                                if ($level > 0):
                                                                    ?>
                                                                    <?= $blabel ?> <b>(<?= __('screens.common.level') ?>                             <?= $level ?>)</b><br>
                                                                    <?php
                                                                endif;
                                                                $building_index++;
                                                            endforeach;
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <!-- Units Outside Village -->
                                            <?php if ($def_out_units_see): ?>
                                                <tr>
                                                    <th colspan="2"><?= __('screens.report.units_outside') ?></th>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <table class="vis" width="100%">
                                                            <tr class="center">
                                                                <?php foreach ($units as $unit_name => $unit_label): ?>
                                                                    <th width="35">
                                                                        <img src="graphic/unit/<?= $unit_name ?>.png"
                                                                            title="<?= $unit_label ?>" />
                                                                    </th>
                                                                <?php endforeach; ?>
                                                            </tr>
                                                            <tr class="center">
                                                                <?php
                                                                $unit_index = 0;
                                                                foreach ($units as $unit_name => $unit_label):
                                                                    $count = isset($report['f_units'][$unit_index]) ? $report['f_units'][$unit_index] : 0;
                                                                    $unit_index++;
                                                                    ?>
                                                                    <?php if ($count > 0): ?>
                                                                        <td><?= number_format($count) ?></td>
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
                                        <br />
                                    <?php endif; ?>

                                    <!-- Loot -->


                                </div>
                            </td>
                        </tr>
                    </table>

                <?php elseif ($report['type'] === 'supportAttack'): ?>
                    <!-- Support Attack Report -->
                    <table width="100%" style="border: 1px solid #7D510F;" cellspacing="0">
                        <tbody>
                            <tr>
                                <td style="padding: 0;">
                                    <!-- Header with status icon -->
                                    <div style="background-color: #f4e4bc; padding: 10px; border-bottom: 1px solid #7D510F;">
                                        <table width="100%">
                                            <tr>
                                                <td width="40">
                                                    <img src="<?= $report['title_image'] ?>" alt="Status" />
                                                </td>
                                                <td>
                                                    <h3 style="margin: 0;"><?= $report['title'] ?>
                                                    </h3>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Support troops table -->
                                    <div style="padding: 15px;">
                                        <h4><?= __('screens.report.your_support_troops') ?></h4>
                                        <table class="vis" width="100%">
                                            <tbody>
                                                <tr>
                                                    <th width="100"></th>
                                                    <?php foreach ($units as $uname => $ulabel): ?>
                                                        <th style="text-align: center; padding: 2px;">
                                                            <img src="graphic/unit/<?= $uname ?>.png" title="<?= $ulabel ?>" />
                                                        </th>
                                                    <?php endforeach; ?>
                                                </tr>
                                                <tr>
                                                    <td><?= __('screens.report.quantity') ?></td>
                                                    <?php
                                                    $unit_index = 0;
                                                    foreach ($units as $uname => $ulabel):
                                                        $count = isset($report['a_units'][$unit_index]) ? (int) $report['a_units'][$unit_index] : 0;
                                                        ?>
                                                        <td style="text-align: center;"><?= $count ?></td>
                                                        <?php
                                                        $unit_index++;
                                                    endforeach;
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td><?= __('screens.report.losses') ?></td>
                                                    <?php
                                                    $unit_index = 0;
                                                    $total_losses = 0;
                                                    $total_troops = 0;
                                                    foreach ($units as $uname => $ulabel):
                                                        $losses = isset($report['b_units'][$unit_index]) ? (int) $report['b_units'][$unit_index] : 0;
                                                        $troops = isset($report['a_units'][$unit_index]) ? (int) $report['a_units'][$unit_index] : 0;
                                                        $total_losses += $losses;
                                                        $total_troops += $troops;
                                                        ?>
                                                        <td style="text-align: center;"><?= $losses ?></td>
                                                        <?php
                                                        $unit_index++;
                                                    endforeach;
                                                    ?>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <!-- Summary message -->
                                        <div
                                            style="margin-top: 15px; padding: 10px; background-color: #f4e4bc; border: 1px solid #7D510F;">
                                            <?php if ($total_losses == 0): ?>
                                                <strong>✓ <?= __('screens.report.good_news') ?></strong>
                                                <?= __('screens.report.support_no_losses') ?>
                                            <?php elseif ($total_losses >= $total_troops): ?>
                                                <strong>✗ <?= __('screens.report.bad_news') ?></strong>
                                                <?= __('screens.report.support_all_destroyed') ?>
                                            <?php else: ?>
                                                <strong>⚠ <?= __('screens.report.attention') ?></strong>
                                                <?= __('screens.report.support_losses', ['count' => $total_losses]) ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                <?php elseif ($report['type'] === 'support'): ?>
                    <!-- Support Report Content -->
                    <table width="462" style="border: 1px solid #7D510F; margin: 0 auto;">
                        <tr>
                            <td style="padding:0;">
                                <h3 style="padding: 10px; margin: 0;"><?= __('screens.report.support_arrived') ?></h3>

                                <div class="report_image"
                                    style="width: 100%; margin: 0; border-top: 1px solid #7D510F; border-bottom: 1px solid #7D510F; background: url('graphic/reports/support_arrives.jpg') center center no-repeat; background-size: cover; min-height: 150px;">
                                    <div class="report_transparent_overlay" style="padding: 10px;">
                                        <!-- Transparent overlay for readability -->
                                    </div>
                                </div>
                                <div style="padding: 10px;">
                                    <br />

                                    <table width="100%" class="vis">
                                        <tr>
                                            <th width="100"><?= __('screens.report.from') ?></th>
                                            <th><a
                                                    href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $report['from_user'] ?>"><?= $report['from_username'] ?></a>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td><?= __('screens.report.origin') ?></td>
                                            <td><a
                                                    href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $report['from_village'] ?>"><?= $report['from_villagename'] ?>
                                                    (<?= $report['from_x'] ?>|<?= $report['from_y'] ?>)</a></td>
                                        </tr>
                                    </table>
                                    <br />

                                    <table width="100%" class="vis">
                                        <tr>
                                            <th width="100"><?= __('screens.report.to') ?></th>
                                            <th><a
                                                    href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $report['to_user'] ?>"><?= $report['to_username'] ?></a>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td><?= __('screens.report.destination') ?></td>
                                            <td><a
                                                    href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $report['to_village'] ?>"><?= $report['to_villagename'] ?>
                                                    (<?= $report['to_x'] ?>|<?= $report['to_y'] ?>)</a></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding: 0;">
                                                <table class="vis" width="100%" style="border: none; margin: 0;">
                                                    <tr class="center">
                                                        <td></td>
                                                        <?php foreach ($units as $unitKey => $unitName): ?>
                                                            <td width="35"><img src="graphic/unit/<?= $unitKey ?>.png"
                                                                    title="<?= $unitName ?>" alt="" /></td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                    <tr class="center">
                                                        <td><?= __('screens.report.quantity') ?></td>
                                                        <?php
                                                         $unit_index = 0;
                                                         foreach ($units as $unitKey => $unitName):
                                                             $count = $report['a_units'][$unit_index] ?? 0;
                                                             $unit_index++;
                                                             ?>
                                                             <td class="<?= $count == 0 ? 'hidden' : '' ?>">
                                                                 <?= $count ?>
                                                             </td>
                                                         <?php endforeach; ?>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </td>
                        </tr>
                    </table>

                <?php elseif ($report['type'] === 'support_back'): ?>
                    <!-- Support Withdrawal Report Content -->
                    <table width="462" style="border: 1px solid #7D510F; margin: 0 auto;">
                        <tr>
                            <td style="padding:0;">
                                <h3 style="padding: 10px; margin: 0;"><?= __('screens.report.support_withdrawn') ?></h3>

                                <div class="report_image"
                                    style="width: 100%; margin: 0; border-top: 1px solid #7D510F; border-bottom: 1px solid #7D510F; background: url('graphic/reports/support_arrives.jpg') center center no-repeat; background-size: cover; min-height: 150px;">
                                    <div class="report_transparent_overlay" style="padding: 10px;">
                                        <!-- Transparent overlay for readability -->
                                    </div>
                                </div>
                                <div style="padding: 10px;">
                                    <br />

                                    <table width="100%" class="vis">
                                        <tr>
                                            <th width="100"><?= __('screens.report.sender') ?></th>
                                            <th><a
                                                    href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $report['from_user'] ?>"><?= htmlspecialchars($report['from_username'] ?? __('screens.report.unknown')) ?></a>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td><?= __('screens.report.origin') ?></td>
                                            <td><a
                                                    href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $report['from_village'] ?>"><?= htmlspecialchars($report['from_villagename'] ?? '') ?>
                                                    (<?= $report['from_x'] ?? 0 ?>|<?= $report['from_y'] ?? 0 ?>)</a></td>
                                        </tr>
                                    </table>
                                    <br />

                                    <table width="100%" class="vis">
                                        <tr>
                                            <th width="100"><?= __('screens.report.recipient') ?></th>
                                            <th><a
                                                    href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $report['to_user'] ?>"><?= htmlspecialchars($report['to_username'] ?? __('screens.report.unknown')) ?></a>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td><?= __('screens.report.destination') ?></td>
                                            <td><a
                                                    href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $report['to_village'] ?>"><?= htmlspecialchars($report['to_villagename'] ?? '') ?>
                                                    (<?= $report['to_x'] ?? 0 ?>|<?= $report['to_y'] ?? 0 ?>)</a></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding: 0;">
                                                <table class="vis" width="100%" style="border: none; margin: 0;">
                                                    <tr class="center">
                                                        <td></td>
                                                        <?php foreach ($units as $unitKey => $unitName): ?>
                                                            <td width="35"><img src="graphic/unit/<?= $unitKey ?>.png"
                                                                    title="<?= $unitName ?>" alt="" /></td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                    <tr class="center">
                                                        <td><?= __('screens.report.quantity') ?></td>
                                                        <?php
                                                         $unit_index = 0;
                                                         foreach ($units as $unitKey => $unitName):
                                                             $count = $report['a_units'][$unit_index] ?? 0;
                                                             $unit_index++;
                                                             ?>
                                                             <td class="<?= $count == 0 ? 'hidden' : '' ?>">
                                                                 <?= $count ?>
                                                             </td>
                                                         <?php endforeach; ?>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </td>
                        </tr>
                    </table>

                <?php elseif ($report['type'] === 'get_award'): ?>
                    <div class="content-border" style="max-width: 100%; margin: 0 auto;">
                        <div style="background: #F4E4BC; border: 2px solid #DED3B9; padding: 10px; padding-bottom: 25px;">
                            <?php
                            $awardData = json_decode((string) $report['hives'], true);
                            if ($awardData && isset($awardData['award_title'])) {
                                $levelName = __('screens.common.award_level_' . $awardData['level']);
                                $title = __($awardData['award_title']);
                                $text = __($awardData['award_text'], ['count' => $awardData['count']]);
                                $userid = $report['receiver_userid'];
                                $viewMedalsText = __('screens.awards.view_medals');
                                $levelStr = __('screens.common.level');

                                echo "<h3>{$title} ({$levelName} - {$levelStr} {$awardData['level']})</h3>";
                                echo "<div class=\"award level{$awardData['level']}\" style=\"float: left; margin-right: 10px;\">";
                                echo "<img src=\"graphic/awards/{$awardData['award_name']}.png\" alt=\"\"></div>";
                                echo "<p>{$text}</p>";
                                echo "<p><a href=\"game.php?village=[akuvillage]&amp;screen=profile&mode=awards{$userid}\">{$viewMedalsText}</a></p>";
                            } else {
                                echo $report['hives'];
                            }
                            ?>
                        </div>
                    </div>

                <?php elseif ($report['type'] === 'pala_find_item'): ?>
                    <?php
                    // Get item details
                    $itemKey = $report['hives'];
                    $itemName = $itemKey;
                    $bonuses = \App\Config\PaladinConfig::getBonuses();
                    if (isset($bonuses[$itemKey])) {
                        $itemName = $bonuses[$itemKey][2];
                    }
                    ?>
                    <table width="100%">
                        <tr>
                            <td style="padding: 10px; text-align: center;">
                                <p><?= __('screens.report.paladin_found_item') ?></p>
                                <img src="graphic/inventory/<?= $itemKey ?>.png" alt="<?= $itemName ?>" /><br>
                                <h3><?= $itemName ?></h3>
                            </td>
                        </tr>
                    </table>

                <?php else: ?>
                    <!-- Generic Report -->
                    <div class="report-message"><?= nl2br(htmlspecialchars($report['message'] ?? '')) ?></div>
                <?php endif; ?>

                <table align="center" class="vis" width="100%">
                    <tr>
                        <td align="center" width="20%">
                            <a
                                href="game.php?village=<?= $village['id'] ?>&screen=report&mode=<?= $mode ?>&action=del_one&id=<?= $report['id'] ?>&h=<?= $hkey ?>"><?= __('screens.report.delete') ?></a>
                        </td>
                    </tr>
                </table>
                <br>
                <a
                    href="game.php?village=<?= $village['id'] ?>&screen=report&mode=<?= $mode ?>"><?= __('screens.report.back') ?></a>
            </td>
        </tr>
    </table>

<?php else: ?>
    <!-- Report List -->
    <form action="game.php?village=<?= $village['id'] ?>&screen=report&mode=<?= $mode ?>&action=del_arch&h=<?= $hkey ?>"
        method="post">
        <table class="vis" width="100%">
            <?php if ($totalPages > 1): ?>
                <tr>
                    <td align="center" colspan="2">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <?php if ($page == $i): ?>
                                <strong> &gt;<?= $i ?>&lt; </strong>
                            <?php else: ?>
                                <a href="game.php?village=<?= $village['id'] ?>&screen=report&mode=<?= $mode ?>&page=<?= $i ?>">
                                    [<?= $i ?>] </a>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </td>
                </tr>
            <?php endif; ?>

            <tr>
                <th><?= __('screens.report.subject') ?></th>
                <th width="140"><?= __('screens.report.received') ?></th>
            </tr>

            <?php if (empty($reports)): ?>
                <tr>
                    <td colspan="2" align="center"><?= __('screens.report.no_reports_available') ?></td>
                </tr>
            <?php else: ?>
                <?php foreach ($reports as $r): ?>
                    <tr>
                        <td>
                            <input name="id_<?= $r['id'] ?>" type="checkbox" />
                            <a href="game.php?village=<?= $village['id'] ?>&screen=report&mode=<?= $mode ?>&view=<?= $r['id'] ?>">
                                <?php
                                // Detect report type and determine icon
                                $icon = '0.png'; // Default
                                $is_direct_path = false; // Reset direct path flag for each item
                    
                                // Check if this is a support report
                                if (isset($r['type']) && $r['type'] === 'support') {
                                    $icon = 'brown.png';
                                }
                                // Check if this is a trade report
                                elseif (isset($r['type']) && $r['type'] === 'trade') {
                                    $icon = 'graphic/command/report_trade.webp';
                                    $is_direct_path = true;
                                }
                                // Check if target is ally member (grey dot - cannot attack)
                                elseif (
                                    isset($r['to_ally']) && isset($r['from_ally']) &&
                                    $r['to_ally'] > 0 && $r['to_ally'] == $r['from_ally']
                                ) {
                                    $icon = 'grey.png';
                                }
                                // Check if this is a spy or attack report
                                elseif (isset($r['type']) && ($r['type'] === 'attack' || $r['type'] === 'spy')) {
                                    $units_array = is_string($r['a_units']) ? explode(';', $r['a_units']) : $r['a_units'];
                                    $total_units = array_sum($units_array);
                                    $spy_count = isset($units_array[4]) ? $units_array[4] : 0; // unit_spy is index 4
                                    $is_spy_only = ($total_units == $spy_count && $spy_count > 0);

                                    // Check if there were casualties
                                    $has_casualties = false;
                                    if (isset($r['b_units'])) {
                                        $losses_array = is_string($r['b_units']) ? explode(';', $r['b_units']) : $r['b_units'];
                                        $has_casualties = array_sum($losses_array) > 0;
                                    }

                                    // Check if spy mission succeeded (got information)
                                    $spy_success = false;
                                    if (isset($r['budynki']) || isset($r['sorowce_poz'])) {
                                        $buildings = is_string($r['budynki']) ? explode(';', $r['budynki']) : ($r['budynki'] ?? []);
                                        $resources = is_string($r['sorowce_poz']) ? explode(';', $r['sorowce_poz']) : ($r['sorowce_poz'] ?? []);
                                        $spy_success = (is_array($buildings) && array_sum($buildings) > 0) ||
                                            (is_array($resources) && array_sum($resources) > 0);
                                    }

                                    if ($is_spy_only) {
                                        // Pure spy report
                                        if ($has_casualties && $spy_success) {
                                            // Spy report with casualties but got info
                                            $icon = 'red_yellow@2x.webp';
                                        } elseif (!$spy_success) {
                                            // Failed spy mission (lost spies, no info)
                                            $icon = 'red_blue@2x.webp';
                                        } else {
                                            // Successful spy mission, no casualties
                                            $icon = 'blue.png';
                                        }
                                    } else {
                                        // Attack + spy report (or regular attack)
                                        if ($has_casualties && $spy_success) {
                                            // Attack with spy info and casualties
                                            $icon = 'red_yellow@2x.webp';
                                        } elseif ($spy_success) {
                                            // Attack with spy info, no casualties - still use blue for spy component
                                            $icon = 'blue.png';
                                        } else {
                                            // Regular attack icon (based on loot)
                                            $icon = '0.png';
                                            if (isset($r['hives'])) {
                                                $hives = explode(';', $r['hives']);
                                                if (array_sum(array_slice($hives, 0, 3)) > 0)
                                                    $icon = '1.png';
                                            }
                                        }
                                    }
                                } elseif ($r['type'] === 'get_award') {
                                    $icon = 'graphic/awards/dummy.png'; // default fallback
                                    $is_direct_path = true;
                                    if (isset($r['hives'])) {
                                        $awardData = json_decode((string) $r['hives'], true);
                                        if ($awardData && isset($awardData['award_name'])) {
                                            $icon = 'graphic/awards/' . $awardData['award_name'] . '_mini.png';
                                        } elseif (strpos($r['hives'], 'graphic/awards/') !== false) {
                                            // Handle legacy HTML strings by regexing the image src
                                            if (preg_match('/src="\/graphic\/awards\/([^\.]+)\.png"/', $r['hives'], $matches)) {
                                                $icon = 'graphic/awards/' . $matches[1] . '_mini.png';
                                            }
                                        }
                                    }
                                    $is_direct_path = true;
                                } else {
                                    // Default icon logic (green/yellow based on loot)
                                    if (isset($r['hives'])) {
                                        $hives = explode(';', $r['hives']);
                                        if (array_sum(array_slice($hives, 0, 3)) > 0)
                                            $icon = '1.png';
                                    }
                                }

                                if (!empty($r['title_image'])) {
                                    echo '<img src="' . $r['title_image'] . '"> ';
                                } elseif (isset($is_direct_path) && $is_direct_path) {
                                    echo '<img src="' . $icon . '" width="15" /> ';
                                } else {
                                    echo '<img src="graphic/max_loot/' . $icon . '" width="15" /> ';
                                }
                                ?>
                                <?php if ($r['is_new']): ?>
                                    <span class="icon header new_report"></span>
                                <?php endif; ?>
                                <?= $r['title'] ?>
                            </a>
                            <?php if ($r['is_new']): ?>
                                <span class="new_report_label" style="display:none">(<?= __('screens.report.new_report') ?>)</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d/m/Y H:i', $r['time']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>

            <tr>
                <th><input name="all" type="checkbox" onclick="selectAll(this.form, this.checked)" />
                    <?= __('screens.report.mark_all') ?> </th>
                <th></th>
            </tr>
        </table>
        <table class="vis" align="left">
            <tr>
                <td><input type="submit" class="btn btn-cancel" value="<?= __('screens.report.delete_btn_standalone') ?>"
                        name="del" /></td>
                <td>&nbsp;</td>
                <td>
                    <a href="game.php?village=<?= $village['id'] ?>&screen=report&mode=<?= $mode ?>&action=del_all"
                       class="btn btn-cancel"
                       id="report_delete_all_btn"
                       onclick="return confirm('<?= addslashes(__('screens.report.delete_all_confirm') ?: 'Tens a certeza que queres apagar TODOS os relatórios desta categoria? Esta ação não pode ser desfeita.') ?>')">
                        <?= __('screens.report.delete_all_btn') ?: '🗑 Apagar Tudo' ?>
                    </a>
                </td>
            </tr>
        </table>
    </form>
<?php if (isset($_GET['deleted'])): ?>
    <p style="color: green; font-weight: bold; margin-top: 8px;">
        <?= __('screens.report.delete_all_success') ?: 'Todos os relatórios foram apagados com sucesso.' ?>
    </p>
<?php endif; ?>
<?php endif; ?>
</td>
</tr>
</table>

<script>
    function selectAll(form, checked) {
        var inputs = form.getElementsByTagName("input");
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].type == "checkbox" && inputs[i].name.indexOf("id_") == 0) {
                inputs[i].checked = checked;
            }
        }
    }
</script>
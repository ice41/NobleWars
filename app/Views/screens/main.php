<?php
// Helper functions
if (!function_exists('format_number')) {
    function format_number($number)
    {
        return number_format($number, 0, '.', '.');
    }
}

if (!function_exists('format_time')) {
    function format_time($seconds)
    {
        $seconds = (int) $seconds;
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;
        return sprintf("%02d:%02d:%02d", $hours, $minutes, $secs);
    }
}

$dbname = 'main';
$lvl = $village[$dbname] ?? 0;
$max = $cl_builds->get_maxstage($dbname);

// Helper to determine building image suffix (1, 2, or 3)
if (!function_exists('get_building_suffix')) {
    function get_building_suffix($lvl, $max) {
        if ($max <= 1) return 1;
        if ($max <= 3) return max(1, min((int)$lvl, (int)$max));
        $prc = $lvl / $max;
        if ($prc > 0.5) return 3;
        if ($prc > 0.2) return 2;
        return 1;
    }
}
$suffix = get_building_suffix($lvl, $max);
?>

<table>
    <tr>
        <td>
            <img src="graphic/big_buildings/<?= $dbname ?><?= $suffix ?>.webp" title="<?= $cl_builds->get_name($dbname) ?>" alt="" />
        </td>
        <td>
            <h2><?= $cl_builds->get_name($dbname) ?>
                (<?php if (($village[$dbname] ?? 0) > 0): ?><?= __('screens.main.level') ?>
                    <?= $village[$dbname] ?><?php else: ?><?= __('screens.main.not_built') ?><?php endif; ?>)
            </h2>
            <?= $cl_builds->get_description_bydbname($dbname) ?>
        </td>
    </tr>
</table>
<br />

<?php if ($display_modes): ?>
    <table class="vis modemenu">
        <tbody>
            <tr>
                <?php foreach ($modes as $modename => $modephp): ?>
                    <?php if ($modephp == $mode): ?>
                        <td class="selected" width="100"><a
                                href="game.php?village=<?= $village['id'] ?>&amp;screen=main&amp;mode=<?= $modephp ?>"><?= $modename ?>
                            </a></td>
                    <?php else: ?>
                        <td width="100"><a
                                href="game.php?village=<?= $village['id'] ?>&amp;screen=main&amp;mode=<?= $modephp ?>"><?= $modename ?>
                            </a></td>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table>
<?php endif; ?>

<?php if ($mode == 'build'): ?>

    <?php /* BUILD QUEUE */ ?>
    <?php if ($num_do_build > 0): ?>
        <table class="vis">
            <tbody class="ui-sortable" id="buildqueue">
                <tr>
                    <th style="width: 23%"><?= __('screens.main.build_command') ?></th>
                    <th><?= __('screens.main.duration') ?></th>
                    <th><?= __('screens.main.complete') ?></th>
                    <th style="width: 15%"><?= __('screens.main.cancel') ?></th>
                    <th style="background:none !important;"></th>
                </tr>
                <?php foreach ($do_build as $id => $item): ?>
                    <?php 
                        $buildname = $item['build']; 
                        $stage = $item['stage'];
                        $max = $cl_builds->get_maxstage($buildname);
                        $suffix = get_building_suffix($stage, $max);
                    ?>
                    <tr class="lit nodrag buildorder_wood">
                        <td class="lit-item">
                            <img src="graphic/buildings/mid/<?= $buildname ?><?= $suffix ?>.webp" title="<?= $cl_builds->get_name($buildname) ?>"
                                style="float: left; margin-right: 8px" alt="">
                            <?= $cl_builds->get_name($buildname) ?> <br> <?= __('screens.main.level') ?>             <?= $item['stage'] ?>
                        </td>
                        <td class="nowrap lit-item">
                            <?php if ($id == 0): ?>
                                <span class="timer"><?= format_time($item['dauer']) ?></span>
                            <?php else: ?>
                                <?= format_time($item['dauer']) ?>
                            <?php endif; ?>
                        </td>
                        <td class="lit-item"><?= date('d.m.Y H:i:s', $item['finished']) ?></td>
                        <td class="lit-item">
                            <a class="btn btn-cancel"
                                href="game.php?village=<?= $village['id'] ?>&amp;screen=main&amp;action=cancel&amp;id=<?= $item['r_id'] ?>&amp;mode=build&amp;h=<?= $hkey ?>"><?= __('screens.main.cancel') ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

            <?php /* ADDITIONAL COSTS */ ?>
            <?php if ($num_do_build > 2): ?>
                <tr>
                    <td colspan="4">
                        <?= __('screens.main.additional_costs') ?>
                        <b><?= $cl_builds->get_buildsharpens_costs($num_do_build) ?>%</b><br />
                        <small><?= __('screens.main.additional_costs_note') ?></small>
                    </td>
                </tr>
            <?php endif; ?>
        </table>
        <br />
    <?php endif; ?>

    <?php /* DESTROY QUEUE */ ?>
    <?php if ($num_do_destory > 0): ?>
        <table class="vis">
            <tbody class="ui-sortable" id="buildqueue">
                <tr>
                    <th width="250">
                        <?= __('screens.main.demolish_command') ?>
                    </th>
                    <th width="100">
                        <?= __('screens.main.duration') ?>
                    </th>
                    <th width="150">
                        <?= __('screens.main.complete') ?>
                    </th>
                    <th><?= __('screens.main.cancel') ?></th>
                </tr>
                <?php foreach ($do_destory as $id => $item): ?>
                    <?php $buildname = $item['build']; ?>
                    <?php if ($id == 0): ?>
                        <tr class="lit">
                        <?php else: ?>
                        <tr>
                        <?php endif; ?>
                        <td><?= $cl_builds->get_name($buildname) ?> (<?= __('screens.main.demolish_level') ?>)</td>
                        <?php if ($id == 0): ?>
                            <?php if ($item['finished'] < $time): ?>
                                <td><?= format_time($item['dauer']) ?></td>
                            <?php else: ?>
                                <td><span class="timer"><?= format_time($item['dauer']) ?></span></td>
                            <?php endif; ?>
                        <?php else: ?>
                            <td><?= format_time($item['dauer']) ?></td>
                        <?php endif; ?>
                        <td><?= date('d.m.Y H:i:s', $item['finished']) ?></td>
                        <td>
                            <a href="game.php?village=<?= $village['id'] ?>&amp;screen=main&mode=build&amp;action=cancel_dest&amp;id=<?= $item['r_id'] ?>&amp;h=<?= $hkey ?>"
                                class="btn btn-cancel"><?= __('screens.main.cancel') ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br />
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <font class="error"><?= $error ?></font>
    <?php endif; ?>

    <script type="text/javascript">
        //<![[CDATA[
        var BuildingMain = {};
        $(document).ready(function () {
            BuildingMain.upgrade_building_link = 'game.php?village=<?= $village['id'] ?>&akcja=build&screen=main&h=<?= $hkey ?>';
            BuildingMain.downgrade_building_link = 'game.php?village=<?= $village['id'] ?>&akcja=d_build&screen=main&h=<?= $hkey ?>';
            BuildingMain.confirm_queue = false;
            BuildingMain.mode = 0;
            $('.inactive img').fadeTo(0, .5);
        });
        //]]>
    </script>

    <form name="building" action="game.php?village=<?= $village['id'] ?>&screen=main&action=build&h=<?= $hkey ?>"
        method="POST">
        <div id="building_wrapper">
            <input name="id" value="-1" type="hidden" />

            <table id="buildings" class="vis nowrap" style="width: 100%; line-height: 17px">
                <tbody>
                    <tr>
                        <th style="width: 23%"><?= __('screens.main.buildings') ?></th>
                        <th colspan="5"><?= __('screens.main.requirements') ?></th>
                        <th style="width: 30%"><?= __('screens.main.build') ?></th>
                    </tr>
                    <?php foreach ($fulfilled_builds as $id => $dbname): ?>
                        <tr id="main_buildrow_<?= $dbname ?>">
                            <td style="text-align: left">
                                <?php
                                    $lvl = $village[$dbname] ?? 0;
                                    $max = $cl_builds->get_maxstage($dbname);
                                    $suffix = get_building_suffix($lvl, $max);
                                ?>
                                <a href="game.php?village=<?= $village['id'] ?>&amp;screen=<?= $dbname ?><?= $dbname === 'market' ? '&amp;mode=other_offer' : '' ?>"><img
                                        src="graphic/buildings/mid/<?= $dbname ?><?= $suffix ?>.webp"
                                        title="<?= $cl_builds->get_name($dbname) ?>" style="float: left; margin-right: 8px"
                                        alt=""></a>
                                <a
                                    href="game.php?village=<?= $village['id'] ?>&amp;screen=<?= $dbname ?><?= $dbname === 'market' ? '&amp;mode=other_offer' : '' ?>"><?= $cl_builds->get_name($dbname) ?></a><br>
                                <?php if (($village[$dbname] ?? 0) > 0): ?>             <?= __('screens.main.level') ?>
                                    <?= $village[$dbname] ?>         <?php else: ?>             <?= __('screens.main.not_built') ?>         <?php endif; ?>
                            </td>
                            <?php if ($cl_builds->get_maxstage($dbname) <= ($build_village[$dbname] ?? 0)): ?>
                                <td colspan="7" align="center" class="inactive">
                                    <?= __('screens.main.building_fully_developed') ?>
                                </td>
                            <?php else: ?>
                                <td><span class="icon header wood">
                                    </span><?php if ($cl_builds->get_wood($dbname, ($build_village[$dbname] ?? 0) + 1) > ($village['r_wood'] ?? 0)): ?>
                                        <font color="red">
                                            <?= format_number($cl_builds->get_wood($dbname, ($build_village[$dbname] ?? 0) + 1)) ?>
                                        </font>
                                    <?php else: ?>
                                        <?= format_number($cl_builds->get_wood($dbname, ($build_village[$dbname] ?? 0) + 1)) ?>
                                    <?php endif; ?>
                                </td>
                                <td><span class="icon header stone">
                                    </span><?php if ($cl_builds->get_stone($dbname, ($build_village[$dbname] ?? 0) + 1) > ($village['r_stone'] ?? 0)): ?>
                                        <font color="red">
                                            <?= format_number($cl_builds->get_stone($dbname, ($build_village[$dbname] ?? 0) + 1)) ?>
                                        </font>
                                    <?php else: ?>
                                        <?= format_number($cl_builds->get_stone($dbname, ($build_village[$dbname] ?? 0) + 1)) ?>
                                    <?php endif; ?>
                                </td>
                                <td><span class="icon header iron">
                                    </span><?php if ($cl_builds->get_iron($dbname, ($build_village[$dbname] ?? 0) + 1) > ($village['r_iron'] ?? 0)): ?>
                                        <font color="red">
                                            <?= format_number($cl_builds->get_iron($dbname, ($build_village[$dbname] ?? 0) + 1)) ?>
                                        </font>
                                    <?php else: ?>
                                        <?= format_number($cl_builds->get_iron($dbname, ($build_village[$dbname] ?? 0) + 1)) ?>
                                    <?php endif; ?>
                                </td>
                                <td><span
                                        class="icon header time"></span><?= format_time($cl_builds->get_time($village['main'], $dbname, ($build_village[$dbname] ?? 0) + 1, $village['userid'], $village['id'])) ?>
                                </td>
                                <td><span class="icon header population">
                                    </span><?php if ($cl_builds->get_bh($dbname, ($build_village[$dbname] ?? 0) + 1) > 0): ?><?php if ($cl_builds->get_bh($dbname, ($build_village[$dbname] ?? 0) + 1) > ($max_bh - ($village['r_bh'] ?? 0))): ?>
                                            <font color="red"><?= $cl_builds->get_bh($dbname, ($build_village[$dbname] ?? 0) + 1) ?></font>
                                        <?php else: ?>                     <?= $cl_builds->get_bh($dbname, ($build_village[$dbname] ?? 0) + 1) ?>
                                        <?php endif; ?>             <?php endif; ?>
                                </td>

                                <?php if (($can_build[$dbname] ?? '') == 'not_enough_ress'): ?>
                                    <td class="inactive"><span><?= __('screens.main.resources_available_at') ?> <span
                                                class="timer_replace"><?= $res_timer[$dbname] ?? '' ?></span></span><span
                                             style="display:none">
                                            <?php if (($build_village[$dbname] ?? 0) < 1): ?>
                                                <a class="btn btn-build" id="main_buildlink_<?= $dbname ?>" href="#"
                                                    onclick="insertUnit(document.forms['building'].id,'<?= $dbname ?>');document.forms['building'].submit();"><?= __('screens.main.build_action') ?></a>
                                            <?php else: ?>
                                                <a class="btn btn-build" id="main_buildlink_<?= $dbname ?>" href="#building"
                                                    onclick="insertUnit(document.forms['building'].id,'<?= $dbname ?>');document.forms['building'].submit();"><?= __('screens.main.level') ?> <?= ($build_village[$dbname] ?? 0) + 1 ?></a>
                                            <?php endif; ?>
                                        </span>
                                    <?php elseif (($can_build[$dbname] ?? '') == 'not_enough_ress_plus'): ?>
                                    <td class="inactive"><?= __('screens.main.not_enough_space_storage') ?>
                                    <?php elseif (($can_build[$dbname] ?? '') == 'not_fulfilled'): ?>
                                    <td class="inactive"><?= __('screens.main.not_fulfilled') ?: 'Não atende aos requisitos deste edifício!' ?></td>
                                    <?php elseif (($can_build[$dbname] ?? '') == 'not_enough_bh'): ?>
                                    <td class="inactive"><?= __('screens.main.not_enough_space_farm') ?>
                                    <?php elseif (($can_build[$dbname] ?? '') == 'not_enough_storage'): ?>
                                    <td class="inactive"><?= __('screens.main.not_enough_space_storage') ?>
                                    <?php else: ?>
                                        <?php if (($build_village[$dbname] ?? 0) < 1): ?>
                                        <td><a class="btn btn-build" id="main_buildlink_<?= $dbname ?>" href="#"
                                                onclick="insertUnit(document.forms['building'].id,'<?= $dbname ?>');document.forms['building'].submit();"><?= __('screens.main.build_action') ?></a>
                                        <?php else: ?>
                                        <td><a class="btn btn-build" id="main_buildlink_<?= $dbname ?>" href="#building"
                                                onclick="insertUnit(document.forms['building'].id,'<?= $dbname ?>');document.forms['building'].submit();"><?= __('screens.main.level') ?>
                                                <?= ($build_village[$dbname] ?? 0) + 1 ?></a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <br>

        <table style="margin: 0pt; padding: 0pt;" width="100%" class="vis">
            <tbody>
                <tr>
                    <th colspan="2"><?= __('screens.main.village_construction_process') ?></th>
                </tr>
                <tr>
                    <td style="padding: 4px;">
                        <div class="progress-bar" style="height: 18px; border: 1px solid #804000; background: #e0d0b0; position: relative; width: 100%;">
                            <div style="width: <?= $village_build_process ?>%; height: 100%; background-color: #804000;"></div>
                            <span style="position: absolute; width: 100%; text-align: center; top: 0; left: 0; line-height: 18px; font-weight: bold; color: <?= $village_build_process > 50 ? '#fff' : '#000' ?>;"><?= $village_build_process ?>%</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <br>
    </form>

    <form action="game.php?village=<?= $village['id'] ?>&amp;screen=main&amp;action=change_name&amp;h=<?= $hkey ?>"
        method="post">
        <table class="vis" width="300">
            <tr>
                <th colspan="3"><?= __('screens.main.rename_village') ?></th>
            </tr>
            <tr>
                <td><input type="text" name="name" value="<?= htmlspecialchars($village['name']) ?>"></td>
                <td><input type="submit" value="<?= __('screens.main.change') ?>" class="btn btn-default">
            </tr>
        </table>
    </form>

<?php endif; ?>

<?php if ($mode == 'destroy'): ?>
    <?php /* BUILD QUEUE IN DESTROY MODE */ ?>
    <?php if ($num_do_build > 0): ?>
        <table class="vis">
            <tr>
                <th width="250"><?= __('screens.main.build_command') ?></th>
                <th width="100"><?= __('screens.main.duration') ?></th>
                <th width="150"><?= __('screens.main.complete') ?></th>
                <th><?= __('screens.main.cancel') ?></th>
            </tr>
            <?php foreach ($do_build as $id => $item): ?>
                <?php $buildname = $item['build']; ?>
                <?php if ($id == 0): ?>
                    <tr class="lit">
                    <?php else: ?>
                    <tr>
                    <?php endif; ?>
                    <td><?= $cl_builds->get_name($buildname) ?> (<?= __('screens.main.level') ?>             <?= $item['stage'] ?>)</td>
                    <?php if ($id == 0): ?>
                        <?php if ($item['finished'] < $time): ?>
                            <td><?= format_time($item['dauer']) ?></td>
                        <?php else: ?>
                            <td><span class="timer"><?= format_time($item['dauer']) ?></span></td>
                        <?php endif; ?>
                    <?php else: ?>
                        <td><?= format_time($item['dauer']) ?></td>
                    <?php endif; ?>
                    <td><?= date('d.m.Y H:i:s', $item['finished']) ?></td>
                    <td>
                        <a
                            href="javascript:ask('<?= __('screens.main.ask_cancel_build') ?>', 'game.php?village=<?= $village['id'] ?>&amp;screen=main&mode=destroy&amp;action=cancel&amp;id=<?= $item['r_id'] ?>&amp;h=<?= $hkey ?>')"><?= __('screens.main.cancel') ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br />
    <?php endif; ?>

    <?php /* DESTROY QUEUE */ ?>
    <?php if ($num_do_destory > 0): ?>
        <table class="vis">
            <tr>
                <th width="250"><?= __('screens.main.demolish_command') ?></th>
                <th width="100"><?= __('screens.main.duration') ?></th>
                <th width="150"><?= __('screens.main.complete') ?></th>
                <th><?= __('screens.main.cancel') ?></th>
            </tr>
            <?php foreach ($do_destory as $id => $item): ?>
                <?php $buildname = $item['build']; ?>
                <?php if ($id == 0): ?>
                    <tr class="lit">
                    <?php else: ?>
                    <tr>
                    <?php endif; ?>
                    <td><?= $cl_builds->get_name($buildname) ?> (<?= __('screens.main.demolish_level') ?>)</td>
                    <?php if ($id == 0): ?>
                        <?php if ($item['finished'] < $time): ?>
                            <td><?= format_time($item['dauer']) ?></td>
                        <?php else: ?>
                            <td><span class="timer"><?= format_time($item['dauer']) ?></span></td>
                        <?php endif; ?>
                    <?php else: ?>
                        <td><?= format_time($item['dauer']) ?></td>
                    <?php endif; ?>
                    <td><?= date('d.m.Y H:i:s', $item['finished']) ?></td>
                    <td>
                        <a class="btn btn-cancel"
                            href="javascript:ask('<?= __('screens.main.ask_cancel_demolish') ?>', 'game.php?village=<?= $village['id'] ?>&amp;screen=main&mode=destroy&amp;action=cancel_dest&amp;id=<?= $item['r_id'] ?>&amp;h=<?= $hkey ?>')"><?= __('screens.main.cancel') ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br />
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <font class="error"><?= $error ?></font>
    <?php endif; ?>

    <form name="burzenie"
        action="game.php?village=<?= $village['id'] ?>&screen=main&mode=destroy&action=destroy&h=<?= $hkey ?>"
        method="POST">
        <input name="id" value="-1" type="hidden" />

        <table class="vis" width="100%">
            <tr>
                <th><?= __('screens.main.buildings') ?></th>
                <th><?= __('screens.main.demolition_time') ?><br />(hh:mm:ss)</th>
                <th><?= __('screens.main.population') ?></th>
                <th><?= __('screens.main.demolish') ?></th>
            </tr>

            <?php foreach ($fulfilled_builds as $id => $dbname): ?>
                <tr>
                    <td>
                        <?php
                            $lvl = $village[$dbname] ?? 0;
                            $max = $cl_builds->get_maxstage($dbname);
                            $suffix = get_building_suffix($lvl, $max);
                        ?>
                        <a href="game.php?village=<?= $village['id'] ?>&screen=<?= $dbname ?><?= $dbname === 'market' ? '&mode=other_offer' : '' ?>">
                            <img src="graphic/buildings/mid/<?= $dbname ?><?= $suffix ?>.webp">
                            <?= $cl_builds->get_name($dbname) ?>
                        </a>
                        (<?= __('screens.main.level') ?>         <?= $village[$dbname] ?? 0 ?>)
                    </td>

                    <?php if (($village_builds_do_destory[$dbname] ?? 0) <= 0): ?>
                        <td colspan="3" class="inactive"><?= __('screens.main.building_cannot_be_demolished') ?></td>
                    <?php else: ?>
                        <?php if (in_array($dbname, $arr_builds_starts_by_one ?? []) && ($village_builds_do_destory[$dbname] ?? 0) <= 1): ?>
                            <td colspan="3" class="inactive"><?= __('screens.main.building_cannot_be_demolished') ?></td>
                        <?php else: ?>
                            <td><?= format_time($cl_builds->get_time($village['main'], $dbname, $village_builds_do_destory[$dbname] ?? 0, $village['userid'], $village['id'])) ?>
                            </td>
                            <td>
                                <img src="graphic/icons/face.png" title="Aldeão" alt="" />
                                <?= $cl_builds->get_bh($dbname, $village_builds_do_destory[$dbname] ?? 0) ?>
                            </td>
                            <?php if (($counts_do_build[$dbname] ?? 0) > 0): ?>
                                <td class="inactive"><?= __('screens.main.building_already_in_progress') ?></td>
                            <?php else: ?>
                                <td><a class="btn btn-default"
                                        onclick="insertUnit(document.forms['burzenie'].id,'<?= $dbname ?>');document.forms['burzenie'].submit();"><?= __('screens.main.demolish') ?></a>
                                </td>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </form>

    <br>

    <table style="margin: 0pt; padding: 0pt;" width="100%" class="vis">
        <tbody>
            <tr>
                <th colspan="2"><?= __('screens.main.village_construction_process') ?></th>
            </tr>
            <tr>
                <td style="padding: 4px;">
                    <div class="progress-bar" style="height: 18px; border: 1px solid #804000; background: #e0d0b0; position: relative; width: 100%;">
                        <div style="width: <?= $village_build_process ?>%; height: 100%; background-color: #804000;"></div>
                        <span style="position: absolute; width: 100%; text-align: center; top: 0; left: 0; line-height: 18px; font-weight: bold; color: <?= $village_build_process > 50 ? '#fff' : '#000' ?>;"><?= $village_build_process ?>%</span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <br>

    <form
        action="game.php?village=<?= $village['id'] ?>&amp;screen=main&mode=destroy&amp;action=change_name&amp;h=<?= $hkey ?>"
        method="post">
        <table class="vis" width="300">
            <tr>
                <th colspan="3"><?= __('screens.main.rename_village') ?></th>
            </tr>
            <tr>
                <td><input type="text" name="name" value="<?= htmlspecialchars($village['name']) ?>"></td>
                <td><input type="submit" value="<?= __('screens.main.change') ?>">
            </tr>
        </table>
    </form>
<?php endif; ?>

<script type="text/javascript">
    function insertUnit(input, unit) {
        input.value = unit;
    }
</script>
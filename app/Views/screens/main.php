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
    function get_building_suffix($lvl, $max)
    {
        if ($max <= 1)
            return 1;
        if ($max <= 3)
            return max(1, min((int) $lvl, (int) $max));
        $prc = $lvl / $max;
        if ($prc > 0.5)
            return 3;
        if ($prc > 0.2)
            return 2;
        return 1;
    }
}
$suffix = get_building_suffix($lvl, $max);
?>

<table>
    <tr>
        <td>
            <img src="graphic/big_buildings/<?= $dbname ?><?= $suffix ?>.webp"
                title="<?= $cl_builds->get_name($dbname) ?>" alt="" />
        </td>
        <td>
            <h2><?= $cl_builds->get_name($dbname) ?>
                (<?php if (($village[$dbname] ?? 0) > 0): ?><?= __('screens.main.level') ?>
                    <?= $village[$dbname] ?><?php else: ?>     <?= __('screens.main.not_built') ?><?php endif; ?>)
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
                    <th><?= __('screens.main.increase_speed') ?: 'Aumentar a velocidade' ?></th>
                    <th><?= __('screens.main.complete') ?></th>
                    <th style="width: 15%"><?= __('screens.main.cancel') ?></th>
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
                            <img src="graphic/buildings/mid/<?= $buildname ?><?= $suffix ?>.webp"
                                title="<?= $cl_builds->get_name($buildname) ?>" style="float: left; margin-right: 8px" alt="">
                            <?= $cl_builds->get_name($buildname) ?> <br> <?= __('screens.main.level') ?>             <?= $item['stage'] ?>
                        </td>
                        <td class="nowrap lit-item">
                            <?php if ($id == 0): ?>
                                <span class="timer"><?= format_time($item['dauer']) ?></span>
                            <?php else: ?>
                                <?= format_time($item['dauer']) ?>
                            <?php endif; ?>
                        </td>
                        <td class="lit-item" style="text-align: center;">
                            <?php if ($config['premium_enabled'] ?? true): ?>
                                <?php if ($id == 0 && $item['dauer'] <= 180): ?>
                                    <a class="btn btn-confirm-yes"
                                        style="padding: 3px 9px 3px 25px !important; background-image: url('graphic/new/buttons.png?b84b6'), linear-gradient(to bottom, #0bac00 0%, #0e7a1e 100%) !important; background-image: url('graphic/new/buttons.png?b84b6'), -webkit-linear-gradient(top, #0bac00 0%, #0e7a1e 100%) !important; background-image: url('graphic/new/buttons.png?b84b6'), -moz-linear-gradient(top, #0bac00 0%, #0e7a1e 100%) !important; background-position: 3px -49px, 0 0 !important; background-repeat: no-repeat, no-repeat !important; border-color: #006712 !important; color: white !important; text-decoration: none;"
                                        href="game.php?village=<?= $village['id'] ?>&amp;screen=main&amp;action=instant_complete&amp;id=<?= $item['r_id'] ?>&amp;mode=build&amp;h=<?= $hkey ?>">
                                        Completar
                                    </a>
                                <?php else: ?>
                                    <a class="btn btn-btr"
                                        href="game.php?village=<?= $village['id'] ?>&amp;screen=main&amp;action=reduce_time&amp;id=<?= $item['r_id'] ?>&amp;mode=build&amp;h=<?= $hkey ?>"
                                        onclick="return confirm('Desejas reduzir o tempo de construção em 50% por 10 Pontos Premium?');">
                                        Completar
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                        <td class="lit-item"><?= date('d.m.Y H:i:s', $item['finished']) ?></td>
                        <td class="lit-item" style="white-space: nowrap;">
                            <a class="btn btn-cancel"
                                href="game.php?village=<?= $village['id'] ?>&amp;screen=main&amp;action=cancel&amp;id=<?= $item['r_id'] ?>&amp;mode=build&amp;h=<?= $hkey ?>"><?= __('screens.main.cancel') ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

            <?php /* ADDITIONAL COSTS */ ?>
            <?php if ($num_do_build > 2): ?>
                <tr>
                    <td colspan="5">
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

    <style>
        #bcr-tip {
            display: none;
            position: absolute;
            z-index: 9999;
            background: #fff8e7;
            border: 1px solid #9b7b3a;
            border-radius: 4px;
            padding: 7px 10px;
            font-size: 11px;
            color: #333;
            box-shadow: 2px 3px 8px rgba(0, 0, 0, 0.35);
            pointer-events: none;
            white-space: nowrap;
            line-height: 20px;
        }
    </style>
    <script type="text/javascript">
        //<![[CDATA[
        var BuildingMain = {};
        $(document).ready(function () {
            BuildingMain.upgrade_building_link = 'game.php?village=<?= $village['id'] ?>&akcja=build&screen=main&h=<?= $hkey ?>';
            BuildingMain.downgrade_building_link = 'game.php?village=<?= $village['id'] ?>&akcja=d_build&screen=main&h=<?= $hkey ?>';
            BuildingMain.confirm_queue = false;
            BuildingMain.mode = 0;
            $('.inactive img').fadeTo(0, .5);

            // Move tooltip div to body so absolute positioning is relative to document
            if ($('#bcr-tip').length === 0) {
                $('body').append('<div id="bcr-tip"></div>');
            } else {
                $('#bcr-tip').appendTo('body');
            }

            // Tooltip HTML junto ao botão -20%
            $(document).on('mouseenter', '[data-tiphtml]', function () {
                var $el = $(this);
                var offset = $el.offset();
                var html = $el.data('tiphtml');
                $('#bcr-tip').html(html).css({
                    top: (offset.top + $el.outerHeight() + 4) + 'px',
                    left: offset.left + 'px'
                }).show();
            }).on('mouseleave', '[data-tiphtml]', function () {
                $('#bcr-tip').hide();
            });
        });
        //]]>
    </script>

    <form name="building" action="game.php?village=<?= $village['id'] ?>&screen=main&action=build&h=<?= $hkey ?>"
        method="POST">
        <div id="building_wrapper">
            <input name="id" value="-1" type="hidden" />
            <input name="reduce_cost" value="0" type="hidden" />

            <table id="buildings" class="vis nowrap" style="width: 100%; line-height: 17px">
                <tbody>
                    <tr>
                        <th style="width: 23%"><?= __('screens.main.buildings') ?></th>
                        <th colspan="5"><?= __('screens.main.requirements') ?></th>
                        <th style="width: 14%"><?= __('screens.main.build') ?></th>
                        <th style="width: 8%"></th>
                    </tr>
                    <?php foreach ($fulfilled_builds as $id => $dbname): ?>
                        <tr id="main_buildrow_<?= $dbname ?>">
                            <td style="text-align: left">
                                <?php
                                $lvl = $village[$dbname] ?? 0;
                                $max = $cl_builds->get_maxstage($dbname);
                                $suffix = get_building_suffix($lvl, $max);
                                ?>
                                <a
                                    href="game.php?village=<?= $village['id'] ?>&amp;screen=<?= $dbname ?><?= $dbname === 'market' ? '&amp;mode=other_offer' : '' ?>"><img
                                        src="graphic/buildings/mid/<?= $dbname ?><?= $suffix ?>.webp"
                                        title="<?= $cl_builds->get_name($dbname) ?>" style="float: left; margin-right: 8px"
                                        alt=""></a>
                                <a
                                    href="game.php?village=<?= $village['id'] ?>&amp;screen=<?= $dbname ?><?= $dbname === 'market' ? '&amp;mode=other_offer' : '' ?>"><?= $cl_builds->get_name($dbname) ?></a><br>
                                <?php if (($village[$dbname] ?? 0) > 0): ?>             <?= __('screens.main.level') ?>
                                    <?= $village[$dbname] ?>         <?php else: ?>             <?= __('screens.main.not_built') ?>         <?php endif; ?>
                            </td> <?php if ($cl_builds->get_maxstage($dbname) <= ($build_village[$dbname] ?? 0)): ?>
                                <td colspan="8" align="center" class="inactive">
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
                                                    onclick="insertUnit(document.forms['building'].id,'<?= $dbname ?>');document.forms['building'].submit();"><?= __('screens.main.level') ?>
                                                    <?= ($build_village[$dbname] ?? 0) + 1 ?></a>
                                            <?php endif; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if (($can_build[$dbname] ?? '') !== 'not_fulfilled' && ($can_build[$dbname] ?? '') !== 'not_enough_bh' && ($can_build[$dbname] ?? '') !== 'not_enough_storage'): ?>
                                            <?php
                                            $w_base = $cl_builds->get_wood($dbname, $build_village[$dbname] + 1);
                                            $s_base = $cl_builds->get_stone($dbname, $build_village[$dbname] + 1);
                                            $i_base = $cl_builds->get_iron($dbname, $build_village[$dbname] + 1);
                                            $w_red = (int) floor($w_base * 0.8);
                                            $s_red = (int) floor($s_base * 0.8);
                                            $i_red = (int) floor($i_base * 0.8);
                                            $has_ress_discount = ($village['r_wood'] >= $w_red && $village['r_stone'] >= $s_red && $village['r_iron'] >= $i_red);
                                            ?>
                                            <?php if ($has_ress_discount && ($config['premium_enabled'] ?? true)): ?>
                                                <?php
                                                $tooltip_html =
                                                    "<b>20% de custos reduzidos:</b><br/>" .
                                                    "<span class='icon header wood'></span> <span style='text-decoration:line-through;color:#aaa'>" . format_number($w_base) . "</span> " . format_number($w_red) . " " .
                                                    "<span class='icon header stone'></span> <span style='text-decoration:line-through;color:#aaa'>" . format_number($s_base) . "</span> " . format_number($s_red) . "<br/>" .
                                                    "<span class='icon header iron'></span> <span style='text-decoration:line-through;color:#aaa'>" . format_number($i_base) . "</span> " . format_number($i_red) . "<br/>" .
                                                    "Custos: <img src='graphic/new/premium/coinbag_15x15.png' style='vertical-align:middle;width:12px'/> 30";
                                                ?>
                                                <a class="btn btn-bcr" data-tiphtml="<?= htmlspecialchars($tooltip_html) ?>" href="#"
                                                    onclick="document.forms['building'].reduce_cost.value = '1'; insertUnit(document.forms['building'].id,'<?= $dbname ?>');document.forms['building'].submit();">
                                                    -20%
                                                </a>
                                            <?php else: ?>
                                                <a class="btn btn-bcr" data-tiphtml="Recursos insuficientes mesmo com 20% de desconto"
                                                    style="cursor: not-allowed; opacity: 0.5;" href="#" onclick="return false;">
                                                    -20%
                                                </a>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            &nbsp;
                                        <?php endif; ?>
                                    </td>
                                <?php elseif (($can_build[$dbname] ?? '') == 'not_enough_ress_plus'): ?>
                                    <td class="inactive" colspan="2"><?= __('screens.main.not_enough_space_storage') ?></td>
                                <?php elseif (($can_build[$dbname] ?? '') == 'not_fulfilled'): ?>
                                    <td class="inactive" colspan="2">
                                        <?= __('screens.main.not_fulfilled') ?: 'Não atende aos requisitos deste edifício!' ?>
                                    </td>
                                <?php elseif (($can_build[$dbname] ?? '') == 'not_enough_bh'): ?>
                                    <td class="inactive" colspan="2"><?= __('screens.main.not_enough_space_farm') ?></td>
                                <?php elseif (($can_build[$dbname] ?? '') == 'not_enough_storage'): ?>
                                    <td class="inactive" colspan="2"><?= __('screens.main.not_enough_space_storage') ?></td>
                                <?php else: ?>
                                    <?php if (($build_village[$dbname] ?? 0) < 1): ?>
                                        <td><a class="btn btn-build" id="main_buildlink_<?= $dbname ?>" href="#"
                                                onclick="insertUnit(document.forms['building'].id,'<?= $dbname ?>');document.forms['building'].submit();"><?= __('screens.main.build_action') ?></a>
                                        <?php else: ?>
                                        <td><a class="btn btn-build" id="main_buildlink_<?= $dbname ?>" href="#building"
                                                onclick="insertUnit(document.forms['building'].id,'<?= $dbname ?>');document.forms['building'].submit();"><?= __('screens.main.level') ?>
                                                <?= ($build_village[$dbname] ?? 0) + 1 ?></a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (($can_build[$dbname] ?? '') !== 'not_fulfilled' && ($can_build[$dbname] ?? '') !== 'not_enough_bh' && ($can_build[$dbname] ?? '') !== 'not_enough_storage'): ?>
                                            <?php
                                            $w_base = $cl_builds->get_wood($dbname, $build_village[$dbname] + 1);
                                            $s_base = $cl_builds->get_stone($dbname, $build_village[$dbname] + 1);
                                            $i_base = $cl_builds->get_iron($dbname, $build_village[$dbname] + 1);
                                            $w_red = (int) floor($w_base * 0.8);
                                            $s_red = (int) floor($s_base * 0.8);
                                            $i_red = (int) floor($i_base * 0.8);
                                            $has_ress_discount = ($village['r_wood'] >= $w_red && $village['r_stone'] >= $s_red && $village['r_iron'] >= $i_red);
                                            ?>
                                            <?php if ($has_ress_discount && ($config['premium_enabled'] ?? true)): ?>
                                                <?php
                                                $tooltip_html =
                                                    "<b>20% de custos reduzidos:</b><br/>" .
                                                    "<span class='icon header wood'></span> <span style='text-decoration:line-through;color:#aaa'>" . format_number($w_base) . "</span> " . format_number($w_red) . " " .
                                                    "<span class='icon header stone'></span> <span style='text-decoration:line-through;color:#aaa'>" . format_number($s_base) . "</span> " . format_number($s_red) . "<br/>" .
                                                    "<span class='icon header iron'></span> <span style='text-decoration:line-through;color:#aaa'>" . format_number($i_base) . "</span> " . format_number($i_red) . "<br/>" .
                                                    "Custos: <img src='graphic/new/premium/coinbag_15x15.png' style='vertical-align:middle;width:12px'/> 30";
                                                ?>
                                                <a class="btn btn-bcr" data-tiphtml="<?= htmlspecialchars($tooltip_html) ?>" href="#"
                                                    onclick="document.forms['building'].reduce_cost.value = '1'; insertUnit(document.forms['building'].id,'<?= $dbname ?>');document.forms['building'].submit();">
                                                    -20%
                                                </a>
                                            <?php else: ?>
                                                <a class="btn btn-bcr" data-tiphtml="Recursos insuficientes mesmo com 20% de desconto"
                                                    style="cursor: not-allowed; opacity: 0.5;" href="#" onclick="return false;">
                                                    -20%
                                                </a>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            &nbsp;
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
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
                        <div class="progress-bar"
                            style="height: 18px; border: 1px solid #804000; background: #e0d0b0; position: relative; width: 100%;">
                            <div style="width: <?= $village_build_process ?>%; height: 100%; background-color: #804000;">
                            </div>
                            <span
                                style="position: absolute; width: 100%; text-align: center; top: 0; left: 0; line-height: 18px; font-weight: bold; color: <?= $village_build_process > 50 ? '#fff' : '#000' ?>;"><?= $village_build_process ?>%</span>
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
                        <a
                            href="game.php?village=<?= $village['id'] ?>&screen=<?= $dbname ?><?= $dbname === 'market' ? '&mode=other_offer' : '' ?>">
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
                    <div class="progress-bar"
                        style="height: 18px; border: 1px solid #804000; background: #e0d0b0; position: relative; width: 100%;">
                        <div style="width: <?= $village_build_process ?>%; height: 100%; background-color: #804000;"></div>
                        <span
                            style="position: absolute; width: 100%; text-align: center; top: 0; left: 0; line-height: 18px; font-weight: bold; color: <?= $village_build_process > 50 ? '#fff' : '#000' ?>;"><?= $village_build_process ?>%</span>
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
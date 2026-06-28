<?php
/**
 * Train Central Screen - Normal Mode
 * Centralized recruitment from all military buildings
 */
?>


<h2><?= __('screens.train.recruitment') ?></h2>
<p><?= __('screens.train.mass_recruitment_description') ?></p>

<table class="vis">
    <tbody>
        <tr>
            <td class="selected"><a
                    href="game.php?village=<?= $village['id'] ?>&screen=train&mode=train"><?= __('screens.train.recruitment') ?></a>
            </td>
            <td><a
                    href="game.php?village=<?= $village['id'] ?>&screen=train&mode=mass"><?= __('screens.train.mass_recruitment') ?></a>
            </td>
        </tr>
    </tbody>
</table>

<?php foreach ($buildings as $build): ?>
    <?php if (count($recruiting[$build] ?? []) > 0): ?>
        <div class="current_prod_wrapper">
            <div id="replace_<?= $build ?>">
                <?php if (($first_unit[$build]['is'] ?? false)): ?>
                    <table class="vis">
                        <tbody>
                            <tr>
                                <th width="250"><?= __('screens.recruitment.training_next_unit') ?>
                                    (<?= $first_unit[$build]['unitname'] ?>):
                                </th>
                                <th><span class="timer"><?= format_time($first_unit[$build]['time_to_train']) ?></span></th>
                            </tr>
                        </tbody>
                    </table>
                <?php endif; ?>

                <div class="trainqueue_wrap" id="trainqueue_wrap_<?= $build ?>">
                    <table class="vis">
                        <tbody>
                            <tr>
                                <th width="150"><?= __('screens.recruitment.education') ?></th>
                                <th width="120"><?= __('screens.recruitment.duration') ?></th>
                                <th width="150"><?= __('screens.recruitment.ready') ?></th>
                                <th width="100"><?= __('screens.recruitment.finish') ?> *</th>
                            </tr>
                            <?php foreach ($recruiting[$build] as $id => $recruit): ?>
                                <tr <?= $recruit['lit'] ? 'class="lit"' : '' ?>>
                                    <td><img src="/graphic/unit/<?= $recruit['unit'] ?>.png" alt="" /> <?= $recruit['num_unit'] ?>
                                        <?= $cl_units->get_name($recruit['unit']) ?>
                                    </td>
                                    <?php if ($recruit['lit'] && $recruit['countdown'] > -1): ?>
                                        <td><span class="timer"><?= format_time($recruit['countdown']) ?></span></td>
                                    <?php else: ?>
                                        <td><?= format_time($recruit['countdown']) ?></td>
                                    <?php endif; ?>
                                    <td><?= date('d.m.Y H:i:s', $recruit['time_finished']) ?></td>
                                    <td><a class="btn btn-cancel"
                                            href="game.php?village=<?= $village['id'] ?>&screen=train&action=cancel&id=<?= $id ?>&h=<?= $hkey ?>"><?= __('screens.recruitment.cancel') ?></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div style="font-size: 7pt;"><?= __('screens.recruitment.cancel_note') ?></div>
                <br>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<?php if (!empty($error)): ?>
    <font class="error">
        <?php
        $error_messages = [
            'not_enough_pop' => __('screens.recruitment.not_enough_farm'),
            'not_enough_resources' => __('screens.recruitment.not_enough_resources'),
            'invalid_key' => __('screens.recruitment.will_perform_actions')
        ];
        echo $error_messages[$error] ?? $error;
        ?>
    </font>
<?php endif; ?>

<form action="game.php?village=<?= $village['id'] ?>&screen=train&mode=train&action=train&h=<?= $hkey ?>" method="post"
    onsubmit="this.submit.disabled=true;">
    <table class="vis" width="100%">
        <tbody>
            <tr>
                <th width="190"><?= __('screens.recruitment.unit') ?></th>
                <th colspan="4" width="200"><?= __('screens.recruitment.cost') ?></th>
                <th class="nowrap" width="120"><?= __('screens.recruitment.time') ?></th>
                <th class="nowrap"><?= __('screens.recruitment.in_village') ?></th>
                <th><?= __('screens.common.recruit') ?></th>
            </tr>
            <?php
            $i = 0;
            foreach ($buildings as $build):
                if ($village[$build] > 0):
                    foreach ($build_units[$build] as $name => $dbname):
                        ?>
                        <tr class="row_<?= $i % 2 ? 'b' : 'a' ?>">
                            <td class="nowrap">
                                <a href="javascript:popup_scroll('popup_unit.php?unit=<?= $dbname ?>', 520, 520)">
                                    <img src="/graphic/unit/<?= $dbname ?>.png" alt="" /> <?= $name ?>
                                </a>
                            </td>

                            <td><img src="/graphic/icons/wood.png" title="Madeira" alt="" /> <?= $cl_units->get_woodprice($dbname) ?>
                            </td>
                            <td><img src="/graphic/icons/stone.png" title="Argila" alt="" /> <?= $cl_units->get_stoneprice($dbname) ?>
                            </td>
                            <td><img src="/graphic/icons/iron.png" title="Ferro" alt="" /> <?= $cl_units->get_ironprice($dbname) ?>
                            </td>
                            <td><img src="/graphic/icons/face.png" title="População" alt="" /> <?= $cl_units->get_bhprice($dbname) ?>
                            </td>
                            <td><?= format_time($cl_units->get_time_round($village[$build], $dbname, $village['bonus'], $village['userid'], $village['id'])) ?></td>

                            <td><?= $units_in_village[$dbname] ?>/<?= $units_all[$dbname] ?></td>

                            <?php
                            $cl_units->check_needed($dbname, $village);
                            $last_error = $cl_units->last_error;
                            ?>

                            <?php if ($last_error == 'not_tec'): ?>
                                <td class="inactive nowrap"><?= __('screens.recruitment.unit_not_researched') ?></td>
                            <?php elseif ($last_error == 'not_needed'): ?>
                                <td class="inactive nowrap"><?= __('screens.recruitment.requirements_not_met') ?></td>
                            <?php elseif ($last_error == 'not_enough_ress'): ?>
                                <td class="inactive nowrap"><?= __('screens.recruitment.not_enough_resources') ?></td>
                            <?php elseif ($last_error == 'not_enough_bh'): ?>
                                <td class="inactive nowrap"><?= __('screens.recruitment.not_enough_farm') ?></td>
                            <?php else: ?>
                                <td class="nowrap">
                                    <input style="color: black;" name="<?= $dbname ?>" class="recruit_unit" id="<?= $dbname ?>_0"
                                        size="5" maxlength="5" tabindex="1" type="text">
                                    <a id="<?= $dbname ?>_0_a"
                                        href="javascript:unit_build_block.set_max('<?= $dbname ?>')">(<?= $last_error ?>)</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                        <?php
                        $i++;
                    endforeach;
                endif;
            endforeach;
            ?>
            <tr>
                <td colspan="8" align="right">
                    <input class="btn btn-recruit" value="<?= __('screens.common.recruit') ?>" style="font-size: 10pt;"
                        name="sub" type="submit">
                </td>
            </tr>
        </tbody>
    </table>
</form>

<script type="text/javascript">
    $(document).ready(function () {
        TrainOverview.init();
        TrainOverview.train_link = "";
        TrainOverview.cancel_link = "";
        TrainOverview.pop_max = <?= $village['r_bh'] ?>;
    });

    unit_managers = {};
    unit_managers.units = {
        <?php
        $i = 0;
        foreach ($buildings as $build):
            foreach ($build_units[$build] as $name => $dbname):
                $i++;
                ?>
                                        <?= $dbname ?>: { wood: <?= $cl_units->get_woodprice($dbname) ?>, stone: <?= $cl_units->get_stoneprice($dbname) ?>, iron: <?= $cl_units->get_ironprice($dbname) ?>, pop: <?= $cl_units->get_bhprice($dbname) ?> }<?= $i != $counter_unit ? ',' : '' ?>
                                <?php
            endforeach;
        endforeach;
        ?>
    };

    var unit_build_block = new UnitBuildManager(0, {
        res: { wood: <?= $village['r_wood'] ?>, stone: <?= $village['r_stone'] ?>, iron: <?= $village['r_iron'] ?>, pop: <?= $max_bh - $village['r_bh'] ?> }
    });
    unit_build_block._onchange();
</script>
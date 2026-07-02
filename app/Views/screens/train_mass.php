<?php
/**
 * Mass Recruitment View
 * Allows recruiting units across multiple villages
 */

// Helper functions
if (!function_exists('format_number')) {
    function format_number($number)
    {
        return number_format($number, 0, ',', '.');
    }
}
?>



<?php if (!$is_train_mass_succes): ?>
    <h2><?= __('screens.train.mass_recruitment') ?></h2>
    <p><?= __('screens.train.mass_recruitment_description') ?></p>

    <table class="vis">
        <tbody>
            <tr>
                <td><a
                        href="game.php?village=<?= $village['id'] ?>&screen=train&mode=train"><?= __('screens.train.recruitment') ?></a>
                </td>
                <td class="selected"><a
                        href="game.php?village=<?= $village['id'] ?>&screen=train&mode=mass"><?= __('screens.train.mass_recruitment') ?></a>
                </td>
            </tr>
        </tbody>
    </table>

    <br>

    <?php if (!empty($error)): ?>
        <font class="error"><?= $error ?></font>
    <?php endif; ?>

    <form id="mass_train_form"
        action="game.php?village=<?= $village['id'] ?>&screen=train&mode=mass&action=train_mass&h=<?= $hkey ?>"
        method="post" onsubmit="this.submit.disabled=true;">

        <input class="btn btn-recruit" type="submit" value="<?= __('common.recruit') ?>" />

        <table id="mass_train_table" class="vis overview_table" style="min-width:950px">
            <thead>
                <tr>
                    <th width="120"><?= __('screens.train.village') ?> (<?= count($masowa_rek_wioski) ?>)</th>
                    <th width="130"><?= __('screens.train.resources') ?></th>
                    <th><?= __('screens.train.population') ?></th>
                    <?php foreach ($units as $key => $unit): ?>
                        <th style="text-align:center" width="35">
                            <img src="graphic/unit/<?= $key ?>.png" title="<?= $cl_units->get_name($key) ?>" alt="" />
                        </th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $vid_counter = 0;
                $villages_cache = '';
                foreach ($masowa_rek_wioski as $wioska):
                    $is_current = $wioska['id'] == $village['id'];
                    $row_class = $is_current ? 'selected' : ($vid_counter % 2 ? 'row_b' : 'row_a');
                    ?>
                    <tr class="<?= $row_class ?>">
                        <td>
                            <a href="game.php?village=<?= $wioska['id'] ?>&screen=barracks">
                                <?= htmlspecialchars($wioska['name']) ?> (<?= $wioska['x'] ?>|<?= $wioska['y'] ?>)
                                K<?= $wioska['continent'] ?>
                            </a>
                        </td>
                        <td>
                            <img src="graphic/icons/wood.png" /> <?= format_number($wioska['r_wood']) ?><br>
                            <img src="graphic/icons/stone.png" /> <?= format_number($wioska['r_stone']) ?><br>
                            <img src="graphic/icons/iron.png" /> <?= format_number($wioska['r_iron']) ?><br>
                        </td>
                        <td>
                            <img src="graphic/icons/face.png" /> <?= format_number($wioska['wolni_osadnicy']) ?>
                        </td>

                        <?php foreach ($units as $key => $unit): ?>
                            <td>
                                <div style="white-space: nowrap; margin-bottom: 3px;">
                                    <img src="graphic/dots/grey.png" /> <?= $wioska[$key] ?? 0 ?><br>
                                </div>

                                <?php
                                $tech_level = $wioska['tech_' . $key] ?? 0;
                                if ($tech_level > 0):
                                    // Check if village has required buildings
                                    $has_building = $wioska['budynki'][$unit['rekrutuj_w']] > 0;
                                    $max_units = 0;

                                    if ($has_building) {
                                        // Calculate max units that can be recruited
                                        $max_by_wood = $unit['koszt_wood'] > 0 ? floor($wioska['r_wood'] / $unit['koszt_wood']) : 999999;
                                        $max_by_stone = $unit['koszt_stone'] > 0 ? floor($wioska['r_stone'] / $unit['koszt_stone']) : 999999;
                                        $max_by_iron = $unit['koszt_iron'] > 0 ? floor($wioska['r_iron'] / $unit['koszt_iron']) : 999999;
                                        $max_by_pop = $unit['koszt_bh'] > 0 ? floor($wioska['wolni_osadnicy'] / $unit['koszt_bh']) : 999999;
                                        $max_units = min($max_by_wood, $max_by_stone, $max_by_iron, $max_by_pop);
                                    }
                                    ?>
                                    <?php if ($has_building): ?>
                                        <input data-existing="0" data-running="0" id="<?= $key ?>_<?= $wioska['id'] ?>"
                                            name="units[<?= $wioska['id'] ?>][<?= $key ?>]" size="3" type="text" maxlength="5"><br>
                                        <a id="<?= $key ?>_<?= $wioska['id'] ?>_a"
                                            href="javascript:unit_managers[<?= $wioska['id'] ?>].set_max('<?= $key ?>')">(<?= $max_units ?>)</a>
                                    <?php else: ?>
                                        <input data-existing="0" data-running="" disabled="disabled"
                                            id="units[<?= $wioska['id'] ?>][<?= $key ?>]" name="units[<?= $wioska['id'] ?>][<?= $key ?>]"
                                            size="3" type="text"><br><br>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <input data-existing="0" data-running="" disabled="disabled"
                                        id="units[<?= $wioska['id'] ?>][<?= $key ?>]" name="units[<?= $wioska['id'] ?>][<?= $key ?>]"
                                        size="3" type="text"><br><br>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <?php
                    // Build JavaScript cache for unit managers
                    $villages_cache .= "unit_managers[{$wioska['id']}] = new UnitBuildManager({$wioska['id']}, {res: {wood: {$wioska['r_wood']}, stone: {$wioska['r_stone']}, iron: {$wioska['r_iron']}, pop: {$wioska['wolni_osadnicy']}}});\n";
                    $vid_counter++;
                    ?>
                <?php endforeach; ?>
            </tbody>

        </table>
    </form>

    <script type="text/javascript">
        $(document).ready(function () {
            unit_managers = {};
            unit_managers.units = {
                <?php
                $i = 0;
                foreach ($units as $dbname => $unit_info):
                    $i++;
                    ?>
                                                "<?= $dbname ?>": {
                        "wood": <?= $cl_units->get_woodprice($dbname) ?>,
                        "stone": <?= $cl_units->get_stoneprice($dbname) ?>,
                        "iron": <?= $cl_units->get_ironprice($dbname) ?>,
                        "pop": <?= $cl_units->get_bhprice($dbname) ?>
                    }<?= $i != count($units) ? ',' : '' ?>
                                <?php endforeach; ?>
            };

            <?= $villages_cache ?>

            if (typeof TrainOverview !== 'undefined' && TrainOverview.initMassOverview) {
                TrainOverview.initMassOverview();
            }
        });
    </script>

<?php else: ?>
    <!-- Success screen -->
    <h2><?= __('screens.train.mass_recruitment') ?></h2>

    <a
        href="game.php?village=<?= $village['id'] ?>&screen=train&mode=mass"><?= __('screens.train.back_to_recruitment') ?></a><br>

    <p><?= __('screens.train.units_recruited_success') ?></p>

    <table class="vis">
        <tbody>
            <tr>
                <th><?= __('screens.train.village') ?></th>
                <th><?= __('screens.train.units') ?></th>
            </tr>

            <?php foreach ($rec_succes as $vid => $units_recruited): ?>
                <?php if (array_sum($units_recruited) > 0): ?>
                    <?php $wioska = $masowa_rek_wioski[$vid] ?? null; ?>
                    <?php if ($wioska): ?>
                        <tr>
                            <td>
                                <a href="game.php?village=<?= $vid ?>&screen=info_village&id=<?= $vid ?>">
                                    <?= htmlspecialchars($wioska['name']) ?> (<?= $wioska['x'] ?>|<?= $wioska['y'] ?>)
                                    K<?= $wioska['continent'] ?>
                                </a>
                            </td>
                            <td>
                                <?php foreach ($units_recruited as $dbname => $value): ?>
                                    <?php if ($value > 0): ?>
                                        <img src="graphic/unit/<?= $dbname ?>.png" title="<?= $cl_units->get_name($dbname) ?>" alt="">
                                        <?= $value ?> &nbsp;
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a
        href="game.php?village=<?= $village['id'] ?>&screen=train&mode=mass"><?= __('screens.train.back_to_recruitment') ?></a><br>

    <?php
    // Clear session data after displaying
    unset($_SESSION['rec_succes']);
?>
<?php endif; ?>
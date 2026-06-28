<?php
// Determine image and description based on level
$max_stage = $cl_builds->get_maxstage($screen);
$current_level = $village[$screen];
$percent = $current_level / $max_stage;

$img_suffix = '1';
if ($max_stage > 3) {
    if ($percent > 0.5) {
        $img_suffix = '3';
    } elseif ($percent > 0.2) {
        $img_suffix = '2';
    }
}
?>
<table>
    <tr>
        <td>
            <img src="graphic/big_buildings/<?= $screen . $img_suffix ?>.png"
                title="<?= $cl_builds->get_name($screen) ?>" alt="" />
        </td>
        <td>
            <h2><?= $cl_builds->get_name($screen) ?> (<?php if ($current_level > 0): ?><?= __('screens.common.level') ?>
                    <?= $current_level ?><?php else: ?>    <?= __('screens.common.not_built') ?><?php endif; ?>)
            </h2>
            <?= $cl_builds->get_description_bydbname($screen) ?>
        </td>
    </tr>
</table>
<br />

<?php if ($current_level > 0): ?>
    <?php if ($screen == 'storage'): ?>
        <table class="vis">
            <?php foreach ($storage_arr as $lev): ?>
                <tr>
                    <td width="200">
                        <img src="graphic/icons/resources.png" alt="" />
                        <?= $lev['opis'] ?>
                    </td>
                    <td>
                        <b><?= $lev['produkcja'] ?></b>
                        <?= __('simple_building.resources', 'Recursos') ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br />
        <!-- TODO: Add storage fill time table -->
    <?php elseif ($screen == 'hide'): ?>
        <table class="vis">
            <?php foreach ($hide_arr as $lev): ?>
                <tr>
                    <td width="200">
                        <img src="graphic/<?= $screen ?>.png" alt="" />
                        <?= $lev['opis'] ?>
                    </td>
                    <td>
                        <b><?= $lev['produkcja'] ?></b>
                        <?= __('simple_building.resources', 'Recursos') ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <table class="vis">
            <tr>
                <th colspan="2">
                    <?= __('simple_building.information', 'Em formação') ?>
                </th>
            </tr>
            <tr>
                <td>
                    <?= __('simple_building.lootable_resources', 'Recursos possíveis para saquear:') ?>
                </td>
                <td>
                    <img src="graphic/wood.png" title="<?= __('simple_building.wood', 'Madeira') ?>" alt="" /> <?= $p_wood ?>
                    <img src="graphic/stone.png" title="<?= __('simple_building.stone', 'Argila') ?>" alt="" /><?= $p_stone ?>
                    <img src="graphic/iron.png" title="<?= __('simple_building.iron', 'Ferro') ?>" alt="" /><?= $p_iron ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?= __('simple_building.market_lootable', 'As ofertas no mercado são pilháveis.') ?>
                </td>
            </tr>
        </table>
    <?php elseif ($screen == 'wall'): ?>
        <table class="vis">
            <tr>
                <th width="150">
                    <?= __('screens.common.wall_level') ?>
                </th>
                <th width="220">
                    <?= __('simple_building.defensive_bonus', 'Bônus defensivo em porcentagem') ?>
                </th>
                <th width="150">
                    <?= __('simple_building.ground_defense', 'Defesa terrestre') ?>
                </th>
            </tr>
            <?php foreach ($wall_arr as $lev): ?>
                <tr>
                    <td>
                        <?= $lev['opis'] ?>
                    </td>
                    <td>
                        <?= $lev['bonus'] ?>
                    </td>
                    <td>
                        <?= $lev['gruntowa'] ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
<?php endif; ?>
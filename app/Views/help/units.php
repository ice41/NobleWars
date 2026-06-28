<?php
// Units Help View
global $cl_units;
$units = $cl_units->get_array('name'); // Order: unit_spear => Lanceiro, ...
?>
<h1><?= __('help.units.title') ?></h1>

<p><?= __('help.units.intro') ?></p>

<table class="vis" width="100%">
    <tr>
        <th><?= __('help.units.table.unit') ?></th>
        <th><?= __('help.units.table.speed') ?></th>
        <th><?= __('help.units.table.carry') ?></th>
        <th><?= __('help.units.table.recruited_in') ?></th>
    </tr>
    <?php foreach ($units as $unit_key => $unit_name):
        // Image mapping based on user feedback
        $image_file = $unit_key . '.png';
        if ($unit_key == 'unit_spear')
            $image_file = 'spear.png';
        if ($unit_key == 'unit_sword')
            $image_file = 'sword.png';
        if ($unit_key == 'unit_spy')
            $image_file = 'spy.png';
        if ($unit_key == 'unit_axe')
            $image_file = 'axe.png';
        if ($unit_key == 'unit_light')
            $image_file = 'light.png';
        if ($unit_key == 'unit_heavy')
            $image_file = 'heavy.png';
        if ($unit_key == 'unit_ram')
            $image_file = 'ram.png';
        if ($unit_key == 'unit_catapult')
            $image_file = 'catapult.png';
        if ($unit_key == 'unit_snob')
            $image_file = 'snob.png';
        if ($unit_key == 'unit_mnich')
            $image_file = 'mnich.png'; // Explicit mapping
        // unit_archer stays as unit_archer.png per request
        ?>
        <tr>
            <td>
                <a href="#<?= $unit_key ?>">
                    <img src="graphic/unit/<?= $image_file ?>" /> <b><?= $unit_name ?></b>
                </a>
            </td>
            <td><?= round($cl_units->get_speed($unit_key) / 60) ?>     <?= __('help.units.minutes_per_field') ?></td>
            <td><?= $cl_units->get_booty($unit_key) ?></td>
            <td><?= ucfirst($cl_units->get_recruit_in($unit_key) ?? '') ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<br>
<hr><br>

<?php foreach ($units as $unit_key => $unit_name):
    // Image mapping
    $image_file = $unit_key . '.png';
    if ($unit_key == 'unit_spear')
        $image_file = 'spear.png';
    if ($unit_key == 'unit_sword')
        $image_file = 'sword.png';
    if ($unit_key == 'unit_spy')
        $image_file = 'spy.png';
    if ($unit_key == 'unit_axe')
        $image_file = 'axe.png';
    if ($unit_key == 'unit_light')
        $image_file = 'light.png';
    if ($unit_key == 'unit_heavy')
        $image_file = 'heavy.png';
    if ($unit_key == 'unit_ram')
        $image_file = 'ram.png';
    if ($unit_key == 'unit_catapult')
        $image_file = 'catapult.png';
    if ($unit_key == 'unit_snob')
        $image_file = 'snob.png';
    if ($unit_key == 'unit_mnich')
        $image_file = 'mnich.png'; // Explicit mapping
    ?>
    <a name="<?= $unit_key ?>"></a>
    <div style="border: 1px solid #c1a264; background: #f4ead4; padding: 10px; margin-bottom: 20px;">
        <h3><img src="graphic/unit/<?= $image_file ?>"> <?= $unit_name ?></h3>
        <p><i><?= $cl_units->get_description($unit_key) ?></i></p>

        <div style="display: flex; gap: 20px; flex-wrap: wrap;">
            <table class="vis" style="flex: 0 0 auto; width: auto;">
                <tr>
                    <th colspan="2"><?= __('help.units.costs') ?></th>
                </tr>
                <tr>
                    <td><img src="graphic/icons/wood.png" title="<?= __('help.buildings.resources.wood') ?>"></td>
                    <td><?= $cl_units->get_woodprice($unit_key) ?></td>
                </tr>
                <tr>
                    <td><img src="graphic/icons/stone.png" title="<?= __('help.buildings.resources.clay') ?>"></td>
                    <td><?= $cl_units->get_stoneprice($unit_key) ?></td>
                </tr>
                <tr>
                    <td><img src="graphic/icons/iron.png" title="<?= __('help.buildings.resources.iron') ?>"></td>
                    <td><?= $cl_units->get_ironprice($unit_key) ?></td>
                </tr>
                <tr>
                    <td><img src="graphic/icons/face.png" title="<?= __('help.buildings.resources.population') ?>"></td>
                    <td><?= $cl_units->get_bhprice($unit_key) ?></td>
                </tr>
            </table>

            <table class="vis" style="flex: 0 0 auto; width: auto;">
                <tr>
                    <th colspan="2"><?= __('help.units.combat') ?></th>
                </tr>
                <tr>
                    <td><?= __('help.units.attack') ?>:</td>
                    <td><?= $cl_units->get_att($unit_key, 1) ?></td>
                </tr>
                <tr>
                    <td><?= __('help.units.defense_general') ?>:</td>
                    <td><?= $cl_units->get_def($unit_key, 1) ?></td>
                </tr>
                <tr>
                    <td><?= __('help.units.defense_cavalry') ?>:</td>
                    <td><?= $cl_units->get_defcav($unit_key, 1) ?></td>
                </tr>
                <tr>
                    <td><?= __('help.units.defense_archers') ?>:</td>
                    <td><?= $cl_units->get_defarcher($unit_key, 1) ?></td>
                </tr>
            </table>
        </div>
    </div>
<?php endforeach; ?>
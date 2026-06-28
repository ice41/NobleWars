<?php
// Buildings Help View
global $cl_builds;
$buildings = $cl_builds->get_array('dbname');
?>
<h1><?= __('help.buildings.title') ?></h1>
<p><?= __('help.buildings.intro') ?></p>

<table class="vis" width="100%">
    <tr>
        <th><?= __('help.buildings.table.building') ?></th>
        <th><?= __('help.buildings.table.max_level') ?></th>
        <th><?= __('help.buildings.table.description') ?></th>
    </tr>
    <?php foreach ($buildings as $dbname): ?>
        <tr>
            <td width="150" align="center">
                <a href="#<?= $dbname ?>">
                    <img src="graphic/buildings/<?= $dbname ?>.png" alt="<?= $cl_builds->get_name($dbname) ?>"><br>
                    <b><?= $cl_builds->get_name($dbname) ?></b>
                </a>
            </td>
            <td align="center"><?= $cl_builds->get_maxstage($dbname) ?></td>
            <td><?= $cl_builds->get_description_bydbname($dbname) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<br>
<hr><br>

<?php foreach ($buildings as $dbname): ?>
    <a name="<?= $dbname ?>"></a>
    <div class="building-help-section" style="margin-bottom: 40px; border-bottom: 1px solid #cfaa7d; padding-bottom: 20px;">
        <h3><img src="graphic/buildings/<?= $dbname ?>.png"> <?= $cl_builds->get_name($dbname) ?></h3>
        <p><i><?= $cl_builds->get_description_bydbname($dbname) ?></i></p>

        <table class="vis" width="100%">
            <tr>
                <th><?= __('help.buildings.table.level') ?></th>
                <th><img src="graphic/icons/wood.png" title="<?= __('help.buildings.resources.wood') ?>">
                    <?= __('help.buildings.resources.wood') ?></th>
                <th><img src="graphic/icons/stone.png" title="<?= __('help.buildings.resources.clay') ?>">
                    <?= __('help.buildings.resources.clay') ?></th>
                <th><img src="graphic/icons/iron.png" title="<?= __('help.buildings.resources.iron') ?>">
                    <?= __('help.buildings.resources.iron') ?></th>
                <th><img src="graphic/icons/face.png" title="<?= __('help.buildings.resources.population') ?>">
                    <?= __('help.buildings.resources.population') ?></th>
                <th><?= __('help.buildings.table.points') ?></th>
            </tr>
            <?php
            $max_stage = $cl_builds->get_maxstage($dbname);
            for ($i = 1; $i <= $max_stage; $i++):
                if ($i > 5 && $max_stage > 10) {
                    if ($i == 6)
                        echo "<tr><td colspan='6' align='center'>...</td></tr>";
                    if ($i < $max_stage - 2)
                        continue;
                }
                ?>
                <tr>
                    <td align="center"><?= $i ?></td>
                    <td><?= number_format($cl_builds->get_wood($dbname, $i)) ?></td>
                    <td><?= number_format($cl_builds->get_stone($dbname, $i)) ?></td>
                    <td><?= number_format($cl_builds->get_iron($dbname, $i)) ?></td>
                    <td><?= number_format($cl_builds->get_bh($dbname, $i)) ?></td>
                    <td><?= $cl_builds->get_points_stage($dbname, $i) ?></td>
                </tr>
            <?php endfor; ?>
        </table>
    </div>
<?php endforeach; ?>

<?php
// Special Buildings Explanations
$hasChurch = in_array('church', $buildings);
$hasWatchtower = in_array('watchtower', $buildings);
?>

<?php if ($hasChurch || $hasWatchtower): ?>
    <br>
    <hr><br>
    <h2><?= __('help.buildings.special_title', 'Edifícios Especiais / Special Buildings') ?></h2>
    <p><?= __('help.buildings.special_intro', 'Alguns edifícios têm mecânicas e propósitos específicos no jogo:') ?></p>

    <?php if ($hasChurch): ?>
        <div class="building-help-section" style="margin-bottom: 30px;">
            <h3><img src="graphic/buildings/church.png" onerror="this.src='graphic/icons/questionmark.png'">
                <?= __('help.church.title') ?></h3>
            <p><b><?= __('help.church.faith') ?>:</b> <?= __('help.church.intro') ?></p>
            <p><?= __('help.church.faith_desc') ?></p>
        </div>
    <?php endif; ?>

    <?php if ($hasWatchtower): ?>
        <div class="building-help-section" style="margin-bottom: 30px;">
            <h3><img width="10" height="10" src="graphic/buildings/watchtower.png" onerror="this.src='graphic/icons/questionmark.png'">
                <?= __('help.watchtower.title') ?></h3>
            <p><b><?= __('help.watchtower.range') ?>:</b> <?= __('help.watchtower.intro') ?></p>
            <p><?= __('help.watchtower.range_desc') ?></p>
        </div>
    <?php endif; ?>
<?php endif; ?>
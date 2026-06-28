<?php
// Points Table View
global $cl_builds;

// Helper function to calculate total points for a maxed village
function calculateMaxPoints($cl_builds)
{
    $total = 0;
    foreach ($cl_builds->get_array('dbname') as $dbname) {
        $max_stage = $cl_builds->get_maxstage($dbname);
        $total += $cl_builds->get_points_stage($dbname, $max_stage);
    }
    return $total;
}

$max_points = calculateMaxPoints($cl_builds);
?>

<h1><?= __('help.points.title') ?></h1>

<p><?= __('help.points.intro') ?> <b><?= number_format($max_points) ?></b> <?= __('help.points.points') ?>.</p>

<table class="vis" width="100%">
    <tr>
        <th><?= __('help.points.building') ?></th>
        <th><?= __('help.points.level') ?> 1</th>
        <th><?= __('help.points.level') ?> 10</th>
        <th><?= __('help.points.level') ?> 15</th>
        <th><?= __('help.points.level') ?> 20</th>
        <th><?= __('help.points.level') ?> 25</th>
        <th><?= __('help.points.level') ?> 30</th>
        <th><?= __('help.points.total') ?></th>
    </tr>
    <?php
    $buildings = $cl_builds->get_array('dbname');
    foreach ($buildings as $building) {
        $name = $cl_builds->get_name($building);
        $maxKey = $cl_builds->get_maxstage($building);
        $totalPoints = $cl_builds->get_points_stage($building, $maxKey);

        $p1 = $maxKey >= 1 ? $cl_builds->get_points_stage($building, 1) : '-';
        $p10 = $maxKey >= 10 ? $cl_builds->get_points_stage($building, 10) : '-';
        $p15 = $maxKey >= 15 ? $cl_builds->get_points_stage($building, 15) : '-';
        $p20 = $maxKey >= 20 ? $cl_builds->get_points_stage($building, 20) : '-';
        $p25 = $maxKey >= 25 ? $cl_builds->get_points_stage($building, 25) : '-';
        $p30 = $maxKey >= 30 ? $cl_builds->get_points_stage($building, 30) : '-';

        echo "<tr>";
        echo "<td><a href='help.php?mode=buildings#$building'><img src='graphic/buildings/$building.png'> $name</a></td>";
        echo "<td>$p1</td>";
        echo "<td>$p10</td>";
        echo "<td>$p15</td>";
        echo "<td>$p20</td>";
        echo "<td>$p25</td>";
        echo "<td>$p30</td>";
        echo "<td><b>$totalPoints</b></td>";
        echo "</tr>";
    }
    ?>
</table>

<br>
<h3><?= __('help.points.breakdown') ?></h3>
<?php foreach ($buildings as $building):
    $max_stage = $cl_builds->get_maxstage($building);
    $name = $cl_builds->get_name($building);
    ?>
    <div style="display: inline-block; vertical-align: top; margin: 10px; width: 200px;">
        <table class="vis" width="100%">
            <tr>
                <th colspan="2"><img src="graphic/buildings/<?= $building ?>.png"> <?= $name ?></th>
            </tr>
            <tr>
                <th><?= __('help.points.level') ?></th>
                <th><?= __('help.points.points') ?></th>
            </tr>
            <?php for ($i = 1; $i <= $max_stage; $i++):
                $points = $cl_builds->get_points_stage($building, $i);
                $diff = ($i > 1) ? ($points - $cl_builds->get_points_stage($building, $i - 1)) : $points;
                ?>
                <tr class="<?= $i % 2 == 0 ? 'row_b' : 'row_a' ?>">
                    <td><?= $i ?></td>
                    <td><?= $points ?> <span style="font-size: 9px; color: #555;">(+<?= $diff ?>)</span></td>
                </tr>
            <?php endfor; ?>
        </table>
    </div>
<?php endforeach; ?>
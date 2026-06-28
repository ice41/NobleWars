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
                    <?= $current_level ?><?php else: ?>     <?= __('screens.common.not_built') ?><?php endif; ?>)
            </h2>
            <?= $cl_builds->get_description_bydbname($screen) ?>
        </td>
    </tr>
</table>
<br />

<?php if ($current_level > 0): ?>
    <table class="vis">
        <?php foreach ($production_arr as $lev): ?>
            <tr>
                <td width="200">
                    <?php if ($screen == 'farm'): ?>
                        <img src="graphic/icons/face.png" alt="" />
                    <?php else: ?>
                        <img src="graphic/<?= $screen ?>.png" alt="" />
                    <?php endif; ?>
                    <?= $lev['opis'] ?>
                </td>
                <td>
                    <b><?= $lev['produkcja'] ?></b>
                    <?php if ($screen == 'farm'): ?>
                        <?= __('screens.resources.population') ?>
                    <?php else: ?>
                        <?= __('screens.resources.per_hour') ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>

    <?php if ($screen != 'farm'): ?>
        <table class="vis">
            <tr>
                <td width="60%">
                    <?= __('screens.resources.resources_produced_so_far') ?>:
                </td>
                <td>
                    <?= __('screens.resources.from') ?>:<?= $time_last_rel ?> (<?= $day_last_rel ?>
                    <?php if ($day_last_rel == 1): ?>            <?= __('screens.resources.day') ?>        <?php else: ?>            <?= __('screens.resources.days') ?>        <?php endif; ?>)
                </td>
                <td>
                    <img src="graphic/<?= $screen ?>.png" alt="" /> <b><?= $sur_dtp ?></b>
                </td>
                <td>
                    <a href="game.php?village=<?= $village['id'] ?>&screen=<?= $screen ?>&action=resetCounter&h=<?= $hkey ?>">
                        <?= __('screens.resources.reset') ?>
                    </a>
                </td>
            </tr>
        </table>
    <?php endif; ?>
<?php endif; ?>
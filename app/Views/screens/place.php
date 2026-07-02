<?php
/**
 * Place Screen View (Rally Point)
 * Faithful migration of game_place.tpl
 */

// Calculate building image stage
$dbname = $screen;
$maxstage = $cl_builds->get_maxstage($dbname);
$aktu_build_prc = ($maxstage > 0) ? $village[$dbname] / $maxstage : 0;
?>

<table>
    <tr>
        <td>
            <?php if ($cl_builds->get_maxstage($dbname) > 3): ?>
                <?php if ($aktu_build_prc > 0.5): ?>
                    <img src="graphic/big_buildings/<?= $dbname ?>3.png" title="<?= $cl_builds->get_name($dbname) ?>" alt="" />
                <?php else: ?>
                    <?php if ($aktu_build_prc > 0.2): ?>
                        <img src="graphic/big_buildings/<?= $dbname ?>2.png" title="<?= $cl_builds->get_name($dbname) ?>" alt="" />
                    <?php else: ?>
                        <img src="graphic/big_buildings/<?= $dbname ?>1.png" title="<?= $cl_builds->get_name($dbname) ?>" alt="" />
                    <?php endif; ?>
                <?php endif; ?>
            <?php else: ?>
                <img src="graphic/big_buildings/<?= $dbname ?>1.png" title="<?= $cl_builds->get_name($dbname) ?>" alt="" />
            <?php endif; ?>
        </td>
        <td>
            <h2><?= $cl_builds->get_name($dbname) ?>
                (<?php if ($village[$dbname] > 0): ?><?= __('screens.recruitment.level') ?>
                    <?= $village[$dbname] ?><?php else: ?>    <?= __('screens.recruitment.not_built') ?><?php endif; ?>)
            </h2>
            <?= $cl_builds->get_description_bydbname($dbname) ?>
        </td>
    </tr>
</table>
<br />

<?php if ($show_build): ?>
    <table width="100%">
        <tr>
            <td valign="top" width="100">
                <table class="vis" width="100%">
                    <?php foreach ($links as $f_name => $f_mode): ?>
                        <?php if ($f_mode == $mode): ?>
                            <tr>
                                <td class="selected" width="120">
                                    <a
                                        href="game.php?village=<?= $village['id'] ?>&screen=place&mode=<?= $f_mode ?>"><?= $f_name ?></a>
                                </td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td width="120">
                                    <a
                                        href="game.php?village=<?= $village['id'] ?>&screen=place&mode=<?= $f_mode ?>"><?= $f_name ?></a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </table>

            </td>
            <td valign="top" width="*">
                <?php
                if (in_array($mode, $allow_mods)) {
                    // Include sub-view based on mode or mode_view if set
                    $current_view = $mode_view ?? $mode;
                    $viewPath = __DIR__ . '/place_' . $current_view . '.php';
                    if (file_exists($viewPath)) {
                        include $viewPath;
                    } else {
                        echo (__('screens.place.mode_not_implemented') ?: 'Modo não implementado') . ": " . htmlspecialchars($current_view);
                    }
                }
                ?>
            </td>
        </tr>
    </table>
<?php endif; ?>
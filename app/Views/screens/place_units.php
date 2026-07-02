<?php if (!empty($error)): ?>
    <div style="color:red; font-size:large"><?= $error ?></div>
<?php endif; ?>

<h3><?= __('screens.place.troops') ?></h3>

<form action="game.php?village=<?= $village['id'] ?>&screen=place&mode=units&action=command_other&h=<?= $hkey ?>"
    method="post">

    <table class="vis" width="100%">
        <tr>
            <th><?= __('screens.place.units') ?></th>
            <?php foreach ($cl_units->get_array("dbname") as $dbname): ?>
                <th width="40"><img src="graphic/unit/<?= $dbname ?>.png" title="<?= $cl_units->get_name($dbname) ?>"
                        alt="" /></th>
            <?php endforeach; ?>
        </tr>

        <tr>
            <td><?= __('screens.place.from_this_village') ?></td>
            <?php foreach ($own_units as $num_units): ?>
                <?php if ($num_units > 0): ?>
                    <td><?= format_number($num_units) ?></td>
                <?php else: ?>
                    <td class="hidden">0</td>
                <?php endif; ?>
            <?php endforeach; ?>
        </tr>

        <?php foreach ($in_my_village_units as $id => $arr): ?>
            <tr>
                <td>
                    <input name="id_<?= $id ?>" type="checkbox" />
                    <a href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $id ?>">
                        <?= $arr['villagename'] ?> (<?= $arr['x'] ?>|<?= $arr['y'] ?>) K<?= $arr['continent'] ?>
                    </a>
                </td>
                <?php foreach ($cl_units->get_array('dbname') as $dbname): ?>
                    <?php if (($arr[$dbname] ?? 0) > 0): ?>
                        <td><?= format_number($arr[$dbname]) ?></td>
                    <?php else: ?>
                        <td class="hidden">0</td>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>

        <tr>
            <th><?= __('screens.place.together') ?></th>
            <?php foreach ($all_units as $num_units): ?>
                <?php if ($num_units > 0): ?>
                    <th><?= format_number($num_units) ?></th>
                <?php else: ?>
                    <th class="hidden">0</th>
                <?php endif; ?>
            <?php endforeach; ?>
        </tr>
    </table>

    <?php if (count($in_my_village_units) > 0): ?>
        <table align="left">
            <tr>
                <td><input class="btn" type="submit" name="back" value="<?= __('screens.place.return') ?>" /></td>
            </tr>
        </table>
    <?php endif; ?>
</form>

<?php if (count($outside_village_units) > 0): ?>
    <br style="clear:both;" />
    <h3><?= __('screens.place.troops_outside_village') ?></h3>

    <table class="vis">
        <tr>
            <th width="320"><?= __('screens.place.village') ?></th>
            <?php foreach ($cl_units->get_array("dbname") as $dbname): ?>
                <th width="40"><img src="graphic/unit/<?= $dbname ?>.png" title="<?= $cl_units->get_name($dbname) ?>" alt="" />
                </th>
            <?php endforeach; ?>
            <th><?= __('screens.place.order') ?></th>
        </tr>

        <?php foreach ($outside_village_units as $id => $arr): ?>
            <tr>
                <td>
                    <a href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $id ?>">
                        <?= $arr['villagename'] ?> (<?= $arr['x'] ?>|<?= $arr['y'] ?>) K<?= $arr['continent'] ?>
                    </a>
                </td>
                <?php foreach ($cl_units->get_array('dbname') as $dbname): ?>
                    <?php if (($arr[$dbname] ?? 0) > 0): ?>
                        <td><?= format_number($arr[$dbname]) ?></td>
                    <?php else: ?>
                        <td class="hidden">0</td>
                    <?php endif; ?>
                <?php endforeach; ?>

                <td>
                    <a href="game.php?village=<?= $village['id'] ?>&screen=place&mode=units&try=back&unit_id=<?= $id ?>"
                        class="btn"><?= __('screens.place.some') ?></a>
                    <a href="game.php?village=<?= $village['id'] ?>&screen=place&mode=units&action=all_back&unit_id=<?= $id ?>&h=<?= $hkey ?>"
                        class="btn"><?= __('screens.place.all') ?></a>
                </td>
            </tr>

        <?php endforeach; ?>

    </table>
<?php endif; ?>
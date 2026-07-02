<?php
/**
 * Account Manager - Overview Mode
 * Shows village overview table similar to overview_villages
 */
?>

<table class="vis" width="100%">
    <tr>
        <th><?= __('screens.am_overview.village') ?></th>
        <th><?= __('screens.am_overview.points') ?></th>
        <th><?= __('screens.am_overview.resources') ?></th>
        <th><?= __('screens.am_overview.storage') ?></th>
        <th><?= __('screens.am_overview.farm') ?></th>
    </tr>
    <?php if (!empty($villages)): ?>
        <?php foreach ($villages as $vid => $vdata): ?>
            <tr <?= $vdata['parzysta_liczba'] ? 'class="row_b"' : 'class="row_a"' ?>>
                <td>
                    <a href="game.php?village=<?= $vdata['id'] ?>&screen=overview"><?= $vdata['name'] ?>
                        (<?= $vdata['x'] ?>|<?= $vdata['y'] ?>) K<?= $vdata['continent'] ?></a>
                </td>
                <td><?= $vdata['points'] ?></td>
                <td>
                    <img src="graphic/icons/wood.png" title="Madeira" alt="" style="vertical-align: middle;" />
                    <?= $vdata['r_wood'] ?>
                    <img src="graphic/icons/stone.png" title="Argila" alt="" style="vertical-align: middle; margin-left: 10px;" />
                    <?= $vdata['r_stone'] ?>
                    <img src="graphic/icons/iron.png" title="Ferro" alt="" style="vertical-align: middle; margin-left: 10px;" />
                    <?= $vdata['r_iron'] ?>
                </td>
                <td><?= $vdata['storage'] ?? '?' ?></td>
                <td><?= $vdata['r_bh'] ?> / <?= $vdata['farm'] ?? '?' ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5"><?= __('screens.am_overview.no_villages_found') ?></td>
        </tr>
    <?php endif; ?>
</table>
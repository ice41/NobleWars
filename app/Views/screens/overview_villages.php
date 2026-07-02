<?php
/**
 * Overview Villages View
 * Handles multiple modes: prod, combined, units, etc.
 */
?>

<h2>Visão geral</h2>

<table class="vis" width="100%">
    <tr>
        <?php foreach ($links as $name => $link_mode): ?>
            <?php if ($mode == $link_mode): ?>
                <td class="selected" width="100"><a
                        href="game.php?village=<?= $village['id'] ?>&screen=overview_villages&mode=<?= $link_mode ?>"><?= $name ?></a>
                </td>
            <?php else: ?>
                <td width="100"><a
                        href="game.php?village=<?= $village['id'] ?>&screen=overview_villages&mode=<?= $link_mode ?>"><?= $name ?></a>
                </td>
            <?php endif; ?>
        <?php endforeach; ?>
    </tr>
</table>
<br>

<?php if ($mode == 'prod'): ?>
    <table class="vis" width="100%">
        <tr>
            <th>Aldeia</th>
            <th>Pontos</th>
            <th>Recursos</th>
            <th>Armazém</th>
            <th>Fazenda</th>
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
                        <span class="wood"><img src="graphic/icons/wood.png" title="Madeira" alt="" /> <?= $vdata['r_wood'] ?></span>
                        <span class="stone"><img src="graphic/icons/stone.png" title="Argila" alt="" /> <?= $vdata['r_stone'] ?></span>
                        <span class="iron"><img src="graphic/icons/iron.png" title="Ferro" alt="" /> <?= $vdata['r_iron'] ?></span>
                    </td>
                    <td><?= $vdata['storage'] ?? '?' ?></td>
                    <td><?= $vdata['r_bh'] ?> / <?= $vdata['farm'] ?? '?' ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Nenhuma aldeia encontrada.</td>
            </tr>
        <?php endif; ?>
    </table>
<?php elseif ($mode == 'combined'): ?>
    <table class="vis" width="100%">
        <tr>
            <th>Aldeia</th>
            <th>Fazenda</th>
            <th>Pesquisas</th>
            <th>Tropas</th>
        </tr>
        <?php if (!empty($villages)): ?>
            <?php foreach ($villages as $vid => $vdata): ?>
                <tr <?= $vdata['parzysta_liczba'] ? 'class="row_b"' : 'class="row_a"' ?>>
                    <td>
                        <a href="game.php?village=<?= $vdata['id'] ?>&screen=overview"><?= $vdata['name'] ?>
                            (<?= $vdata['x'] ?>|<?= $vdata['y'] ?>) K<?= $vdata['continent'] ?></a>
                    </td>
                    <td><?= $vdata['farm'] ?></td>
                    <td>
                        <!-- Tech status placeholders -->
                        <?php if ($vdata['smith']): ?><img src="graphic/buildings/smith.png" title="Ferreiro"><?php endif; ?>
                    </td>
                    <td>
                        <!-- Unit status placeholders -->
                        <?php if ($vdata['barracks']): ?><img src="graphic/buildings/barracks.png"
                                title="Quartel"><?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
<?php else: ?>
    <p>Modo '<?= $mode ?>' ainda não implementado na visualização.</p>
<?php endif; ?>
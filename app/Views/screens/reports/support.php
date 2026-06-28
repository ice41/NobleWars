<?php
/**
 * Support Report View
 * Simple display showing sender, receiver, and units sent
 * No battle mechanics (luck, moral, loot) as this is just troop movement
 */

// Parse units
$units_sent = $report['a_units'] ?? [];

// Unit names
if (!isset($units)) {
    $units = [
        'spear' => __('screens.common.unit_spear') ?: 'Lanceiro',
        'sword' => __('screens.common.unit_sword') ?: 'Espadachim',
        'axe' => __('screens.common.unit_axe') ?: 'Bárbaro',
        'archer' => __('screens.common.unit_archer') ?: 'Arqueiro',
        'spy' => __('screens.common.unit_spy') ?: 'Explorador',
        'light' => __('screens.common.unit_light') ?: 'Cavalaria Leve',
        'cav_archer' => __('screens.common.unit_cav_archer') ?: 'Arqueiro a Cavalo',
        'heavy' => __('screens.common.unit_heavy') ?: 'Cavalaria Pesada',
        'ram' => __('screens.common.unit_ram') ?: 'Ariete',
        'catapult' => __('screens.common.unit_catapult') ?: 'Catapulta',
        'paladin' => __('screens.common.unit_paladin') ?: 'Paladino',
        'snob' => __('screens.common.unit_snob') ?: 'Nobre',
        'mnich' => __('units.monk.name') ?: 'Monge'
    ];
}
?>

<h2><?= __('screens.report.support_report') ?></h2>

<table class="vis" width="100%">
    <tr>
        <th width="140"><?= __('screens.report.subject') ?></th>
        <th><?= htmlspecialchars($report['title']) ?></th>
    </tr>
    <tr>
        <td><?= __('screens.report.sent_at') ?></td>
        <td><?= date('d/m/Y H:i:s', $report['time']) ?></td>
    </tr>
</table>

<br>

<!-- Sender Information -->
<table class="vis" width="100%">
    <tr>
        <th width="100"><?= __('screens.report.sender') ?>:</th>
        <th>
            <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $report['from_user'] ?>">
                <?= htmlspecialchars($report['from_username'] ?? (__('screens.report.unknown') ?: 'Desconhecido')) ?>
            </a>
        </th>
    </tr>
    <tr>
        <td><?= __('screens.report.origin') ?>:</td>
        <td>
            <a href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $report['from_village'] ?>">
                <?= htmlspecialchars($report['from_villagename'] ?? '') ?>
                (<?= $report['from_x'] ?? 0 ?>|<?= $report['from_y'] ?? 0 ?>)
                K<?= floor(($report['from_y'] ?? 0) / 100) . floor(($report['from_x'] ?? 0) / 100) ?>
            </a>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding: 0;">
            <table class="vis" width="100%" style="border: none; margin: 0;">
                <tr class="center">
                    <td width="50"></td>
                    <?php foreach ($units as $unitKey => $unitName): ?>
                        <td width="35">
                            <img src="/graphic/unit/<?= $unitKey ?>.png" title="<?= $unitName ?>" alt="">
                        </td>
                    <?php endforeach; ?>
                </tr>
                <tr class="center">
                    <td><?= __('screens.report.quantity') ?>:</td>
                    <?php
                    $unit_index = 0;
                    foreach ($units as $unitKey => $unitName):
                        $count = $units_sent[$unit_index] ?? 0;
                        ?>
                        <td class="<?= $count == 0 ? 'hidden' : '' ?>">
                            <?= $count ?>
                        </td>
                        <?php
                        $unit_index++;
                    endforeach;
                    ?>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br>

<!-- Receiver Information -->
<table class="vis" width="100%">
    <tr>
        <th width="100"><?= __('screens.report.recipient') ?>:</th>
        <th>
            <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $report['to_user'] ?>">
                <?= htmlspecialchars($report['to_username'] ?? (__('screens.report.unknown') ?: 'Desconhecido')) ?>
            </a>
        </th>
    </tr>
    <tr>
        <td><?= __('screens.report.destination') ?>:</td>
        <td>
            <a href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $report['to_village'] ?>">
                <?= htmlspecialchars($report['to_villagename'] ?? '') ?>
                (<?= $report['to_x'] ?? 0 ?>|<?= $report['to_y'] ?? 0 ?>)
                K<?= floor(($report['to_y'] ?? 0) / 100) . floor(($report['to_x'] ?? 0) / 100) ?>
            </a>
        </td>
    </tr>
</table>

<br>

<!-- Action Buttons -->
<table class="vis" width="100%">
    <tr>
        <td>
            <a href="game.php?village=<?= $village['id'] ?>&screen=report&mode=support">« <?= __('screens.report.back_to_support') ?></a>
        </td>
        <td style="text-align: right;">
            <a
                href="game.php?village=<?= $village['id'] ?>&screen=report&mode=view&view=<?= $report['id'] ?>&action=del_one&h=<?= $hkey ?>">
                <?= __('screens.report.delete_report') ?>
            </a>
        </td>
    </tr>
</table>
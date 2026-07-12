<?php
// Ensure variables exist
$templates = $templates ?? ['A' => [], 'B' => []];
$targets = $targets ?? [];
$recent_raids = $recent_raids ?? [];
$available_units = $available_units ?? [];

// Unit configuration
$unit_types = [
    'spear' => 'Lanceiro',
    'sword' => 'Espadachim',
    'axe' => 'Viking',
    'archer' => 'Arqueiro',
    'spy' => 'Explorador',
    'light' => 'Cavalaria leve',
    'marcher' => 'Arqueiro a cavalo',
    'heavy' => 'Cavalaria pesada'
];

// Calculate carrying capacity
function calculateCapacity($units)
{
    $capacities = [
        'spear' => 25,
        'sword' => 15,
        'axe' => 10,
        'archer' => 10,
        'spy' => 0,
        'light' => 80,
        'marcher' => 50,
        'heavy' => 50
    ];

    $total = 0;
    foreach ($units as $unit => $count) {
        $total += ($count * ($capacities[$unit] ?? 0));
    }
    return $total;
}
?>

<h3><?= __('screens.am_farm.farm_assistant') ?></h3>
<!-- <span class="quest_link">&raquo; <a href="#"><?= __('screens.am_farm.farm_assistant_help') ?></a></span> -->

<?php if (!empty($success)): ?>
    <div class="success p-10 mb-15"
         style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724;">
        <?= $success ?>
    </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="error p-10 mb-15"
         style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24;">
        <?= $error ?>
    </div>
<?php endif; ?>

<!-- Templates Section -->
<table class="vis" width="100%">
    <tr>
        <th colspan="10"><?= __('screens.am_farm.templates') ?></th>
    </tr>

    <!-- Template A -->
    <form action="game.php?village=<?= $village['id'] ?>&screen=am_farm&action=save_template&h=<?= $hkey ?>"
        method="POST">
        <input type="hidden" name="template" value="A" />
        <tr>
            <td class="lit-item text-center p-5" >
                <div  style="width: 24px; height: 24px; background-image: url(;"graphic/icons/icons_context.png'); background-position: -264px 0; background-repeat: no-repeat; display: inline-block;"
                    title="Modelo A"></div>
            </td>
            <?php foreach (['spear', 'sword', 'axe', 'archer', 'spy', 'light', 'marcher', 'heavy'] as $unit): ?>
                <td  class="text-center" style="background: #DED3B9;">
                    <img src="graphic/unit/unit_<?= $unit ?>.png" alt="<?= $unit_types[$unit] ?>"
                        title="<?= $unit_types[$unit] ?>" />
                    <br />
                    <input type="text" name="unit_<?= $unit ?>" value="<?= $templates['A'][$unit] ?? 0 ?>" size="4"
                        style="text-align: center;" />
                </td>
            <?php endforeach; ?>
            <td  class="text-center" style="background: #DED3B9;">
                <img src="graphic/icons/resources.png" alt="Capacidade" title="Capacidade de carga" />
                <br />
                <strong><?= calculateCapacity($templates['A'] ?? []) ?></strong>
            </td>
            <td  class="text-center">
                <input type="submit" value="<?= __('screens.am_farm.save') ?>" class="btn" />
            </td>
        </tr>
    </form>

    <!-- Template B -->
    <form action="game.php?village=<?= $village['id'] ?>&screen=am_farm&action=save_template&h=<?= $hkey ?>"
        method="POST">
        <input type="hidden" name="template" value="B" />
        <tr>
            <td class="lit-item text-center p-5" >
                <div  style="width: 24px; height: 24px; background-image: url(;"graphic/icons/icons_context.png'); background-position: -288px 0; background-repeat: no-repeat; display: inline-block;"
                    title="Modelo B"></div>
            </td>
            <?php foreach (['spear', 'sword', 'axe', 'archer', 'spy', 'light', 'marcher', 'heavy'] as $unit): ?>
                <td  class="text-center" style="background: #DED3B9;">
                    <img src="graphic/unit/unit_<?= $unit ?>.png" alt="<?= $unit_types[$unit] ?>"
                        title="<?= $unit_types[$unit] ?>" />
                    <br />
                    <input type="text" name="unit_<?= $unit ?>" value="<?= $templates['B'][$unit] ?? 0 ?>" size="4"
                        style="text-align: center;" />
                </td>
            <?php endforeach; ?>
            <td  class="text-center" style="background: #DED3B9;">
                <img src="graphic/icons/resources.png" alt="Capacidade" title="Capacidade de carga" />
                <br />
                <strong><?= calculateCapacity($templates['B'] ?? []) ?></strong>
            </td>
            <td  class="text-center">
                <input type="submit" value="<?= __('screens.am_farm.save') ?>" class="btn" />
            </td>
        </tr>
    </form>
</table>

<br />

<!-- Available Units Section -->
<table class="vis" width="100%">
    <tr>
        <th colspan="9"><?= __('screens.am_farm.available') ?></th>
    </tr>
    <tr>
        <td  class="p-10"><?= __('screens.am_farm.from_this_village') ?></td>
        <?php foreach (['spear', 'sword', 'axe', 'archer', 'spy', 'light', 'marcher', 'heavy'] as $unit): ?>
            <td  class="text-center">
                <input type="checkbox" checked />
                <br />
                <img src="graphic/unit/unit_<?= $unit ?>.png" alt="<?= $unit_types[$unit] ?>" />
                <br />
                <strong><?= $available_units[$unit] ?? 0 ?></strong>
            </td>
        <?php endforeach; ?>
    </tr>
</table>

<br />

<!-- Recent Raids Section -->
<table class="vis" width="100%">
    <tr>
        <th colspan="2">
            <img src="graphic/new/configuration.webp"
                 class="v-align-middle" style="width: 16px; height: 16px; margin-right: 5px;" alt="" />
            <?= __('screens.am_farm.recent_raids') ?>
        </th>
    </tr>
    <tr>
        <td colspan="2">
            <label><input type="checkbox" /> <?= __('screens.am_farm.show_only_attacks_from_village') ?></label><br />
            <label><input type="checkbox" />
                <?= __('screens.am_farm.include_reports_currently_attacking') ?></label><br />
            <label><input type="checkbox" /> <?= __('screens.am_farm.show_only_full_capacity') ?></label>
        </td>
    </tr>
</table>

<br />

<!-- Farm Targets List -->
<table class="vis" width="100%">
    <tr>
        <th width="20"  class="text-center"><img src="graphic/new/delete_small.webp" alt="Remover" /></th>
        <th><?= __('screens.am_farm.village') ?></th>
        <th><?= __('screens.am_farm.time') ?></th>
        <th width="30"  class="text-center"><img src="graphic/icons/resources.png"
                 style="background-position: 0 0; width: 14px; height: 14px;"
                alt="Recursos calculados no último relatório dos batedores" /></th>
        <th width="30"  class="text-center"><img src="graphic/buildings/wall.png"
                 style="background-position: 0 0; width: 14px; height: 14px;"
                alt="<?= __('screens.common.wall_detected') ?>" /></th>
        <th width="30"  class="text-center"><img src="graphic/icons/rechts.png"
                 style="background-position: 0 0; width: 14px; height: 14px;" alt="Recursos" /></th>
        <th width="30"  class="text-center"><img src="graphic/new/questionmark.webp"
                 style="background-position: 0 0; width: 14px; height: 14px;" alt="Muralha" /></th>

        <th width="30">
            <div  style="width: 24px; height: 24px; background-image: url(;"graphic/icons/icons_context.png'); background-position: -264px 0; background-repeat: no-repeat; display: inline-block;"
                title="A"></div>
        </th>
        <th width="30">
            <div  style="width: 24px; height: 24px; background-image: url(;"graphic/icons/icons_context.png'); background-position: -288px 0; background-repeat: no-repeat; display: inline-block;"
                title="B"></div>
        </th>
        <th width="30"  class="text-center"><img src="graphic/new/delete_small.webp"
                 style="background-position: 0 0; width: 14px; height: 14px;" alt="Remover" /></th>
        <!-- <th width="30"  class="text-center">
            <img src="graphic/new/place.webp"  style="background-position: 0 0; width: 14px; height: 14px;"
                alt="Ataque a aldeia pela praça de reuniões" />
        </th> -->
        <th width="30"  class="text-center">
            <img src="graphic/command/attack.png"  style="width: 14px; height: 14px;" alt="Ataque rápido" />
        </th>
    </tr>

    <?php if (empty($targets)): ?>
        <tr>
            <td colspan="15"  class="text-center" style="padding: 20px; color: #999;">
                <?= __('screens.am_farm.no_villages_added') ?>
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($targets as $target): ?>
            <?php
            // Calculate distance and time
            $distance = sqrt(pow($target['target_x'] - $village['x'], 2) + pow($target['target_y'] - $village['y'], 2));
            $time_minutes = round($distance * 18); // Approximate time with light cavalry
            $arrival_time = date('H:i:s', time() + ($time_minutes * 60));
            ?>
            <tr>
                <td><input type="checkbox" /></td>
                <td>
                    <?= htmlspecialchars($target['name'] ?? '???') ?>
                    <?php if (!empty($target['latest_report_id'])): ?>
                        <a href="game.php?village=<?= $village['id'] ?>&screen=report&view=<?= $target['latest_report_id'] ?>">
                            (<?= $target['target_x'] ?>|<?= $target['target_y'] ?>)
                        </a>
                    <?php else: ?>
                        (<?= $target['target_x'] ?>|<?= $target['target_y'] ?>)
                    <?php endif; ?>
                    K<?= floor($target['target_x'] / 100) . floor($target['target_y'] / 100) ?>
                </td>
                <td  class="text-center">
                    <?php
                    // Show arrival time based on distance
                    echo date('H:i:s', time() + ($time_minutes * 60));
                    ?>
                </td>
                <td  class="text-center">
                    <?php if ($target['total_loot'] !== null): ?>
                        <strong><?= number_format($target['total_loot']) ?></strong>
                    <?php else: ?>
                        ?
                    <?php endif; ?>
                </td>
                <td  class="text-center"><?= $target['spy_wall_level'] ?? '?' ?></td>
                <td  class="text-center">?</td>
                <td  class="text-center">
                    <?php if ($target['battle_result'] !== null): ?>
                        <?php
                        // wins: 0 = defeat (red), 1 = yellow victory, 2 = green victory
                        $color = match ((int) $target['battle_result']) {
                            0 => 'red',
                            1 => 'yellow',
                            2 => 'green',
                            default => 'gray'
                        };
                        ?>
                        <span
                             style="display: inline-block; width: 12px; height: 12px; border-radius: 50%; background-color: <?= $color ?>;"
                            title="Resultado do último ataque"></span>
                    <?php else: ?>
                        ?
                    <?php endif; ?>
                </td>
                <td  class="text-center">
                    <a href="game.php?village=<?= $village['id'] ?>&screen=am_farm&action=attack&target_id=<?= $target['id'] ?>&template=A&h=<?= $hkey ?>"
                        class="farm-btn">
                        <div  style="width: 24px; height: 24px; background-image: url(;"graphic/icons/icons_context.png'); background-position: -264px 0; background-repeat: no-repeat; display: inline-block;"
                            title="Atacar com modelo A"></div>
                    </a>
                </td>
                <td  class="text-center">
                    <a href="game.php?village=<?= $village['id'] ?>&screen=am_farm&action=attack&target_id=<?= $target['id'] ?>&template=B&h=<?= $hkey ?>"
                        class="farm-btn">
                        <div  style="width: 24px; height: 24px; background-image: url(;"graphic/icons/icons_context.png'); background-position: -288px 0; background-repeat: no-repeat; display: inline-block;"
                            title="Atacar com modelo B"></div>
                    </a>
                </td>
                <td  class="text-center">
                    <a href="game.php?village=<?= $village['id'] ?>&screen=am_farm&action=remove&id=<?= $target['id'] ?>&h=<?= $hkey ?>"
                        onclick="return confirm('<?= __('screens.am_farm.remove_village') ?>');">
                        <img src="graphic/icons/delete.png" alt="Remover" />
                    </a>
                </td>
                <td  class="text-center">
                    <a href="game.php?village=<?= $village['id'] ?>&screen=place&x=<?= $target['target_x'] ?>&y=<?= $target['target_y'] ?>"
                        title="Ir para praça de reuniões">
                        <img src="graphic/icons/place.png" alt="Praça"  style="width: 18px; height: 18px;" />
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>

    <tr>
        <td colspan="12"  class="text-center p-10">
            <form action="game.php?village=<?= $village['id'] ?>&screen=am_farm&action=add_target&h=<?= $hkey ?>"
                method="POST" style="display: inline;">
                <?= __('screens.am_farm.add_village') ?>:
                <input type="text" name="coords" placeholder="<?= __('screens.am_farm.coords_placeholder') ?>"
                    size="10" />
                <input type="submit" value="<?= __('screens.am_farm.add') ?>" class="btn" />
            </form>
        </td>
    </tr>
</table>

<br />

<div  class="text-center">
    <?= __('screens.am_farm.entries_per_page') ?>:
    <input type="text" value="15" size="3" />
    <input type="button" value="<?= __('screens.am_farm.change') ?>" class="btn" />
</div>
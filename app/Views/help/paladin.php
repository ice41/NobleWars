<?php
// Paladin Help View
global $config;
?>
<h1><?= __('help.paladin.title') ?></h1>
<p><?= __('help.paladin.intro') ?></p>

<h3><?= __('help.paladin.the_paladin') ?></h3>
<table class="vis" width="100%">
    <tr>
        <td width="100"><img src="graphic/unit/unit_knight.png"></td>
        <td><?= __('help.paladin.description') ?></td>
    </tr>
</table>

<?php if (isset($config['pala_bonus'])): ?>
    <h3>Itens do Paladino</h3>
    <p>Estes são os itens que seu Paladino pode encontrar:</p>

    <table class="vis" width="100%">
        <tr>
            <th>Unidade</th>
            <th>Item</th>
            <th>Efeito</th>
        </tr>
        <?php foreach ($config['pala_bonus'] as $unit => $data):
            // $data[0] = Offense multiplier, $data[1] = Defense multiplier, $data[2] = Name
            $offBonus = round(($data[0] - 1) * 100);
            $defBonus = round(($data[1] - 1) * 100);
            $itemName = $data[2];

            // Clean unit name for image matching in graphic/inventory/
            // The inventory images are named like 'spear.png', 'sword.png', etc.
            // or 'unit_archer.png' for some.
    
            $cleanUnit = strpos($unit, 'unit_') === 0 ? substr($unit, 5) : $unit;

            // Default attempt
            $weaponImg = 'graphic/inventory/unit_' . $cleanUnit . '.png';

            // Specific overrides based on verified file list in graphic/inventory/
            if ($unit == 'unit_spear')
                $weaponImg = 'graphic/inventory/spear.png';
            if ($unit == 'unit_sword')
                $weaponImg = 'graphic/inventory/sword.png';
            if ($unit == 'unit_axe')
                $weaponImg = 'graphic/inventory/axe.png';
            if ($unit == 'unit_archer')
                $weaponImg = 'graphic/inventory/unit_archer.png'; // Note: unit_archer.png exists in inventory
            if ($unit == 'unit_spy')
                $weaponImg = 'graphic/inventory/spy.png';
            if ($unit == 'unit_light')
                $weaponImg = 'graphic/inventory/light.png';
            if ($unit == 'unit_heavy')
                $weaponImg = 'graphic/inventory/heavy.png';
            if ($unit == 'unit_ram')
                $weaponImg = 'graphic/inventory/ram.png';
            if ($unit == 'unit_catapult')
                $weaponImg = 'graphic/inventory/catapult.png';
            if ($unit == 'unit_snob')
                $weaponImg = 'graphic/inventory/snob.png';
            if ($unit == 'unit_marcher')
                $weaponImg = 'graphic/inventory/marcher.png';
            if ($unit == 'unit_cav_archer')
                $weaponImg = 'graphic/inventory/marcher.png';

            // Fallback to avoid broken image
            if (!file_exists($weaponImg) && file_exists('graphic/inventory/unit_' . $cleanUnit . '.png')) {
                $weaponImg = 'graphic/inventory/unit_' . $cleanUnit . '.png';
            }
            ?>
            <tr>
                <td align="center"><img src="<?= $weaponImg ?>" alt="<?= $unit ?>"
                        onerror="this.src='graphic/icons/questionmark.png'"></td>
                <td><b><?= $itemName ?></b></td>
                <td>
                    <?php if ($offBonus > 0)
                        echo "Aumenta o ataque em <b>{$offBonus}%</b>.<br>"; ?>
                    <?php if ($defBonus > 0)
                        echo "Aumenta a defesa em <b>{$defBonus}%</b>."; ?>
                    <?php if ($offBonus == 0 && $defBonus == 0)
                        echo "Efeito especial."; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<br><hr><br>
<h2><?= __('help.inventory.title') ?></h2>
<p><?= __('help.inventory.intro') ?></p>

<table class="vis" width="100%">
    <tr>
        <td width="100" align="center"><img src="graphic/icons/inventory.png" alt="Inventory" onerror="this.src='graphic/icons/questionmark.png'"></td>
        <td>
            <h3><?= __('help.inventory.activation') ?></h3>
            <p><?= __('help.inventory.activation_desc') ?></p>
        </td>
    </tr>
</table>
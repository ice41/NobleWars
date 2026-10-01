<?php
// Grid: 9 columns x 8 rows
// Mapping: tipo_nivel.png (1_1 to 8_9)

// Define flag types (8 types for 8 rows)
$flagTypeMap = [
    1 => 'resource_wood',    // Produção de recursos
    2 => 'recruitment',      // Velocidade de recrutamento  
    3 => 'attack',           // Força de ataque
    4 => 'defense',          // Força Defesa
    5 => 'luck',             // Sorte
    6 => 'population',       // Capacidade da população
    7 => 'coin_cost',        // Menores custos de moeda
    8 => 'cargo'             // Capacidade de carga
];

// Reverse map for image generation (string -> numeric ID)
$typeToId = array_flip($flagTypeMap);
?>

<!-- Left: Big Flag Display -->
<div id="flags_current">
    <div id="flag_big">
        <?php if ($active_flag):
            $typeId = $typeToId[$active_flag['flag_type']] ?? 1;
            ?>
            <!-- Overlay active flag image on top of flag_big.png background -->
            <img src="graphic/flags/big/<?= $typeId ?>_<?= $active_flag['flag_level'] ?>.png"
                alt="<?= \App\Models\FlagsModel::getFlagName($active_flag['flag_type']) ?>">
        <?php endif; ?>
    </div>

    <div id="selected_flag">
        <table class="vis">
            <tr>
                <th><?= __('screens.flags.active_flag') ?></th>
            </tr>
            <tr>
                <td>
                    <?php if ($active_flag):
                        $typeId = $typeToId[$active_flag['flag_type']] ?? 1;
                        ?>
                        <img src="graphic/flags/medium/<?= $typeId ?>_<?= $active_flag['flag_level'] ?>.png"
                            alt="<?= \App\Models\FlagsModel::getFlagName($active_flag['flag_type']) ?>">
                        <strong><?= \App\Models\FlagsModel::getFlagName($active_flag['flag_type']) ?></strong><br>
                        <?= \App\Models\FlagsModel::getFlagEffectDescription($active_flag['flag_type'], $active_flag['flag_level']) ?><br>
                        <form method="post"  class="mt-10">
                            <input type="hidden" name="action" value="remove">
                            <button type="submit" class="btn btn-cancel"><?= __('screens.flags.remove_flag') ?></button>
                        </form>
                    <?php else: ?>
                        <?= __('screens.flags.no_active_flag') ?>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
</div>

<!-- Right: Flags Grid Container -->
<div id="flags_container">
    <?php
    // Create grid: 8 rows (types) x 9 columns (levels 1-9)
    $displayTypes = [1, 2, 3, 4, 5, 6, 7, 8];

    foreach ($displayTypes as $tipo):
        $flagType = $flagTypeMap[$tipo];

        // Each row shows 9 levels for this flag type
        for ($nivel = 1; $nivel <= 9; $nivel++):
            // Check if user owns this flag
            $owned = false;
            $count = 0;

            if (isset($flags_by_type[$flagType][$nivel])) {
                $owned = true;
                $count = $flags_by_type[$flagType][$nivel]['count'] ?? 1;
            }

            // Check if active
            $isActive = $active_flag &&
                $active_flag['flag_type'] === $flagType &&
                $active_flag['flag_level'] === $nivel;

            // Determine which image to show
            if ($owned) {
                // Show actual flag image
                $bgClass = '';
                $bgStyle = "background-image: url('graphic/flags/medium/{$tipo}_{$nivel}.png');";
            } else {
                // Show empty placeholder (none_X.png based on column)
                $colorIndex = $nivel;
                $bgClass = "flag_box_empty_" . $colorIndex;
                $bgStyle = '';
            }

            $flagClass = 'flag_box ' . $bgClass;
            if ($isActive)
                $flagClass .= ' flag_box_red';
            if ($owned)
                $flagClass .= ' flag_clickable';

            $flagName = \App\Models\FlagsModel::getFlagName($flagType);
            $flagBonus = \App\Models\FlagsModel::getFlagEffectDescription($flagType, $nivel);
            ?>
            <div class="<?= $flagClass ?>" style="<?= $bgStyle ?>" title="<?= htmlspecialchars($flagBonus) ?>"
                data-type="<?= $tipo ?>" data-level="<?= $nivel ?>" <?php if ($owned): ?>
                    onclick="selectFlag(<?= $tipo ?>, <?= $nivel ?>, '<?= addslashes($flagName) ?>', '<?= addslashes($flagBonus) ?>')" <?php endif; ?>>

                <?php if ($owned): ?>
                    <!-- Flag count badge (bottom right) -->
                    <span class="flag_count"><?= $count ?></span>

                    <!-- Upgrade button (bottom left) -->
                    <?php if ($count >= 6 && $nivel < 9): ?>
                        <div class="flag_multi_upgrade" onclick="event.stopPropagation(); upgradeFlagMulti(<?= $tipo ?>, <?= $nivel ?>)"
                            title="Combinar 6 bandeiras para 2 do nível <?= $nivel + 1 ?>"></div>
                    <?php elseif ($count >= 3 && $nivel < 9): ?>
                        <div class="flag_upgrade" onclick="event.stopPropagation(); upgradeFlag(<?= $tipo ?>, <?= $nivel ?>)"
                            title="Combinar 3 bandeiras para nível <?= $nivel + 1 ?>"></div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php
        endfor;
    endforeach;
    ?>
    <div  class="clear-both"></div>

    <!-- Progress Section (Moved inside flags_container) -->
    <table class="vis w-100 mt-20" >
        <tr>
            <th colspan="3"><?= __('screens.flags.flag_progress_title') ?></th>
        </tr>

        <!-- Row 1: Comprar -->
        <tr>
            <td  class="text-center" style="width: 60px;">
                <img src="graphic/new/flag/buy.webp" alt="Premium">
            </td>
            <td  class="v-align-top" style="padding-bottom: 8px; padding-top: 3px;">
                <strong><?= __('screens.flags.buy_flags') ?></strong><br>
                <?= __('screens.flags.buy_flags_desc') ?><br>
                <div  class="mt-5">
                    <button class="btn"><?= __('screens.flags.show_flag_package') ?></button>
                </div>
            </td>
            <td  class="text-right v-align-top" style="width: 60px;">
                <img src="graphic/flags/small/3.png" title="<?= __('screens.common.level') ?> 3"
                    style="margin-right: -2px;">
                <img src="graphic/flags/small/4.png" title="<?= __('screens.common.level') ?> 4"
                    style="margin-right: -2px;">
                <img src="graphic/flags/small/5.png" title="<?= __('screens.common.level') ?> 5">
            </td>
        </tr>

        <!-- Row 2: Metas (Achievements) -->
        <?php
        $achievCurrent = $progress['achievements'] ?? 0;
        $achievMax = 150;
        $achievPercent = min(100, ($achievCurrent / $achievMax) * 100);
        ?>
        <tr>
            <td  class="text-center">
                <img src="graphic/new/flag/award.png" alt="Metas">
            </td>
            <td>
                <strong><?= __('screens.flags.achievements') ?></strong><br>
                <?= __('screens.flags.achievements_desc') ?><br>
                <div  class="mt-5" style="margin-bottom: 2px;"><?= __('screens.flags.next_flag_architect_bronze', ['level_label' => __('screens.common.level')]) ?></div>
                <div class="flag-progress-container">
                    <div class="flag-progress-fill"  style="width: <?= $achievPercent ?>%;"></div>
                    <div class="flag-progress-text"><?= $achievCurrent ?> / <?= $achievMax ?></div>
                </div>
            </td>
            <td  class="text-right v-align-top">
                <img src="graphic/flags/small/3.png" title="<?= __('screens.common.level') ?> 3">
            </td>
        </tr>

        <!-- Row 3: Derrotar unidades -->
        <?php
        $defeatCurrent = $progress['defeats'] ?? 0;
        $defeatMax = 200;
        $defeatPercent = min(100, ($defeatCurrent / $defeatMax) * 100);
        ?>
        <tr>
            <td  class="text-center">
                <img src="graphic/new/flag/kills.webp" alt=" Ataque">
            </td>
            <td>
                <strong><?= __('screens.flags.defeat_units') ?></strong><br>
                <?= __('screens.flags.defeat_units_desc') ?><br>
                <div  class="mt-5" style="margin-bottom: 2px;"><?= __('screens.flags.next_flag_defeat_units', ['count' => 200]) ?></div>
                <div class="flag-progress-container">
                    <div class="flag-progress-fill"  style="width: <?= $defeatPercent ?>%;"></div>
                    <div class="flag-progress-text"><?= $defeatCurrent ?> / <?= $defeatMax ?></div>
                </div>
            </td>
            <td  class="text-right v-align-top">
                <img src="graphic/flags/small/4.png" title="<?= __('screens.common.level') ?> 1">
            </td>
        </tr>

        <!-- Row 4: Nobresa -->
        <tr>
            <td  class="text-center">
                <img src="graphic/new/flag/gold.webp" alt="Nobre">
            </td>
            <td>
                <strong><?= __('screens.flags.nobles_produced') ?></strong><br>
                <?= __('screens.flags.nobles_produced_desc') ?>
            </td>
            <td  class="text-right v-align-top">
                <img src="graphic/flags/small/1.png" title="<?= __('screens.common.level') ?> 1">
            </td>
        </tr>

        <!-- Row 5: Convidar -->
        <tr>
            <td  class="text-center">
                <img src="graphic/new/flag/invite.webp" alt="Convidar"  style="opacity: 0.7;">
            </td>
            <td>
                <strong><?= __('screens.flags.invite_players') ?></strong><br>
                <?= __('screens.flags.invite_players_desc') ?><br>
                <div  class="mt-5">
                    <a href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=profile&mode=invite"
                        class="btn"><?= __('screens.flags.invite_players') ?></a>
                </div>
            </td>
            <td  class="text-right v-align-top">
                <img src="graphic/flags/small/3.png" title="<?= __('screens.common.level') ?> 4">
            </td>
        </tr>
    </table>
</div>

<div  class="clear-both"></div>

<!-- Flag Selection Modal -->
<div id="flagSelectionModal"
     style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #f4e4bc; border: 2px solid #7d510f; padding: 20px; z-index: 1000; border-radius: 8px;">
    <table class="vis">
        <tr>
            <th><?= __('screens.flags.select_a_flag') ?></th>
        </tr>
        <tr>
            <td  class="text-center" style="padding: 20px;">
                <img id="modalFlagImage" src="" alt=""  class="mb-10" style="width: 60px; height: 60px;"><br>
                <strong id="modalFlagName"></strong><br>
                <span id="modalFlagBonus"></span><br><br>
                <button onclick="activateSelectedFlag()" class="btn"
                     style="background: green; color: white; margin-right: 10px;"><?= __('screens.flags.activate') ?></button>
                <button onclick="closeModal()" class="btn btn-cancel"><?= __('screens.flags.cancel') ?></button>
            </td>
        </tr>
    </table>
</div>
<div id="modalOverlay"
     class="w-100" style="display: none; position: fixed; top: 0; left: 0; height: 100%; background: rgba(0,0,0,0.5); z-index: 999;"
    onclick="closeModal()"></div>

<!-- Duplicate Table Removed -->

<script>
    let selectedFlagType = null;
    let selectedFlagLevel = null;

    function selectFlag(tipo, nivel, name, bonus) {
        // Current 'tipo' is the numeric ID (1-9) passed from the loop
        // But the backend expects the string name (e.g., 'resource_wood')
        // We need to map it back before submitting
        const flagTypeMap = {
            1: 'resource_wood',
            2: 'recruitment',
            3: 'attack',
            4: 'defense',
            5: 'luck',
            6: 'population',
            7: 'coin_cost',
            8: 'cargo'
        };

        selectedFlagType = flagTypeMap[tipo];
        selectedFlagLevel = nivel;

        // Update modal content - use numeric Type ID for image path
        document.getElementById('modalFlagImage').src = `graphic/flags/medium/${tipo}_${nivel}.png`;
        document.getElementById('modalFlagName').textContent = name;
        document.getElementById('modalFlagBonus').textContent = bonus;

        // Show modal
        document.getElementById('flagSelectionModal').style.display = 'block';
        document.getElementById('modalOverlay').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('flagSelectionModal').style.display = 'none';
        document.getElementById('modalOverlay').style.display = 'none';
        selectedFlagType = null;
        selectedFlagLevel = null;
    }

    function activateSelectedFlag() {
        if (selectedFlagType && selectedFlagLevel) {
            // Submit activation form
            const form = document.createElement('form');
            form.method = 'POST';
            // Explicitly set current URL as action to ensure it posts to the controller
            form.action = window.location.href;
            form.innerHTML = `
                <input type="hidden" name="action" value="activate">
                <input type="hidden" name="flag_type" value="${selectedFlagType}">
                <input type="hidden" name="flag_level" value="${selectedFlagLevel}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }

    function upgradeFlag(flagTypeId, flagLevel) {
        console.log('Upgrading flag:', flagTypeId, flagLevel);
        const flagTypeMap = {
            1: 'resource_wood',
            2: 'recruitment',
            3: 'attack',
            4: 'defense',
            5: 'luck',
            6: 'population',
            7: 'coin_cost',
            8: 'cargo'
        };
        const flagTypeString = flagTypeMap[flagTypeId];

        if (flagTypeString && flagLevel) {
            const form = document.createElement('form');
            form.method = 'POST';
            // Explicitly set current URL as action
            form.action = window.location.href;
            form.innerHTML = `
                <input type="hidden" name="action" value="upgrade">
                <input type="hidden" name="flag_type" value="${flagTypeString}">
                <input type="hidden" name="flag_level" value="${flagLevel}">
            `;
            document.body.appendChild(form);
            form.submit();
        } else {
            console.error('Invalid flag type or level for upgrade');
        }
    }

    function upgradeFlagMulti(flagTypeId, flagLevel) {
        console.log('Multi Upgrading flag:', flagTypeId, flagLevel);
        const flagTypeMap = {
            1: 'resource_wood',
            2: 'recruitment',
            3: 'attack',
            4: 'defense',
            5: 'luck',
            6: 'population',
            7: 'coin_cost',
            8: 'cargo'
        };
        const flagTypeString = flagTypeMap[flagTypeId];

        if (flagTypeString && flagLevel) {
            const form = document.createElement('form');
            form.method = 'POST';
            // Explicitly set current URL as action
            form.action = window.location.href;
            form.innerHTML = `
                <input type="hidden" name="action" value="upgrade_multi">
                <input type="hidden" name="flag_type" value="${flagTypeString}">
                <input type="hidden" name="flag_level" value="${flagLevel}">
            `;
            document.body.appendChild(form);
            form.submit();
        } else {
            console.error('Invalid flag type or level for multi upgrade');
        }
    }
</script>

<link rel="stylesheet" href="/public/css/flags.css">
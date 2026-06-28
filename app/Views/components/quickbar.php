<?php
/**
 * Quickbar Component
 * Displays quick access links to main buildings
 * <!-- ANTIGRAVITY QUICKBAR v2.1 (MARKET FIXED) -->
 */

// Get village data
$village_id = $village['id'] ?? 0;

// Get user's custom quickbar selection
$quickbar_buildings = [];
if (!empty($user['quickbar_buildings'])) {
    $decoded = json_decode($user['quickbar_buildings'], true);
    if (is_array($decoded) && !empty($decoded)) {
        $quickbar_buildings = $decoded;
    }
}

// Default buildings if no custom selection
if (empty($quickbar_buildings)) {
    $quickbar_buildings = ['main', 'barracks', 'stable', 'garage', 'snob', 'smith', 'place', 'market'];
}

// Building names are now handled by the translation system in the loop below

// Check if user has show_toolbar enabled (default to true for now)
$show_toolbar = $user['show_toolbar'] ?? 1;

if ($show_toolbar == 1):
    ?>
    <table id="quickbar_outer" align="left" cellspacing="0" width="100%">
        <tbody>
            <tr>
                <td>
                    <table id="quickbar_inner" style="border-collapse: collapse;" width="100%">
                        <tbody>
                            <tr class="topborder">
                                <td class="left"> </td>
                                <td class="main"> </td>
                                <td class="right"> </td>
                            </tr>
                            <tr>
                                <td class="left"> </td>
                                <td class="main">
                                    <ul class="menu quickbar"
                                        style="display: flex; flex-wrap: nowrap; justify-content: flex-start; overflow-x: auto; white-space: nowrap;">
                                        <?php foreach ($quickbar_buildings as $building_key): ?>
                                            <?php
                                            // Translate building name
                                            $building_name = __("buildings.{$building_key}.name");
                                            $level = $village[$building_key] ?? 0;
                                            $icon_path = "/graphic/buildings/{$building_key}.png";
                                            
                                            // Special URL for market as requested by user
                                            $url = "game.php?village={$village_id}&screen={$building_key}";
                                            if ($building_key === 'market') {
                                                $url .= "&mode=other_offer";
                                            }
                                            
                                            // Localized title
                                            $title = $building_name . " (" . __('common.level') . " " . $level . ")";
                                            ?>
                                            <li style="flex-shrink: 0;">
                                                <span>
                                                    <a href="<?= $url ?>">
                                                        <img src="<?= $icon_path ?>"
                                                            title="<?= htmlspecialchars($title) ?>"
                                                            alt="<?= htmlspecialchars($building_name) ?>" />
                                                        <?= htmlspecialchars($building_name) ?>
                                                    </a>
                                                </span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td class="right"> </td>
                            </tr>
                            <tr class="bottomborder">
                                <td class="left"> </td>
                                <td class="main"> </td>
                                <td class="right"> </td>
                            </tr>
                            <tr>
                                <td class="shadow" colspan="3">
                                    <div class="leftshadow"> </div>
                                    <div class="rightshadow"> </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
<?php endif; ?>
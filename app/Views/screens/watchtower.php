<?php
/**
 * Watchtower Screen View
 */
?>
<table>
    <tr>
        <td>
            <img src="graphic/big_buildings/watchtower1.png" title="Torre de vigia" alt="" />
        </td>
        <td>
            <h2><?= __('screens.watchtower.title') ?> (<?= __('screens.main.level') ?> <?= $watchtower_level ?>)</h2>
            <p><?= __('screens.watchtower.description') ?></p>
        </td>
    </tr>
</table>

<br>

<table width="100%">
    <tr>
        <td valign="top" width="60%">
            <!-- Ativa Info -->
            <table class="vis" width="100%">
                <tr>
                    <th><?= __('screens.watchtower.active_title') ?></th>
                </tr>
                <tr>
                    <td>
                        <?= __('screens.watchtower.active_info_1') ?><br>
                        <?= __('screens.watchtower.active_info_2') ?>
                        <b><a href="help.php?mode=buildings#watchtower" target="_blank"><?= __('screens.watchtower.kb_link') ?></a></b>.
                    </td>
                </tr>
            </table>

            <br>
            
            <!-- Tipos de Informação -->
            <table class="vis" width="100%">
                <tr>
                    <th colspan="2"><?= __('screens.watchtower.info_types_title') ?></th>
                </tr>
                <tr>
                    <td width="20" align="center"><img src="graphic/command/attack_small.webp" alt=""></td>
                    <td><?= __('screens.watchtower.small_attack') ?> (1-1000 <?= __('screens.watchtower.troops') ?>)</td>
                </tr>
                <tr>
                    <td align="center"><img src="graphic/command/attack_medium.webp" alt=""></td>
                    <td><?= __('screens.watchtower.medium_attack') ?> (1000-5000 <?= __('screens.watchtower.troops') ?>)</td>
                </tr>
                <tr>
                    <td align="center"><img src="graphic/command/attack_large.webp" alt=""></td>
                    <td><?= __('screens.watchtower.large_attack') ?> (5000+ <?= __('screens.watchtower.troops') ?>)</td>
                </tr>
                <tr>
                    <td align="center"><img src="graphic/unit/unit_snob.png" alt=""></td>
                    <td><?= __('screens.watchtower.with_noble') ?></td>
                </tr>
                <tr>
                    <td align="center"><img align="right" src="graphic/command/watchtower_all_seeing_eye.webp" alt=""><img align="left" src="graphic/command/attack.webp" alt=""></td>
                    <td><?= __('screens.watchtower.will_be_detected') ?></td>
                </tr>
            </table>
        </td>
        
        <td valign="top" width="40%"  style="padding-left:10px;">
            <!-- Map View -->
            <table class="vis" width="100%">
                <tr>
                    <th><?= __('screens.watchtower.map_view') ?></th>
                </tr>
                <tr>
                    <td align="center"  style="position:relative;">
                        <div id="world-minimap"  style="margin: 0 auto; width: 200px;"></div>
                    </td>
                </tr>
            </table>

            <script>
                var isWatchtowerScreen = true;
                var currentVillageId = <?= $village['id'] ?>;
                var currentVillageX = <?= $village['x'] ?>;
                var currentVillageY = <?= $village['y'] ?>;
                var currentMapSize = 15; // default viewport size
                
                // Inject fake map data so minimap naturally renders the watchtower ring
                window.mapData = {
                    watchtower_circles: [
                        { x: currentVillageX, y: currentVillageY, radius: <?= $detection_range ?> }
                    ],
                    faith_circles: []
                };
            </script>
            <script src="/js/map_leaflet_combined.js?v=<?= file_exists(__DIR__ . '/../../../public/js/map_leaflet_combined.js') ? filemtime(__DIR__ . '/../../../public/js/map_leaflet_combined.js') : '1' ?>"></script>

            <br>
            
            <!-- Ranges table -->
            <table class="vis" width="100%">
                <?php 
                $ranges = [
                    1 => 1.1, 2 => 1.3, 3 => 1.5, 4 => 1.7, 5 => 2.0,
                    6 => 2.3, 7 => 2.6, 8 => 3.0, 9 => 3.4, 10 => 3.9,
                    11 => 4.4, 12 => 5.1, 13 => 5.8, 14 => 6.7, 15 => 7.6,
                    16 => 8.7, 17 => 10.0, 18 => 11.5, 19 => 13.1, 20 => 15.0
                ];
                
                foreach ($ranges as $lvl => $range): ?>
                <tr>
                    <td <?= ($lvl == $watchtower_level) ? 'class="selected"' : '' ?>>
                        <?= ($lvl == $watchtower_level) ? '<b>' : '' ?>
                        <?= __('screens.main.level') ?> <?= $lvl ?>
                        <?= ($lvl == $watchtower_level) ? '</b>' : '' ?>
                    </td>
                    <td <?= ($lvl == $watchtower_level) ? 'class="selected"' : '' ?>>
                        <?= ($lvl == $watchtower_level) ? '<b>' : '' ?>
                        <?= $range ?> <?= __('screens.watchtower.fields') ?>
                        <?= ($lvl == $watchtower_level) ? '</b>' : '' ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </td>
    </tr>
</table>

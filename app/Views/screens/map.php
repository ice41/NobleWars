<div class="map-screen">
    <?php
    $getMapGraphic = function ($graphicName) use ($map_folder) {
        if ($map_folder === 'map_dark') {
            $parts = explode('/', $graphicName);
            $filename = array_pop($parts);
            if (strpos($filename, 'n_') !== 0) {
                $graphicName = (count($parts) > 0 ? implode('/', $parts) . '/' : '') . 'n_' . $filename;
            }
        }
        return "graphic/{$map_folder}/{$graphicName}";
    };
    ?>
    <h2><?= __('screens.map.continent') ?> <span id="continent_id"><?= $mapa['kontynent'] ?></span></h2>

<<<<<<< Updated upstream
=======
    <!-- JS Error Debug Overlay -->
    <div id="js-debug-errors" style="color: #a94442; font-weight: bold; background-color: #f2dede; border: 2px solid #ebccd1; padding: 12px; border-radius: 4px; display: none; margin: 15px 0; font-family: monospace; font-size: 13px; z-index: 999999; position: relative;"></div>
    <script>
    window.addEventListener('error', function(e) {
        var errDiv = document.getElementById('js-debug-errors');
        if (errDiv) {
            errDiv.style.display = 'block';
            errDiv.innerHTML += '<div style="margin-bottom: 5px;">⚠️ JS Error: ' + e.message + ' at ' + e.filename + ':' + e.lineno + '</div>';
        }
    });
    </script>

    <!-- Map specific styles -->
    <link rel="stylesheet" href="/css/map.css" />

>>>>>>> Stashed changes
    <!-- Leaflet.js CSS -->
    <link rel="stylesheet" href="/css/leaflet.css" />
    <style>
        /* Remove default Leaflet divIcon styling */
        .village-icon-with-ownership {
            background: none !important;
            border: none !important;
        }
    </style>

    <!-- Map Mode Toggle -->
    <!-- <div style="margin: 10px 0; text-align: right;">
        <button id="toggle-drag-mode" class="btn" style="font-size: 11px;">
            <span id="mode-text">🖱️ Ativar Modo Arrastável</span>
        </button>
    </div> -->

    <!-- Static Map Container -->
    <div id="map-static">
        <table class="padding2">
            <tr>
                <td valign="top">
                    <!-- Map table hidden when using JS map -->
                    <table class="map_container padding2" cellspacing="0" cellpadding="0" style="display: none;">
                        <tr>
                            <td align="center"><a
                                    href="game.php?village=<?= $village['id'] ?>&screen=map&x=<?= $mapa['x'] - $mapa['polowa'] ?>&y=<?= $mapa['y'] - $mapa['polowa'] ?>"><img
                                        src="graphic/<?= $map_folder ?>/map_nw.png"
                                        style="z-index:1; position:relative;" alt="" /></a>
                            </td>
                            <td align="center"><a
                                    href="game.php?village=<?= $village['id'] ?>&screen=map&x=<?= $mapa['x'] ?>&y=<?= $mapa['y'] - $mapa['polowa'] ?>"><img
                                        src="graphic/<?= $map_folder ?>/map_n.png"
                                        style="z-index:1; position:relative;" alt="map/map_n.png" /></a></td>
                            <td align="center"><a
                                    href="game.php?village=<?= $village['id'] ?>&screen=map&x=<?= $mapa['x'] + $mapa['polowa'] ?>&y=<?= $mapa['y'] - $mapa['polowa'] ?>"><img
                                        src="graphic/<?= $map_folder ?>/map_ne.png"
                                        style="z-index:1; position:relative;" alt="map/map_ne.png" /></a></td>
                        </tr>
                        <tr>
                            <td align="center"><a
                                    href="game.php?village=<?= $village['id'] ?>&screen=map&x=<?= $mapa['x'] - $mapa['polowa'] ?>&y=<?= $mapa['y'] ?>"><img
                                        src="graphic/<?= $map_folder ?>/map_w.png"
                                        style="z-index:1; position:relative;" alt="map/map_w.png" /></a></td>
                            <td>
                                <table
                                    style="border: 1px solid rgb(248, 237, 206); background-color: rgb(248, 237, 206); border-spacing: 0px; vertical-align:middle;padding: 0px 0px;"
                                    cellpadding="0" cellspacing="0">
                                    <?php foreach ($y_coords as $y): ?>
                                        <tr>
                                            <td width="20"><?= $y ?></td>
                                            <?php foreach ($x_coords as $x): ?>
                                                <?php $coords = $x . '|' . $y; ?>
                                                <?php
                                                // Check faith coverage
                                                $has_faith = false;
                                                foreach ($faith_circles as $fc) {
                                                    $dist = sqrt(pow($x - $fc['x'], 2) + pow($y - $fc['y'], 2));
                                                    if ($dist <= $fc['radius']) {
                                                        $has_faith = true;
                                                        break;
                                                    }
                                                }
                                                
                                                // Check watchtower coverage
                                                $has_watchtower = false;
                                                foreach ($watchtower_circles as $wtc) {
                                                    $dist = sqrt(pow($x - $wtc['x'], 2) + pow($y - $wtc['y'], 2));
                                                    if ($dist <= $wtc['radius']) {
                                                        $has_watchtower = true;
                                                        break;
                                                    }
                                                }
                                                ?>

                                                <?php if (!$mapLibrary->isVillage($coords)): ?>
                                                    <?php if ($mapLibrary->isGhost($coords)): ?>
                                                        <?php
                                                        $ghost = $mapLibrary->getGhostData($coords);
                                                        $isPending = $ghost['status'] === 'pending';
                                                        $inviteUrl = $isPending 
                                                            ? "game.php?village=" . $village['id'] . "&screen=profile&mode=invite" 
                                                            : "game.php?village=" . $village['id'] . "&screen=profile&mode=invite&invite_x=" . $x . "&invite_y=" . $y;
                                                        $inviteText = $isPending ? __('screens.map.invited_friend') : __('screens.map.invite_friend');
                                                        $graphicFile = (isset($map_folder) && $map_folder === 'map_dark') ? 'n_ghost.png' : 'ghost.png';
                                                        ?>
                                                        <td id="tile_<?= $x ?>_<?= $y ?>" style="position: relative;">
                                                            <a href="<?= $inviteUrl ?>">
                                                                <img src="graphic/<?= $map_folder ?>/<?= $graphicFile ?>" 
                                                                     title="<?= $inviteText ?> (<?= $x ?>|<?= $y ?>)" 
                                                                     alt="<?= $inviteText ?>" />
                                                            </a>
                                                            <?php if ($has_faith): ?>
                                                                <div style="position:absolute; top:0; left:0; width:53px; height:38px; background-color: rgba(0, 0, 255, 0.15); pointer-events: none;"></div>
                                                            <?php endif; ?>
                                                            <?php if ($has_watchtower): ?>
                                                                <div style="position:absolute; top:0; left:0; width:53px; height:38px; background-color: rgba(150, 255, 0, 0.2); pointer-events: none;"></div>
                                                            <?php endif; ?>
                                                        </td>
                                                    <?php elseif ($mapLibrary->isDecoration($coords)): ?>
                                                        <?php $dec = $mapLibrary->getDecoration($coords); ?>
                                                        <td id="tile_<?= $x ?>_<?= $y ?>" style="position: relative;">
                                                            <img src="<?= $getMapGraphic($dec['typ'] . '.png') ?>" alt="" />
                                                            <?php if ($has_faith): ?>
                                                                <div style="position:absolute; top:0; left:0; width:53px; height:38px; background-color: rgba(0, 0, 255, 0.15); pointer-events: none;"></div>
                                                            <?php endif; ?>
                                                            <?php if ($has_watchtower): ?>
                                                                <div style="position:absolute; top:0; left:0; width:53px; height:38px; background-color: rgba(150, 255, 0, 0.2); pointer-events: none;"></div>
                                                            <?php endif; ?>
                                                        </td>
                                                    <?php elseif ($mapLibrary->isBush($coords)): ?>
                                                        <td id="tile_<?= $x ?>_<?= $y ?>" style="position: relative;">
                                                            <img src="<?= $getMapGraphic($mapLibrary->getBushType($coords) . '.png') ?>"
                                                                alt="" />
                                                            <?php if ($has_faith): ?>
                                                                <div style="position:absolute; top:0; left:0; width:53px; height:38px; background-color: rgba(0, 0, 255, 0.15); pointer-events: none;"></div>
                                                            <?php endif; ?>
                                                            <?php if ($has_watchtower): ?>
                                                                <div style="position:absolute; top:0; left:0; width:53px; height:38px; background-color: rgba(150, 255, 0, 0.2); pointer-events: none;"></div>
                                                            <?php endif; ?>
                                                        </td>
                                                    <?php elseif ($mapLibrary->isGrass($coords)): ?>
                                                        <td id="tile_<?= $x ?>_<?= $y ?>" style="position: relative;">
                                                            <img src="<?= $getMapGraphic($mapLibrary->getGrassType($coords) . '.png') ?>"
                                                                alt="" />
                                                            <?php if ($has_faith): ?>
                                                                <div style="position:absolute; top:0; left:0; width:53px; height:38px; background-color: rgba(0, 0, 255, 0.15); pointer-events: none;"></div>
                                                            <?php endif; ?>
                                                            <?php if ($has_watchtower): ?>
                                                                <div style="position:absolute; top:0; left:0; width:53px; height:38px; background-color: rgba(150, 255, 0, 0.2); pointer-events: none;"></div>
                                                            <?php endif; ?>
                                                        </td>
                                                    <?php else: ?>
                                                        <td id="tile_<?= $x ?>_<?= $y ?>" style="position: relative;">
                                                            <img src="<?= $getMapGraphic('gras1.png') ?>" alt="" />
                                                            <?php if ($has_faith): ?>
                                                                <div style="position:absolute; top:0; left:0; width:53px; height:38px; background-color: rgba(0, 0, 255, 0.15); pointer-events: none;"></div>
                                                            <?php endif; ?>
                                                            <?php if ($has_watchtower): ?>
                                                                <div style="position:absolute; top:0; left:0; width:53px; height:38px; background-color: rgba(150, 255, 0, 0.2); pointer-events: none;"></div>
                                                            <?php endif; ?>
                                                        </td>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <td id="tile_<?= $x ?>_<?= $y ?>"
                                                        style="<?= $mapLibrary->getVillageColorStyle($coords, $village['id'], $user['id'], $user['ally'] ?? -1) ?> position: relative;">
                                                        <div style="width: 53px; height: 38px;">
                                                            <a id="map"
                                                                href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $mapLibrary->getVillageId($coords) ?>">
                                                                <img src="<?= $getMapGraphic($mapLibrary->getVillageGraphic($coords)) ?>"
                                                                    title="<?= $mapLibrary->getVillageName($coords) ?> (<?= $x ?>|<?= $y ?>) K<?= $mapLibrary->getContinent($coords) ?> - <?= $mapLibrary->getPlayerInfo($coords) ?> - <?= $mapLibrary->getAllyInfo($coords) ?>"
                                                                    alt="" />
                                                                <?= $mapLibrary->getVillageStatus($coords, $user['id'], $user['ally'] ?? -1) ?>
                                                                <?php if ($mapLibrary->getVillageId($coords) == $village['id']): ?>
                                                                    <img src="graphic/<?= $map_folder ?>/home.png" style="position: absolute; top: -50%; left: -25%; width: 150%; height: 200%; z-index: 5; pointer-events: none;" alt="" />
                                                                <?php endif; ?>
                                                                <?php if ($has_faith): ?>
                                                                    <div style="position:absolute; top:0; left:0; width:53px; height:38px; background-color: rgba(0, 0, 255, 0.15); pointer-events: none;"></div>
                                                                <?php endif; ?>
                                                                <?php if ($has_watchtower): ?>
                                                                    <div style="position:absolute; top:0; left:0; width:53px; height:38px; background-color: rgba(150, 255, 0, 0.2); pointer-events: none;"></div>
                                                                <?php endif; ?>
                                                            </a>
                                                        </div>
                                                    </td>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach; ?>

                                    <tr>
                                        <td height="20"></td>
                                        <?php foreach ($x_coords as $x): ?>
                                            <td><?= $x ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                </table>
                            </td>
                            <td align="center"><a
                                    href="game.php?village=<?= $village['id'] ?>&screen=map&x=<?= $mapa['x'] + $mapa['polowa'] ?>&y=<?= $mapa['y'] ?>"><img
                                        src="graphic/<?= $map_folder ?>/map_e.png"
                                        style="z-index:1; position:relative;" alt="map/map_e.png" /></a></td>
                        </tr>
                        <tr>
                            <td align="center"><a
                                    href="game.php?village=<?= $village['id'] ?>&screen=map&x=<?= $mapa['x'] - $mapa['polowa'] ?>&y=<?= $mapa['y'] + $mapa['polowa'] ?>"><img
                                        src="graphic/<?= $map_folder ?>/map_sw.png"
                                        style="z-index:1; position:relative;" alt="map/map_sw.png" /></a></td>
                            <td align="center"><a
                                    href="game.php?village=<?= $village['id'] ?>&screen=map&x=<?= $mapa['x'] ?>&y=<?= $mapa['y'] + $mapa['polowa'] ?>"><img
                                        src="graphic/<?= $map_folder ?>/map_s.png"
                                        style="z-index:1; position:relative;" alt="map/map_s.png" /></a></td>
                            <td align="center"><a
                                    href="game.php?village=<?= $village['id'] ?>&screen=map&x=<?= $mapa['x'] + $mapa['polowa'] ?>&y=<?= $mapa['y'] + $mapa['polowa'] ?>"><img
                                        src="graphic/<?= $map_folder ?>/map_se.png"
                                        style="z-index:1; position:relative;" alt="map/map_se.png" /></a></td>
                        </tr>
                    </table>

                    <!-- JavaScript Map System (replaces static map table) -->
                    <div id="js-map-container" style="width: 795px; height: 570px;"></div>

                    <table class="vis" width="100%" style="margin-top: 8px;">
                        <tr>
                            <th><b><?= __('screens.map.display_options') ?: 'Opções de Exibição' ?></b></th>
                        </tr>
                        <?php if (!empty($config['church'])): ?>
                            <tr>
                                <td style="padding: 5px;">
                                    <label for="cb-map-faith"
                                        style="cursor: pointer; display: flex; align-items: center; gap: 5px;">
                                        <input type="checkbox" id="cb-map-faith"
                                            onchange="if(window.jsMapSystem) window.jsMapSystem.toggleFaithCircles(this.checked);" />
                                        <?= __('screens.map.show_church_influence') ?: 'Mostrar raio de influência da Igreja' ?>
                                    </label>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($config['watchtower'])): ?>
                            <tr>
                                <td style="padding: 5px;">
                                    <label for="cb-map-watchtower"
                                        style="cursor: pointer; display: flex; align-items: center; gap: 5px;">
                                        <input type="checkbox" id="cb-map-watchtower"
                                            onchange="if(window.jsMapSystem) window.jsMapSystem.toggleWatchtowerCircles(this.checked);" />
                                        <?= __('screens.map.show_watchtower_influence') ?: 'Mostrar raio de influência da Torre de Vigia' ?>
                                    </label>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </td>
                <td valign="top" style="padding-left: 10px;">
                    <table class="vis padding2" width="100%">
                        <tr>
                            <th><b><?= __('screens.map.center_map') ?></b></th>
                        </tr>
                        <tr>
                            <td>
                                <form action="game.php?village=<?= $village['id'] ?>&screen=map" method="get">
                                    <input type="hidden" name="village" value="<?= $village['id'] ?>" />
                                    <input type="hidden" name="screen" value="map" />
                                    <table>
                                        <tr>
                                            <td>x: <input type="text" name="x" value="<?= $mapa['x'] ?>" size="5" /> y:
                                                <input type="text" name="y" value="<?= $mapa['y'] ?>" size="5" />
                                            </td>
                                            <td><input class="btn btn-defult" type="submit"
                                                    value="<?= __('screens.map.map_coord_btn') ?>"
                                                    style="font-size: 10pt;" /></td>
                                        </tr>
                                    </table>
                                </form>
                            </td>
                        </tr>
                    </table>

                    <br>

                    <!-- World Minimap -->
                    <table class="vis" width="100%">
                        <tr>
                            <th><b><?= __('screens.map.world_map') ?></b></th>
                        </tr>
                        <tr>
                            <td align="center">
                                <div id="world-minimap" style="padding: 10px;"></div>
                            </td>
                        </tr>
                    </table>

                    <br>

                    <table class="vis padding2" width="100%">
                        <tr>
                            <th><b><?= __('screens.map.map_size') ?></b></th>
                        </tr>
                        <tr>
                            <td>
                                <form
                                    action="game.php?village=<?= $village['id'] ?>&screen=map&action=zapisz_rozmiar_mapy"
                                    method="post">
                                    <table class="vis" width="100%">
                                        <tr>
                                            <td width="50%">
                                                <center>
                                                    <select name="map_size" style="width: 80%;">
                                                        <option label="7x7" value="7" <?= ($mapSize == 7) ? 'selected' : '' ?>>
                                                            7x7</option>
                                                        <option label="9x9" value="9" <?= ($mapSize == 9) ? 'selected' : '' ?>>
                                                            9x9</option>
                                                        <option label="11x11" value="11" <?= ($mapSize == 11) ? 'selected' : '' ?>>11x11</option>
                                                        <option label="13x13" value="13" <?= ($mapSize == 13) ? 'selected' : '' ?>>13x13</option>
                                                        <option label="15x15" value="15" <?= ($mapSize == 15) ? 'selected' : '' ?>>15x15</option>
                                                        <option label="19x19" value="19" <?= ($mapSize == 19) ? 'selected' : '' ?>>19x19</option>
                                                        <option label="23x23" value="23" <?= ($mapSize == 23) ? 'selected' : '' ?>>23x23</option>
                                                        <option label="31x31" value="31" <?= ($mapSize == 31) ? 'selected' : '' ?>>31x31</option>
                                                    </select>
                                                </center>
                                            </td>
                                            <td width="50%">
                                                <center>
                                                    <input class="btn btn-defult" type="submit"
                                                        value="<?= __('screens.map.map_size_btn') ?>"
                                                        style="font-size: 10pt; width: 50%;" />
                                                </center>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </td>
                        </tr>
                    </table>

                    <br>

                    <table
                        style="border: 1px solid rgb(140, 95, 13); background-color: rgb(244, 228, 188); margin-left: 0px; border-collapse: separate; text-align: left; width: auto;"
                        class="padding2" width="1">
                        <tbody>
                            <tr class="nowrap">
                                <td class="small" valign="top"><?= __('screens.map.legend_default') ?></td>
                                <td
                                    style="padding: 0px; width: 15px; min-width: 15px; height: 15px; background-color: rgb(255, 255, 255);">&nbsp;
                                </td>
                                <td class="small" style="white-space: normal;"><?= __('screens.map.legend_selected') ?>
                                </td>
                                <td
                                    style="padding: 0px; width: 15px; min-width: 15px; height: 15px; background-color: rgb(240, 200, 0);">&nbsp;
                                </td>
                                <td class="small" style="white-space: normal;">
                                    <?= __('screens.map.legend_own_villages') ?>
                                </td>
                                <td
                                    style="padding: 0px; width: 15px; min-width: 15px; height: 15px; background-color: rgb(0, 0, 244);">&nbsp;
                                </td>
                                <td class="small" style="white-space: normal;"><?= __('screens.map.legend_tribe') ?>
                                </td>
                                <td
                                    style="padding: 0px; width: 15px; min-width: 15px; height: 15px; background-color: rgb(150, 150, 150);">&nbsp;
                                </td>
                                <td class="small" style="white-space: normal;"><?= __('screens.map.legend_barbarian') ?>
                                </td>
                                <td
                                    style="padding: 0px; width: 15px; min-width: 15px; height: 15px; background-color: rgb(130, 60, 10);">&nbsp;
                                </td>
                                <td class="small" style="white-space: normal;"><?= __('screens.map.legend_other') ?>
                                </td>
                            </tr>
                            <tr class="nowrap">
                                <td class="small" valign="top"><?= __('screens.map.legend_tribe') ?></td>
                                <td
                                    style="padding: 0px; width: 15px; min-width: 15px; height: 15px; background-color: rgb(0, 160, 244);">&nbsp;
                                </td>
                                <td class="small" style="white-space: normal;"><?= __('screens.map.legend_allied') ?>
                                </td>
                                <td
                                    style="padding: 0px; width: 15px; min-width: 15px; height: 15px; background-color: rgb(128, 0, 128);">&nbsp;
                                </td>
                                <td class="small" style="white-space: normal;"><?= __('screens.map.legend_nap') ?></td>
                                <td
                                    style="padding: 0px; width: 15px; min-width: 15px; height: 15px; background-color: rgb(244, 0, 0);">&nbsp;
                                </td>
                                <td class="small" style="white-space: normal;"><?= __('screens.map.legend_enemies') ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="margin-top: 10px; font-weight: bold;">
                        <a href="game.php?village=<?= $village['id'] ?>&screen=edytuj_kolory_graczy">&raquo; <?= __('screens.ally.mark_on_map') ?: 'Marcar jogador no mapa' ?></a>
                    </div>
                </td>
            </tr>
        </table>

    </div>

    <!-- Leaflet Map Container (hidden by default) -->
    <div id='map-leaflet'
        style='display: none; width: 795px; height: 570px; border: 1px solid #8C5F0D; background: #F4E4BC; margin: 0 auto;'>
    </div>
</div>

<!-- Leaflet.js and TW Leaflet Map Script -->

<script>
    var currentMapX = <?= $mapa['x'] ?>;
    var currentMapSize = <?= $mapa['rozmiar'] ?? 13 ?>;
    var currentMapY = <?= $mapa['y'] ?>;

    var mapData = {
        x_coords: <?= json_encode($x_coords) ?>,
        y_coords: <?= json_encode($y_coords) ?>,
        tiles: [],
        faith_circles: <?= json_encode($faith_circles) ?>,
        watchtower_circles: <?= json_encode($watchtower_circles) ?>
    };

    // Build tiles data from PHP
    <?php foreach ($y_coords as $y): ?>
        <?php foreach ($x_coords as $x): ?>
            <?php
            $coords = $x . '|' . $y;
            $has_faith = false;
            foreach ($faith_circles as $fc) {
                $dist = sqrt(pow($x - $fc['x'], 2) + pow($y - $fc['y'], 2));
                if ($dist <= $fc['radius']) {
                    $has_faith = true;
                    break;
                }
            }

            if ($mapLibrary->isVillage($coords)):
                ?>
                mapData.tiles.push({
                    x: <?= $x ?>,
                    y: <?= $y ?>,
                    type: 'village',
                    id: <?= $mapLibrary->getVillageId($coords) ?>,
                    name: <?= json_encode($mapLibrary->getVillageName($coords)) ?>,
                    graphic: '<?= $mapLibrary->getVillageGraphic($coords) ?>',
                    color: '<?= $mapLibrary->getVillageColorStyle($coords, $village['id'], $user['id'], $user['ally'] ?? -1) ?>',
                    player: <?= json_encode($mapLibrary->getPlayerInfo($coords)) ?>,
                    ally: <?= json_encode($mapLibrary->getAllyInfo($coords)) ?>,
                    continent: '<?= $mapLibrary->getContinent($coords) ?>',
                    commands: <?= json_encode($mapLibrary->getVillageCommands($coords)) ?>
                });
            <?php elseif ($mapLibrary->isGhost($coords)):
                $ghost = $mapLibrary->getGhostData($coords);
                $isPending = $ghost['status'] === 'pending';
                ?>
                mapData.tiles.push({
                    x: <?= $x ?>,
                    y: <?= $y ?>,
                    type: 'ghost',
                    status: '<?= $ghost['status'] ?>',
                    title: <?= json_encode($isPending ? __('screens.map.invited_friend') : __('screens.map.invite_friend')) ?>,
                    description: <?= json_encode($isPending ? __('screens.map.invited_friend_desc', ['email' => htmlspecialchars($ghost['email'])]) : __('screens.map.invite_friend_desc')) ?>,
                    invite_url: '<?= $isPending ? "game.php?village=" . $village['id'] . "&screen=profile&mode=invite" : "game.php?village=" . $village['id'] . "&screen=profile&mode=invite&invite_x=" . $x . "&invite_y=" . $y ?>',
                    invite_text: '<?= $isPending ? __('screens.map.view_invites') : __('screens.map.invite') ?>',
                    graphic: 'ghost'
                });
            <?php elseif ($mapLibrary->isDecoration($coords)):
                $dec = $mapLibrary->getDecoration($coords);
                ?>
                mapData.tiles.push({ x: <?= $x ?>, y: <?= $y ?>, type: 'decoration', graphic: '<?= str_replace('.png', '', $dec['typ']) ?>' });
            <?php elseif ($mapLibrary->isBush($coords)): ?>
                mapData.tiles.push({ x: <?= $x ?>, y: <?= $y ?>, type: 'bush', graphic: '<?= str_replace('.png', '', $mapLibrary->getBushType($coords)) ?>' });
            <?php elseif ($mapLibrary->isGrass($coords)): ?>
                mapData.tiles.push({ x: <?= $x ?>, y: <?= $y ?>, type: 'grass', graphic: '<?= str_replace('.png', '', $mapLibrary->getGrassType($coords)) ?>' });
            <?php else: ?>
                mapData.tiles.push({ x: <?= $x ?>, y: <?= $y ?>, type: 'grass', graphic: 'gras1' });
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>

    console.log('Map data loaded:', Object.keys(mapData.tiles).length, 'tiles');

<<<<<<< Updated upstream
</div>

<!-- Leaflet Map Container -->
<div id="map-leaflet" style="display: none; width: 795px; height: 570px; border: 1px solid #8C5F0D; margin: 0 auto;">
</div>
</div>
<script src="/js/leaflet.js"></script>
<script src="/js/map_leaflet_combined.js?v=<?= file_exists(__DIR__ . '/../../../public/js/map_leaflet_combined.js') ? filemtime(__DIR__ . '/../../../public/js/map_leaflet_combined.js') : '1' ?>"></script>
<script>
    var currentMapX = <?= $mapa['x'] ?>;
    var currentMapY = <?= $mapa['y'] ?>;
    var currentVillageId = <?= $village['id'] ?>;
    var currentVillageX = <?= $village['x'] ?>;
    var currentVillageY = <?= $village['y'] ?>;
    var currentMapSize = <?= $mapSize ?>;
    var isNightMode = <?= isset($map_folder) && $map_folder === 'map_dark' ? 'true' : 'false' ?>;
    var mapFolder = '<?= $map_folder ?? 'map' ?>';
</script>

<!-- Village Popup Container (used by map_popup function) -->
<!--<div id="info"
    style="visibility: hidden; position: absolute; z-index: 1000; background: #f4e4bc; border: 2px solid #7d510f; padding: 8px; font-size: 11px; min-width: 200px;">
    <table class="vis" style="width: 100%;">
        <tr id="info_title_row">
            <th id="info_title" colspan="2"></th>
        </tr>
        <tr id="info_points_row">
            <td>Pontos:</td>
            <td id="info_points"></td>
        </tr>
        <tr id="info_owner_row" style="display: none;">
            <td>Proprietário:</td>
            <td id="info_owner"></td>
        </tr>
        <tr id="info_left_row" style="display: none;">
            <td colspan="2">Abandonada</td>
        </tr>
        <tr id="info_ally_row" style="display: none;">
            <td>Tribo:</td>
            <td id="info_ally"></td>
        </tr>
        <tr id="info_village_grocusto_row" style="display: none;">
            <td>Continente:</td>
            <td id="info_village_grocusto"></td>
        </tr>
        <tr id="info_bonus_image_row" style="display: none;">
            <td colspan="2" align="center">
                <img id="image" src="" alt="" />
            </td>
        </tr>
        <tr id="info_bonus_row" style="display: none;">
            <td>Bônus:</td>
            <td id="text_bonus"></td>
        </tr>
        <tr id="info_units_times_row" style="display: none;">
            <td colspan="2" id="info_units_times"></td>
        </tr>
    </table>
</div>-->

=======
    // Inicializa o mapa JavaScript assim que o DOM estiver pronto
    document.addEventListener('DOMContentLoaded', function () {
        var container = document.getElementById('js-map-container');
        var staticMap = document.querySelector('.map_container.padding2');

        if (container && typeof JSMapSystem !== 'undefined') {
            try {
                // Esconde o mapa estático e mostra o container JS
                if (staticMap) {
                    staticMap.style.display = 'none';
                }

                window.jsMapSystem = new JSMapSystem('js-map-container', {
                    currentX: currentMapX || 500,
                    currentY: currentMapY || 500,
                    mapSize: currentMapSize || 11,
                    villageId: currentVillageId,
                    village_x: currentVillageX,
                    village_y: currentVillageY,
                    preloadedData: mapData
                });
            } catch (err) {
                console.error('Erro ao inicializar JSMapSystem:', err);
                if (staticMap) {
                    staticMap.style.display = '';
                }
            }
        } else {
            // Fallback: mostra o mapa estático se o JS falhar
            if (staticMap) {
                staticMap.style.display = '';
            }
            console.warn('JSMapSystem não disponível; a usar mapa estático.');
        }
    });
</script>

>>>>>>> Stashed changes
<?php include __DIR__ . '/map_modal.php'; ?>
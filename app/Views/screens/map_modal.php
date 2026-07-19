<?php
// This file will be appended to the existing map.php
// It contains the context menu, modal, and JavaScript

// Check if user has farm assistant premium active
$has_farm_assistant = false;
if (isset($user['farm_assistant_expires']) && $user['farm_assistant_expires'] > time()) {
    $has_farm_assistant = true;
}
?>

<!-- Map Context Menu -->
<div id="map_context_menu" style="display: none; position: absolute; z-index: 10000;">
    <a id="mp_info" href="#" class="mp" style="background-position: -144px 0px;"></a>
    <a id="mp_att" href="#" class="mp" style="background-position: -24px 0px;"></a>
    <a id="mp_res" href="#" class="mp" style="background-position: 0px 0px;"></a>
    <a id="mp_farm_a" href="#" class="mp"
        style="background-position: -264px 0px;<?= !$has_farm_assistant ? ' opacity: 0.4; cursor: not-allowed;' : '' ?>"></a>
    <a id="mp_farm_b" href="#" class="mp"
        style="background-position: -288px 0px;<?= !$has_farm_assistant ? ' opacity: 0.4; cursor: not-allowed;' : '' ?>"></a>
</div>

<!-- Attack Modal -->
<div id="attack_modal_overlay" onclick="closeAttackModal(event)">
    <div id="attack_modal" onclick="event.stopPropagation()">
        <div id="attack_modal_header">
            <h3><?= __('screens.map.modal_title') ?: 'Enviar tropas' ?></h3>
            <button id="attack_modal_close" onclick="closeAttackModal()"
                title="<?= __('screens.map.close') ?: 'Fechar' ?>"></button>
        </div>
        <div id="attack_modal_body">
            <!-- Units Grid - No Headers -->
            <div class="units_grid_simple">
                <table cellspacing="0" cellpadding="0">
                    <tr>
                        <!-- Column 1: Infantry -->
                        <td class="unit_column" valign="top">
                            <table cellspacing="0" cellpadding="0" width="110%">
                                <tr>
                                    <td><img src="graphic/unit/unit_spear.png" style="width: 18px; height: 18px;"
                                            title="<?= __('screens.map.unit_spear') ?: 'Lanceiro' ?>" alt=""><input
                                            name="unit_spear" type="text" size="5" id="unit_spear"
                                            max="<?= $units['unit_spear'] ?? 0 ?>" value=""><a
                                            onclick="document.getElementById('unit_spear').value=<?= $units['unit_spear'] ?? 0 ?>">(<?= $units['unit_spear'] ?? 0 ?>)</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="graphic/unit/unit_sword.png" style="width: 18px; height: 18px;"
                                            title="<?= __('screens.map.unit_sword') ?: 'Espadachim' ?>" alt=""><input
                                            name="unit_sword" type="text" size="5" id="unit_sword" value=""><a
                                            onclick="document.getElementById('unit_sword').value=<?= $units['unit_sword'] ?? 0 ?>">(<?= $units['unit_sword'] ?? 0 ?>)</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="graphic/unit/unit_axe.png" style="width: 18px; height: 18px;"
                                            title="<?= __('screens.map.unit_axe') ?: 'Viking' ?>" alt=""><input
                                            name="unit_axe" type="text" size="5" id="unit_axe" value=""><a
                                            onclick="document.getElementById('unit_axe').value=<?= $units['unit_axe'] ?? 0 ?>">(<?= $units['unit_axe'] ?? 0 ?>)</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="graphic/unit/unit_archer.png" style="width: 18px; height: 18px;"
                                            title="<?= __('screens.map.unit_archer') ?: 'Arqueiro' ?>" alt=""><input
                                            name="unit_archer" type="text" size="5" id="unit_archer" value=""><a
                                            onclick="document.getElementById('unit_archer').value=0">(0)</a>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <!-- Column 2: Cavalry -->
                        <td class="unit_column" valign="top">
                            <table cellspacing="0" cellpadding="0" width="120%">
                                <tr>
                                    <td><img src="graphic/unit/unit_spy.png" style="width: 18px; height: 18px;"
                                            title="<?= __('screens.map.unit_spy') ?: 'Explorador' ?>" alt=""><input
                                            name="unit_spy" type="text" size="5" id="unit_spy" value=""><a
                                            onclick="document.getElementById('unit_spy').value=<?= $units['unit_spy'] ?? 0 ?>">(<?= $units['unit_spy'] ?? 0 ?>)</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="graphic/unit/unit_light.png" style="width: 18px; height: 18px;"
                                            title="<?= __('screens.map.unit_light') ?: 'Cavalaria leve' ?>"
                                            alt=""><input name="unit_light" type="text" size="5" id="unit_light"
                                            value=""><a
                                            onclick="document.getElementById('unit_light').value=<?= $units['unit_light'] ?? 0 ?>">(<?= $units['unit_light'] ?? 0 ?>)</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="graphic/unit/unit_marcher.png" style="width: 18px; height: 18px;"
                                            title="<?= __('screens.map.unit_marcher') ?: 'Arqueiro a cavalo' ?>"
                                            alt=""><input name="unit_marcher" type="text" size="5" id="unit_marcher"
                                            value=""><a
                                            onclick="document.getElementById('unit_marcher').value=0">(0)</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="graphic/unit/unit_heavy.png" style="width: 18px; height: 18px;"
                                            title="<?= __('screens.map.unit_heavy') ?: 'Cavalaria pesada' ?>"
                                            alt=""><input name="unit_heavy" type="text" size="2" id="unit_heavy"
                                            value=""><a
                                            onclick="document.getElementById('unit_heavy').value=<?= $units['unit_heavy'] ?? 0 ?>">(<?= $units['unit_heavy'] ?? 0 ?>)</a>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <!-- Column 3: Siege -->
                        <td class="unit_column" valign="top">
                            <table cellspacing="0" cellpadding="0" width="110%">
                                <tr>
                                    <td><img src="graphic/unit/unit_ram.png" style="width: 18px; height: 18px;"
                                            title="<?= __('screens.map.unit_ram') ?: 'Aríete' ?>" alt=""><input
                                            name="unit_ram" type="text" size="5" id="unit_ram" value=""><a
                                            onclick="document.getElementById('unit_ram').value=<?= $units['unit_ram'] ?? 0 ?>">(<?= $units['unit_ram'] ?? 0 ?>)</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="graphic/unit/unit_catapult.png" style="width: 18px; height: 18px;"
                                            title="<?= __('screens.map.unit_catapult') ?: 'Catapulta' ?>" alt=""><input
                                            name="unit_catapult" type="text" size="5" id="unit_catapult" value=""><a
                                            onclick="document.getElementById('unit_catapult').value=<?= $units['unit_catapult'] ?? 0 ?>">(<?= $units['unit_catapult'] ?? 0 ?>)</a>
                                    </td>
                                </tr>
                                <!-- Catapult Target Selector -->
                                <tr id="catapult_target_row" style="display: none;">
                                    <td colspan="2">
                                        <table class="vis" width="100%" style="margin-top: 5px;">
                                            <tr>
                                                <th><?= __('screens.map.catapult_target') ?></th>
                                                <td>
                                                    <select name="building" id="modal_building_select" size="1">
                                                        <?php
                                                        if (isset($cl_builds) && is_object($cl_builds)):
                                                            foreach ($cl_builds->get_array("dbname") as $dbname):
                                                                $specials = $cl_builds->get_specials($dbname) ?? [];
                                                                if (!in_array("catapult_protection", $specials)):
                                                                    ?>
                                                                    <option value="<?= $dbname ?>">
                                                                        <?= $cl_builds->get_name($dbname) ?>
                                                                    </option>
                                                                    <?php
                                                                endif;
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <!-- Column 4: Other -->
                        <td class="unit_column" valign="top">
                            <table cellspacing="0" cellpadding="0" width="110%">
                                <tr>
                                    <td><img src="graphic/unit/unit_knight.png" style="width: 18px; height: 18px;"
                                            title="<?= __('screens.map.unit_paladin') ?: 'Paladino' ?>" alt=""><input
                                            name="unit_knight" type="text" size="5" id="unit_knight" value=""><a
                                            onclick="document.getElementById('unit_knight').value=<?= $units['unit_knight'] ?? 0 ?>">(<?= $units['unit_knight'] ?? 0 ?>)</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="graphic/unit/unit_snob.png" style="width: 18px; height: 18px;"
                                            title="<?= __('screens.map.unit_noble') ?: 'Nobre' ?>" alt=""><input
                                            name="unit_snob" type="text" size="5" id="unit_snob" value=""><a
                                            onclick="document.getElementById('unit_snob').value=<?= $units['unit_snob'] ?? 0 ?>">(<?= $units['unit_snob'] ?? 0 ?>)</a>
                                    </td>
                                </tr>
                                <?php if (!empty($config['church'])): ?>
                                    <tr>
                                        <td><img src="graphic/unit/unit_mnich.png" style="width: 18px; height: 18px;"
                                                title="<?= __('screens.map.unit_monk') ?: 'Monge' ?>" alt=""><input
                                                name="unit_monk" type="text" size="5" id="unit_monk" value=""><a
                                                onclick="document.getElementById('unit_monk').value=<?= $units['unit_mnich'] ?? 0 ?>">(<?= $units['unit_mnich'] ?? 0 ?>)</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- All Troops Link -->
            <div style="padding: 5px 10px; background: transparent;">
                <a href="#" onclick="fillAllUnits(); return false;"
                    style="font-size: 10pt; color: #804000; font-weight: bold; text-decoration: none;"><?= __('screens.map.all_troops') ?></a>
            </div>

            <!-- Target Village Info -->
            <div class="target_info">
                <table cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="60" style="text-align: center;">
                            <img src="graphic/map/v1.png" id="target_village_img" alt="">
                        </td>
                        <td class="target_info_text">
                            <strong id="target_village_name"><?= __('screens.map.village') ?: 'Aldeia' ?></strong><br>
                            <span id="target_village_owner"><?= __('screens.map.owner') ?: 'Proprietário' ?>:
                                -</span><br>
                            <span id="target_village_distance"><?= __('screens.map.distance') ?: 'Distância' ?>: -
                                <?= __('screens.map.fields') ?: 'campos' ?></span>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Action Buttons -->
            <div class="modal_actions">
                <button class="btn btn-attack" onclick="sendCommand('attack')"><?= __('screens.map.attack') ?></button>
                <button class="btn btn-support"
                    onclick="sendCommand('support')"><?= __('screens.map.support') ?></button>
                <!--<span class="farm_btn" title="Farm A (Premium)"></span>
                        <span class="farm_btn farm_b" title="Farm B (Premium)"></span>
                        -->
                <a href="game.php?village=<?= $village['id'] ?>&screen=am_farm&action=attack&target_id=<?= $target['id'] ?>&template=A&h=<?= $hkey ?>"
                    class="farm-btn">
                    <div style="width: 24px; height: 24px; background-image: url('graphic/icons/icons_context.png'); background-position: -264px 0; background-repeat: no-repeat; display: inline-block;"
                        title="<?= __('screens.map.attack_with_template_a') ?: 'Atacar com modelo A' ?>"></div>
                </a>
                <a href="game.php?village=<?= $village['id'] ?>&screen=am_farm&action=attack&target_id=<?= $target['id'] ?>&template=B&h=<?= $hkey ?>"
                    class="farm-btn">
                    <div style="width: 24px; height: 24px; background-image: url('graphic/icons/icons_context.png'); background-position: -288px 0; background-repeat: no-repeat; display: inline-block;"
                        title="<?= __('screens.map.attack_with_template_b') ?: 'Atacar com modelo B' ?>"></div>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Global variables for map modal
    var currentTargetVillage = null;
    var currentTargetX = 0;
    var currentTargetY = 0;
    var currentTargetOwner = '';
    var currentTargetCoords = '';
    var mapMenuTimer = null;

    // Unit speeds in min/field (standard Tribal Wars values)
    // world movement_speed: higher = faster travel
    var worldSpeed = <?= (float) ($config['movement_speed'] ?? 1) ?>;
    var unitSpeeds = {
        spear: 18,
        sword: 22,
        axe: 18,
        archer: 18,
        spy: 9,
        light: 10,
        cav_archer: 10,
        heavy: 11,
        ram: 30,
        catapult: 30,
        paladin: 10,
        snob: 35,
        monk: 20
    };

    function calcTravelTime(units, distance) {
        var slowest = 0;
        for (var u in units) {
            if (parseInt(units[u]) > 0 && unitSpeeds[u] !== undefined) {
                if (unitSpeeds[u] > slowest) slowest = unitSpeeds[u];
            }
        }
        if (slowest === 0 || distance === 0) return 0;
        // TW formula: travel_minutes = (distance * speed_min_per_field) / world_speed_multiplier
        return (distance * slowest) / worldSpeed;
    }

    function formatDuration(totalMinutes) {
        var h = Math.floor(totalMinutes / 60);
        var m = Math.floor(totalMinutes % 60);
        var s = Math.floor((totalMinutes * 60) % 60);
        return (h < 10 ? '0' : '') + h + ':' + (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
    }

    function formatArrival(totalMinutes) {
        var arr = new Date(Date.now() + totalMinutes * 60000);
        var today = new Date();
        var isToday = arr.toDateString() === today.toDateString();
        var tomorrow = new Date(today); tomorrow.setDate(today.getDate() + 1);
        var isTomorrow = arr.toDateString() === tomorrow.toDateString();
        var timeStr = (arr.getHours() < 10 ? '0' : '') + arr.getHours() + ':'
            + (arr.getMinutes() < 10 ? '0' : '') + arr.getMinutes() + ':'
            + (arr.getSeconds() < 10 ? '0' : '') + arr.getSeconds();
        if (isToday) return '<?= __('screens.map.today') ?: 'Hoje' ?> às ' + timeStr;
        if (isTomorrow) return '<?= __('screens.map.tomorrow') ?: 'Amanhã' ?> às ' + timeStr;
        return arr.toLocaleDateString() + ' ' + timeStr;
    }

    // Context Menu Functions
    function showMapMenu(target, villageId) {
        var menu = document.getElementById('map_context_menu');
        var rect = target.getBoundingClientRect();

        menu.style.left = (rect.left + window.scrollX - 48) + 'px';
        menu.style.top = (rect.top + window.scrollY - 40) + 'px';
        menu.style.display = 'block';

        // Get target village data from the link's title attribute
        var targetLink = target.querySelector('img');
        var titleText = targetLink ? targetLink.getAttribute('title') : '';

        // Parse village name and coordinates
        var villageName = target.dataset.vname || '<?= __('screens.map.village') ?: 'Aldeia' ?>';
        var villageOwner = target.dataset.vowner || '<?= __('screens.map.barbarian') ?: 'Bárbara' ?>';
        var villageX = target.dataset.vx ? parseInt(target.dataset.vx) : 0;
        var villageY = target.dataset.vy ? parseInt(target.dataset.vy) : 0;

        // Fallback for old HTML map (reads from img title)
        if (!target.dataset.vname && titleText) {
            var parts = titleText.split(' - ');
            if (parts.length > 0) {
                var firstPart = parts[0];
                var nameMatch = firstPart.match(/^(.+?)\s+\((\d+)\|(\d+)\)/);
                if (nameMatch) {
                    villageName = nameMatch[1];
                    villageX = parseInt(nameMatch[2]);
                    villageY = parseInt(nameMatch[3]);
                }
            }
            if (parts.length > 1 && parts[1].trim() !== '') {
                villageOwner = parts[1].split('(')[0].trim();
            }
        }

        var imageSrc = targetLink ? targetLink.getAttribute('src') : 'graphic/map/v1.png';

        // Info
        document.getElementById('mp_info').href = "game.php?village=<?= $village['id'] ?>&screen=info_village&id=" + villageId;

        // Attack - Open Modal
        document.getElementById('mp_att').onclick = function (e) {
            e.preventDefault();
            hideMapMenu();
            openAttackModal(villageId, villageName, villageOwner, villageX, villageY, imageSrc);
            return false;
        };
        document.getElementById('mp_att').href = "#";

        // Resources (Market)
        document.getElementById('mp_res').href = "game.php?village=<?= $village['id'] ?>&screen=market&mode=send&target=" + villageId;

        // Farm A/B - Only enable if user has farm assistant
        <?php if ($has_farm_assistant): ?>
            document.getElementById('mp_farm_a').onclick = function (e) {
                e.preventDefault();
                hideMapMenu();
                window.location.href = 'game.php?village=<?= $village['id'] ?>&screen=am_farm&action=attack_from_map&target=' + villageId + '&template=A&h=<?= $hkey ?>';
                return false;
            };
            document.getElementById('mp_farm_b').onclick = function (e) {
                e.preventDefault();
                hideMapMenu();
                window.location.href = 'game.php?village=<?= $village['id'] ?>&screen=am_farm&action=attack_from_map&target=' + villageId + '&template=B&h=<?= $hkey ?>';
                return false;
            };
        <?php else: ?>
            document.getElementById('mp_farm_a').onclick = function (e) {
                e.preventDefault();
                alert('<?= __('screens.map.farm_assistant_required') ?>');
                return false;
            };
            document.getElementById('mp_farm_b').onclick = function (e) {
                e.preventDefault();
                alert('<?= __('screens.map.farm_assistant_required') ?: 'Necessita do Assistente de Saque premium para usar esta funcionalidade.' ?>');
                return false;
            };
        <?php endif; ?>

    }

    function hideMapMenu() {
        mapMenuTimer = setTimeout(function () {
            document.getElementById('map_context_menu').style.display = 'none';
        }, 500);
    }

    function cancelHideMenu() {
        if (mapMenuTimer) {
            clearTimeout(mapMenuTimer);
            mapMenuTimer = null;
        }
    }

    // Modal Functions
    function openAttackModal(villageId, villageName, villageOwner, villageX, villageY, imageSrc) {
        currentTargetVillage = villageId;
        currentTargetX = villageX;
        currentTargetY = villageY;
        currentTargetOwner = villageOwner;
        currentTargetCoords = '(' + villageX + '|' + villageY + ')';

        // Update target info
        if (imageSrc) {
            document.getElementById('target_village_img').src = imageSrc;
        }
        document.getElementById('target_village_name').textContent = villageName;
        document.getElementById('target_village_owner').textContent = '<?= __('screens.map.owner') ?>: ' + villageOwner;

        // Calculate distance
        var currentX = <?= $village['x'] ?>;
        var currentY = <?= $village['y'] ?>;
        var distance = Math.sqrt(Math.pow(villageX - currentX, 2) + Math.pow(villageY - currentY, 2)).toFixed(1);
        document.getElementById('target_village_distance').textContent = '<?= __('screens.map.distance') ?>: ' + distance + ' <?= __('screens.map.fields') ?>';

        // Show modal
        document.getElementById('attack_modal_overlay').style.display = 'flex';
    }

    function closeAttackModal(event) {
        if (!event || event.target.id === 'attack_modal_overlay') {
            // Cancel any pending page reload so closing doesn't trigger it
            if (window.reloadTimer) {
                clearTimeout(window.reloadTimer);
                window.reloadTimer = null;
            }
            // Restore modal body to original units form so it can be reopened
            if (window.originalModalHTML) {
                document.getElementById('attack_modal_body').innerHTML = window.originalModalHTML;
                // Re-attach catapult listener after restoring
                var catapultInput = document.getElementById('unit_catapult');
                if (catapultInput) {
                    catapultInput.addEventListener('input', updateCatapultTarget);
                    catapultInput.addEventListener('change', updateCatapultTarget);
                }
            }
            document.getElementById('attack_modal_overlay').style.display = 'none';
            currentTargetVillage = null;
        }
    }


    function sendCommand(type) {
        if (!currentTargetVillage) return;

        // Collect unit values
        var units = {
            spear: document.getElementById('unit_spear').value || 0,
            sword: document.getElementById('unit_sword').value || 0,
            axe: document.getElementById('unit_axe').value || 0,
            archer: document.getElementById('unit_archer').value || 0,
            spy: document.getElementById('unit_spy').value || 0,
            light: document.getElementById('unit_light').value || 0,
            cav_archer: document.getElementById('unit_marcher').value || 0,
            heavy: document.getElementById('unit_heavy').value || 0,
            ram: document.getElementById('unit_ram').value || 0,
            catapult: document.getElementById('unit_catapult').value || 0,
            paladin: document.getElementById('unit_knight').value || 0,
            snob: document.getElementById('unit_snob').value || 0,
            monk: (document.getElementById('unit_monk') ? document.getElementById('unit_monk').value : 0) || 0
        };

        // Check if any units selected
        var hasUnits = false;
        for (var unit in units) {
            if (parseInt(units[unit]) > 0) {
                hasUnits = true;
                break;
            }
        }

        if (!hasUnits) {
            alert('<?= __('screens.map.select_troops') ?>');
            return;
        }

        // Show confirmation screen
        showConfirmation(type, units);
    }

    function showConfirmation(type, units) {
        var modalBody = document.getElementById('attack_modal_body');
        var targetName = document.getElementById('target_village_name').textContent;

        // Save original content BEFORE replacing it with loading state
        window.originalModalContent = modalBody.innerHTML;
        window.currentCommandType = type;
        window.currentCommandUnits = units;

        // Show loading state
        modalBody.innerHTML = '<div style="padding: 40px; text-align: center;"><?= __('screens.map.loading') ?></div>';

        // Calculate travel time
        var currentX = <?= $village['x'] ?>;
        var currentY = <?= $village['y'] ?>;
        var distance = Math.sqrt(Math.pow(currentTargetX - currentX, 2) + Math.pow(currentTargetY - currentY, 2));
        var travelMinutes = calcTravelTime(units, distance);
        var durationStr = formatDuration(travelMinutes);
        var arrivalStr = formatArrival(travelMinutes);

        var villageUnits = {
            'spear': <?= $units['unit_spear'] ?? 0 ?>,
            'sword': <?= $units['unit_sword'] ?? 0 ?>,
            'axe': <?= $units['unit_axe'] ?? 0 ?>,
            'archer': <?= $units['unit_archer'] ?? 0 ?>,
            'spy': <?= $units['unit_spy'] ?? 0 ?>,
            'light': <?= $units['unit_light'] ?? 0 ?>,
            'cav_archer': <?= $units['unit_marcher'] ?? 0 ?>,
            'heavy': <?= $units['unit_heavy'] ?? 0 ?>,
            'ram': <?= $units['unit_ram'] ?? 0 ?>,
            'catapult': <?= $units['unit_catapult'] ?? 0 ?>,
            'paladin': <?= $units['unit_knight'] ?? 0 ?>,
            'snob': <?= $units['unit_snob'] ?? 0 ?>
            <?php if (!empty($config['church'])): ?>
            ,'monk': <?= $units['unit_mnich'] ?? 0 ?>
            <?php endif; ?>
        };

        // Prepare form data
        var formData = new FormData();
        formData.append('type', type);
        formData.append('targetId', currentTargetVillage);
        formData.append('targetName', targetName + ' ' + currentTargetCoords);
        formData.append('targetPlayer', currentTargetOwner);
        formData.append('duration', durationStr);
        formData.append('arrival', arrivalStr);
        formData.append('units', JSON.stringify(units));
        formData.append('villageUnits', JSON.stringify(villageUnits));

        // Get catapult target if present
        var buildingSelect = document.getElementById('modal_building_select');
        if (buildingSelect) {
            formData.append('building', buildingSelect.value);
        }

        // Fetch confirmation HTML from server
        fetch('/ajax/ajax_attack_confirm.php?world=<?= $_GET['world'] ?? 1 ?>', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(html => {
                modalBody.innerHTML = html;
            })
            .catch(error => {
                console.error('Error loading confirmation:', error);
                modalBody.innerHTML = '<div style="padding: 20px; color: red;"><?= __('screens.map.error_loading') ?></div>';
            });
    }

    function cancelConfirmation() {
        var modalBody = document.getElementById('attack_modal_body');
        modalBody.innerHTML = window.originalModalContent;
    }


    // --- Multi Attack Logic ---
    window.isMultiAttack = false;

    function initMultiAttack() {
        window.isMultiAttack = true;
        document.getElementById('single_attack_ui').style.display = 'none';
        document.getElementById('multi_attack_ui').style.display = 'block';
        updateMultiAttackTotals();
    }

    function addMultiAttackRow() {
        var tbody = document.getElementById('multi_attack_rows');
        var nextNum = parseInt(document.getElementById('next_attack_num').innerText);
        
        // Clone the first row
        var templateRow = document.getElementById('row_attack_1');
        var newRow = templateRow.cloneNode(true);
        newRow.id = 'row_attack_' + nextNum;
        newRow.dataset.row = nextNum;
        
        // Update labels and inputs
        var cells = newRow.getElementsByTagName('td');
        cells[0].innerHTML = 'Atacar #' + nextNum + ' <a href="#" onclick="removeMultiAttackRow(' + nextNum + '); return false;" style="color:red; font-weight:bold; margin-left: 5px;">X</a>';
        
        var inputs = newRow.getElementsByTagName('input');
        for (var i = 0; i < inputs.length; i++) {
            var unit = inputs[i].name.split('_')[2]; // multi_unit_spear_1 -> spear
            inputs[i].name = 'multi_unit_' + unit + '_' + nextNum;
            inputs[i].value = 0;
        }
        
        tbody.appendChild(newRow);
        
        document.getElementById('next_attack_num').innerText = nextNum + 1;
        updateMultiAttackTotals();
    }

    function removeMultiAttackRow(rowNum) {
        var row = document.getElementById('row_attack_' + rowNum);
        if (row) {
            row.parentNode.removeChild(row);
            updateMultiAttackTotals();
        }
    }

    function updateMultiAttackTotals() {
        var allUnits = ['spear','sword','axe','archer','spy','light','marcher','heavy','ram','catapult','knight','snob','monk'];
        
        allUnits.forEach(function(unit) {
            var total = 0;
            var inputs = document.querySelectorAll('input[name^="multi_unit_' + unit + '_"]');
            inputs.forEach(function(input) {
                total += parseInt(input.value) || 0;
            });
            
            var totalCells = document.querySelectorAll('.total_val[data-unit="' + unit + '"]');
            totalCells.forEach(function(cell) {
                cell.innerText = total;
            });
            
            // Check vs village capacity
            var villageCells = document.querySelectorAll('.village_unit_count[data-unit="' + unit + '"]');
            if (villageCells.length > 0) {
                var max = parseInt(villageCells[0].innerText) || 0;
                totalCells.forEach(function(cell) {
                    if (total > max) {
                        cell.style.color = 'red';
                        cell.style.fontWeight = 'bold';
                    } else {
                        cell.style.color = '';
                        cell.style.fontWeight = 'normal';
                    }
                });
            }
        });
    }

    // Rewrite confirmCommand to handle multiple sequential attacks
    function confirmCommand(type) {
        var modalBody = document.getElementById('attack_modal_body');
        
        // 1. Collect all attacks to send
        var attacksQueue = [];
        
        if (window.isMultiAttack) {
            var rows = document.querySelectorAll('.attack_row');
            rows.forEach(function(row) {
                var rowNum = row.dataset.row;
                var attackUnits = {};
                var hasUnits = false;
                
                var inputs = row.querySelectorAll('input[name^="multi_unit_"]');
                inputs.forEach(function(input) {
                    var unitName = input.name.split('_')[2]; // multi_unit_spear_1 -> spear
                    var qty = parseInt(input.value) || 0;
                    if (qty > 0) {
                        attackUnits[unitName] = qty;
                        hasUnits = true;
                    }
                });
                
                if (hasUnits) {
                    attacksQueue.push(attackUnits);
                }
            });
        } else {
            attacksQueue.push(window.currentCommandUnits);
        }

        if (attacksQueue.length === 0) {
            alert('<?= __('screens.map.select_troops') ?>');
            return;
        }

        console.log('Attacks Queue:', attacksQueue);

        // Show loading state
        modalBody.innerHTML = '<div style="padding: 40px; text-align: center;"><p><?= __('screens.map.sending') ?> (1/' + attacksQueue.length + ')</p></div>';

        // Add catapult target if selected
        var buildingSelect = document.getElementById('modal_building_select');
        var catapultTarget = buildingSelect ? buildingSelect.value : null;

        // Process queue sequentially
        processAttackQueue(attacksQueue, 0, type, catapultTarget, modalBody);
    }

    function processAttackQueue(queue, currentIndex, type, catapultTarget, modalBody) {
        if (currentIndex >= queue.length) {
            // All done!
            modalBody.innerHTML = '<div style="padding: 40px; text-align: center; color: green;"><p>Comandos enviados com sucesso!</p></div>';
            setTimeout(function() {
                closeAttackModal();
                // Optionally reload map data here
            }, 1500);
            return;
        }

        modalBody.innerHTML = '<div style="padding: 40px; text-align: center;"><p><?= __('screens.map.sending') ?> (' + (currentIndex + 1) + '/' + queue.length + ')...</p></div>';

        var units = queue[currentIndex];
        var formData = new FormData();
        formData.append('village', '<?= $village['id'] ?>');
        formData.append('target', currentTargetVillage);
        formData.append('type', type);
        
        if (catapultTarget) {
            formData.append('building', catapultTarget);
        }

        // Add units
        for (var unit in units) {
            if (parseInt(units[unit]) > 0) {
                // Handle different mapping if needed, e.g. mnich vs monk
                var paramName = unit === 'monk' ? 'unit_mnich' : 'unit_' + unit;
                formData.append(paramName, units[unit]);
            }
        }

        // Submit via AJAX
        fetch('game.php?village=<?= $village['id'] ?>&screen=place&action=command', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Wait 200ms before sending the next one to mimic human or proper server spacing
                setTimeout(function() {
                    processAttackQueue(queue, currentIndex + 1, type, catapultTarget, modalBody);
                }, 200);
            } else {
                modalBody.innerHTML = '<div style="padding: 20px; color: red;">Erro (Ataque ' + (currentIndex + 1) + '): ' + (data.error || 'Erro desconhecido') + '</div>';
            }
        })
        .catch(error => {
            console.error('Error sending attack:', error);
            modalBody.innerHTML = '<div style="padding: 20px; color: red;">Erro ao comunicar com o servidor.</div>';
        });
    }

    function fillAllUnits() {
        // Fill all unit inputs with their maximum values
        var unitIds = ['unit_spear', 'unit_sword', 'unit_axe', 'unit_archer',
            'unit_spy', 'unit_light', 'unit_marcher', 'unit_heavy',
            'unit_ram', 'unit_catapult', 'unit_knight', 'unit_snob', 'unit_monk'];

        unitIds.forEach(function (id) {
            var input = document.getElementById(id);
            if (input) {
                var maxAttr = input.getAttribute('max');
                if (maxAttr) {
                    input.value = maxAttr;
                } else {
                    // Extract from the adjacent <a> element which has the format "(123)"
                    var link = input.nextElementSibling;
                    if (link && link.tagName === 'A') {
                        var text = link.textContent.replace(/[()]/g, '');
                        input.value = parseInt(text) || 0;
                    }
                }
            }
        });
    }

    // Attach event listeners
    document.addEventListener('DOMContentLoaded', function () {
        // Save the original modal body HTML (units form) so we can restore it after closing
        window.originalModalHTML = document.getElementById('attack_modal_body').innerHTML;

        // Move context menu to body
        var menu = document.getElementById('map_context_menu');
        if (menu) {
            document.body.appendChild(menu);

            menu.addEventListener('mouseenter', cancelHideMenu);
            menu.addEventListener('mouseleave', hideMapMenu);
        }

        // Attach click handlers to village links
        document.querySelectorAll('td[id^="tile_"] a[href*="screen=info_village"]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                var villageId = new URL(this.href).searchParams.get('id');
                var tile = this.closest('td');
                showMapMenu(tile, villageId);
            });
        });

        // Initial catapult check
        var catapultInput = document.getElementById('unit_catapult');
        if (catapultInput) {
            catapultInput.addEventListener('input', updateCatapultTarget);
            catapultInput.addEventListener('change', updateCatapultTarget);
            catapultInput.addEventListener('blur', updateCatapultTarget);
            updateCatapultTarget(); // Initial check
        }
    });

    // Catapult Target Selector Logic (module-scope so closeAttackModal can re-attach)
    function updateCatapultTarget() {
        var catapultInput = document.getElementById('unit_catapult');
        var targetRow = document.getElementById('catapult_target_row');
        if (catapultInput && targetRow) {
            var catapultCount = parseInt(catapultInput.value) || 0;
            targetRow.style.display = (catapultCount > 0) ? 'table-row' : 'none';
        }
    }

</script>
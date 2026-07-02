

<style>
#place_autocomplete_dropdown {
    display: none;
    position: absolute;
    z-index: 99999;
    border: 1px solid #7d510f;
    background: #f4e4bc;
    max-height: 300px;
    overflow-y: auto;
    box-shadow: 0px 4px 8px rgba(0,0,0,0.3);
    transform: translateY(-100%);
    margin-top: -2px;
}
.autocomplete-item {
    display: flex;
    align-items: center;
    padding: 6px 10px;
    border-bottom: 1px solid #7d510f;
    cursor: pointer;
    background: #f4e4bc;
    color: #000;
}
.autocomplete-item:hover {
    background-color: #e3d5b3;
}
.autocomplete-item img {
    width: 38px;
    height: 38px;
    margin-right: 12px;
    object-fit: contain;
}
.autocomplete-details {
    flex: 1;
    font-size: 11px;
    line-height: 1.4;
    text-align: left;
}
</style>

<?php if (!empty($error)): ?>
    <div style="color:red; font-size:large"><?= $error ?></div>
<?php endif; ?>

<h3><?= __('screens.place.give_order') ?></h3>

<form name="kingsage" action="game.php?village=<?= $village['id'] ?>&screen=place&try=confirm" method="post">
    <table>
        <tr>
            <?php $counter = 0; ?>
            <?php foreach ($group_units as $group_name => $value): ?>
                <td width="150" valign="top">
                    <table class="vis" width="100%">
                        <?php foreach ($group_units[$group_name] as $dbname): ?>
                            <?php $counter++; ?>
                            <tr>
                                <td>
                                    <a href="#" onclick="showUnitModal('<?= $dbname ?>'); return false;"><img
                                            src="graphic/unit/<?= $dbname ?>.png" title="<?= $cl_units->get_name($dbname) ?>"
                                            alt="" /></a>
                                    <input name="<?= $dbname ?>" type="text" size="5" max_value="<?= $units[$dbname] ?>"
                                        tabindex="<?= $counter ?>" value="<?= $values[$dbname] ?? '' ?>" />
                                    <a
                                        href="javascript:insertUnit(document.forms[0].<?= $dbname ?>, <?= $units[$dbname] ?>)">(<?= $units[$dbname] ?>)</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </td>
            <?php endforeach; ?>
        </tr>
    </table>

    <span style="font-weight:bold; color: #804000; cursor: pointer;" class="click"
        onclick="selectCoiningNoneMax('<?= __('screens.place.all_troops') ?>', '<?= __('screens.place.unselect_all') ?>');return false;">
        <span id="select_all_1" class="link">
            <?= __('screens.place.all_troops') ?>
        </span>
    </span>


    <div id="inline_popup" style="display: none; position: absolute; clear: both;">
        <table cellspacing="0" cellpadding="0"
            class="<?php if (($graphic ?? '') == '1'): ?>content-border<?php else: ?>main<?php endif; ?>">
            <tr>
                <th>
                    <div id="inline_popup_menu" style="text-align: right;">
                        <a href="javascript:inlinePopupClose()"><?= __('screens.place.close') ?></a>
                    </div>
                </th>
            </tr>
            <tr>
                <td>
                    <h3><?= __('screens.place.targets') ?></h3>
                    <div>

                        <div id="inline_popup_content" style="height: 340px; overflow: auto;">
                            <img src="graphic/new/throbber.gif" alt="<?= __('screens.place.loading') ?>" />
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Catapult Target Selector -->
    <div id="catapult_target_container" style="display: none; margin-top: 10px;">
        <table class="vis">
            <tr>
                <th><?= __('screens.place.catapult_target') ?>:</th>
                <td>
                    <select name="building" size="1">
                        <?php foreach ($cl_builds->get_array("dbname") as $dbname): ?>
                            <option value="<?= $dbname ?>"><?= $cl_builds->get_name($dbname) ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table>
    </div>

    <table>
        <tr>
            <!-- Left Column: The new standalone Destination block -->
            <td valign="top" style="padding-right: 15px;">
                <table class="vis" style="border-collapse: collapse; border: 1px solid #7d510f;">
                    <tr>
                        <th style="background-color: #c1a264; color: #fff; text-align: left; padding: 3px; font-weight: bold;"><?= __('screens.market.destination') ?? 'Destination' ?></th>
                    </tr>
                    <tr>
                        <td style="background-color: #f4e4bc; border: 1px solid #7d510f; padding: 4px; white-space: nowrap;">
                            <input type="radio" name="target_type" value="coords" id="tt_coords" checked> <label for="tt_coords"><?= __('screens.market.coords') ?? 'Coordinates' ?></label>
                            <input type="radio" name="target_type" value="village_name" id="tt_vname"> <label for="tt_vname"><?= __('screens.market.village_name') ?? 'Village name' ?></label>
                            <input type="radio" name="target_type" value="player_name" id="tt_pname"> <label for="tt_pname"><?= __('screens.market.player_name') ?? 'Player name' ?></label>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color: #f4e4bc; border: 1px solid #7d510f; padding: 5px; width: 330px; box-sizing: border-box;">
                            <input type="text" id="place_destination_input" name="place_input" autocomplete="off" style="width: 100%; box-sizing: border-box; padding: 4px;">
                            
                             <!-- Hidden legacy input coordinates fields so backend and other modals work seamlessly -->
                             <input type="hidden" name="x" id="x" value="<?= $prefill_x ?? $values['x'] ?? '' ?>">
                             <input type="hidden" name="y" id="y" value="<?= $prefill_y ?? $values['y'] ?? '' ?>">

                            <!-- Selected Village Card -->
                            <div id="place_selected_village_card" style="display:none; align-items:center; border:1px solid #7d510f; background:#fcf6e4; padding:5px; box-sizing:border-box; margin-top:2px;">
                                <img id="sel_village_img" src="graphic/map/v1.png" style="width:38px; height:38px; margin-right:12px; object-fit:contain;" alt="">
                                <div style="flex:1; font-size:11px; line-height:1.4; text-align:left; color:#000;">
                                    <b id="sel_village_title"></b><br>
                                    Proprietário: <span id="sel_village_owner"></span> Pontos: <span id="sel_village_points"></span><br>
                                    Distância: <span id="sel_village_distance"></span> campos
                                </div>
                                <div style="display:flex; align-items:center; margin-left:10px;">
                                    <a href="#" id="clear_selected_village" style="display:inline-block; width:20px; height:20px; line-height:20px; text-align:center; border:1px solid #7d510f; background:#e3d5b3; color:#a00; font-weight:bold; text-decoration:none; cursor:pointer; font-size:13px;" title="Limpar">X</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
            
            <!-- Right Column: Links and Action buttons side by side -->
            <td valign="middle" style="padding-left: 5px;">
                <div style="display: inline-flex; align-items: center; gap: 15px;">
                    <!-- Column 1 of links -->
                    <div style="font-size: 11px; line-height: 1.5; white-space: nowrap;">
                        <a href="#" id="btn-favoritos" style="font-weight: bold; color: #804000; text-decoration: none;"><?= __('screens.place.favorites') ?></a><br>
                        <a href="#" id="btn-proprias" style="font-weight: bold; color: #804000; text-decoration: none; <?php if ($user['villages'] <= 1): ?>color: gray; cursor: not-allowed;<?php endif; ?>" <?php if ($user['villages'] <= 1): ?>title="<?= __('screens.place.must_have_2_villages') ?>"<?php endif; ?>><?= __('screens.place.own_villages') ?></a>
                    </div>
                    <!-- Column 2 of links -->
                    <div style="font-size: 11px; line-height: 1.5; white-space: nowrap;">
                        <a href="#" id="btn-historico" style="font-weight: bold; color: #804000; text-decoration: none;"><?= __('screens.place.history') ?></a><br>
                        <a href="#" onclick="insertNumId('x',<?= $last_command['x'] ?>);insertNumId('y',<?= $last_command['y'] ?>); return false;" style="font-weight: bold; color: #804000; text-decoration: none;"><?= __('screens.place.previous') ?></a>
                    </div>
                    <!-- Action buttons -->
                    <div style="display: inline-flex; gap: 8px; align-items: center;">
                        <button class="btn btn-attack" name="attack" type="submit" style="">
                            <?= __('screens.place.attack') ?>
                        </button>
                        <button class="btn btn-support" name="support" type="submit" style="">
                            <?= __('screens.place.support') ?>
                        </button>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</form>

<script type="text/javascript">
    //<![CDATA[
    // setImageTitles(); // TODO: Check if this function exists in global scope or needs helper

    var popup_options = {
        offset_x: 10,
        offset_y: 10,
        empty_errors: false
    };

    $(document).ready(function () {
        if (typeof UI !== 'undefined' && UI.Draggable) {
            UI.Draggable($('#inline_popup'));
        }
    });

    // Vanilla JavaScript event listeners (don't depend on jQuery)
    document.addEventListener('DOMContentLoaded', function () {
        console.log('Place screen loaded, setting up popup buttons');

        // Favoritos button
        var btnFavoritos = document.getElementById('btn-favoritos');
        if (btnFavoritos) {
            btnFavoritos.addEventListener('click', function (e) {
                e.preventDefault();
                console.log('Favoritos clicked');
                showBookmarksModal();
                return false;
            });
        }

        // Histórico button
        var btnHistorico = document.getElementById('btn-historico');
        if (btnHistorico) {
            btnHistorico.addEventListener('click', function (e) {
                e.preventDefault();
                console.log('Histórico clicked');
                showCommandHistoryModal();
                return false;
            });
        }

        // Próprias button
        <?php if ($user['villages'] > 1): ?>
            var btnProprias = document.getElementById('btn-proprias');
            if (btnProprias) {
                btnProprias.addEventListener('click', function (e) {
                    e.preventDefault();
                    console.log('Próprias clicked');
                    showVillagesModal();
                    return false;
                });
            }
        <?php endif; ?>

        console.log('Popup buttons setup complete');

        // Catapult target visibility logic
        var catapultInput = document.querySelector('input[name="catapult"]');
        var catapultTarget = document.getElementById('catapult_target_container');
        if (catapultInput && catapultTarget) {
            var updateCatapultVisibility = function () {
                var count = parseInt(catapultInput.value) || 0;
                catapultTarget.style.display = count > 0 ? 'block' : 'none';
            };
            catapultInput.addEventListener('input', updateCatapultVisibility);
            catapultInput.addEventListener('change', updateCatapultVisibility);
            // Run initially in case of pre-fill
            updateCatapultVisibility();
        }
    });

    function insertUnit(input, max) {
        input.value = max;
    }

    function insertNumId(id, val) {
        document.getElementById(id).value = val;
    }

    function selectCoiningNoneMax(text_all, text_none) {
        var inputs = document.forms['kingsage'].getElementsByTagName('input');
        var all_selected = true;

        // Check if all are selected (max)
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].type == 'text' && inputs[i].getAttribute('max_value')) {
                if (inputs[i].value != inputs[i].getAttribute('max_value')) {
                    all_selected = false;
                    break;
                }
            }
        }

        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].type == 'text' && inputs[i].getAttribute('max_value')) {
                if (all_selected) {
                    inputs[i].value = '';
                } else {
                    inputs[i].value = inputs[i].getAttribute('max_value');
                }
            }
        }

        var link = document.getElementById('select_all_1');
        if (all_selected) {
            link.innerHTML = text_all;
        } else {
            link.innerHTML = text_none;
        }

        // Update catapult target visibility after selecting all
        updateCatapultTarget();
    }

    // Catapult Target Selector Logic
    function updateCatapultTarget() {
        var catapultInput = document.querySelector('input[name="unit_catapult"]');
        var targetContainer = document.getElementById('catapult_target_container');

        if (catapultInput && targetContainer) {
            var catapultCount = parseInt(catapultInput.value) || 0;
            targetContainer.style.display = (catapultCount > 0) ? 'block' : 'none';
        }
    }

    // Setup catapult input listener
    document.addEventListener('DOMContentLoaded', function () {
        var catapultInput = document.querySelector('input[name="unit_catapult"]');
        if (catapultInput) {
            catapultInput.addEventListener('input', updateCatapultTarget);
            catapultInput.addEventListener('change', updateCatapultTarget);
            catapultInput.addEventListener('blur', updateCatapultTarget);
            updateCatapultTarget(); // Initial check
        }
    });

    // Override insertUnit to trigger catapult check
    var originalInsertUnit = insertUnit;
    function insertUnit(input, max) {
        input.value = max;
        updateCatapultTarget();
    }

    //]]>
</script>

<h3><?= __('screens.place.troop_movements') ?></h3>
<?php if (count($my_movements) > 0): ?>
    <table class="vis">
        <tr>
            <th width="250"><?= __('screens.place.own_orders') ?> (<?= count($my_movements) ?>)</th>
            <th width="160"><?= __('screens.place.duration') ?></th>
            <th width="80"><?= __('screens.place.arrival') ?></th>
        </tr>
        <?php foreach ($my_movements as $array): ?>
            <tr>
                <td>
                    <a href="game.php?village=<?= $village['id'] ?>&screen=info_command&id=<?= $array['id'] ?>&type=own">
                        <img src="graphic/command/<?= $array['type'] ?>.png"> <?= $array['message'] ?>
                    </a>
                </td>
                <td><?= $array['end_time'] ?></td>
                <?php if ($array['arrival_in'] < 0): ?>
                    <td><?= format_time($array['arrival_in']) ?></td>
                <?php else: ?>
                    <td><span class="timer"><?= format_time($array['arrival_in']) ?></span></td>
                <?php endif; ?>
                <?php if ($array['can_cancel']): ?>
                    <td><a
                            href="game.php?village=<?= $village['id'] ?>&screen=place&action=cancel&id=<?= $array['id'] ?>&h=<?= $hkey ?>"><?= __('screens.place.cancel') ?></a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
<?php endif; ?>


<?php if (count($other_movements) > 0): ?>
    <table class="vis">
        <tr>
            <th width="250"><?= __('screens.place.next_army') ?> (<?= count($other_movements) ?>)</th>
            <th width="160"><?= __('screens.place.duration') ?></th>
            <th width="80"><?= __('screens.place.arrival') ?></th>
        </tr>
        <?php foreach ($other_movements as $array): ?>
            <tr>
                <td>
                    <a href="game.php?village=<?= $village['id'] ?>&screen=info_command&id=<?= $array['id'] ?>&type=other">
                        <img src="graphic/command/<?= $array['type'] ?>.png"> <?= $array['message'] ?>
                    </a>
                </td>
                <td><?= $array['end_time'] ?></td>
                <?php if ($array['arrival_in'] < 0): ?>
                    <td><?= format_time($array['arrival_in']) ?></td>
                <?php else: ?>
                    <td><span class="timer"><?= format_time($array['arrival_in']) ?></span></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<!-- Unit Info Modal -->
<div id="unit_info_modal"
    style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.6);">
    <div id="unit_modal_container"
        style="background-color: #f7eed3; border: 2px solid #804000; width: 700px; margin: 100px auto; padding: 10px; position: relative; box-shadow: 0px 0px 15px #000; cursor: move;">
        <div id="unit_modal_header"
            style="background-color: #c1a264; padding: 5px; border: 1px solid #7d510f; color: #fff; font-weight: bold; margin-bottom: 10px; cursor: move;">
            <span id="modal_unit_title"><?= __('screens.recruitment.unit') ?></span>
            <span onclick="closeUnitModal()"
                style="float: right; cursor: pointer; color: #5c0d0d; background: #e3d5b3; border: 1px solid #804000; padding: 0 5px;">X</span>
        </div>
        <div id="modal_unit_desc"
            style="padding: 10px; font-style: italic; border-bottom: 1px solid #804000; margin-bottom: 10px;"></div>
        <div id="modal_unit_content" style="padding: 10px; display: flex; gap: 20px;">
            <div id="modal_unit_tables" style="flex-grow: 1;">
                <table class="vis" width="100%">
                    <tr>
                        <th width="100"><?= __('screens.recruitment.cost') ?></th>
                        <td id="modal_unit_cost"></td>
                    </tr>
                    <tr>
                        <th><?= __('screens.recruitment.population') ?></th>
                        <td id="modal_unit_pop"></td>
                    </tr>
                    <tr>
                        <th><?= __('screens.recruitment.speed') ?></th>
                        <td id="modal_unit_speed"></td>
                    </tr>
                    <tr>
                        <th><?= __('screens.recruitment.carry_capacity') ?></th>
                        <td id="modal_unit_booty"></td>
                    </tr>
                    <tr>
                        <th><?= __('screens.recruitment.attack') ?></th>
                        <td id="modal_unit_att"></td>
                    </tr>
                    <tr>
                        <th><?= __('screens.recruitment.defense') ?></th>
                        <td id="modal_unit_def"></td>
                    </tr>
                </table>

                <div id="modal_unit_requirements" style="margin-top: 15px; display: none;">
                    <table class="vis" width="100%">
                        <tr>
                            <th colspan="2"><?= __('screens.recruitment.requirements') ?></th>
                        </tr>
                        <tbody id="modal_unit_req_body">
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="modal_unit_img_container" style="flex-shrink: 0;">
                <img id="modal_unit_img" src="" alt="" />
            </div>
        </div>
    </div>
</div>

<!-- Command History Modal -->
<div id="command_history_modal"
    style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.6);">
    <div id="history_modal_container"
        style="background-color: #f7eed3; border: 2px solid #804000; width: 500px; margin: 100px auto; padding: 10px; position: relative; box-shadow: 0px 0px 15px #000;">
        <div id="history_modal_header"
            style="background-color: #c1a264; padding: 5px; border: 1px solid #7d510f; color: #fff; font-weight: bold; margin-bottom: 10px;">
            <span><?= __('screens.place.attack_history') ?></span>
            <span onclick="closeCommandHistoryModal()"
                style="float: right; cursor: pointer; color: #5c0d0d; background: #e3d5b3; border: 1px solid #804000; padding: 0 5px;">X</span>
        </div>
        <div id="history_modal_content" style="padding: 10px; max-height: 400px; overflow-y: auto;">
            <p style="text-align: center;"><?= __('screens.place.loading') ?></p>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Unit definitions for modal
    var unit_info = {
        <?php
        $u_infos = [];

        // Define graphic mapping for exceptions
        $graphic_map = [
            'unit_cav_archer' => 'marcher_b',
            'unit_mnich' => 'monge_b',
        ];

        // Iterate over ALL units, not just those the player has
        foreach ($cl_units->get_array('dbname') as $u_db) {
            // Get unit name
            $u_name = $cl_units->get_name($u_db);

            // Determine graphic name
            if (isset($graphic_map[$u_db])) {
                $graphic = $graphic_map[$u_db];
            } else {
                // Default pattern: remove 'unit_' prefix and add '_b'
                $graphic = str_replace('unit_', '', $u_db) . '_b';
            }

            // Get requirements
            $needed = $cl_units->get_needed($u_db);
            $req_str = '[]';
            if (count($needed) > 0) {
                $req_arr = [];
                foreach ($needed as $build => $level) {
                    $buildName = $cl_builds->get_name($build);
                    if (empty($buildName)) {
                        // Fallback to translation key directly
                        $buildName = __('buildings.' . $build . '.name');
                    }
                    $req_arr[] = "{building: '" . addslashes($buildName) . "', level: $level}";
                }
                $req_str = '[' . implode(',', $req_arr) . ']';
            }

            $u_infos[] = "'$u_db': {
                name: '" . addslashes($u_name) . "',
                desc: '" . addslashes($cl_units->get_description($u_db)) . "',
                graphic: '" . addslashes($graphic) . "',
                wood: " . $cl_units->get_woodprice($u_db) . ",
                stone: " . $cl_units->get_stoneprice($u_db) . ",
                iron: " . $cl_units->get_ironprice($u_db) . ",
                pop: " . $cl_units->get_bhprice($u_db) . ",
                speed: " . ($cl_units->get_speed($u_db) / 60) . ",
                booty: " . $cl_units->get_booty($u_db) . ",
                att: " . $cl_units->get_att($u_db, 1) . ",
                def: " . $cl_units->get_def($u_db, 1) . ",
                def_cav: " . $cl_units->get_defCav($u_db, 1) . ",
                def_archer: " . $cl_units->get_defArcher($u_db, 1) . ",
                requirements: $req_str
            }";
        }
        // Properly join the array with comma and newline
        echo implode(",\n        ", $u_infos);
        ?>
    };

    function showUnitModal(unit) {
        if (!unit_info[unit]) return;
        var info = unit_info[unit];

        document.getElementById('modal_unit_title').innerHTML = info.name;
        document.getElementById('modal_unit_desc').innerHTML = info.desc;
        document.getElementById('modal_unit_cost').innerHTML =
            '<img src="graphic/icons/wood.png" /> ' + info.wood + ' ' +
            '<img src="graphic/icons/stone.png" /> ' + info.stone + ' ' +
            '<img src="graphic/icons/iron.png" /> ' + info.iron;
        document.getElementById('modal_unit_pop').innerHTML = '<img src="graphic/icons/face.png" /> ' + info.pop;
        document.getElementById('modal_unit_speed').innerHTML = info.speed + ' <?= __('screens.recruitment.min_per_field') ?>';
        document.getElementById('modal_unit_booty').innerHTML = info.booty;
        document.getElementById('modal_unit_att').innerHTML = '<img src="graphic/unit/att.png" /> ' + info.att;
        document.getElementById('modal_unit_def').innerHTML =
            '<img src="graphic/unit/def.png" /> ' + info.def + ' | ' +
            '<img src="graphic/unit/def_cav.png" /> ' + info.def_cav + ' | ' +
            '<img src="graphic/unit/def_archer.png" /> ' + info.def_archer;

        // Use the graphic mapped in PHP
        document.getElementById('modal_unit_img').src = 'graphic/unit_big/' + info.graphic + '.png';

        // Requirements
        var reqDiv = document.getElementById('modal_unit_requirements');
        var reqBody = document.getElementById('modal_unit_req_body');
        if (info.requirements.length > 0) {
            reqBody.innerHTML = '';
            info.requirements.forEach(function (req) {
                reqBody.innerHTML += '<tr><td>' + req.building + '</td><td><?= __('screens.recruitment.level') ?> ' + req.level + '</td></tr>';
            });
            reqDiv.style.display = 'block';
        } else {
            reqDiv.style.display = 'none';
        }

        document.getElementById('unit_info_modal').style.display = 'block';
    }

    function closeUnitModal() {
        document.getElementById('unit_info_modal').style.display = 'none';
    }

    // Close modal when clicking outside
    document.getElementById('unit_info_modal').addEventListener('click', function (e) {
        if (e.target.id === 'unit_info_modal') {
            closeUnitModal();
        }
    });

    // Make modal draggable
    var modalContainer = document.getElementById('unit_modal_container');
    var modalHeader = document.getElementById('unit_modal_header');
    var isDragging = false;
    var currentX, currentY, initialX, initialY;

    modalHeader.addEventListener('mousedown', function (e) {
        isDragging = true;
        initialX = e.clientX - modalContainer.offsetLeft;
        initialY = e.clientY - modalContainer.offsetTop;
    });

    document.addEventListener('mousemove', function (e) {
        if (isDragging) {
            e.preventDefault();
            currentX = e.clientX - initialX;
            currentY = e.clientY - initialY;
            modalContainer.style.margin = '0';
            modalContainer.style.left = currentX + 'px';
            modalContainer.style.top = currentY + 'px';
        }
    });

    document.addEventListener('mouseup', function () {
        isDragging = false;
    });

    // Command History Modal Functions
    function showCommandHistoryModal() {
        var modal = document.getElementById('command_history_modal');
        var content = document.getElementById('history_modal_content');

        modal.style.display = 'block';
        content.innerHTML = '<p style="text-align: center;"><?= addslashes(__('screens.place.loading')) ?></p>';

        // Load history via AJAX
        fetch('game.php?village=<?= $village['id'] ?>&screen=popup&mode=command_history')
            .then(response => response.text())
            .then(html => {
                // Extract table content from response
                var parser = new DOMParser();
                var doc = parser.parseFromString(html, 'text/html');
                var table = doc.querySelector('table');

                if (table) {
                    content.innerHTML = '';
                    content.appendChild(table);

                    // Add click handlers to links
                    var links = content.querySelectorAll('a');
                    links.forEach(function (link) {
                        link.addEventListener('click', function (e) {
                            e.preventDefault();
                            var x = this.getAttribute('data-x') || this.textContent.match(/(\d+)\|(\d+)/)?.[1];
                            var y = this.getAttribute('data-y') || this.textContent.match(/(\d+)\|(\d+)/)?.[2];

                            if (x && y) {
                                document.getElementById('x').value = x;
                                document.getElementById('y').value = y;
                                closeCommandHistoryModal();
                            }
                        });
                    });
                } else {
                    content.innerHTML = '<p style="text-align: center; color: #999;"><?= addslashes(__('screens.place.no_history')) ?></p>';
                }
            })
            .catch(error => {
                console.error('Error loading history:', error);
                content.innerHTML = '<p style="text-align: center; color: red;"><?= addslashes(__('screens.place.error_loading_history')) ?></p>';
            });
    }

    function closeCommandHistoryModal() {
        document.getElementById('command_history_modal').style.display = 'none';
    }

    function showBookmarksModal() {
        var modal = document.getElementById('command_history_modal');
        var content = document.getElementById('history_modal_content');
        var headerTitle = document.querySelector('#history_modal_header span:first-child');

        headerTitle.textContent = '<?= addslashes(__('screens.place.favorites')) ?>';
        modal.style.display = 'block';
        content.innerHTML = '<p style="text-align: center;"><?= addslashes(__('screens.place.loading')) ?></p>';

        fetch('game.php?village=<?= $village['id'] ?>&screen=popup&mode=bookmark')
            .then(response => response.text())
            .then(html => {
                var parser = new DOMParser();
                var doc = parser.parseFromString(html, 'text/html');
                var table = doc.querySelector('table');
                if (table) {
                    content.innerHTML = '';
                    content.appendChild(table);
                    addCoordinateClickHandlers(content);

                    // Add AJAX deletion support for favorite items inside the modal
                    var delLinks = content.querySelectorAll('.del-favorite-link');
                    delLinks.forEach(function (delLink) {
                        delLink.addEventListener('click', function (e) {
                            e.preventDefault();
                            if (confirm('<?= addslashes(__('screens.place.confirm_remove_favorite')) ?>')) {
                                var url = this.getAttribute('href');
                                fetch(url)
                                    .then(() => {
                                        showBookmarksModal();
                                    })
                                    .catch(err => console.error('Error deleting favorite:', err));
                            }
                        });
                    });
                } else {
                    content.innerHTML = '<p style="text-align: center; color: #999;"><?= addslashes(__('screens.place.no_favorites')) ?></p>';
                }
            });
    }

    function showVillagesModal() {
        var modal = document.getElementById('command_history_modal');
        var content = document.getElementById('history_modal_content');
        var headerTitle = document.querySelector('#history_modal_header span:first-child');

        headerTitle.textContent = '<?= addslashes(__('screens.place.own_villages')) ?>';
        modal.style.display = 'block';
        content.innerHTML = '<p style="text-align: center;"><?= addslashes(__('screens.place.loading')) ?></p>';

        fetch('game.php?village=<?= $village['id'] ?>&screen=popup&mode=villages')
            .then(response => response.text())
            .then(html => {
                var parser = new DOMParser();
                var doc = parser.parseFromString(html, 'text/html');
                var table = doc.querySelector('table');
                if (table) {
                    content.innerHTML = '';
                    content.appendChild(table);
                    addCoordinateClickHandlers(content);
                } else {
                    content.innerHTML = '<p style="text-align: center; color: #999;"><?= addslashes(__('screens.place.no_villages')) ?></p>';
                }
            });
    }

    function addCoordinateClickHandlers(container) {
        var links = container.querySelectorAll('a:not(.del-favorite-link)');
        console.log('addCoordinateClickHandlers: Found ' + links.length + ' links');
        
        links.forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                console.log('Link clicked:', this);
                
                // Try to extract from onclick attribute first (popup views use this)
                var onclick = this.getAttribute('onclick');
                console.log('onclick attribute:', onclick);
                var x, y;
                
                if (onclick) {
                    // Extract from insertNumId('x','123');insertNumId('y','456')
                    var xMatch = onclick.match(/insertNumId\('x',\s*'(\d+)'\)/);
                    var yMatch = onclick.match(/insertNumId\('y',\s*'(\d+)'\)/);
                    console.log('xMatch:', xMatch, 'yMatch:', yMatch);
                    if (xMatch && yMatch) {
                        x = xMatch[1];
                        y = yMatch[1];
                    }
                }
                
                // Fallback: try to extract from link text (format: 123|456)
                if (!x || !y) {
                    var text = this.textContent;
                    console.log('Trying text extraction from:', text);
                    var match = text.match(/(\d+)\|(\d+)/);
                    console.log('text match:', match);
                    if (match) {
                        x = match[1];
                        y = match[2];
                    }
                }
                
                console.log('Final coordinates - x:', x, 'y:', y);
                
                if (x && y) {
                    console.log('Setting coordinates...');
                    document.getElementById('x').value = x;
                    document.getElementById('y').value = y;
                    console.log('Coordinates set, closing modal');
                    closeCommandHistoryModal();
                } else {
                    console.error('Could not extract coordinates!');
                }
            });
        });
    }

    // Close modal when clicking outside
    document.getElementById('command_history_modal').addEventListener('click', function (e) {
        if (e.target.id === 'command_history_modal') {
            closeCommandHistoryModal();
        }
    });

    $(document).ready(function() {
        const input = $('#place_destination_input');
        
        // Append autocomplete dropdown container to body to avoid container clipping
        if ($('#place_autocomplete_dropdown').length === 0) {
            $('body').append('<div id="place_autocomplete_dropdown"></div>');
        }
        const dropdown = $('#place_autocomplete_dropdown');
        let ajaxTimeout = null;

        function repositionDropdown() {
            if (dropdown.is(':visible')) {
                let offset = input.offset();
                dropdown.css({
                    top: offset.top + 'px',
                    left: offset.left + 'px',
                    width: input.outerWidth() + 'px'
                });
            }
        }

        $(window).on('scroll resize', repositionDropdown);

        function showSelectedVillageCard(item) {
            if (!item) return;

            let pts = parseInt(item.points) || 0;
            let graphic = 'v1';
            if (pts >= 11000) graphic = 'v6';
            else if (pts >= 9000) graphic = 'v5';
            else if (pts >= 3000) graphic = 'v4';
            else if (pts >= 1000) graphic = 'v3';
            else if (pts >= 300) graphic = 'v2';

            $('#sel_village_img').attr('src', 'graphic/map/' + graphic + '.png');
            $('#sel_village_title').text(item.name + ' (' + item.x + '|' + item.y + ')');
            $('#sel_village_owner').text(item.owner || 'Aldeia bárbara');
            $('#sel_village_points').text(pts.toLocaleString('pt-PT'));
            $('#sel_village_distance').text(item.distance);

            // Force target type to coordinates since we have exact coordinates now
            $('#tt_coords').prop('checked', true);

            input.hide();
            $('#place_selected_village_card').css('display', 'flex');
            dropdown.hide().empty();
        }

        let lastValue = '';
        let currentAjax = null;

        function checkCoordinates(val) {
            let match = val.match(/^(\d{1,3})\|(\d{1,3})$/);
            if (match) {
                let x = match[1];
                let y = match[2];

                if (currentAjax) currentAjax.abort();

                currentAjax = $.ajax({
                    url: 'game.php',
                    type: 'GET',
                    data: {
                        screen: 'api',
                        type: 'village_by_coords',
                        x: x,
                        y: y
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data) {
                            showSelectedVillageCard(data);
                        } else {
                            $('#place_selected_village_card').hide();
                            input.show();
                        }
                    }
                });
            } else {
                $('#place_selected_village_card').hide();
                input.show();
            }
        }

        // Run interval to detect coordinate changes (including manual typing, load, and clicking legacy modals/links)
        setInterval(function() {
            // Check the values of hidden inputs #x and #y
            let xVal = $('#x').val().trim();
            let yVal = $('#y').val().trim();
            let val = '';
            if (xVal !== '' && yVal !== '') {
                val = xVal + '|' + yVal;
            }
            if (val !== lastValue) {
                lastValue = val;
                if (val !== '') {
                    input.val(val);
                    checkCoordinates(val);
                } else {
                    input.val('');
                    $('#place_selected_village_card').hide();
                    input.show();
                }
            }
        }, 200);

        input.on('input focus', function() {
            let q = $(this).val().trim();
            let targetType = $('input[name="target_type"]:checked').val();

            if (q.length < 2 || targetType === 'coords') {
                dropdown.hide().empty();
                return;
            }

            clearTimeout(ajaxTimeout);
            ajaxTimeout = setTimeout(function() {
                let apiType = targetType === 'village_name' ? 'autocomplete_village' : 'autocomplete_player';
                $.ajax({
                    url: 'game.php',
                    type: 'GET',
                    data: {
                        screen: 'api',
                        type: apiType,
                        q: q
                    },
                    dataType: 'json',
                    success: function(data) {
                        dropdown.empty();
                        if (!data || data.length === 0) {
                            // Reposition before showing
                            let offset = input.offset();
                            dropdown.css({
                                top: offset.top + 'px',
                                left: offset.left + 'px',
                                width: input.outerWidth() + 'px'
                            }).html('<div style="padding:10px; text-align:center; font-style:italic; font-size:11px; color:#555; background:#f4e4bc;">Nenhuma aldeia encontrada</div>').show();
                            return;
                        }

                        data.forEach(function(item, idx) {
                            let pts = parseInt(item.points) || 0;
                            let graphic = 'v1';
                            if (pts >= 11000) graphic = 'v6';
                            else if (pts >= 9000) graphic = 'v5';
                            else if (pts >= 3000) graphic = 'v4';
                            else if (pts >= 1000) graphic = 'v3';
                            else if (pts >= 300) graphic = 'v2';

                            let displayStyle = idx >= 10 ? 'style="display:none;" class="autocomplete-item hidden-item"' : 'class="autocomplete-item"';

                            let row = $(`
                                <div ${displayStyle} data-x="${item.x}" data-y="${item.y}">
                                    <img src="graphic/map/${graphic}.png" alt="">
                                    <div class="autocomplete-details">
                                        <b>${item.name} (${item.x}|${item.y})</b><br>
                                        Proprietário: ${item.owner} Pontos: ${pts.toLocaleString('pt-PT')}<br>
                                        Distância: ${item.distance} campos
                                    </div>
                                </div>
                            `);
                            row.data('item', item);
                            dropdown.append(row);
                        });

                        if (data.length > 10) {
                            dropdown.append(`
                                <div id="show_more_autocomplete" style="padding:8px; text-align:center; font-weight:bold; cursor:pointer; background:#e3d5b3; border-top:1px solid #7d510f; color:#000; font-size:11px;">
                                    Mostrar mais
                                </div>
                            `);
                        }

                        // Position and show
                        let offset = input.offset();
                        dropdown.css({
                            top: offset.top + 'px',
                            left: offset.left + 'px',
                            width: input.outerWidth() + 'px'
                        }).show();
                    }
                });
            }, 150);
        });

        // Handle selection click from dropdown
        dropdown.on('click', '.autocomplete-item', function() {
            let x = $(this).data('x');
            let y = $(this).data('y');
            let item = $(this).data('item');

            $('#x').val(x);
            $('#y').val(y);
            input.val(x + '|' + y);
            lastValue = x + '|' + y;

            $('#tt_coords').prop('checked', true);
            dropdown.hide().empty();
            
            showSelectedVillageCard(item);
        });

        // Handle clearing the selected village
        $('#clear_selected_village').on('click', function(e) {
            e.preventDefault();
            $('#x').val('');
            $('#y').val('');
            input.val('');
            lastValue = '';
            $('#place_selected_village_card').hide();
            input.show().focus();
        });

        // Handle "Mostrar mais" click
        dropdown.on('click', '#show_more_autocomplete', function() {
            $(this).remove();
            dropdown.find('.hidden-item').removeClass('hidden-item').show();
            repositionDropdown(); // Adjust height calculations if container grows
        });

        // Hide on click outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#place_destination_input, #place_autocomplete_dropdown').length) {
                dropdown.hide();
            }
        });

        // Handle target type change
        $('input[name="target_type"]').on('change', function() {
            dropdown.hide().empty();
            if ($(this).val() !== 'coords') {
                input.trigger('input');
            }
        });

        // Also handle manual coordinates typed directly in place_destination_input
        input.on('input', function() {
            let val = $(this).val().trim();
            let match = val.match(/^(\d{1,3})\|(\d{1,3})$/);
            if (match) {
                $('#x').val(match[1]);
                $('#y').val(match[2]);
            }
        });
    });
</script>
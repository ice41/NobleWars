<?php
/**
 * Place Confirm View - Attack/Support Confirmation Screen
 * Migrated from game_place_confirm.tpl
 */

// Check for reservation conflict (if in tribe)
$attack_res_error = false;
if (($user['ally'] ?? '-1') != '-1') {
    $counts = $db->fetch(
        "SELECT COUNT(id) as count FROM rezerwacje WHERE do_wioski = ? AND od_plemienia = ? AND od_gracza != ?",
        [$info_village['id'], $user['ally'], $user['id']]
    );
    $attack_res_error = ($counts['count'] ?? 0) > 0;
}
?>

<?php if ($type == "attack" && $attack_res_error): ?>
    <h3 class="error"><?= __('screens.place.reservation_alert') ?></h3>
<?php endif; ?>

<?php if ($type == "attack"): ?>
    <h2><?= __('screens.place.attack') ?></h2>
<?php else: ?>
    <h2><?= __('screens.place.support') ?></h2>
<?php endif; ?>

<form action="game.php?village=<?= $village['id'] ?>&screen=place&action=command&h=<?= $hkey ?>" method="post"
    onSubmit="this.submit.disabled=false;">
    <input type="hidden" name="type" value="<?= $type ?>">
    <input type="hidden" name="target" value="<?= $info_village['id'] ?>">
    <input type="hidden" name="x" value="<?= $values['x'] ?>">
    <input type="hidden" name="y" value="<?= $values['y'] ?>">

    <table class="vis" width="300">
        <tr>
            <th colspan="2"><?= __('screens.place.order') ?></th>
        </tr>
        <tr>
            <td><?= __('screens.place.destination') ?></td>
            <td>
                <a href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $info_village['id'] ?>">
                    <?= htmlspecialchars($info_village['name']) ?> (<?= $values['x'] ?>|<?= $values['y'] ?>)
                    K<?= $info_village['continent'] ?>
                </a>
            </td>
        </tr>
        <tr>
            <td><?= __('screens.place.player') ?></td>
            <td>
                <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $info_village['userid'] ?>">
                    <?= htmlspecialchars($info_user['username'] ?? '') ?>
                </a>
            </td>
        </tr>
        <tr>
            <td><?= __('screens.place.duration') ?></td>
            <td><?= format_time($unit_runtime) ?></td>
        </tr>
        <tr>
            <td><?= __('screens.place.arrival') ?></td>
            <td>
                <?php if ($noc): ?>
                    <span style="color:red;"><?= format_date($arrival) ?></span>
                <?php else: ?>
                    <?= format_date($arrival) ?>
                <?php endif; ?>
            </td>
        </tr>
        <?php if ($type != "support"): ?>
            <?php if ($info_village['userid'] != "-1"): ?>
                <tr>
                    <td><?= __('screens.place.morale') ?></td>
                    <td><?= $morals ?? 100 ?>%</td>
                </tr>
            <?php endif; ?>
            <tr>
                <td colspan="2">
                    <img src="graphic/icons/resources.png"> <?= format_number($max_booty) ?>
                </td>
            </tr>
            <?php if ($noc): ?>
                <tr>
                    <td colspan="2">
                        <span class="error"><?= __('screens.place.night_bonus_alert') ?></span>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endif; ?>
    </table>
    <br>

    <div id="single_attack_ui">
        <table class="vis">
            <tr>
                <?php foreach ($cl_units->get_array("dbname") as $name => $dbname): ?>
                    <th width="50">
                        <img src="graphic/unit/<?= $dbname ?>.png" title="<?= $name ?>" alt="" />
                    </th>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach ($cl_units->get_array("dbname") as $name => $dbname): ?>
                    <?php if (($send_units[$dbname] ?? 0) > 0): ?>
                        <td><?= $send_units[$dbname] ?></td>
                    <?php else: ?>
                        <td class="hidden">0</td>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        </table>
        <br />

        <div style="margin-bottom: 15px;">
            <a href="#" id="add_attack_btn" onclick="initMultiAttack(); return false;" style="font-weight: bold; text-decoration: none; color: #804000;">
                <img src="graphic/icons/plus.png" alt="+" style="vertical-align: -2px;"> Adicionar novo ataque
            </a>
        </div>

        <?php foreach ($cl_units->get_array("dbname") as $name => $dbname): ?>
            <input type="hidden" name="<?= $dbname ?>" value="<?= $send_units[$dbname] ?? 0 ?>">
        <?php endforeach; ?>

        <?php if (($send_units['unit_catapult'] ?? 0) > 0 && $type != 'support'): ?>
            <table class="vis">
                <tr>
                    <th><?= __('screens.place.catapult_target') ?>:</th>
                    <td>
                        <select name="building" id="catapult_target_select" size="1">
                            <?php foreach ($cl_builds->get_array("dbname") as $dbname): ?>
                                <option value="<?= $dbname ?>" <?= (isset($building) && $building === $dbname) ? 'selected' : '' ?>>
                                    <?= $cl_builds->get_name($dbname) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            </table>
            <br />
        <?php endif; ?>

        <input name="submit_btn" class="troop_confirm_go btn btn-attack" type="submit" value="<?= __('screens.place.confirm_btn') ?>"
            style="font-size: 10pt;">
    </div>

    <!-- Hidden multi-attack UI -->
    <div id="multi_attack_ui" style="display: none;">
        <div style="border: 1px solid #7d510f; background: #f4e4bc; padding: 10px; margin-bottom: 15px; font-size: 12px; border-radius: 4px; display: flex; align-items: flex-start; gap: 10px;">
            <img src="graphic/new/questionmark.webp" alt="Info" style="width: 20px; height: 20px; flex-shrink: 0;">
            <div>
                <strong>Ataque múltiplo ativado:</strong> Enviar vários ataques de uma só vez de uma única aldeia é útil para situações específicas, tal como enviar vários nobres para reduzir a lealdade numa rápida sucessão.<br>
                <em>Na maioria dos casos, é sempre melhor enviar todas as suas tropas num único ataque para causar o maior dano.</em>
            </div>
        </div>
        
        <?php $all_db_units = $cl_units->get_array("dbname"); ?>
        <table class="vis" width="100%" id="multi_attack_table">
            <thead>
                <tr>
                    <th width="140">Unidades</th>
                    <?php foreach ($all_db_units as $name => $dbname): ?>
                    <th style="text-align:center"><img src="graphic/unit/<?= $dbname ?>.png" title="<?= $name ?>"></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody id="multi_attack_rows">
                <tr id="row_village_units" style="font-weight: bold; background: #f4e4bc;">
                    <td>Unidades na aldeia</td>
                    <?php foreach ($all_db_units as $name => $dbname): ?>
                    <td style="text-align:center" class="village_unit_count" data-unit="<?= $dbname ?>"><?= (int)($village[$dbname] ?? 0) ?></td>
                    <?php endforeach; ?>
                </tr>
                <tr id="row_attack_1" class="attack_row" data-row="1">
                    <td style="font-weight: bold;">Atacar #1</td>
                    <?php foreach ($all_db_units as $name => $dbname): ?>
                    <td style="text-align:center" class="attack_val" data-unit="<?= $dbname ?>">
                        <input type="text" size="3" name="multi_<?= $dbname ?>_1" value="<?= (int)($send_units[$dbname] ?? 0) ?>" onkeyup="updateMultiAttackTotals()" style="width: 35px; text-align: center;">
                    </td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
            <tfoot>
                <tr id="row_attack_add" style="background: #f4e4bc;">
                    <td>
                        <a href="#" id="add_another_attack_btn" onclick="addMultiAttackRow(); return false;" style="font-weight: bold; text-decoration: none; color: #804000;">
                            <img src="graphic/icons/plus.png" alt="+" style="vertical-align: -2px;"> Atacar #<span id="next_attack_num">2</span>
                        </a>
                    </td>
                    <td colspan="<?= count($all_db_units) ?>"></td>
                </tr>
                <tr style="font-weight: bold; background: #e3d5b3;">
                    <td>Total</td>
                    <?php foreach ($all_db_units as $name => $dbname): ?>
                    <td style="text-align:center" class="total_val" data-unit="<?= $dbname ?>"><?= (int)($send_units[$dbname] ?? 0) ?></td>
                    <?php endforeach; ?>
                </tr>
            </tfoot>
        </table>

        <?php if ($type != 'support'): ?>
            <div id="multi_catapult_ui" style="margin-top: 15px; display: none;">
                <table class="vis">
                    <tr>
                        <th><?= __('screens.place.catapult_target') ?>:</th>
                        <td>
                            <select name="multi_building" id="multi_catapult_target_select" size="1">
                                <?php foreach ($cl_builds->get_array("dbname") as $dbname): ?>
                                    <option value="<?= $dbname ?>"><?= $cl_builds->get_name($dbname) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>

        <div style="margin-top: 20px;">
            <button type="button" class="btn btn-attack" onclick="submitMultiAttack()">
                <span>Confirmar Ataques Múltiplos</span>
            </button>
            <button type="button" class="btn btn-cancel" onclick="cancelMultiAttack()" style="margin-left: 10px;">
                <span>Voltar</span>
            </button>
        </div>
    </div>
</form>

<div id="submission_status" style="display: none; margin-top: 20px; padding: 20px; border: 1px solid #7d510f; background: #f4e4bc; border-radius: 4px; text-align: center;">
    <p id="status_text">A enviar comandos...</p>
    <div id="progress_bar_container" style="width: 100%; height: 20px; background: #ddd; border-radius: 10px; overflow: hidden; margin-top: 10px;">
        <div id="progress_bar" style="width: 0%; height: 100%; background: #4caf50; transition: width 0.3s;"></div>
    </div>
</div>

<script>
    var allUnitDbNames = <?= json_encode($cl_units->get_array("dbname")) ?>;
    window.isMultiAttackMode = false;

    function initMultiAttack() {
        window.isMultiAttackMode = true;
        document.getElementById('single_attack_ui').style.display = 'none';
        document.getElementById('multi_attack_ui').style.display = 'block';
        updateMultiAttackTotals();
    }

    function cancelMultiAttack() {
        window.isMultiAttackMode = false;
        document.getElementById('single_attack_ui').style.display = 'block';
        document.getElementById('multi_attack_ui').style.display = 'none';
    }

    function addMultiAttackRow() {
        var tbody = document.getElementById('multi_attack_rows');
        var nextNum = parseInt(document.getElementById('next_attack_num').innerText);
        
        var templateRow = document.getElementById('row_attack_1');
        var newRow = templateRow.cloneNode(true);
        newRow.id = 'row_attack_' + nextNum;
        newRow.dataset.row = nextNum;
        
        var cells = newRow.getElementsByTagName('td');
        cells[0].innerHTML = 'Atacar #' + nextNum + ' <a href="#" onclick="removeMultiAttackRow(' + nextNum + '); return false;" style="color:red; font-weight:bold; margin-left: 5px;">X</a>';
        
        var inputs = newRow.getElementsByTagName('input');
        for (var i = 0; i < inputs.length; i++) {
            var nameParts = inputs[i].name.split('_');
            var unit = nameParts[1] + '_' + nameParts[2];
            inputs[i].name = 'multi_' + unit + '_' + nextNum;
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
        var hasCatapults = false;
        for (var dbname in allUnitDbNames) {
            var total = 0;
            var inputs = document.querySelectorAll('input[name^="multi_' + dbname + '_"]');
            inputs.forEach(function(input) {
                total += parseInt(input.value) || 0;
            });
            
            if (dbname === 'unit_catapult' && total > 0) hasCatapults = true;

            var totalCells = document.querySelectorAll('.total_val[data-unit="' + dbname + '"]');
            totalCells.forEach(function(cell) {
                cell.innerText = total;
                
                var villageCells = document.querySelectorAll('.village_unit_count[data-unit="' + dbname + '"]');
                if (villageCells.length > 0) {
                    var max = parseInt(villageCells[0].innerText) || 0;
                    if (total > max) {
                        cell.style.color = 'red';
                        cell.style.fontWeight = 'bold';
                    } else {
                        cell.style.color = '';
                        cell.style.fontWeight = 'normal';
                    }
                }
            });
        }
        
        var catUi = document.getElementById('multi_catapult_ui');
        if (catUi) {
            catUi.style.display = hasCatapults ? 'block' : 'none';
        }
    }

    function submitMultiAttack() {
        var attacksQueue = [];
        var rows = document.querySelectorAll('.attack_row');
        
        rows.forEach(function(row) {
            var attackUnits = {};
            var hasUnits = false;
            var inputs = row.querySelectorAll('input[name^="multi_"]');
            
            inputs.forEach(function(input) {
                var nameParts = input.name.split('_');
                var unitName = nameParts[1] + '_' + nameParts[2];
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

        if (attacksQueue.length === 0) {
            alert('Por favor selecione tropas para pelo menos um ataque.');
            return;
        }

        var catSelect = document.getElementById('multi_catapult_target_select');
        var catapultTarget = catSelect ? catSelect.value : null;

        document.getElementById('multi_attack_ui').style.display = 'none';
        document.getElementById('submission_status').style.display = 'block';
        
        processQueue(attacksQueue, 0, catapultTarget);
    }

    function processQueue(queue, index, catTarget) {
        if (index >= queue.length) {
            document.getElementById('status_text').innerHTML = '<span style="color:green; font-weight:bold;">Todos os comandos foram enviados com sucesso!</span>';
            document.getElementById('progress_bar').style.width = '100%';
            setTimeout(function() {
                window.location.href = 'game.php?village=<?= $village['id'] ?>&screen=place';
            }, 1500);
            return;
        }

        var progress = (index / queue.length) * 100;
        document.getElementById('progress_bar').style.width = progress + '%';
        document.getElementById('status_text').innerText = 'A enviar comando ' + (index + 1) + ' de ' + queue.length + '...';

        var units = queue[index];
        var formData = new FormData();
        formData.append('type', '<?= $type ?>');
        formData.append('target', '<?= $info_village['id'] ?>');
        if (catTarget) formData.append('building', catTarget);
        
        for (var u in units) {
            formData.append(u, units[u]);
        }

        fetch('game.php?village=<?= $village['id'] ?>&screen=place&action=command', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                setTimeout(function() {
                    processQueue(queue, index + 1, catTarget);
                }, 200);
            } else {
                document.getElementById('status_text').innerHTML = '<span style="color:red; font-weight:bold;">Erro no ataque ' + (index + 1) + ': ' + (data.error || 'Erro desconhecido') + '</span>';
            }
        })
        .catch(error => {
            document.getElementById('status_text').innerHTML = '<span style="color:red; font-weight:bold;">Erro de comunicação no servidor.</span>';
        });
    }
</script>
</form>
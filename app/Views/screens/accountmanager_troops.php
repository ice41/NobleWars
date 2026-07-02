<?php
/**
 * Account Manager - Troops Mode
 * Manage troop recruitment templates for villages
 */

// Unit types
$units = [
    'spear' => __('units.spear.name'),
    'sword' => __('units.sword.name'),
    'axe' => __('units.axe.name'),
    'archer' => __('units.archer.name'),
    'spy' => __('units.spy.name'),
    'light' => __('units.light.name'),
    'marcher' => __('units.marcher.name'),
    'heavy' => __('units.heavy.name'),
    'ram' => __('units.ram.name'),
    'catapult' => __('units.catapult.name')
];

// No predefined templates, only custom ones created by the player
$all_templates = $custom_templates ?? [];
?>

<h3><?= __('screens.accountmanager.troops.title') ?? 'Gerir Modelos de Tropas' ?></h3>

<?php if (!empty($success)): ?>
    <div class="success_box" style="margin-bottom: 15px;">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="error_box" style="margin-bottom: 15px;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<form method="post" action="game.php?village=<?= $village['id'] ?>&screen=accountmanager&mode=troops&action=confirm">
    <input type="hidden" name="h" value="<?= $hkey ?>">

    <!-- Villages List -->
    <table class="vis" width="100%">
        <tr>
            <th width="20">
                <input type="checkbox" id="select_all" onclick="toggleAllVillages(this)">
            </th>
            <th>Aldeia</th>
            <th>Modelo</th>
            <th>Fila de Recrutamento</th>
            <th>Tropas Atuais</th>
            <th width="40">Remover</th>
        </tr>
        <?php if (empty($villages)): ?>
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px; color: #999;">
                    Nenhuma aldeia encontrada!
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($villages as $village_item): ?>
                <?php
                $automation = $automations[$village_item['id']] ?? null;
                $template_name = $automation['template_name'] ?? '-';
                $status = 'Não gerido';
                
                if ($automation && $automation['active']) {
                    $status = 'Ativo (Aguardando recursos)';
                }
                ?>
                <tr>
                    <td>
                        <input type="checkbox" name="village_ids[]" value="<?= $village_item['id'] ?>" class="village_checkbox">
                    </td>
                    <td>
                        <a href="game.php?village=<?= $village_item['id'] ?>&screen=overview">
                            <?= htmlspecialchars($village_item['name']) ?>
                            (<?= $village_item['x'] ?>|<?= $village_item['y'] ?>) K<?= $village_item['continent'] ?>
                        </a>
                    </td>
                    <td style="text-align: center;">
                        <strong><?= htmlspecialchars($template_name) ?></strong>
                    </td>
                    <td>
                        <?= $status ?>
                    </td>
                    <td style="font-size: 10px; color: #666; line-height: 1.4;">
                        <?php 
                        $units_printed = [];
                        foreach ($units as $u_key => $u_name) {
                            $count = $village_item['units'][$u_key] ?? 0;
                            if ($count > 0) {
                                $units_printed[] = "<img src='graphic/unit/unit_{$u_key}.png' style='vertical-align:middle; width:12px;' /> {$count}";
                            }
                        }
                        echo !empty($units_printed) ? implode(', ', $units_printed) : 'Sem tropas';
                        ?>
                    </td>
                    <td style="text-align: center;">
                        <?php if ($automation): ?>
                            <a href="game.php?village=<?= $village['id'] ?>&screen=accountmanager&mode=troops&action=remove&target=<?= $village_item['id'] ?>&h=<?= $hkey ?>"
                                onclick="return confirm('Tem a certeza que deseja remover o recrutamento automático desta aldeia?');">
                                <img src="graphic/icons/delete.png" alt="Remover" />
                            </a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

    <!-- Action Configuration -->
    <table class="vis" width="100%" style="margin-top: 15px;">
        <tr>
            <th colspan="5">Ação</th>
        </tr>
        <tr>
            <td>
                <label>
                    <input type="checkbox" id="select_all_bottom" onclick="toggleAllVillages(this)">
                    Selecionar tudo
                </label>
            </td>
            <td>
                <select name="action_type" id="action_type">
                    <option value="use_template">Aplicar Modelo</option>
                    <option value="remove">Remover Gestão</option>
                </select>
            </td>
            <td>
                <label>Modelo:</label>
                <select name="template" id="template_select">
                    <?php if (!empty($custom_templates)): ?>
                        <?php foreach ($custom_templates as $temp_name => $temp_data): ?>
                            <option value="<?= htmlspecialchars($temp_name) ?>">
                                <?= htmlspecialchars($temp_name) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">-- Nenhum modelo criado --</option>
                    <?php endif; ?>
                </select>
            </td>
            <td>
                <button type="submit" class="btn">Confirmar</button>
            </td>
            <td align="right">
                <a href="javascript:void(0);" onclick="openTemplateModal();">&raquo; Gerir Modelos de Tropas</a>
            </td>
        </tr>
    </table>
</form>

<!-- Modal Overlay -->
<div id="modal_overlay"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9998;"
    onclick="closeTemplateModal();"></div>

<!-- Template Management Modal -->
<div id="template_modal"
    style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 95%; max-width: 700px; z-index: 9999;">
    <div style="border-radius: 8px; overflow: hidden;">
        <table class="popup_box" cellspacing="0" cellpadding="0"
            style="background: url('graphic/popup/content_background.png'); border-collapse: collapse; line-height: 0; font-size: 0; width: 100%;">
            <!-- Top Border -->
            <tr style="line-height: 0;">
                <td style="background: url('graphic/popup/border_top_left.png') no-repeat; width: 20px; height: 20px; padding: 0;"></td>
                <td style="background: url('graphic/popup/border_top.png') repeat-x; height: 20px; padding: 0;"></td>
                <td style="background: url('graphic/popup/border_top_right.png') no-repeat; width: 20px; height: 20px; padding: 0;"></td>
            </tr>
            <!-- Content -->
            <tr>
                <td style="background: url('graphic/popup/mainborder_left.png') repeat-y; width: 20px; padding: 0;"></td>
                <td style="padding: 20px; background-color: #f4e4bc; line-height: normal; font-size: 12px;">
                    <!-- Header -->
                    <div style="margin-bottom: 15px; padding-bottom: 10px; position: relative;">
                        <h3 style="margin: 0;">Gerir Modelos de Recrutamento</h3>
                        <a href="javascript:void(0);" onclick="closeTemplateModal();" style="position: absolute; top: -5px; right: -5px;">
                            <img src="graphic/popup/close.png" alt="Fechar" style="cursor: pointer;" />
                        </a>
                    </div>

                    <!-- Template Selector to Edit / Delete -->
                    <div style="margin-bottom: 15px; background: #e2cfa7; padding: 10px; border: 1px solid #7d510f;">
                        <label><strong>Editar modelo existente ou criar novo:</strong></label><br>
                        <select id="edit_template_select" onchange="loadTemplateToEdit(this.value);" style="margin-top: 5px; width: 200px; padding: 3px; border: 1px solid #7d510f;">
                            <option value="">-- Criar Novo Modelo --</option>
                            <?php foreach ($custom_templates as $temp_name => $temp_data): ?>
                                <option value="<?= htmlspecialchars($temp_name) ?>"><?= htmlspecialchars($temp_name) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="button" class="btn" id="delete_template_btn" onclick="deleteSelectedTemplate();" style="display: none; margin-left: 10px; background: #c9302c; color: white;">Apagar Modelo</button>
                    </div>

                    <!-- Template Name -->
                    <div style="margin-bottom: 15px;">
                        <label><strong>Nome do Modelo:</strong></label><br>
                        <input type="text" id="new_template_name" placeholder="Ex: Ataque, Defesa..."
                            style="width: 100%; padding: 5px; margin-top: 5px; border: 1px solid #7d510f;">
                    </div>

                    <!-- Units Form Grid -->
                    <div style="max-height: 300px; overflow-y: auto; background: #fff; padding: 10px; border: 1px solid #7d510f;">
                        <table class="vis" width="100%">
                            <tr>
                                <th width="50">Ícone</th>
                                <th>Unidade</th>
                                <th width="150">Quantidade Alvo</th>
                            </tr>
                            <?php foreach ($units as $unit_key => $unit_name): ?>
                                <tr>
                                    <td style="text-align: center;">
                                        <img src="graphic/unit/unit_<?= $unit_key ?>.png" alt="<?= $unit_name ?>" />
                                    </td>
                                    <td><?= htmlspecialchars($unit_name) ?></td>
                                    <td style="text-align: center;">
                                        <input type="number" id="level_<?= $unit_key ?>" min="0" max="25000" value="0"
                                            style="width: 100px; text-align: center; border: 1px solid #7d510f; padding: 3px;">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>

                    <!-- Buttons -->
                    <div style="text-align: center; margin-top: 15px; padding-top: 15px; border-top: 1px solid #7d510f;">
                        <button class="btn" onclick="saveTemplate()">Guardar Modelo</button>
                        <button class="btn" onclick="closeTemplateModal()" style="margin-left: 10px;">Cancelar</button>
                    </div>
                </td>
                <td style="background: url('graphic/popup/mainborder_right.png') repeat-y; width: 20px; padding: 0;"></td>
            </tr>
            <!-- Bottom Border -->
            <tr style="line-height: 0;">
                <td style="background: url('graphic/popup/border_bottom_left.png') no-repeat; width: 20px; height: 20px; padding: 0;"></td>
                <td style="background: url('graphic/popup/border_bottom.png') repeat-x; height: 20px; padding: 0;"></td>
                <td style="background: url('graphic/popup/border_bottom_right.png') no-repeat; width: 20px; height: 20px; padding: 0;"></td>
            </tr>
        </table>
    </div>
</div>

<script>
    const customTemplates = <?= json_encode($custom_templates ?? []) ?>;

    function toggleAllVillages(checkbox) {
        const checkboxes = document.querySelectorAll('.village_checkbox');
        checkboxes.forEach(cb => cb.checked = checkbox.checked);
    }

    // Sync the two checkboxes
    document.addEventListener('DOMContentLoaded', function() {
        const topSelect = document.getElementById('select_all');
        const bottomSelect = document.getElementById('select_all_bottom');
        
        if (topSelect && bottomSelect) {
            topSelect.addEventListener('change', function () {
                bottomSelect.checked = this.checked;
            });
            bottomSelect.addEventListener('change', function () {
                topSelect.checked = this.checked;
            });
        }
    });

    window.openTemplateModal = function () {
        document.getElementById('template_modal').style.display = 'block';
        document.getElementById('modal_overlay').style.display = 'block';
        document.getElementById('edit_template_select').value = "";
        loadTemplateToEdit("");
    }

    window.closeTemplateModal = function () {
        document.getElementById('template_modal').style.display = 'none';
        document.getElementById('modal_overlay').style.display = 'none';
    }

    window.loadTemplateToEdit = function (templateName) {
        const units = ['spear', 'sword', 'axe', 'archer', 'spy', 'light', 'marcher', 'heavy', 'ram', 'catapult'];
        const nameInput = document.getElementById('new_template_name');
        const deleteBtn = document.getElementById('delete_template_btn');

        if (templateName && customTemplates[templateName]) {
            nameInput.value = templateName;
            nameInput.disabled = true; // Don't let rename from here (delete and create instead)
            deleteBtn.style.display = 'inline-block';
            
            const templateData = customTemplates[templateName];
            units.forEach(unit => {
                document.getElementById('level_' + unit).value = templateData[unit] ?? 0;
            });
        } else {
            nameInput.value = "";
            nameInput.disabled = false;
            deleteBtn.style.display = 'none';
            units.forEach(unit => {
                document.getElementById('level_' + unit).value = 0;
            });
        }
    }

    window.deleteSelectedTemplate = function () {
        const templateName = document.getElementById('edit_template_select').value;
        if (!templateName || !confirm('Deseja realmente apagar o modelo "' + templateName + '"?')) return;

        const formData = new FormData();
        formData.append('h', '<?= $hkey ?>');
        formData.append('template_name', templateName);

        fetch('game.php?village=<?= $village['id'] ?>&screen=accountmanager&mode=troops&action=delete_template', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Modelo apagado com sucesso!');
                location.reload();
            } else {
                alert('Erro ao apagar modelo: ' + (data.message || 'Erro desconhecido'));
            }
        })
        .catch(error => {
            alert('Erro ao apagar modelo!');
            console.error(error);
        });
    }

    window.saveTemplate = function () {
        const templateName = document.getElementById('new_template_name').value.trim();

        if (!templateName) {
            alert('Por favor insira um nome para o modelo!');
            return;
        }

        const units = ['spear', 'sword', 'axe', 'archer', 'spy', 'light', 'marcher', 'heavy', 'ram', 'catapult'];
        const levels = {};

        units.forEach(unit => {
            const value = parseInt(document.getElementById('level_' + unit).value) || 0;
            levels[unit] = value;
        });

        const formData = new FormData();
        formData.append('h', '<?= $hkey ?>');
        formData.append('template_name', templateName);
        formData.append('levels', JSON.stringify(levels));

        fetch('game.php?village=<?= $village['id'] ?>&screen=accountmanager&mode=troops&action=save_template', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Modelo guardado com sucesso!');
                location.reload();
            } else {
                alert('Erro ao guardar modelo: ' + (data.message || 'Erro desconhecido'));
            }
        })
        .catch(error => {
            alert('Erro ao guardar modelo!');
            console.error(error);
        });
    }
</script>
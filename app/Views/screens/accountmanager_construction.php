<?php
/**
 * Account Manager - Construction Mode
 * Manage village construction queues across all villages
 */

// Building types for dropdown
$building_types = [
    'main' => __('buildings.main.name'),
    'barracks' => __('buildings.barracks.name'),
    'stable' => __('buildings.stable.name'),
    'garage' => __('buildings.garage.name'),
    'church' => __('buildings.church.name'),
    'snob' => __('buildings.snob.name'),
    'smith' => __('buildings.smith.name'),
    'place' => __('buildings.place.name'),
    'statue' => __('buildings.statue.name'),
    'market' => __('buildings.market.name'),
    'wood' => __('buildings.wood.name'),
    'stone' => __('buildings.stone.name'),
    'iron' => __('buildings.iron.name'),
    'farm' => __('buildings.farm.name'),
    'storage' => __('buildings.storage.name'),
    'hide' => __('buildings.hide.name'),
    'wall' => __('buildings.wall.name')
];
?>

<h3><?= __('screens.am_construction.title') ?></h3>

<form method="post"
    action="game.php?village=<?= $village['id'] ?>&screen=accountmanager&mode=construction&action=confirm">
    <input type="hidden" name="h" value="<?= $hkey ?>">

    <!-- Village List -->
    <table class="vis" width="100%">
        <tr>
            <th width="20">
                <input type="checkbox" id="select_all" onclick="toggleAllVillages(this)">
            </th>
            <th><?= __('screens.am_construction.village_name') ?></th>
            <th><?= __('screens.am_construction.template') ?></th>
            <th width="80"><?= __('screens.am_construction.orders') ?></th>
            <th><?= __('screens.am_construction.status') ?></th>
            <th width="40"><?= __('screens.am_construction.remove') ?></th>
        </tr>

        <?php if (empty($villages)): ?>
            <tr>
                <td colspan="6"  class="text-center" style="padding: 20px; color: #999;">
                    <?= __('screens.am_construction.no_villages_found') ?>
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($villages as $village_item): ?>
                <?php
                // Get automation status for this village
                $automation = $automations[$village_item['id']] ?? null;
                $template_name = $automation['template_name'] ?? '-';
                $orders_count = $automation['orders_completed'] ?? 0;
                $orders_total = $automation['orders_total'] ?? 50;
                $status = __('screens.am_construction.not_managed');

                if ($automation && $automation['active']) {
                    if (!empty($village_item['build_queue'])) {
                        $queue = $village_item['build_queue'];
                        $building_name = $building_types[$queue['building']] ?? $queue['building'];
                        $status = __('screens.am_construction.building') . ': ' . $building_name;
                    } else {
                        $status = __('screens.am_construction.managed_waiting');
                    }
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
                    <td  class="text-center">
                        <?= $template_name ?>
                    </td>
                    <td  class="text-center">
                        <?= $orders_count ?> / <?= $orders_total ?>
                    </td>
                    <td>
                        <?= $status ?>
                    </td>
                    <td  class="text-center">
                        <?php if ($automation): ?>
                            <a href="game.php?village=<?= $village['id'] ?>&screen=accountmanager&mode=construction&action=remove&target=<?= $village_item['id'] ?>&h=<?= $hkey ?>">
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
    <table class="vis mt-15" width="100%" >
        <tr>
            <th colspan="5"><?= __('screens.am_construction.action') ?></th>
        </tr>
        <tr>
            <td>
                <label>
                    <input type="checkbox" id="select_all_bottom" onclick="toggleAllVillages(this)">
                    <?= __('screens.am_construction.select_all') ?>
                </label>
            </td>
            <td>
                <select name="action_type" id="action_type">
                    <option value="use_template"><?= __('screens.am_construction.use_template') ?></option>
                    <option value="build_to_level"><?= __('screens.common.build_to_level') ?></option>
                </select>
            </td>
            <td>
                <label><?= __('screens.am_construction.template_label') ?></label>
                <select name="template" id="template_select">
                    <option value="normal"><?= __('screens.am_construction.normal') ?></option>
                    <option value="defensive"><?= __('screens.am_construction.defensive') ?></option>
                    <option value="offensive"><?= __('screens.am_construction.offensive') ?></option>
                    <?php if (!empty($custom_templates)): ?>
                        <optgroup label="<?= __('screens.am_construction.custom_templates') ?>">
                            <?php foreach ($custom_templates as $template_name => $template_data): ?>
                                <option value="<?= htmlspecialchars($template_name) ?>">
                                    <?= htmlspecialchars($template_name) ?>
                                </option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endif; ?>
                </select>
            </td>
            <td>
                <button type="submit" class="btn"><?= __('screens.am_construction.confirm') ?></button>
            </td>
            <td align="right">
                <a href="javascript:void(0);" onclick="openTemplateModal();">&raquo;
                    <?= __('screens.am_construction.manage_templates') ?></a>
            </td>
        </tr>
    </table>
</form>

<br />

<!-- Villages per page -->
<div  class="text-center">
    <?= __('screens.am_construction.villages_per_page') ?>:
    <input type="text" value="100" size="3" readonly />
    <button class="btn" disabled><?= __('screens.am_construction.ok') ?></button>
</div>

<script>
    function toggleAllVillages(checkbox) {
        const checkboxes = document.querySelectorAll('.village_checkbox');
        checkboxes.forEach(cb => cb.checked = checkbox.checked);
    }

    // Sync the two "select all" checkboxes
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


    // Template Management Modal Functions (make them global)
    window.openTemplateModal = function () {
        console.log('Opening template modal...');
        var modal = document.getElementById('template_modal');
        var overlay = document.getElementById('modal_overlay');

        if (!modal || !overlay) {
            console.error('Modal elements not found!');
            alert('<?= __('screens.am_construction.modal_not_found') ?>');
            return;
        }

        modal.style.display = 'block';
        overlay.style.display = 'block';
        console.log('Modal opened successfully');
    }

    window.closeTemplateModal = function () {
        document.getElementById('template_modal').style.display = 'none';
        document.getElementById('modal_overlay').style.display = 'none';
    }

    window.saveTemplate = function () {
        const templateName = document.getElementById('new_template_name').value.trim();

        if (!templateName) {
            alert('<?= __('screens.am_construction.enter_template_name') ?>');
            return;
        }

        // Collect building levels
        const buildings = ['main', 'farm', 'wood', 'stone', 'iron', 'storage', 'barracks', 'stable', 'garage', 'smith', 'place', 'market', 'wall', 'hide', 'church', 'snob', 'statue'];
        const levels = {};

        buildings.forEach(building => {
            const value = parseInt(document.getElementById('level_' + building).value) || 0;
            if (value > 0) {
                levels[building] = value;
            }
        });

        // Send to server
        const formData = new FormData();
        formData.append('h', '<?= $hkey ?>');
        formData.append('template_name', templateName);
        formData.append('levels', JSON.stringify(levels));

        fetch('game.php?village=<?= $village['id'] ?>&screen=accountmanager&mode=construction&action=save_template', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('<?= __('screens.am_construction.template_saved') ?>');
                    location.reload();
                } else {
                    alert('<?= __('screens.am_construction.error_saving') ?>: ' + (data.message || '<?= __('screens.am_construction.unknown_error') ?>'));
                }
            })
            .catch(error => {
                alert('<?= __('screens.am_construction.error_saving') ?>!');
                console.error(error);
            });
    }
</script>

<!-- Template Management Modal -->
<div id="modal_overlay"
     style="display: none; position: fixed; top: 0; left: 0; width: 80%; height: 80%; background: rgba(0,0,0,0.5); z-index: 9998;"
    onclick="closeTemplateModal();"></div>

<div id="template_modal"
     style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 95%; max-width: 900px; z-index: 9999;">
    <div  style="border-radius: 8px; overflow: hidden;">
        <!-- Popup Structure using game graphics -->
        <table class="popup_box" cellspacing="0" cellpadding="0"
             style="background: url(;"graphic/popup/content_background.png'); border-collapse: collapse; line-height: 0; font-size: 0; width: 100%;">
            <!-- Top Border -->
            <tr  style="line-height: 0;">
                <td
                     style="background: url(;"graphic/popup/border_top_left.png') no-repeat; width: 20px; height: 20px; line-height: 0; font-size: 0; padding: 0; margin: 0; vertical-align: top;">
                </td>
                <td
                     style="background: url(;"graphic/popup/border_top.png') repeat-x; height: 20px; line-height: 0; font-size: 0; padding: 0; margin: 0; vertical-align: top;">
                </td>
                <td
                     style="background: url(;"graphic/popup/border_top_right.png') no-repeat; width: 20px; height: 20px; line-height: 0; font-size: 0; padding: 0; margin: 0; vertical-align: top;">
                </td>
            </tr>

            <!-- Content -->
            <tr>
                <td
                     style="background: url(;"graphic/popup/mainborder_left.png') repeat-y; width: 20px; line-height: 0; font-size: 0;">
                </td>
                <td
                     style="padding: 20px; background-color: #f4e4bc; line-height: normal; font-size: 12px; max-height: 80vh; overflow-y: auto;">
                    <!-- Header -->
                    <div  class="mb-15" style="padding-bottom: 10px; position: relative;">
                        <h3  style="margin: 0;"><?= __('screens.am_construction.manage_construction_templates') ?></h3>
                        <a href="javascript:void(0);" onclick="closeTemplateModal();"
                             style="position: absolute; top: -5px; right: -5px;">
                            <img src="graphic/popup/close.png" alt="<?= __('screens.am_construction.close') ?>" style="cursor: pointer;" />
                        </a>
                    </div>

                    <!-- Template Name -->
                    <div  class="mb-15">
                        <label><strong><?= __('screens.am_construction.template_name_label') ?></strong></label><br>
                        <input type="text" id="new_template_name" placeholder="<?= __('screens.am_construction.template_name_placeholder') ?>"
                            style="width: 100%; padding: 5px; margin-top: 5px; border: 1px solid #7d510f;">
                    </div>

                    <!-- Buildings Table -->
                    <div  style="max-height: 100%; overflow-y: auto;">
                        <table class="vis" width="100%">
                            <tr>
                                <th><?= __('screens.common.build_to_level') ?></th>
                                <th width="120"><?= __('screens.common.target_level') ?></th>
                            </tr>
                            <?php foreach ($building_types as $building_key => $building_name): ?>
                                <tr>
                                    <td><?= $building_name ?></td>
                                    <td  class="text-center">
                                        <input type="number" id="level_<?= $building_key ?>" min="0" max="30" value="0"
                                            style="width: 70px; text-align: center; border: 1px solid #7d510f; padding: 3px;">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>

                    <!-- Buttons -->
                    <div
                         class="text-center mt-15" style="padding-top: 15px; border-top: 1px solid #7d510f;">
                        <button class="btn" onclick="saveTemplate()"><?= __('screens.am_construction.save_template') ?></button>
                        <button class="btn" onclick="closeTemplateModal()"  style="margin-left: 10px;"><?= __('screens.am_construction.cancel') ?></button>
                    </div>
                </td>
                <td
                     style="background: url(;"graphic/popup/mainborder_right.png') repeat-y; width: 20px; line-height: 0; font-size: 0;">
                </td>
            </tr>

            <!-- Bottom Border -->
            <tr>
                <td
                     style="background: url(;"graphic/popup/border_bottom_left.png') no-repeat; width: 20px; height: 20px; line-height: 0; font-size: 0; padding: 0; display: block;">
                </td>
                <td
                     style="background: url(;"graphic/popup/border_bottom.png') repeat-x; height: 20px; line-height: 0; font-size: 0; padding: 0;">
                </td>
                <td
                     style="background: url(;"graphic/popup/border_bottom_right.png') no-repeat; width: 20px; height: 20px; line-height: 0; font-size: 0; padding: 0; display: block;">
                </td>
            </tr>
        </table>
    </div>
</div>
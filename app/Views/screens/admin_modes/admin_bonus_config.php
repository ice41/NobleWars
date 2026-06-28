<?php
// Admin Bonus Configuration View
?>
<!DOCTYPE html>
<html>

<head>
    <title><?= __('admin.bonus.title') ?></title>
    <style>
        .bonus-admin-container {
            padding: 20px;
        }

        .golden-row {
            background-color: #fff9c4 !important;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 600px;
            border-radius: 5px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .dynamic-fields {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
    <div class="bonus-admin-container">
        <h1><?= __('admin.bonus.title') ?></h1>
        <p><?= __('admin.bonus.desc') ?></p>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= __('admin.bonus.success') ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?= __('admin.bonus.error_prefix') ?> <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <table class="vis" width="100%">
            <thead>
                <tr>
                    <th><?= __('admin.bonus.col_day') ?></th>
                    <th><?= __('admin.bonus.col_chest_type') ?></th>
                    <th><?= __('admin.bonus.col_reward_type') ?></th>
                    <th><?= __('admin.bonus.col_desc') ?></th>
                    <th><?= __('admin.bonus.col_details') ?></th>
                    <th><?= __('admin.bonus.col_actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bonus_configs as $config): ?>
                    <tr class="<?= $config['chest_type'] === 'golden' ? 'golden-row' : '' ?>">
                        <td><strong><?= $config['day'] ?></strong></td>
                        <td><?= $config['chest_type'] === 'golden' ? __('admin.bonus.chest_golden') : __('admin.bonus.chest_normal') ?></td>
                        <td><?= ucfirst($config['reward_type']) ?></td>
                        <td><?= htmlspecialchars($config['description']) ?></td>
                        <td><small><?= htmlspecialchars($config['reward_data']) ?></small></td>
                        <td>
                            <button class="btn" style="background: #ff9800; border-color: #e65100; color: white;" onclick="editBonus(<?= htmlspecialchars(json_encode($config)) ?>)">
                                <i class="fas fa-edit"></i> <?= __('admin.bonus.btn_edit') ?>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2><?= __('admin.bonus.edit_title') ?> <span id="modalDay"></span></h2>

            <form method="POST" action="admin.php?action=dashboard&mode=bonus_config">
                <input type="hidden" name="action" value="save_bonus">
                <input type="hidden" name="day" id="editDay">

                <div class="form-group">
                    <label><?= __('admin.bonus.chest_type_label') ?></label>
                    <select name="chest_type" id="editChestType">
                        <option value="normal"><?= __('admin.bonus.chest_opt_normal') ?></option>
                        <option value="golden"><?= __('admin.bonus.chest_opt_golden') ?></option>
                    </select>
                </div>

                <div class="form-group">
                    <label><?= __('admin.bonus.reward_type_label') ?></label>
                    <select name="reward_type" id="editRewardType" onchange="updateDynamicFields()">
                        <option value="resources"><?= __('admin.bonus.reward_opt_res') ?></option>
                        <option value="premium"><?= __('admin.bonus.reward_opt_premium') ?></option>
                        <option value="features"><?= __('admin.bonus.reward_opt_features') ?></option>
                        <option value="items"><?= __('admin.bonus.reward_opt_items') ?></option>
                        <option value="flags"><?= __('admin.bonus.reward_opt_flags') ?></option>
                    </select>
                </div>

                <div id="dynamicFields" class="dynamic-fields"></div>

                <div class="form-group">
                    <label><?= __('admin.bonus.desc_label') ?></label>
                    <input type="text" name="description" id="editDescription" required>
                </div>

                <button type="submit" class="btn"><i class="fas fa-save"></i> <?= __('admin.bonus.btn_save') ?></button>
            </form>
        </div>
    </div>

    <script>
        const itemsList = <?= json_encode(array_map(function($item) {
            return [
                'id' => $item['id'],
                'name' => __('items.item_' . $item['id'] . '_name', $item['name'])
            ];
        }, $items_list)) ?>;

        function editBonus(config) {
            document.getElementById('editModal').style.display = 'block';
            document.getElementById('modalDay').textContent = config.day;
            document.getElementById('editDay').value = config.day;
            document.getElementById('editChestType').value = config.chest_type;
            document.getElementById('editRewardType').value = config.reward_type;
            document.getElementById('editDescription').value = config.description;

            updateDynamicFields(JSON.parse(config.reward_data));
        }

        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        function updateDynamicFields(currentData = {}) {
            const rewardType = document.getElementById('editRewardType').value;
            const container = document.getElementById('dynamicFields');
            let html = '';

            switch (rewardType) {
                case 'resources':
                    html = `
                        <div class="form-group">
                            <label><?= __('admin.bonus.res_wood') ?></label>
                            <input type="number" name="wood" value="${currentData.wood || 0}" min="0">
                        </div>
                        <div class="form-group">
                            <label><?= __('admin.bonus.res_stone') ?></label>
                            <input type="number" name="stone" value="${currentData.stone || 0}" min="0">
                        </div>
                        <div class="form-group">
                            <label><?= __('admin.bonus.res_iron') ?></label>
                            <input type="number" name="iron" value="${currentData.iron || 0}" min="0">
                        </div>
                    `;
                    break;

                case 'premium':
                    html = `
                        <div class="form-group">
                            <label><?= __('admin.bonus.prem_points') ?></label>
                            <input type="number" name="premium_points" value="${currentData.premium_points || 0}" min="0">
                        </div>
                    `;
                    break;

                case 'features':
                    html = `
                        <div class="form-group">
                            <label><?= __('admin.bonus.feat_am') ?></label>
                            <input type="number" name="am_days" value="${currentData.account_manager_days || 0}" min="0">
                        </div>
                        <div class="form-group">
                            <label><?= __('admin.bonus.feat_fa') ?></label>
                            <input type="number" name="fa_days" value="${currentData.farm_assistant_days || 0}" min="0">
                        </div>
                        <div class="form-group">
                            <label><?= __('admin.bonus.prem_points') ?></label>
                            <input type="number" name="premium_points" value="${currentData.premium_points || 0}" min="0">
                        </div>
                    `;
                    break;

                case 'items':
                    let optionsHtml = '<option value="0">Item Aleatório (Conforme a qualidade do baú do dia)</option>';
                    const selectedId = currentData.item_id !== undefined ? currentData.item_id : 0;
                    itemsList.forEach(item => {
                        const selectedAttr = (item.id == selectedId) ? 'selected' : '';
                        optionsHtml += `<option value="${item.id}" ${selectedAttr}>${item.name} (ID: ${item.id})</option>`;
                    });
                    html = `
                        <div class="form-group">
                            <label><?= __('admin.bonus.item_id', 'Item:') ?></label>
                            <select name="item_id" style="width: 100%; padding: 8px;">
                                ${optionsHtml}
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?= __('admin.bonus.item_qty') ?></label>
                            <input type="number" name="quantity" value="${currentData.quantity || 1}" min="1">
                        </div>
                    `;
                    break;

                case 'flags':
                    html = `
                        <div class="form-group">
                            <label><?= __('admin.bonus.flag_level') ?></label>
                            <input type="number" name="flag_level" value="${currentData.flag_level || 1}" min="1" max="3">
                        </div>
                    `;
                    break;
            }

            container.innerHTML = html;
        }

        // Close modal when clicking outside
        window.onclick = function (event) {
            const modal = document.getElementById('editModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>

</html>
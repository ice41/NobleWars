<?php
$tab = $_GET['tab'] ?? 'world';
$is_standalone_admin = (strpos($_SERVER['REQUEST_URI'], 'admin.php') !== false);
$adminBaseUrl = $is_standalone_admin ? 'admin.php?action=dashboard' : 'game.php?village=' . $village['id'] . '&screen=admin';
?>

<h2><i class="fas fa-cogs"></i> Definições Globais do Mundo</h2>
<p style="color: #5c3a1e;">Gerencie as definições do mundo, bónus diários, geração de bárbaras/decorações no mapa, eventos ativos e encerramento do mundo.</p>

<!-- Tabs Navigation -->
<div class="diamond-tabs-container" style="display: flex; border-bottom: 2px solid #8b5a2b; margin-bottom: 20px; gap: 5px; flex-wrap: wrap;">
    <a href="<?= $adminBaseUrl ?>&mode=configs&tab=world" class="diamond-tab <?= $tab === 'world' ? 'active' : '' ?>">
        <i class="fas fa-globe"></i> Definições do Mundo
    </a>
    <a href="<?= $adminBaseUrl ?>&mode=configs&tab=bonus" class="diamond-tab <?= $tab === 'bonus' ? 'active' : '' ?>">
        <i class="fas fa-gift"></i> Bónus Diário
    </a>
    <a href="<?= $adminBaseUrl ?>&mode=configs&tab=map" class="diamond-tab <?= $tab === 'map' ? 'active' : '' ?>">
        <i class="fas fa-map-marked-alt"></i> Ferramentas do Mapa
    </a>
    <a href="<?= $adminBaseUrl ?>&mode=configs&tab=events" class="diamond-tab <?= $tab === 'events' ? 'active' : '' ?>">
        <i class="fas fa-calendar-alt"></i> Gestão de Eventos
    </a>
    <a href="<?= $adminBaseUrl ?>&mode=configs&tab=shutdown" class="diamond-tab <?= $tab === 'shutdown' ? 'active' : '' ?>">
        <i class="fas fa-flag-checkered"></i> Encerrar Mundo
    </a>
    <a href="<?= $adminBaseUrl ?>&mode=configs&tab=create_world" class="diamond-tab <?= $tab === 'create_world' ? 'active' : '' ?>">
        <i class="fas fa-plus-circle"></i> <?= __('admin.create_world.title') ?>
    </a>
</div>

<!-- Success/Error Alerts -->
<?php if (isset($message) && !empty($message)): ?>
    <div class="admin-alert success" style="padding: 10px; margin: 10px 0; background: #d4edda; border: 1px solid #c3e6cb; color: #155724; border-radius: 4px;">
        <i class="fas fa-check-circle"></i> <?= $message ?>
    </div>
<?php endif; ?>

<?php if (isset($error) && !empty($error)): ?>
    <div class="admin-alert error" style="padding: 10px; margin: 10px 0; background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; border-radius: 4px;">
        <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<!-- ============================================== -->
<!-- TAB 1: WORLD CONFIG (DEFINIÇÕES DO MUNDO)     -->
<!-- ============================================== -->
<?php if ($tab === 'world'): ?>
    <form action="<?= $adminBaseUrl ?>&mode=configs&tab=world" method="post">
        <div class="admin-card">
            <h3><i class="fas fa-tachometer-alt"></i> <?= __('admin.configs.speed') ?></h3>
            <table class="vis" width="100%">
                <tr>
                    <td width="300"><strong><?= __('admin.configs.world_speed') ?></strong></td>
                    <td><input type="number" name="speed" value="<?= $config['speed'] ?? 2500 ?>" min="1" step="1"
                            style="width: 100px;"> <?= __('admin.configs.default_1') ?></td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.configs.movement_speed') ?></strong></td>
                    <td><input type="number" name="movement_speed" value="<?= $config['movement_speed'] ?? 500 ?>" min="1"
                            step="1" style="width: 100px;"> <?= __('admin.configs.default_1') ?></td>
                </tr>
            </table>
        </div>

        <div class="admin-card">
            <h3><i class="fas fa-shield-alt"></i> <?= __('admin.configs.units_buildings') ?></h3>
            <table class="vis" width="100%">
                <tr>
                    <td width="300"><strong><?= __('admin.configs.church') ?></strong></td>
                    <td>
                        <select name="church">
                            <option value="1" <?= ($config['church'] ?? 1) == 1 ? 'selected' : '' ?>><?= __('admin.configs.opt_enabled') ?></option>
                            <option value="0" <?= ($config['church'] ?? 1) == 0 ? 'selected' : '' ?>><?= __('admin.configs.opt_disabled') ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.configs.watchtower') ?></strong></td>
                    <td>
                        <select name="watchtower">
                            <option value="1" <?= ($config['watchtower'] ?? 1) == 1 ? 'selected' : '' ?>><?= __('admin.configs.opt_enabled') ?></option>
                            <option value="0" <?= ($config['watchtower'] ?? 1) == 0 ? 'selected' : '' ?>><?= __('admin.configs.opt_disabled') ?></option>
                        </select>
                        <br><small style="color: #666;"><?= __('admin.configs.watchtower_desc') ?></small>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.configs.archers') ?></strong></td>
                    <td>
                        <select name="archer">
                            <option value="1" <?= ($config['archer'] ?? 1) == 1 ? 'selected' : '' ?>><?= __('admin.configs.opt_enabled_m') ?></option>
                            <option value="0" <?= ($config['archer'] ?? 1) == 0 ? 'selected' : '' ?>><?= __('admin.configs.opt_disabled_m') ?></option>
                        </select>
                        <br><small style="color: #666;"><?= __('admin.configs.archers_desc') ?></small>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.configs.paladin') ?></strong></td>
                    <td>
                        <select name="paladin_enabled">
                            <option value="1" <?= ($config['paladin_enabled'] ?? 1) == 1 ? 'selected' : '' ?>><?= __('admin.configs.opt_enabled_s') ?></option>
                            <option value="0" <?= ($config['paladin_enabled'] ?? 1) == 0 ? 'selected' : '' ?>><?= __('admin.configs.opt_disabled_s') ?>
                            </option>
                        </select>
                        <br><small style="color: #666;"><?= __('admin.configs.paladin_desc') ?></small>
                    </td>
                </tr>
            </table>
        </div>

        <div class="admin-card">
            <h3><i class="fas fa-cogs"></i> <?= __('admin.configs.game_systems') ?></h3>
            <table class="vis" width="100%">
                <tr>
                    <td width="300"><strong><?= __('admin.configs.morale_system') ?></strong></td>
                    <td>
                        <select name="morale_active">
                            <option value="1" <?= ($config['morale_active'] ?? 1) == 1 ? 'selected' : '' ?>><?= __('admin.configs.opt_enabled_s') ?></option>
                            <option value="0" <?= ($config['morale_active'] ?? 1) == 0 ? 'selected' : '' ?>><?= __('admin.configs.opt_disabled_s') ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.configs.min_morale') ?></strong></td>
                    <td><input type="number" name="min_moral" value="<?= $config['min_moral'] ?? 10 ?>" min="0" max="100"
                            style="width: 100px;"> <?= __('admin.configs.default_10_percent') ?></td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.configs.awards_system') ?></strong></td>
                    <td>
                        <select name="awards">
                            <option value="1" <?= ($config['awards'] ?? 1) == 1 ? 'selected' : '' ?>><?= __('admin.configs.opt_enabled_s') ?></option>
                            <option value="0" <?= ($config['awards'] ?? 1) == 0 ? 'selected' : '' ?>><?= __('admin.configs.opt_disabled_s') ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.configs.premium_system') ?></strong></td>
                    <td>
                        <select name="premium_enabled">
                            <option value="1" <?= ($config['premium_enabled'] ?? 1) == 1 ? 'selected' : '' ?>><?= __('admin.configs.opt_enabled_s') ?></option>
                            <option value="0" <?= ($config['premium_enabled'] ?? 1) == 0 ? 'selected' : '' ?>><?= __('admin.configs.opt_disabled_s') ?>
                            </option>
                        </select>
                        <br><small style="color: #666;"><?= __('admin.configs.premium_desc') ?></small>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.configs.flags_system') ?></strong></td>
                    <td>
                        <select name="flags_enabled">
                            <option value="1" <?= ($config['flags_enabled'] ?? 1) == 1 ? 'selected' : '' ?>><?= __('admin.configs.opt_enabled_s') ?></option>
                            <option value="0" <?= ($config['flags_enabled'] ?? 1) == 0 ? 'selected' : '' ?>><?= __('admin.configs.opt_disabled_s') ?></option>
                        </select>
                        <br><small style="color: #666;"><?= __('admin.configs.flags_desc') ?></small>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.configs.inventory_system') ?></strong></td>
                    <td>
                        <select name="inventory_enabled">
                            <option value="1" <?= ($config['inventory_enabled'] ?? 1) == 1 ? 'selected' : '' ?>><?= __('admin.configs.opt_enabled_s') ?>
                            </option>
                            <option value="0" <?= ($config['inventory_enabled'] ?? 1) == 0 ? 'selected' : '' ?>><?= __('admin.configs.opt_disabled_s') ?>
                            </option>
                        </select>
                        <br><small style="color: #666;"><?= __('admin.configs.inventory_desc') ?></small>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.configs.daily_bonus') ?></strong></td>
                    <td>
                        <select name="daily_bonus_enabled">
                            <option value="1" <?= ($config['daily_bonus_enabled'] ?? 1) == 1 ? 'selected' : '' ?>><?= __('admin.configs.opt_enabled_s') ?>
                            </option>
                            <option value="0" <?= ($config['daily_bonus_enabled'] ?? 1) == 0 ? 'selected' : '' ?>><?= __('admin.configs.opt_disabled_s') ?>
                            </option>
                        </select>
                        <br><small style="color: #666;"><?= __('admin.configs.daily_bonus_desc') ?></small>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.configs.questlog_system') ?></strong></td>
                    <td>
                        <select name="questlog_enabled">
                            <option value="1" <?= ($config['questlog_enabled'] ?? 1) == 1 ? 'selected' : '' ?>><?= __('admin.configs.opt_enabled_s') ?>
                            </option>
                            <option value="0" <?= ($config['questlog_enabled'] ?? 1) == 0 ? 'selected' : '' ?>><?= __('admin.configs.opt_disabled_s') ?>
                            </option>
                        </select>
                        <br><small style="color: #666;"><?= __('admin.configs.questlog_desc') ?></small>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.configs.theater_system') ?></strong></td>
                    <td>
                        <select name="theater_enabled">
                            <option value="1" <?= ($config['theater_enabled'] ?? 1) == 1 ? 'selected' : '' ?>><?= __('admin.configs.opt_enabled_s') ?>
                            </option>
                            <option value="0" <?= ($config['theater_enabled'] ?? 1) == 0 ? 'selected' : '' ?>><?= __('admin.configs.opt_disabled_s') ?>
                            </option>
                        </select>
                        <br><small style="color: #666;"><?= __('admin.configs.theater_desc') ?></small>
                    </td>
                </tr>
            </table>
        </div>

        <div class="admin-card">
            <h3><i class="fas fa-moon"></i> <?= __('admin.configs.night_bonus') ?></h3>
            <table class="vis" width="100%">
                <tr>
                    <td width="300"><strong><?= __('admin.configs.night_bonus_active') ?></strong></td>
                    <td>
                        <select name="noc">
                            <option value="1" <?= ($config['night_bonus'] ?? 1) == 1 ? 'selected' : '' ?>><?= __('admin.configs.opt_yes') ?></option>
                            <option value="0" <?= ($config['night_bonus'] ?? 1) == 0 ? 'selected' : '' ?>><?= __('admin.configs.opt_no') ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.configs.start_time') ?></strong></td>
                    <td><input type="number" name="night_bonus_start" value="<?= $config['night_bonus_start'] ?? 22 ?>" min="0"
                            max="23" style="width: 100px;"> <?= __('admin.configs.default_22h') ?></td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.configs.end_time') ?></strong></td>
                    <td><input type="number" name="night_bonus_end" value="<?= $config['night_bonus_end'] ?? 8 ?>" min="0" max="23"
                            style="width: 100px;"> <?= __('admin.configs.default_8h') ?></td>
                </tr>
            </table>
        </div>

        <div class="admin-card">
            <h3><i class="fas fa-users"></i> <?= __('admin.configs.protection') ?></h3>
            <table class="vis" width="100%">
                <tr>
                    <td width="300"><strong><?= __('admin.configs.noob_protection') ?></strong></td>
                    <td><input type="number" name="noob_protection" value="<?= $config['noob_protection'] ?? 180 ?>" min="0"
                            style="width: 100px;"> <?= __('admin.configs.default_180min') ?></td>
                </tr>
            </table>
        </div>

        <div class="admin-card">
            <h3><i class="fas fa-crown"></i> <?= __('admin.configs.snob_system') ?></h3>
            <table class="vis" width="100%">
                <tr>
                    <td width="300"><strong><?= __('admin.configs.snob_range') ?></strong></td>
                    <td><input type="number" name="snob_range" value="<?= $config['snob_range'] ?? 100 ?>" min="1"
                            style="width: 100px;"> <?= __('admin.configs.default_100') ?></td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.configs.support_per_hour') ?></strong></td>
                    <td><input type="number" name="agreement_per_hour" value="<?= $config['agreement_per_hour'] ?? 1 ?>"
                            min="0" step="0.1" style="width: 100px;"> <?= __('admin.configs.default_1') ?></td>
                </tr>
            </table>
        </div>

        <div class="admin-card" style="text-align: center;">
            <button type="submit" name="save_config" class="btn" style="padding: 10px 30px; font-size: 14px; background: #4caf50; border-color: #388e3c; color: white;">
                <i class="fas fa-save"></i> <?= __('admin.configs.btn_save') ?>
            </button>
            <p style="margin-top: 10px; color: #666; font-size: 11px;">
                <?= __('admin.configs.save_desc') ?> <strong><?= $config_file ?? 'world1.php' ?></strong>
            </p>
        </div>
    </form>
<?php endif; ?>

<!-- ============================================== -->
<!-- TAB 2: DAILY BONUS (BÓNUS DIÁRIO)             -->
<!-- ============================================== -->
<?php if ($tab === 'bonus'): ?>
    <style>
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
            color: #5c3a1e;
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
            border: 1px dashed #8b5a2b;
        }
    </style>

    <div class="admin-card">
        <h3><i class="fas fa-gift"></i> <?= __('admin.bonus.title') ?></h3>
        <p style="margin-bottom: 15px;"><?= __('admin.bonus.desc') ?></p>

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
                <?php foreach ($bonus_configs as $bonusConfig): ?>
                    <tr class="<?= $bonusConfig['chest_type'] === 'golden' ? 'golden-row' : '' ?>">
                        <td><strong><?= $bonusConfig['day'] ?></strong></td>
                        <td><?= $bonusConfig['chest_type'] === 'golden' ? __('admin.bonus.chest_golden') : __('admin.bonus.chest_normal') ?></td>
                        <td><?= ucfirst($bonusConfig['reward_type']) ?></td>
                        <td><?= htmlspecialchars($bonusConfig['description']) ?></td>
                        <td><small><?= htmlspecialchars($bonusConfig['reward_data']) ?></small></td>
                        <td>
                            <button class="btn" style="background: #ff9800; border-color: #e65100; color: white;" onclick="editBonus(<?= htmlspecialchars(json_encode($bonusConfig)) ?>)">
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

            <form method="POST" action="<?= $adminBaseUrl ?>&mode=configs&tab=bonus">
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

                <div class="form-group" style="margin-top: 15px;">
                    <label><?= __('admin.bonus.desc_label') ?></label>
                    <input type="text" name="description" id="editDescription" required>
                </div>

                <button type="submit" class="btn" style="background: #4caf50; border-color: #388e3c; color: white; margin-top: 15px;"><i class="fas fa-save"></i> <?= __('admin.bonus.btn_save') ?></button>
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
                        <div class="form-group" style="margin-top: 10px;">
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

        window.onclick = function (event) {
            const modal = document.getElementById('editModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
<?php endif; ?>

<!-- ============================================== -->
<!-- TAB 3: MAP TOOLS (FERRAMENTAS DO MAPA)        -->
<!-- ============================================== -->
<?php if ($tab === 'map'): ?>
    <div class="admin-card">
        <h3><i class="fas fa-dungeon"></i> <?= __('admin.map.add_barbarians') ?></h3>
        <form action="<?= $adminBaseUrl ?>&mode=configs&tab=map&action=create_barbarian" method="post">
            <table class="vis" width="100%">
                <tr>
                    <td width="200"><?= __('admin.map.amount') ?></td>
                    <td>
                        <input type="number" name="amount" value="50" min="1" max="500" style="width: 80px;">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button type="submit" class="btn" style="background: #4caf50; border-color: #388e3c; color: white;">
                            <i class="fas fa-plus-circle"></i> <?= __('admin.map.generate_barbarians') ?>
                        </button>
                        <span style="font-size: 11px; color: #666; margin-left: 10px;"><?= __('admin.map.barb_info') ?></span>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <div class="admin-card">
        <h3><i class="fas fa-tree"></i> <?= __('admin.map.add_decorations') ?></h3>
        <form action="<?= $adminBaseUrl ?>&mode=configs&tab=map&action=add_decoration" method="post">
            <table class="vis" width="100%">
                <tr>
                    <td width="200"><?= __('admin.map.type') ?></td>
                    <td>
                        <select name="type" style="padding: 5px;">
                            <option value="random"><?= __('admin.map.type_random') ?></option>
                            <optgroup label="<?= __('admin.map.legacy_patterns') ?>">
                                <option value="1"><?= __('admin.map.pattern_1') ?></option>
                                <option value="2"><?= __('admin.map.pattern_2') ?></option>
                                <option value="3"><?= __('admin.map.pattern_3') ?></option>
                                <option value="4"><?= __('admin.map.pattern_4') ?></option>
                                <option value="5"><?= __('admin.map.pattern_5') ?></option>
                                <option value="6"><?= __('admin.map.pattern_6') ?></option>
                                <option value="7"><?= __('admin.map.pattern_7') ?></option>
                                <option value="8"><?= __('admin.map.pattern_8') ?></option>
                                <option value="9"><?= __('admin.map.pattern_9') ?></option>
                                <option value="10"><?= __('admin.map.pattern_10') ?></option>
                                <option value="11"><?= __('admin.map.pattern_11') ?></option>
                                <option value="12"><?= __('admin.map.pattern_12') ?></option>
                                <option value="13"><?= __('admin.map.pattern_13') ?></option>
                                <option value="14"><?= __('admin.map.pattern_14') ?></option>
                            </optgroup>
                            <optgroup label="<?= __('admin.map.generic_types') ?>">
                                <?php foreach ($decoration_types as $key => $info): ?>
                                    <option value="<?= $key ?>"><?= htmlspecialchars($info['name']) ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?= __('admin.map.amount') ?></td>
                    <td>
                        <input type="number" name="amount" value="100" min="1" max="10000" style="width: 80px;">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button type="submit" class="btn" style="background: #4caf50; border-color: #388e3c; color: white;">
                            <i class="fas fa-seedling"></i> <?= __('admin.map.btn_add_decorations') ?>
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <div class="admin-card">
        <h3><i class="fas fa-sync"></i> Reconstrução de Florestas</h3>
        <p>Recalcule todos os bitmasks das florestas no mapa para ajustar graficamente os sprites das árvores baseando-se nos seus vizinhos.</p>
        <a href="<?= $adminBaseUrl ?>&mode=configs&tab=map&action=recalc_forest" class="btn" style="background: #2196f3; color: white;">
            <i class="fas fa-magic"></i> Corrigir Bitmasks de Florestas
        </a>
    </div>

    <div class="admin-card">
        <h3><i class="fas fa-trash-alt"></i> Limpeza Geral do Mapa</h3>
        <p>Total de Decorações no Mapa: <strong><?= number_format($decoration_count ?? 0) ?></strong></p>

        <div style="background: #ffebee; padding: 15px; border: 1px solid #ffcdd2; border-radius: 4px; display: inline-block;">
            <strong style="color: #c62828;"><i class="fas fa-exclamation-triangle"></i> Atenção!</strong> Esta ação irá remover todas as árvores, montanhas e lagos do mapa do mundo, reiniciando o gerador.
            <br><br>
            <a href="<?= $adminBaseUrl ?>&mode=configs&tab=map&action=clear_map" class="btn"
                onclick="return confirm('<?= addslashes(__('admin.map.clear_confirm') ?: "Tem a certeza que deseja apagar todas as decorações do mapa?") ?>');"
                style="background: #ef5350; border-color: #d32f2f; color: white;">
                <i class="fas fa-trash"></i> Apagar Todas as Decorações
            </a>
        </div>
    </div>
<?php endif; ?>

<!-- ============================================== -->
<!-- TAB 4: EVENTS (GESTÃO DE EVENTOS)             -->
<!-- ============================================== -->
<?php if ($tab === 'events'): ?>
    <?php
    // Helper formats for inputs
    $hordeEnd = $config['event_horde_end'] ?? '';
    $hordeDateVal = '';
    if (!empty($hordeEnd)) {
        $parts = explode(' ', $hordeEnd);
        if (count($parts) == 2) {
            $dateParts = explode('.', $parts[0]);
            if (count($dateParts) == 3) {
                $hordeDateVal = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0] . 'T' . $parts[1];
            }
        }
    }

    $springEnd = $config['event_spring_end'] ?? '';
    $springDateVal = '';
    if (!empty($springEnd)) {
        $parts = explode(' ', $springEnd);
        if (count($parts) == 2) {
            $dateParts = explode('.', $parts[0]);
            if (count($dateParts) == 3) {
                $springDateVal = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0] . 'T' . $parts[1];
            }
        }
    }

    $horseEnd = $config['event_horse_race_end'] ?? '';
    $horseDateVal = '';
    if (!empty($horseEnd)) {
        $parts = explode(' ', $horseEnd);
        if (count($parts) == 2) {
            $dateParts = explode('.', $parts[0]);
            if (count($dateParts) == 3) {
                $horseDateVal = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0] . 'T' . $parts[1];
            }
        }
    }
    ?>

    <!-- Horde Event -->
    <div class="admin-card">
        <div style="font-size: 16px; font-weight: bold; border-bottom: 2px solid #5c3a1e; padding-bottom: 5px; margin-bottom: 15px; color: #5c3a1e;">
            <i class="fas fa-skull"></i> Evento: Ataque da Horda
        </div>
        <form action="<?= $adminBaseUrl ?>&mode=configs&tab=events" method="post">
            <table class="vis" width="100%">
                <tr>
                    <td width="300"><strong>Estado do Evento:</strong></td>
                    <td>
                        <select name="event_horde_active">
                            <option value="1" <?= ($config['event_horde_active'] ?? false) ? 'selected' : '' ?>>Ativado</option>
                            <option value="0" <?= !($config['event_horde_active'] ?? false) ? 'selected' : '' ?>>Desativado</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>Data e Hora de Fim:</strong><br><small style="color:#666;">O evento será encerrado automaticamente nesta data.</small></td>
                    <td>
                        <input type="datetime-local" name="event_horde_end_date" value="<?= $hordeDateVal ?>" style="padding: 5px;">
                    </td>
                </tr>
                <tr>
                    <td><strong>Fim do Evento Atual:</strong></td>
                    <td>
                        <span class="btn" style="padding: 3px 8px; font-size: 11px; background: <?= ($config['event_horde_active'] ?? false) ? '#4caf50' : '#f44336' ?>; color: white; border: none; cursor: default;">
                            <?= htmlspecialchars($config['event_horde_end'] ?? 'Não definido') ?>
                        </span>
                    </td>
                </tr>
            </table>
            <div style="margin-top: 15px; text-align: center;">
                <button type="submit" name="save_horde_config" class="btn" style="background: #4caf50; border-color: #388e3c; color: white;">
                    <i class="fas fa-save"></i> Atualizar Ataque da Horda
                </button>
            </div>
        </form>
    </div>

    <!-- Spring Festival -->
    <div class="admin-card">
        <div style="font-size: 16px; font-weight: bold; border-bottom: 2px solid #2d7a2d; padding-bottom: 5px; margin-bottom: 15px; color: #2d7a2d;">
            <i class="fas fa-seedling"></i> Evento: Festival de Primavera
        </div>
        <form action="<?= $adminBaseUrl ?>&mode=configs&tab=events" method="post">
            <table class="vis" width="100%">
                <tr>
                    <td width="300"><strong>Estado do Evento:</strong></td>
                    <td>
                        <select name="event_spring_active">
                            <option value="1" <?= ($config['event_spring_active'] ?? false) ? 'selected' : '' ?>>Ativado</option>
                            <option value="0" <?= !($config['event_spring_active'] ?? false) ? 'selected' : '' ?>>Desativado</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>Data e Hora de Fim:</strong><br><small style="color:#666;">O evento será encerrado automaticamente nesta data.</small></td>
                    <td>
                        <input type="datetime-local" name="event_spring_end_date" value="<?= $springDateVal ?>" style="padding: 5px;">
                    </td>
                </tr>
                <tr>
                    <td><strong>Fim do Evento Atual:</strong></td>
                    <td>
                        <span class="btn" style="padding: 3px 8px; font-size: 11px; background: <?= ($config['event_spring_active'] ?? false) ? '#4caf50' : '#f44336' ?>; color: white; border: none; cursor: default;">
                            <?= htmlspecialchars($config['event_spring_end'] ?? 'Não definido') ?>
                        </span>
                    </td>
                </tr>
            </table>
            <div style="margin-top: 15px; text-align: center;">
                <button type="submit" name="save_spring_config" class="btn" style="background: #4caf50; border-color: #388e3c; color: white;">
                    <i class="fas fa-save"></i> Atualizar Festival de Primavera
                </button>
            </div>
        </form>
    </div>

    <!-- Horse Race -->
    <div class="admin-card">
        <div style="font-size: 16px; font-weight: bold; border-bottom: 2px solid #a36f26; padding-bottom: 5px; margin-bottom: 15px; color: #a36f26;">
            <i class="fas fa-horse"></i> Evento: Corrida de Cavalos
        </div>
        <form action="<?= $adminBaseUrl ?>&mode=configs&tab=events" method="post">
            <table class="vis" width="100%">
                <tr>
                    <td width="300"><strong>Estado do Evento:</strong></td>
                    <td>
                        <select name="event_horse_race_active">
                            <option value="1" <?= ($config['event_horse_race_active'] ?? false) ? 'selected' : '' ?>>Ativado</option>
                            <option value="0" <?= !($config['event_horse_race_active'] ?? false) ? 'selected' : '' ?>>Desativado</option>
                        </select>
                        <br><small style="color:red; font-weight: bold;">Atenção: Ao Desativar, as tabelas da corrida e troféus de todos os jogadores serão apagadas!</small>
                    </td>
                </tr>
                <tr>
                    <td><strong>Data e Hora de Fim:</strong><br><small style="color:#666;">O evento será encerrado automaticamente nesta data.</small></td>
                    <td>
                        <input type="datetime-local" name="event_horse_race_end_date" value="<?= $horseDateVal ?>" style="padding: 5px;">
                    </td>
                </tr>
                <tr>
                    <td><strong>Fim do Evento Atual:</strong></td>
                    <td>
                        <span class="btn" style="padding: 3px 8px; font-size: 11px; background: <?= ($config['event_horse_race_active'] ?? false) ? '#4caf50' : '#f44336' ?>; color: white; border: none; cursor: default;">
                            <?= htmlspecialchars($config['event_horse_race_end'] ?? 'Não definido') ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><strong>Duração de cada Corrida (Horas):</strong><br><small style="color:#666;">Tempo para a corrida reiniciar (as distâncias voltam a 0).</small></td>
                    <td>
                        <input type="number" name="event_horse_race_duration" value="<?= htmlspecialchars($config['event_horse_race_duration'] ?? '12') ?>" min="1" max="168" style="width: 80px;">
                    </td>
                </tr>
                <tr>
                    <td><strong>Data de Início das Corridas:</strong></td>
                    <td>
                        <span class="btn" style="padding: 3px 8px; font-size: 11px; background: #2196f3; color: white; border: none; cursor: default;">
                            <?= htmlspecialchars($config['event_horse_race_start'] ?? 'Não definido') ?>
                        </span>
                    </td>
                </tr>
            </table>
            <div style="margin-top: 15px; text-align: center;">
                <button type="submit" name="save_horse_race_config" class="btn" style="background: #4caf50; border-color: #388e3c; color: white;">
                    <i class="fas fa-save"></i> Atualizar Corrida de Cavalos
                </button>
            </div>
        </form>
    </div>
<?php endif; ?>

<!-- ============================================== -->
<!-- TAB 5: SHUTDOWN (ENCERRAR MUNDO)               -->
<!-- ============================================== -->
<?php if ($tab === 'shutdown'): ?>
    <div class="admin-card" style="border-left: 4px solid #ff9800;">
        <h3><i class="fas fa-exclamation-triangle"></i> <?= __('admin.reset.info_title') ?></h3>
        <p style="font-size: 13px; line-height: 1.6;">
            <?= __('admin.reset.info_desc') ?>
        </p>
        <ul style="margin-left: 20px; line-height: 1.8; font-size: 12px;">
            <li><?= __('admin.reset.info_1') ?></li>
            <li><?= __('admin.reset.info_2') ?></li>
            <li><?= __('admin.reset.info_3') ?></li>
        </ul>
        <p style="color: #f44336; font-weight: bold; margin-top: 15px; font-size: 13px;">
            <i class="fas fa-exclamation-circle"></i> <?= __('admin.reset.warning') ?>
        </p>
    </div>

    <div class="admin-card">
        <h3><i class="fas fa-medal"></i> <?= __('admin.reset.top_players') ?></h3>
        <table class="vis" width="100%">
            <tr>
                <th width="50"><?= __('admin.reset.col_rank') ?></th>
                <th><?= __('admin.reset.col_player') ?></th>
                <th width="150"><?= __('admin.reset.col_points') ?></th>
                <th width="100"><?= __('admin.reset.col_villages') ?></th>
            </tr>
            <?php if (!empty($top_players)): ?>
                <?php foreach ($top_players as $rank => $player): ?>
                    <tr>
                        <td align="center">
                            <?php if ($rank == 0): ?>
                                <i class="fas fa-trophy" style="color: gold; font-size: 20px;"></i>
                            <?php elseif ($rank == 1): ?>
                                <i class="fas fa-trophy" style="color: silver; font-size: 18px;"></i>
                            <?php else: ?>
                                <i class="fas fa-trophy" style="color: #cd7f32; font-size: 16px;"></i>
                            <?php endif; ?>
                            #<?= $rank + 1 ?>
                        </td>
                        <td><strong><?= htmlspecialchars($player['username']) ?></strong></td>
                        <td align="right"><?= number_format($player['points'], 0, ',', '.') ?></td>
                        <td align="center"><?= $player['villages'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" align="center" style="padding: 20px; color: #999;">
                        <?= __('admin.reset.no_players') ?>
                    </td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <div class="admin-card">
        <h3><i class="fas fa-users"></i> <?= __('admin.reset.top_tribes') ?></h3>
        <table class="vis" width="100%">
            <tr>
                <th width="50"><?= __('admin.reset.col_rank') ?></th>
                <th><?= __('admin.reset.col_tribe') ?></th>
                <th width="150"><?= __('admin.reset.col_points') ?></th>
                <th width="100"><?= __('admin.reset.col_members') ?></th>
            </tr>
            <?php if (!empty($top_tribes)): ?>
                <?php foreach ($top_tribes as $rank => $tribe): ?>
                    <tr>
                        <td align="center">
                            <?php if ($rank == 0): ?>
                                <i class="fas fa-trophy" style="color: gold; font-size: 20px;"></i>
                            <?php elseif ($rank == 1): ?>
                                <i class="fas fa-trophy" style="color: silver; font-size: 18px;"></i>
                            <?php else: ?>
                                <i class="fas fa-trophy" style="color: #cd7f32; font-size: 16px;"></i>
                            <?php endif; ?>
                            #<?= $rank + 1 ?>
                        </td>
                        <td><strong><?= htmlspecialchars($tribe['name']) ?></strong></td>
                        <td align="right"><?= number_format($tribe['points'], 0, ',', '.') ?></td>
                        <td align="center"><?= $tribe['members'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" align="center" style="padding: 20px; color: #999;">
                        <?= __('admin.reset.no_tribes') ?>
                    </td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <div class="admin-card" style="background: #fff3cd; border-left: 4px solid #ff9800;">
        <h3><i class="fas fa-lock"></i> <?= __('admin.reset.confirm_title') ?></h3>
        <p style="margin-bottom: 15px; font-size: 13px;">
            <?= sprintf(__('admin.reset.confirm_desc_1'), htmlspecialchars($world_name)) ?><br>
            <?= __('admin.reset.confirm_desc_2') ?>
        </p>

        <form method="post" action="<?= $adminBaseUrl ?>&mode=configs&tab=shutdown"
            onsubmit="return confirm('<?= addslashes(__('admin.reset.confirm_alert') ?: "Tem a certeza absoluta de que deseja ENCERRAR este mundo permanentemente?") ?>');">
            <div style="margin-bottom: 15px;">
                <label for="confirm_closure" style="display: block; margin-bottom: 5px; font-weight: bold;">
                    <?= __('admin.reset.confirm_label') ?>
                </label>
                <input type="text" name="confirm_closure" id="confirm_closure"
                    style="padding: 10px; width: 300px; font-size: 14px; border: 2px solid #ff9800;" placeholder="<?= __('admin.reset.confirm_placeholder') ?>"
                    required>
            </div>

            <button type="submit" class="btn"
                style="background: #f44336; border-color: #d32f2f; color: white; padding: 12px 30px; font-size: 16px; font-weight: bold;">
                <i class="fas fa-flag-checkered"></i> <?= __('admin.reset.btn_close') ?>
            </button>
        </form>
    </div>
<?php endif; ?>

<?php if ($tab === 'create_world'): ?>
    <form action="<?= $adminBaseUrl ?>&mode=configs&tab=create_world" method="post">
        <div class="admin-card">
            <h3><i class="fas fa-plus-circle"></i> <?= __('admin.create_world.title') ?></h3>
            <p style="color: #666; font-size: 13px; margin-bottom: 20px;">
                <?= __('admin.create_world.desc') ?>
            </p>

            <table class="vis" width="100%">
                <tr>
                    <td colspan="2" style="background:#e6dfd3; font-weight:bold; padding:8px; color: #5c3a1e;"><i class="fas fa-id-card"></i> <?= __('admin.create_world.sec_identification') ?></td>
                </tr>
                <tr>
                    <td width="250"><strong><?= __('admin.create_world.new_world_id') ?></strong><br><small style="color:#777; font-weight:normal;"><?= __('admin.create_world.new_world_id_help') ?></small></td>
                    <td>
                        <input type="text" name="new_world_id" placeholder="ex: 2" style="padding: 6px; width: 250px;" required pattern="^[a-zA-Z0-9_]+$">
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="background:#e6dfd3; font-weight:bold; padding:8px; height: 10px;"></td>
                </tr>
                <tr>
                    <td colspan="2" style="background:#e6dfd3; font-weight:bold; padding:8px; color: #5c3a1e;"><i class="fas fa-database"></i> <?= __('admin.create_world.sec_database') ?></td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.create_world.db_host') ?></strong><br><small style="color:#777; font-weight:normal;"><?= __('admin.create_world.db_host_help') ?></small></td>
                    <td>
                        <input type="text" name="db_host" value="localhost" style="padding: 6px; width: 250px;" required>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.create_world.db_user') ?></strong><br><small style="color:#777; font-weight:normal;"><?= __('admin.create_world.db_user_help') ?></small></td>
                    <td>
                        <input type="text" name="db_user" value="root" style="padding: 6px; width: 250px;" required>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.create_world.db_pw') ?></strong></td>
                    <td>
                        <input type="password" name="db_pw" value="" placeholder="<?= __('admin.create_world.db_pw_placeholder') ?>" style="padding: 6px; width: 250px;">
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.create_world.db_name') ?></strong><br><small style="color:#777; font-weight:normal;"><?= __('admin.create_world.db_name_help') ?></small></td>
                    <td>
                        <input type="text" name="db_name" placeholder="ex: lan_2" style="padding: 6px; width: 250px;" required>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="background:#e6dfd3; font-weight:bold; padding:8px; height: 10px;"></td>
                </tr>
                <tr>
                    <td colspan="2" style="background:#e6dfd3; font-weight:bold; padding:8px; color: #5c3a1e;"><i class="fas fa-sliders-h"></i> <?= __('admin.create_world.sec_speed') ?></td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.create_world.world_speed') ?></strong><br><small style="color:#777; font-weight:normal;"><?= __('admin.create_world.world_speed_help') ?></small></td>
                    <td>
                        <input type="number" name="speed" value="10" min="1" max="100000" style="padding: 6px; width: 100px;" required>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.create_world.unit_speed') ?></strong><br><small style="color:#777; font-weight:normal;"><?= __('admin.create_world.unit_speed_help') ?></small></td>
                    <td>
                        <input type="number" name="movement_speed" value="5" min="1" max="10000" style="padding: 6px; width: 100px;" required>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="background:#e6dfd3; font-weight:bold; padding:8px; height: 10px;"></td>
                </tr>
                <tr>
                    <td colspan="2" style="background:#e6dfd3; font-weight:bold; padding:8px; color: #5c3a1e;"><i class="fas fa-cogs"></i> <?= __('admin.create_world.sec_features') ?></td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.create_world.archer_system') ?></strong></td>
                    <td>
                        <select name="archer" style="padding: 6px;">
                            <option value="1" selected><?= __('admin.create_world.archer_active') ?></option>
                            <option value="0"><?= __('admin.create_world.opt_disabled') ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.create_world.church_system') ?></strong></td>
                    <td>
                        <select name="church" style="padding: 6px;">
                            <option value="1" selected><?= __('admin.create_world.church_active') ?></option>
                            <option value="0"><?= __('admin.create_world.opt_disabled') ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.create_world.watchtower_system') ?></strong></td>
                    <td>
                        <select name="watchtower" style="padding: 6px;">
                            <option value="1" selected><?= __('admin.create_world.opt_enabled') ?></option>
                            <option value="0"><?= __('admin.create_world.opt_disabled') ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.create_world.premium_system') ?></strong></td>
                    <td>
                        <select name="premium" style="padding: 6px;">
                            <option value="1" selected><?= __('admin.create_world.premium_active') ?></option>
                            <option value="0"><?= __('admin.create_world.opt_disabled') ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.create_world.flags_system') ?></strong></td>
                    <td>
                        <select name="flags_enabled" style="padding: 6px;">
                            <option value="1" selected><?= __('admin.create_world.opt_enabled') ?></option>
                            <option value="0"><?= __('admin.create_world.opt_disabled') ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.create_world.inventory_system') ?></strong></td>
                    <td>
                        <select name="inventory_enabled" style="padding: 6px;">
                            <option value="1" selected><?= __('admin.create_world.opt_enabled') ?></option>
                            <option value="0"><?= __('admin.create_world.opt_disabled') ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.create_world.daily_bonus') ?></strong></td>
                    <td>
                        <select name="daily_bonus_enabled" style="padding: 6px;">
                            <option value="1" selected><?= __('admin.create_world.opt_enabled') ?></option>
                            <option value="0"><?= __('admin.create_world.opt_disabled') ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.create_world.questlog_system') ?></strong></td>
                    <td>
                        <select name="questlog_enabled" style="padding: 6px;">
                            <option value="1"><?= __('admin.create_world.opt_enabled') ?></option>
                            <option value="0" selected><?= __('admin.create_world.questlog_disabled_help') ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.create_world.paladin_system') ?></strong></td>
                    <td>
                        <select name="paladin_enabled" style="padding: 6px;">
                            <option value="1" selected><?= __('admin.create_world.opt_enabled') ?></option>
                            <option value="0"><?= __('admin.create_world.opt_disabled') ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.create_world.awards_system') ?></strong></td>
                    <td>
                        <select name="awards" style="padding: 6px;">
                            <option value="1" selected><?= __('admin.create_world.opt_enabled') ?></option>
                            <option value="0"><?= __('admin.create_world.opt_disabled') ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.create_world.night_bonus') ?></strong></td>
                    <td>
                        <select name="noc" style="padding: 6px;">
                            <option value="1" selected><?= __('admin.create_world.opt_enabled') ?> (<?= __('admin.create_world.night_bonus_help') ?>)</option>
                            <option value="0"><?= __('admin.create_world.opt_disabled') ?></option>
                        </select>
                    </td>
                </tr>
            </table>

            <div style="margin-top: 20px;">
                <button type="submit" name="create_world" class="btn" style="background: #8b5a2b; border-color: #5c3a1e; color: white; padding: 12px 30px; font-size: 14px; font-weight: bold; cursor: pointer;">
                    <i class="fas fa-plus-circle"></i> <?= __('admin.create_world.btn_create') ?>
                </button>
            </div>
        </div>
    </form>
<?php endif; ?>

<style>
.diamond-tab {
    display: inline-block;
    padding: 10px 20px;
    background: #e6dfd3;
    border: 1px solid #8b5a2b;
    border-bottom: none;
    border-radius: 4px 4px 0 0;
    color: #5c3a1e;
    text-decoration: none;
    font-weight: bold;
    font-size: 12px;
    transition: all 0.2s ease-in-out;
}
.diamond-tab:hover {
    background: #d4cbb8;
}
.diamond-tab.active {
    background: #8b5a2b;
    color: #F4E4BC;
}
</style>
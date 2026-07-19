<h2><i class="fas fa-cog"></i> <?= __('admin.configs.title') ?></h2>
<p style="color: #5c3a1e;"><?= __('admin.configs.desc') ?></p>

<<<<<<< Updated upstream
<?php if (isset($message)): ?>
    <div class="success"
        style="padding: 10px; margin: 10px 0; background: #d4edda; border: 1px solid #c3e6cb; color: #155724;">
        <?= $message ?>
=======
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
>>>>>>> Stashed changes
    </div>
<?php endif; ?>

<?php if (isset($error)): ?>
    <div class="error"
        style="padding: 10px; margin: 10px 0; background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24;">
        <?= $error ?>
    </div>
<?php endif; ?>

<<<<<<< Updated upstream
<form action="<?= $adminBaseUrl ?>&mode=configs" method="post">
=======
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

>>>>>>> Stashed changes
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
                    <select name="moral_activ">
                        <option value="1" <?= ($config['moral_activ'] ?? 1) == 1 ? 'selected' : '' ?>><?= __('admin.configs.opt_enabled_s') ?></option>
                        <option value="0" <?= ($config['moral_activ'] ?? 1) == 0 ? 'selected' : '' ?>><?= __('admin.configs.opt_disabled_s') ?></option>
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

<<<<<<< Updated upstream
    <div class="admin-card">
        <h3><i class="fas fa-moon"></i> <?= __('admin.configs.night_bonus') ?></h3>
        <table class="vis" width="100%">
            <tr>
                <td width="300"><strong><?= __('admin.configs.night_bonus_active') ?></strong></td>
                <td>
                    <select name="noc">
                        <option value="1" <?= ($config['noc'] ?? 1) == 1 ? 'selected' : '' ?>><?= __('admin.configs.opt_yes') ?></option>
                        <option value="0" <?= ($config['noc'] ?? 1) == 0 ? 'selected' : '' ?>><?= __('admin.configs.opt_no') ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><strong><?= __('admin.configs.start_time') ?></strong></td>
                <td><input type="number" name="noc_poczatek" value="<?= $config['noc_poczatek'] ?? 22 ?>" min="0"
                        max="23" style="width: 100px;"> <?= __('admin.configs.default_22h') ?></td>
            </tr>
            <tr>
                <td><strong><?= __('admin.configs.end_time') ?></strong></td>
                <td><input type="number" name="noc_koniec" value="<?= $config['noc_koniec'] ?? 8 ?>" min="0" max="23"
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
=======
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
>>>>>>> Stashed changes

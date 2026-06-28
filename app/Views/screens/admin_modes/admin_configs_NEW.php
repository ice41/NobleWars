<h2><i class="fas fa-cog"></i> <?= __('admin.configs.title') ?></h2>
<p style="color: #5c3a1e;"><?= __('admin.configs.desc') ?></p>

<?php if (isset($message)): ?>
    <div class="success"
        style="padding: 10px; margin: 10px 0; background: #d4edda; border: 1px solid #c3e6cb; color: #155724;">
        <?= $message ?>
    </div>
<?php endif; ?>

<?php if (isset($error)): ?>
    <div class="error"
        style="padding: 10px; margin: 10px 0; background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24;">
        <?= $error ?>
    </div>
<?php endif; ?>

<form action="<?= $adminBaseUrl ?>&mode=configs" method="post">
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
        </table>
    </div>

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
        <button type="submit" name="save_config" class="btn" style="padding: 10px 30px; font-size: 14px;">
            <i class="fas fa-save"></i> <?= __('admin.configs.btn_save') ?>
        </button>
        <p style="margin-top: 10px; color: #666; font-size: 11px;">
            <?= __('admin.configs.save_desc') ?> <strong><?= $config_file ?? 'world1.php' ?></strong>
        </p>
    </div>
</form>
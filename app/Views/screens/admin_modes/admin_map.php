<h2><i class="fas fa-map-marked-alt"></i> <?= __('admin.map.title') ?></h2>
<p style="color: #5c3a1e;"><?= __('admin.map.desc') ?></p>

<?php if (!empty($error)): ?>
    <div class="admin-alert error">
        <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="admin-alert success">
        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<div class="admin-card">
    <h3><i class="fas fa-dungeon"></i> <?= __('admin.map.add_barbarians') ?></h3>
    <form action="<?= $adminBaseUrl ?>&mode=map&action=create_barbarian" method="post">
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
    <form action="<?= $adminBaseUrl ?>&mode=map&action=add_decoration" method="post">
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
    <h3><i class="fas fa-trash-alt"></i> <?= __('admin.map.map_cleanup') ?></h3>
    <p><?= __('admin.map.total_decorations') ?> <strong><?= number_format($decoration_count ?? 0) ?></strong></p>

    <div
        style="background: #ffebee; padding: 10px; border: 1px solid #ffcdd2; border-radius: 4px; display: inline-block;">
        <strong style="color: #c62828;"><?= __('admin.map.warning_title') ?></strong> <?= __('admin.map.warning_desc') ?>
        <br><br>
        <a href="<?= $adminBaseUrl ?>&mode=map&action=clear_map" class="btn"
            onclick="return confirm('<?= addslashes(__('admin.map.clear_confirm')) ?>');"
            style="background: #ef5350;">
            <i class="fas fa-trash"></i> <?= __('admin.map.btn_clear') ?>
        </a>
    </div>
</div>

<style>
    .admin-alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
        border-left: 4px solid;
    }

    .admin-alert.error {
        background: #ffebee;
        border-color: #f44336;
        color: #c62828;
    }

    .admin-alert.success {
        background: #e8f5e9;
        border-color: #4caf50;
        color: #2e7d32;
    }
</style>
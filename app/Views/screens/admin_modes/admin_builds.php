<h2><i class="fas fa-hammer"></i> <?= __('admin.builds.title') ?></h2>
<p style="color: #5c3a1e;"><?= $text_tut ?? __('admin.builds.desc') ?></p>

<form method="post" action="<?= $adminBaseUrl ?>&mode=builds&action=edit">
    <div class="admin-card">
        <h3><i class="fas fa-building"></i> <?= __('admin.builds.max_levels') ?></h3>

        <?php if (!empty($buildings)): ?>
            <table class="vis" width="100%">
                <tr>
                    <th width="40%"><?= __('admin.builds.col_building') ?></th>
                    <th width="20%"><?= __('screens.admin.current_max_level') ?></th>
                    <th width="20%"><?= __('admin.builds.col_max_allowed') ?></th>
                    <th width="20%"><?= __('screens.admin.new_max_level') ?></th>
                </tr>
                <?php foreach ($buildings as $dbname => $building): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($building['name'] ?? 'Desconhecido') ?></strong></td>
                        <td align="center">
                            <span style="font-size: 16px; font-weight: bold; color: #2e7d32;">
                                <?= $building['current_max'] ?>
                            </span>
                        </td>
                        <td align="center">
                            <span style="color: #666;">
                                <?= sprintf(__('admin.builds.max_label'), $building['library_max']) ?>
                            </span>
                        </td>
                        <td align="center">
                            <input type="number" name="<?= htmlspecialchars($dbname) ?>" value="<?= $building['current_max'] ?>"
                                min="0" max="<?= $building['library_max'] ?>" style="width: 80px; text-align: center;">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <br>
            <button type="submit" class="btn" style="padding: 10px 20px; font-size: 14px; background: #4caf50; border-color: #388e3c; color: white;">
                <i class="fas fa-save"></i> <?= __('admin.builds.btn_save') ?>
            </button>
        <?php else: ?>
            <div class="admin-alert info">
                <i class="fas fa-info-circle"></i> <?= __('admin.builds.no_buildings') ?>
            </div>
        <?php endif; ?>
    </div>
</form>

<div class="admin-card">
    <h3><i class="fas fa-info-circle"></i> <?= __('admin.builds.info_title') ?></h3>
    <p><strong><?= __('admin.builds.info_important') ?></strong></p>
    <ul>
        <li><?= __('admin.builds.info_1') ?> <code>app/Config/Worlds/<?= get_active_world() ?>.php</code></li>
        <li><?= __('admin.builds.info_2') ?></li>
        <li><?= __('admin.builds.info_3') ?></li>
        <li><?= __('admin.builds.info_4') ?></li>
    </ul>
</div>
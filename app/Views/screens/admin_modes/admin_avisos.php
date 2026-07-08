<h2><i class="fas fa-bullhorn"></i> <?= __('admin.news.avisos_title') ?></h2>
<p style="color: #5c3a1e;"><?= __('admin.news.avisos_desc') ?></p>

<div class="admin-card">
    <h3><i class="fas fa-plus-circle"></i> <?= __('admin.news.add_aviso') ?></h3>
    <form action="<?= $adminBaseUrl ?>&mode=avisos&action=add" method="post">
        <table class="vis" width="100%">
            <tr>
                <td width="150"><strong><?= __('admin.news.aviso_title') ?></strong></td>
                <td>
                    <input type="text" name="title" style="width: 100%; max-width: 500px;" required>
                </td>
            </tr>
            <tr>
                <td><strong><?= __('admin.news.aviso_msg') ?></strong></td>
                <td>
                    <?php
                    $textareaId = 'aviso_textarea';
                    $prefix = 'aa_';
                    include dirname(dirname(__DIR__)) . '/components/bbcode_toolbar.php';
                    ?>
                    <textarea id="aviso_textarea" name="message" rows="5"
                        style="width: 100%; max-width: 600px; margin-top: 5px;" required></textarea>
                </td>

            </tr>
            <tr>
                <td><strong><?= __('admin.news.aviso_type') ?></strong></td>
                <td>
                    <select name="type">
                        <option value="info"><?= __('admin.news.type_info') ?></option>
                        <option value="warning"><?= __('admin.news.type_warning') ?></option>
                        <option value="error"><?= __('admin.news.type_error') ?></option>
                        <option value="success"><?= __('admin.news.type_success') ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><strong><?= __('admin.news.active') ?></strong></td>
                <td>
                    <input type="checkbox" name="active" value="1" checked> <?= __('admin.news.show_players') ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <button type="submit" class="btn"
                        style="background: #4caf50; border-color: #388e3c; color: white;"><i class="fas fa-save"></i>
                        <?= __('admin.news.btn_create_aviso') ?></button>
                </td>
            </tr>
        </table>
    </form>
</div>

<div class="admin-card">
    <h3><i class="fas fa-list"></i> <?= __('admin.news.existing_avisos') ?></h3>
    <table class="vis" width="100%">
        <tr>
            <th width="80"><?= __('admin.news.col_status') ?></th>
            <th width="100"><?= __('admin.news.col_type') ?></th>
            <th width="200"><?= __('admin.news.col_title') ?></th>
            <th><?= __('admin.news.col_msg') ?></th>
            <th width="120"><?= __('admin.news.col_created') ?></th>
            <th width="150"><?= __('admin.news.col_actions') ?></th>
        </tr>
        <?php if (!empty($announcements)): ?>
            <?php $bbParser = new \App\Helpers\BBCodeParser(); ?>
            <?php foreach ($announcements as $announcement): ?>
                <tr>
                    <td align="center">
                        <?php if ($announcement['active']): ?>
                            <span style="color: green; font-weight: bold;"><?= __('admin.news.status_active') ?></span>
                        <?php else: ?>
                            <span style="color: #999;"><?= __('admin.news.status_inactive') ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php
                        $typeLabels = [
                            'info' => '<span style="color: #0066cc;">ℹ Info</span>',
                            'warning' => '<span style="color: #ff9900;">⚠ Aviso</span>',
                            'error' => '<span style="color: #cc0000;">✖ Erro</span>',
                            'success' => '<span style="color: #009900;">✓ Sucesso</span>'
                        ];
                        echo $typeLabels[$announcement['type']] ?? 'Info';
                        ?>
                    </td>
                    <td><strong><?= htmlspecialchars($announcement['title']) ?></strong></td>
                    <td><?= $bbParser->parse($announcement['message']) ?></td>
                    <td><?= date('d.m.Y H:i', $announcement['created_at']) ?></td>
                    <td align="center">
                        <a href="<?= $adminBaseUrl ?>&mode=avisos&action=toggle&id=<?= $announcement['id'] ?>" class="btn"
                            style="padding: 2px 8px; font-size: 10px; background: #0066cc;">
                            <i class="fas fa-power-off"></i>
                            <?= $announcement['active'] ? __('admin.news.btn_deactivate') : __('admin.news.btn_activate') ?>
                        </a>
                        <a href="#" onclick="editAviso(<?= $announcement['id'] ?>); return false;" class="btn"
                            style="padding: 2px 8px; font-size: 10px; background: #ff9800; border-color: #e65100; color: white;">
                            <i class="fas fa-edit"></i> <?= __('admin.rules.btn_edit') ?>
                        </a>
                        <a href="<?= $adminBaseUrl ?>&mode=avisos&action=del&id=<?= $announcement['id'] ?>"
                            onclick="return confirm('<?= addslashes(__('admin.news.del_aviso_confirm')) ?>')" class="btn"
                            style="padding: 2px 8px; font-size: 10px; background: #8b0000;">
                            <i class="fas fa-trash"></i> <?= __('admin.news.btn_del') ?>
                        </a>
                    </td>
                </tr>
                <tr id="edit-<?= $announcement['id'] ?>" style="display:none;">
                    <td colspan="6" style="background: #fcf8e3; padding: 10px; border: 1px solid #fbeed5;">
                        <form action="<?= $adminBaseUrl ?>&mode=avisos&action=edit&id=<?= $announcement['id'] ?>" method="post">
                            <table class="vis" width="100%">
                                <tr>
                                    <td width="120"><strong><?= __('admin.news.aviso_title') ?></strong></td>
                                    <td>
                                        <input type="text" name="title" value="<?= htmlspecialchars($announcement['title']) ?>" style="width: 100%; max-width: 500px;" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><?= __('admin.news.aviso_msg') ?></strong></td>
                                    <td>
                                        <?php
                                        $textareaId = 'edit_aviso_textarea_' . $announcement['id'];
                                        $prefix = 'aa_edit_' . $announcement['id'] . '_';
                                        include dirname(dirname(__DIR__)) . '/components/bbcode_toolbar.php';
                                        ?>
                                        <textarea id="edit_aviso_textarea_<?= $announcement['id'] ?>" name="message" rows="5"
                                            style="width: 100%; max-width: 600px; margin-top: 5px;" required><?= htmlspecialchars($announcement['message']) ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><?= __('admin.news.aviso_type') ?></strong></td>
                                    <td>
                                        <select name="type">
                                            <option value="info" <?= $announcement['type'] === 'info' ? 'selected' : '' ?>><?= __('admin.news.type_info') ?></option>
                                            <option value="warning" <?= $announcement['type'] === 'warning' ? 'selected' : '' ?>><?= __('admin.news.type_warning') ?></option>
                                            <option value="error" <?= $announcement['type'] === 'error' ? 'selected' : '' ?>><?= __('admin.news.type_error') ?></option>
                                            <option value="success" <?= $announcement['type'] === 'success' ? 'selected' : '' ?>><?= __('admin.news.type_success') ?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><?= __('admin.news.active') ?></strong></td>
                                    <td>
                                        <input type="checkbox" name="active" value="1" <?= $announcement['active'] ? 'checked' : '' ?>> <?= __('admin.news.show_players') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <button type="submit" class="btn" style="background: #4caf50; border-color: #388e3c; color: white;"><i class="fas fa-save"></i> <?= __('admin.rules.btn_save') ?></button>
                                        <button type="button" class="btn" style="background: #555; border-color: #333; color: white;" onclick="document.getElementById('edit-<?= $announcement['id'] ?>').style.display='none';"><i class="fas fa-times"></i> <?= __('admin.rules.btn_cancel') ?></button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" align="center" style="padding: 20px;">
                    <i class="fas fa-info-circle" style="color: #999; font-size: 24px;"></i><br>
                    <?= __('admin.news.no_avisos') ?>
                </td>
            </tr>
        <?php endif; ?>
    </table>
</div>

<div class="admin-card">
    <h3><i class="fas fa-info-circle"></i> <?= __('admin.news.note_title') ?></h3>
    <p><?= __('admin.news.note_1') ?></p>
    <p><?= __('admin.news.note_2') ?></p>
</div>

<script>
    function editAviso(id) {
        var row = document.getElementById('edit-' + id);
        if (row.style.display === 'none') {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    }
</script>
<h2><?= __('admin.rules.title') ?></h2>

<?php if (!empty($rules)): ?>
    <table class="vis" width="100%">
        <tr>
            <th><?= __('admin.rules.col_section') ?></th>
            <th><?= __('admin.rules.col_title') ?></th>
            <th><?= __('admin.rules.col_order') ?></th>
            <th><?= __('admin.rules.col_actions') ?></th>
        </tr>
        <?php foreach ($rules as $rule): ?>
            <tr>
                <td><?= htmlspecialchars($rule['section']) ?></td>
                <td><?= htmlspecialchars($rule['title']) ?></td>
                <td><?= $rule['order_num'] ?></td>
                <td>
                    <a href="#" onclick="editRule(<?= $rule['id'] ?>); return false;" class="btn" style="padding: 2px 8px; font-size: 10px; background: #ff9800; border-color: #e65100; color: white;"><i class="fas fa-edit"></i> <?= __('admin.rules.btn_edit') ?></a>
                    <form method="post"  class="inline" style="margin-left: 2px;"
                        onsubmit="return confirm('<?= addslashes(__('admin.rules.del_confirm')) ?>');">
                        <input type="hidden" name="rule_id" value="<?= $rule['id'] ?>">
                        <button type="submit" name="delete_rule" class="btn btn-cancel"  style="padding: 2px 8px; font-size: 10px;"><i class="fas fa-trash"></i> <?= __('admin.rules.btn_del') ?></button>
                    </form>
                </td>
            </tr>
            <tr id="edit-<?= $rule['id'] ?>" style="display:none;">
                <td colspan="4">
                    <form method="post">
                        <input type="hidden" name="rule_id" value="<?= $rule['id'] ?>">
                        <table width="100%">
                            <tr>
                                <td><strong><?= __('admin.rules.form_section') ?></strong></td>
                                <td><input type="text" name="section" value="<?= htmlspecialchars($rule['section']) ?>"
                                        style="width:100%;" required></td>
                            </tr>
                            <tr>
                                <td><strong><?= __('admin.rules.form_title') ?></strong></td>
                                <td><input type="text" name="title" value="<?= htmlspecialchars($rule['title']) ?>"
                                        style="width:100%;" required></td>
                            </tr>
                            <tr>
                                <td><strong><?= __('admin.rules.form_content') ?></strong></td>
                                <td><textarea name="content" rows="10"  class="w-100"
                                        required><?= htmlspecialchars($rule['content']) ?></textarea></td>
                            </tr>
                            <tr>
                                <td><strong><?= __('admin.rules.form_order') ?></strong></td>
                                <td><input type="number" name="order_num" value="<?= $rule['order_num'] ?>" required></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                     <button type="submit" name="edit_rule" class="btn"><i class="fas fa-save"></i> <?= __('admin.rules.btn_save') ?></button>
                                    <button type="button" class="btn"  style="background: #555;"
                                        onclick="document.getElementById('edit-<?= $rule['id'] ?>').style.display='none';"><i class="fas fa-times"></i> <?= __('admin.rules.btn_cancel') ?></button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p><?= __('admin.rules.no_rules') ?></p>
<?php endif; ?>

<br>
<h3><?= __('admin.rules.add_rule') ?></h3>
<form method="post">
    <table class="vis" width="100%">
        <tr>
            <td><strong><?= __('admin.rules.form_section') ?></strong></td>
            <td><input type="text" name="section" placeholder="<?= __('admin.rules.placeholder_section') ?>" required></td>
        </tr>
        <tr>
            <td><strong><?= __('admin.rules.form_title') ?></strong></td>
            <td><input type="text" name="title" placeholder="<?= __('admin.rules.placeholder_title') ?>" required></td>
        </tr>
        <tr>
            <td><strong><?= __('admin.rules.form_content') ?></strong></td>
            <td><textarea name="content" rows="10"  class="w-100" placeholder="<?= __('admin.rules.placeholder_content') ?>"
                    required></textarea></td>
        </tr>
        <tr>
            <td><strong><?= __('admin.rules.form_order') ?></strong></td>
            <td><input type="number" name="order_num" value="0" required></td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit" name="add_rule" class="btn"  style="background: #4caf50; border-color: #388e3c; color: white;"><i class="fas fa-plus-circle"></i> <?= __('admin.rules.btn_add') ?></button>
            </td>
        </tr>
    </table>
</form>

<script>
    function editRule(id) {
        document.getElementById('edit-' + id).style.display = 'table-row';
    }
</script>
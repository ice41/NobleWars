<?php
/**
 * Manage Forum Categories — screen=ally&mode=forum&action=manage_categories
 */
$baseUrl = 'game.php?village=' . $village['id'] . '&screen=ally&mode=forum';
?>

<h2><?= __('screens.ally_forum.manage_categories') ?></h2>

<div  class="mb-10">
    <a href="<?= $baseUrl ?>" class="btn">
        « <?= __('screens.ally_forum.back_to_forum') ?>
    </a>
</div>

<?php if (!empty($error)): ?>
    <div class="error p-10 mb-10"  style="background-color: #ffdddd; border: 1px solid #ff0000;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="success p-10 mb-10"  style="background-color: #ddffdd; border: 1px solid #00aa00;">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<!-- Create New Category -->
<table class="vis mb-20" width="100%" >
    <tr>
        <th colspan="2"><?= __('screens.ally_forum.create_category') ?></th>
    </tr>
    <tr>
        <td colspan="2">
            <form action="<?= $baseUrl ?>&action=create_category&h=<?= $session['hkey'] ?>" method="POST">
                <table width="100%">
                    <tr>
                        <td width="200"><b><?= __('screens.ally_forum.category_name') ?>:</b></td>
                        <td><input type="text" name="name" required  style="width: 300px;" maxlength="50"></td>
                    </tr>
                    <tr>
                        <td><b><?= __('screens.ally_forum.category_description') ?>:</b></td>
                        <td><input type="text" name="description"  style="width: 500px;" maxlength="200"></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="submit" value="<?= __('screens.ally_forum.create_category') ?>" class="btn">
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>

<!-- Existing Categories -->
<table class="vis" width="100%">
    <tr>
        <th colspan="5"><?= __('screens.ally_forum.categories') ?></th>
    </tr>
    <tr>
        <th width="50"><?= __('screens.ally_forum.category_icon') ?></th>
        <th><?= __('screens.ally_forum.category_name') ?></th>
        <th><?= __('screens.ally_forum.category_description') ?></th>
        <th width="100"><?= __('screens.ally_forum.threads') ?></th>
        <th width="200"><?= __('screens.ally_forum.actions') ?></th>
    </tr>

    <?php if (empty($sections)): ?>
        <tr>
            <td colspan="5" align="center"  style="padding: 20px;">
                <i><?= __('screens.ally_forum.no_categories') ?></i>
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($sections as $sec): ?>
            <tr class="row_b">
                <td align="center"  style="font-size: 24px;">
                    <?= htmlspecialchars($sec['icon'] ?? '') ?>
                </td>
                <td>
                    <strong><?= htmlspecialchars($sec['name']) ?></strong>
                </td>
                <td>
                    <?= htmlspecialchars($sec['description'] ?? '') ?>
                </td>
                <td align="center">
                    <?php
                    $count = $db->fetch(
                        "SELECT COUNT(*) as count FROM ally_forum_threads WHERE section_id = ?",
                        [$sec['id']]
                    );
                    echo $count['count'] ?? 0;
                    ?>
                </td>
                <td align="center">
                    <a href="javascript:void(0)"
                       onclick="editCategory(<?= $sec['id'] ?>, '<?= htmlspecialchars($sec['name'], ENT_QUOTES) ?>', '<?= htmlspecialchars($sec['description'] ?? '', ENT_QUOTES) ?>')"
                       class="btn">
                        ✏️ <?= __('screens.ally_forum.edit') ?>
                    </a>
                    <a href="<?= $baseUrl ?>&action=delete_category&section_id=<?= $sec['id'] ?>&h=<?= $session['hkey'] ?>"
                       onclick="return confirm('<?= __('screens.ally_forum.confirm_delete_category') ?>')" class="btn">
                        🗑️ <?= __('screens.ally_forum.delete') ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

<!-- Edit Category Modal -->
<div id="edit_modal"
     style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
            background: white; border: 2px solid #c0a070; padding: 20px; z-index: 1000;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);">
    <h3><?= __('screens.ally_forum.edit_category') ?></h3>
    <form id="edit_form" action="<?= $baseUrl ?>&action=edit_category&h=<?= $session['hkey'] ?>" method="POST">
        <input type="hidden" name="section_id" id="edit_section_id">
        <table>
            <tr>
                <td><b><?= __('screens.ally_forum.category_name') ?>:</b></td>
                <td><input type="text" name="name" id="edit_name" required  style="width: 300px;" maxlength="50"></td>
            </tr>
            <tr>
                <td><b><?= __('screens.ally_forum.category_description') ?>:</b></td>
                <td><input type="text" name="description" id="edit_description"  style="width: 400px;" maxlength="200"></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="<?= __('screens.ally_forum.save') ?>" class="btn">
                    <button type="button" onclick="closeEditModal()" class="btn">
                        <?= __('screens.ally_forum.cancel') ?>
                    </button>
                </td>
            </tr>
        </table>
    </form>
</div>

<!-- Modal Overlay -->
<div id="modal_overlay"
     style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); z-index: 999;"
     onclick="closeEditModal()"></div>

<script>
function editCategory(id, name, description) {
    document.getElementById('edit_section_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_modal').style.display = 'block';
    document.getElementById('modal_overlay').style.display = 'block';
}

function closeEditModal() {
    document.getElementById('edit_modal').style.display = 'none';
    document.getElementById('modal_overlay').style.display = 'none';
}
</script>
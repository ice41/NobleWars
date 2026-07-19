<?php
// Ensure variables are arrays to prevent errors
$selected_buildings = $selected_buildings ?? [];
$available_buildings = $available_buildings ?? [];
$show_toolbar = $user['show_toolbar'] ?? 1;
?>

<h3><?= __('screens.settings_toolbar.title') ?></h3>

<!-- Quickbar Visibility Toggle -->
<form action="game.php?village=<?= $village['id'] ?>&screen=settings&mode=toolbar&action=toggle_visibility&h=<?= $hkey ?>" method="POST" style="margin-bottom: 20px;">
    <table class="vis" width="100%">
        <tr>
            <th colspan="2"><?= __('screens.settings_toolbar.visibility_title') ?></th>
        </tr>
        <tr>
            <td width="200">
                <label>
                    <input type="checkbox" name="show_toolbar" value="1" <?= $show_toolbar == 1 ? 'checked' : '' ?> />
                    <?= __('screens.settings_toolbar.show_toolbar') ?>
                </label>
            </td>
            <td>
                <input type="submit" value="<?= __('screens.settings_toolbar.save_visibility') ?>" class="btn" />
            </td>
        </tr>
    </table>
</form>

<p><?= __('screens.settings_toolbar.select_up_to_8') ?></p>

<?php if (!empty($success_message)): ?>
    <div class="success p-10 mb-15"  style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; border-radius: 4px;">
        <?= $success_message ?>
    </div>
<?php endif; ?>

<?php if (!empty($error_message)): ?>
    <div class="error p-10 mb-15"  style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; border-radius: 4px;">
        <?= $error_message ?>
    </div>
<?php endif; ?>

<form action="game.php?village=<?= $village['id'] ?>&screen=settings&mode=toolbar&action=save&h=<?= $hkey ?>" method="POST">
    <table class="vis" width="100%">
        <tr>
            <th colspan="3"><?= __('screens.settings_toolbar.available_buildings') ?></th>
        </tr>
        <tr>
            <th width="40"><?= __('screens.settings_toolbar.select') ?></th>
            <th><?= __('screens.settings_toolbar.building') ?></th>
            <th><?= __('screens.common.current_level') ?></th>
        </tr>
        
        <?php foreach ($available_buildings as $building_key => $building_name): ?>
            <?php
            $is_selected = in_array($building_key, $selected_buildings);
            $building_level = $village[$building_key] ?? 0;
            ?>
            <tr>
                <td  class="text-center">
                    <input type="checkbox" 
                           name="buildings[]" 
                           value="<?= $building_key ?>" 
                           <?= $is_selected ? 'checked' : '' ?>
                           class="quickbar-checkbox" />
                </td>
                <td>
                    <img src="graphic/buildings/<?= $building_key ?>.png" 
                         style="width: 20px; height: 20px; vertical-align: middle;" 
                         alt="<?= $building_name ?>" />
                    <?= $building_name ?>
                </td>
                <td  class="text-center">
                    <?= $building_level ?>
                </td>
            </tr>
        <?php endforeach; ?>
        
        <tr>
            <td colspan="3"  class="text-center" style="padding: 15px;">
                <input type="submit" value="<?= __('screens.settings_toolbar.save_configuration') ?>" class="btn" />
                <span  style="margin-left: 20px; color: #666;">
                    <?= __('screens.settings_toolbar.selected') ?> <strong id="selected-count"><?= count($selected_buildings) ?></strong> / 8
                </span>
            </td>
        </tr>
    </table>
</form>

<br />

<table class="vis" width="100%">
    <tr>
        <th><?= __('screens.settings_toolbar.current_order') ?></th>
    </tr>
    <tr>
        <td  style="padding: 15px;">
            <?php if (!empty($selected_buildings)): ?>
                <div  style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <?php foreach ($selected_buildings as $building_key): ?>
                        <?php if (isset($available_buildings[$building_key])): ?>
                            <div  class="text-center p-10" style="border: 1px solid #ddd; border-radius: 4px; background: #f9f9f9;">
                                <img src="graphic/buildings/<?= $building_key ?>.png" 
                                     style="width: 32px; height: 32px; display: block; margin: 0 auto 5px;" 
                                     alt="<?= $available_buildings[$building_key] ?>" />
                                <small><?= $available_buildings[$building_key] ?></small>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p  class="text-center" style="color: #999;"><?= __('screens.settings_toolbar.no_buildings_selected') ?></p>
            <?php endif; ?>
        </td>
    </tr>
</table>

<br />

<div  class="p-10" style="background: #e7f3ff; border-left: 4px solid #2196f3;">
    <strong>💡 <?= __('screens.settings_toolbar.tip') ?></strong> <?= __('screens.settings_toolbar.tip_description') ?>
</div>

<script>
// Limit selection to 8 buildings
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.quickbar-checkbox');
    const counter = document.getElementById('selected-count');
    const maxBuildings = 8;
    
    function updateCounter() {
        const checked = document.querySelectorAll('.quickbar-checkbox:checked').length;
        counter.textContent = checked;
        
        // Disable unchecked boxes if limit reached
        checkboxes.forEach(cb => {
            if (!cb.checked && checked >= maxBuildings) {
                cb.disabled = true;
                cb.parentElement.parentElement.style.opacity = '0.5';
            } else {
                cb.disabled = false;
                cb.parentElement.parentElement.style.opacity = '1';
            }
        });
    }
    
    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateCounter);
    });
    
    // Initial update
    updateCounter();
});
</script>
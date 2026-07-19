<?php
/**
 * Account Manager - Research Mode
 * Manage technology research targets for villages
 */

// Get unit names for research (exclude knight and snob - not researched in smith)
$units = [
    'spear' => __('units.spear.name'),
    'sword' => __('units.sword.name'),
    'axe' => __('units.axe.name'),
    'archer' => __('units.archer.name'),
    'spy' => __('units.spy.name'),
    'light' => __('units.light.name'),
    'marcher' => __('units.marcher.name'),
    'heavy' => __('units.heavy.name'),
    'ram' => __('units.ram.name'),
    'catapult' => __('units.catapult.name')
];
?>

<?php if (isset($_SESSION['research_error'])): ?>
    <div class="error p-10 mb-10"  style="background-color: #ffcccc; border: 1px solid #cc0000;">
        ⚠️ <?= htmlspecialchars($_SESSION['research_error']) ?>
    </div>
    <?php unset($_SESSION['research_error']); ?>
<?php endif; ?>

<h3><?= __('screens.accountmanager.research.edit_template') ?></h3>

<form method="post" action="game.php?village=<?= $village['id'] ?>&screen=accountmanager&mode=research&action=save">

    <!-- Summary Section -->
    <table class="vis" width="100%">
        <tr>
            <th colspan="<?= count($units) + 1 ?>"><?= __('screens.accountmanager.research.summary') ?></th>
        </tr>
        <tr>
            <?php foreach ($units as $unit_key => $unit_name): ?>
                <td  class="text-center">
                    <img src="graphic/unit/unit_<?= $unit_key ?>.png" title="<?= $unit_name ?>" />
                </td>
            <?php endforeach; ?>
            <td></td>
        </tr>
        <tr>
            <?php foreach ($units as $unit_key => $unit_name): ?>
                <td  class="text-center">
                    <?= $research_levels[$unit_key] ?? 0 ?>
                </td>
            <?php endforeach; ?>
            <td  class="text-right">
                <a href="javascript:void(0);" onclick="openResearchTemplateModal()"><?= __('screens.accountmanager.research.manage_templates') ?></a>
            </td>
        </tr>
    </table>

    <br>

    <!-- Research Queue -->
    <h4><?= __('screens.accountmanager.research.research_mode') ?></h4>
    <table class="vis" width="100%">
        <tr>
            <th width="40"><?= __('screens.accountmanager.research.unit') ?></th>
            <th><?= __('screens.accountmanager.research.description') ?></th>
            <th width="80"><?= __('screens.common.level') ?></th>
            <th width="40"><?= __('screens.accountmanager.research.remove') ?></th>
        </tr>
        <?php if (empty($research_queue)): ?>
            <tr>
                <td colspan="4"  class="text-center" style="padding: 20px; color: #666;">
                    <?= __('screens.accountmanager.research.no_research') ?>
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($research_queue as $index => $item): ?>
                <tr<?= ($index === 0 && !empty($automation_status)) ? '  style="background-color: #90EE90;"' : '' ?>>
                    <td  class="text-center">
                        <img src="graphic/unit/unit_<?= $item['unit'] ?>.png"
                            title="<?= $units[$item['unit']] ?? $item['unit'] ?>" />
                    </td>
                    <td>
                        <?= $units[$item['unit']] ?? $item['unit'] ?> +1 (<?= __('screens.common.level') ?>
                        <?= $item['level'] ?>)
                        <?php if ($index === 0 && !empty($automation_status)): ?>
                            <span  style="margin-left: 10px; color: #666; font-size: 11px;">
                                <?= htmlspecialchars($automation_status) ?>
                            </span>
                        <?php endif; ?>
                    </td>
                    <td  class="text-center"><?= $item['level'] ?></td>
                    <td  class="text-center">
                        <a
                            href="game.php?village=<?= $village['id'] ?>&screen=accountmanager&mode=research&action=remove&id=<?= $item['id'] ?>&h=<?= $hkey ?>">
                            <?= __('screens.accountmanager.research.remove') ?>
                        </a>
                    </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
    </table>

    <br>

</form>

<!-- Apply Template Section -->
<?php if (!empty($custom_templates)): ?>
    <h4><?= __('screens.accountmanager.research.apply_template') ?></h4>
    <form method="post"
        action="game.php?village=<?= $village['id'] ?>&screen=accountmanager&mode=research&action=apply_template">
        <table class="vis" width="100%">
            <tr>
                <td>
                    <strong><?= __('screens.accountmanager.research.template') ?></strong>
                    <select name="template_name"  style="width: 250px;" required>
                        <option value=""><?= __('screens.accountmanager.research.choose_template') ?></option>
                        <?php foreach ($custom_templates as $name => $levels): ?>
                            <option value="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($name) ?></option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" class="btn"  style="margin-left: 10px;"><?= __('screens.accountmanager.research.btn_apply') ?></button>
                    <span  style="margin-left: 10px; color: #666; font-size: 11px;">
                        <?= __('screens.accountmanager.research.apply_info') ?>
                    </span>
                </td>
            </tr>
        </table>
        <input type="hidden" name="h" value="<?= $hkey ?>">
    </form>
    <br>
<?php endif; ?>

<!-- Add Order Section -->
<h4><?= __('screens.accountmanager.research.add_order') ?></h4>
<form method="post" action="game.php?village=<?= $village['id'] ?>&screen=accountmanager&mode=research&action=add">
    <table class="vis" width="100%">
        <tr>
            <td>
                <strong><?= __('screens.accountmanager.research.research') ?></strong>
                <select name="research_unit"  style="width: 200px;" required>
                    <option value=""><?= __('screens.accountmanager.research.choose') ?></option>
                    <?php foreach ($units as $unit_key => $unit_name): ?>
                        <option value="<?= $unit_key ?>"><?= $unit_name ?></option>
                    <?php endforeach; ?>
                </select>

                <strong  style="margin-left: 20px;"><?= __('screens.common.level') ?>:</strong>
                <input type="number" name="research_level" value="1" min="1" max="10"  style="width: 60px;" required>

                <button type="submit" class="btn"  style="margin-left: 10px;"><?= __('screens.accountmanager.research.btn_add') ?></button>
            </td>
        </tr>
    </table>
    <input type="hidden" name="h" value="<?= $hkey ?>">
</form>

<!-- Research Template Modal -->
<div id="research_modal_overlay"
     class="w-100" style="display: none; position: fixed; top: 0; left: 0; height: 100%; background: rgba(0,0,0,0.5); z-index: 9998;"
    onclick="closeResearchTemplateModal();"></div>

<div id="research_template_modal"
     style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 95%; max-width: 700px; z-index: 9999;">
    <div  style="border-radius: 8px; overflow: hidden;">
        <table class="popup_box" cellspacing="0" cellpadding="0"
             style="background: url(;"graphic/popup/content_background.png'); border-collapse: collapse; line-height: 0; font-size: 0; width: 100%;">
            <tr  style="line-height: 0;">
                <td
                     style="background: url(;"graphic/popup/border_top_left.png') no-repeat; width: 20px; height: 20px; line-height: 0; font-size: 0; padding: 0; margin: 0; vertical-align: top;">
                </td>
                <td
                     style="background: url(;"graphic/popup/border_top.png') repeat-x; height: 20px; line-height: 0; font-size: 0; padding: 0; margin: 0; vertical-align: top;">
                </td>
                <td
                     style="background: url(;"graphic/popup/border_top_right.png') no-repeat; width: 20px; height: 20px; line-height: 0; font-size: 0; padding: 0; margin: 0; vertical-align: top;">
                </td>
            </tr>
            <tr>
                <td
                     style="background: url(;"graphic/popup/mainborder_left.png') repeat-y; width: 20px; line-height: 0; font-size: 0;">
                </td>
                <td
                     style="padding: 20px; background-color: #f4e4bc; line-height: normal; font-size: 12px; max-height: 70vh; overflow-y: auto;">
                    <div  class="mb-15" style="padding-bottom: 10px; position: relative;">
                        <h3  style="margin: 0;"><?= __('screens.accountmanager.research.manage_research_templates') ?></h3>
                        <a href="javascript:void(0);" onclick="closeResearchTemplateModal();"
                             style="position: absolute; top: -5px; right: -5px;">
                            <img src="graphic/popup/close.png" alt="<?= __('screens.accountmanager.research.close') ?>" style="cursor: pointer;" />
                        </a>
                    </div>

                    <div  class="mb-15">
                        <label><strong><?= __('screens.accountmanager.research.template_name') ?></strong></label><br>
                        <input type="text" id="research_template_name" placeholder="<?= __('screens.accountmanager.research.template_name_placeholder') ?>"
                            style="width: 100%; padding: 5px; margin-top: 5px; border: 1px solid #7d510f;">
                    </div>

                    <div  style="max-height: 100%; overflow-y: auto;">
                        <table class="vis" width="100%">
                            <tr>
                                <th><?= __('screens.common.level') ?></th>
                                <th><?= __('screens.common.target_level') ?> (0-10)</th>
                            </tr>
                            <?php foreach ($units as $unit_key => $unit_name): ?>
                                <tr>
                                    <td>
                                        <img src="graphic/unit/unit_<?= $unit_key ?>.png"
                                            style="vertical-align: middle; margin-right: 5px;" />
                                        <?= $unit_name ?>
                                    </td>
                                    <td  class="text-center">
                                        <input type="number" id="research_level_<?= $unit_key ?>" min="0" max="10" value="0"
                                            style="width: 60px; text-align: center; border: 1px solid #7d510f; padding: 3px;">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>

                    <div
                         class="text-center mt-15" style="padding-top: 15px; border-top: 1px solid #7d510f;">
                        <button class="btn" onclick="saveResearchTemplate()"><?= __('screens.accountmanager.research.btn_save_template') ?></button>
                        <button class="btn" onclick="closeResearchTemplateModal()"
                             style="margin-left: 10px;"><?= __('screens.accountmanager.research.btn_cancel') ?></button>
                    </div>
                </td>
                <td
                     style="background: url(;"graphic/popup/mainborder_right.png') repeat-y; width: 20px; line-height: 0; font-size: 0;">
                </td>
            </tr>
            <tr  style="line-height: 0;">
                <td
                     style="background: url(;"graphic/popup/border_bottom_left.png') no-repeat; width: 20px; height: 20px; line-height: 0; font-size: 0; padding: 0; margin: 0; vertical-align: bottom;">
                </td>
                <td
                     style="background: url(;"graphic/popup/border_bottom.png') repeat-x; height: 20px; line-height: 0; font-size: 0; padding: 0; margin: 0; vertical-align: bottom;">
                </td>
                <td
                     style="background: url(;"graphic/popup/border_bottom_right.png') no-repeat; width: 20px; height: 20px; line-height: 0; font-size: 0; padding: 0; margin: 0; vertical-align: bottom;">
                </td>
            </tr>
        </table>
    </div>
</div>

<script>
    function openResearchTemplateModal() {
        document.getElementById('research_modal_overlay').style.display = 'block';
        document.getElementById('research_template_modal').style.display = 'block';
    }

    function closeResearchTemplateModal() {
        document.getElementById('research_modal_overlay').style.display = 'none';
        document.getElementById('research_template_modal').style.display = 'none';
    }

    function saveResearchTemplate() {
        const templateName = document.getElementById('research_template_name').value;
        if (!templateName) {
            alert('<?= __('screens.accountmanager.research.alert_empty_name') ?>');
            return;
        }

        const levels = {};
        <?php foreach ($units as $unit_key => $unit_name): ?>
            levels['<?= $unit_key ?>'] = parseInt(document.getElementById('research_level_<?= $unit_key ?>').value) || 0;
        <?php endforeach; ?>

        // Send to server
        const formData = new FormData();
        formData.append('template_name', templateName);
        formData.append('levels', JSON.stringify(levels));
        formData.append('h', '<?= $hkey ?>');

        fetch('game.php?village=<?= $village['id'] ?>&screen=accountmanager&mode=research&action=save_template', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('<?= __('screens.accountmanager.research.alert_success') ?>');
                    closeResearchTemplateModal();
                    location.reload();
                } else {
                    alert('<?= __('screens.accountmanager.research.alert_error') ?>' + (data.error || '<?= __('screens.accountmanager.research.alert_unknown') ?>'));
                }
            })
            .catch(error => {
                alert('Erro ao guardar modelo.');
                console.error(error);
            });
    }
</script>
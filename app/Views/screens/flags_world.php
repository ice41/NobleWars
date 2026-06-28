<p><?= __('screens.flags.world_desc') ?></p>

<table class="vis" width="100%">
    <tr>
        <th><?= __('screens.flags.village') ?></th>
        <th><?= __('screens.flags.active_flag_col') ?></th>
        <th><?= __('screens.flags.bonus_col') ?></th>
        <th><?= __('screens.flags.action') ?></th>
    </tr>

    <?php foreach ($villages as $v): ?>
        <tr>
            <td>
                <a href="game.php?village=<?= $v['id'] ?>&screen=overview">
                    <?= htmlspecialchars($v['name']) ?> (<?= $v['x'] ?>|<?= $v['y'] ?>)
                </a>
            </td>

            <td>
                <?php if (!empty($v['flag_type'])): ?>
                    <img src="/graphic/flags/<?= $v['flag_type'] ?>-<?= $v['flag_level'] ?>.png" 
                         alt="<?= \App\Models\FlagsModel::getFlagName($v['flag_type']) ?>" 
                         style="width:24px; vertical-align:middle; margin-right:5px;">
                    <?= \App\Models\FlagsModel::getFlagName($v['flag_type']) . ' (' . __('screens.common.level') . ' ' . $v['flag_level'] . ')' ?>
                <?php else: ?>
                    <span class="grey"><?= __('screens.flags.no_active_flag') ?></span>
                <?php endif; ?>
            </td>

            <td>
                <?php if (!empty($v['flag_type'])): ?>
                    <span style="color: #008200; font-weight: bold;">
                        +<?= \App\Models\FlagsModel::getFlagEffectDescription($v['flag_type'], $v['flag_level']) ?>
                    </span>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>

            <td>
                <form method="POST" style="display: inline-block;">
                    <input type="hidden" name="action" value="activate">
                    <input type="hidden" name="target_village" value="<?= $v['id'] ?>">
                    <select name="flag_type" onchange="this.form.flag_level.value = this.options[this.selectedIndex].getAttribute('data-level');" style="max-width:220px;">
                        <option value=""><?= __('screens.flags.select_flag_option') ?></option>
                        <?php foreach ($inventory as $i): ?>
                            <?php if ($i['count'] > 0): ?>
                            <option value="<?= $i['type'] ?>" data-level="<?= $i['level'] ?>">
                                <?= $i['name'] ?> (<?= $i['count'] ?> <?= __('screens.flags.avail') ?>)
                            </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="flag_level" value="">
                    &nbsp;<input type="submit" value="<?= __('screens.flags.apply') ?>" class="btn btn-green">
                </form>

                <?php if (!empty($v['flag_type'])): ?>
                <form method="POST" style="display: inline-block; margin-left: 5px;">
                    <input type="hidden" name="action" value="remove">
                    <input type="hidden" name="target_village" value="<?= $v['id'] ?>">
                    <input type="submit" value="<?= __('screens.flags.remove') ?>" class="btn btn-cancel">
                </form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php if (empty($villages)): ?>
    <div style="padding: 10px; text-align: center;" class="error">
        <?= __('screens.flags.no_villages_found') ?>
    </div>
<?php endif; ?>
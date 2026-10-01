<div class="flags-history-container">
    <p><?= __('screens.flags.history_desc') ?></p>

    <table class="vis">
        <tr>
            <th><?= __('screens.flags.date') ?></th>
            <th><?= __('screens.flags.flag') ?></th>
            <th><?= __('screens.common.level') ?></th>
            <th><?= __('screens.flags.change_col') ?></th>
            <th><?= __('screens.flags.reason') ?></th>
        </tr>
        <?php if (empty($history)): ?>
            <tr>
                <td colspan="5"  class="text-center"><?= __('screens.flags.no_history') ?></td>
            </tr>
        <?php else: ?>
            <?php foreach ($history as $entry): ?>
                <tr>
                    <td><?= date('d.m.Y H:i:s', $entry['acquired_at']) ?></td>
                    <td><?= \App\Models\FlagsModel::getFlagName($entry['flag_type']) ?></td>
                    <td><?= $entry['flag_level'] ?></td>
                    <td>1</td>
                    <td><?= htmlspecialchars($entry['reason']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>
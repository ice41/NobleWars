<h3><?= __('screens.ally.tribe_profile') ?></h3>

<?php if ($is_leader): ?>
    <form action="game.php?village=<?= $village['id'] ?>&screen=ally&mode=profile&action=update&h=<?= $session['hkey'] ?>"
        method="post">
        <table class="vis" width="100%">
            <tr>
                <th colspan="2"><?= __('screens.ally.edit_profile') ?></th>
            </tr>
            <tr>
                <td width="200"><?= __('screens.ally.public_description') ?></td>
                <td>
                    <div id="bb_bar_description" style="text-align:left; overflow:visible; margin-bottom: 5px;">
                        <?php 
                        $textareaId = 'description';
                        $prefix = 'desc_';
                        include __DIR__ . '/../components/bbcode_toolbar.php'; 
                        ?>
                    </div>
                    <textarea id="description" name="description" rows="10"
                        cols="60"><?= htmlspecialchars($ally['description'] ?? '') ?></textarea>
                </td>
            </tr>
            <tr>
                <td><?= __('screens.ally.internal_text_label') ?></td>
                <td>
                    <div id="bb_bar_internal" style="text-align:left; overflow:visible; margin-bottom: 5px;">
                        <?php 
                        $textareaId = 'internal_text';
                        $prefix = 'int_';
                        include __DIR__ . '/../components/bbcode_toolbar.php'; 
                        ?>
                    </div>
                    <textarea id="internal_text" name="internal_text" rows="10"
                        cols="60"><?= htmlspecialchars($ally['internal_text'] ?? '') ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="center">
                    <input type="submit" value="<?= __('screens.ally.save') ?>" class="btn" />
                </td>
            </tr>
        </table>
    </form>
    <br />
<?php endif; ?>

<table class="vis" width="100%">
    <tr>
        <th colspan="2"><?= __('screens.ally.tribe_information') ?></th>
    </tr>
    <tr>
        <td width="200"><?= __('screens.ally.name') ?></td>
        <td><?= htmlspecialchars($ally['name']) ?></td>
    </tr>
    <tr>
        <td><?= __('screens.ally.tag_label') ?></td>
        <td><?= htmlspecialchars($ally['short']) ?></td>
    </tr>
    <tr>
        <td><?= __('screens.ally.members_label') ?></td>
        <td><?= $ally['members'] ?? 0 ?></td>
    </tr>
    <tr>
        <td><?= __('screens.ally.villages') ?></td>
        <td><?= $ally['villages'] ?? 0 ?></td>
    </tr>
    <tr>
        <td><?= __('screens.ally.points_label') ?></td>
        <td><?= number_format($ally['points'] ?? 0) ?></td>
    </tr>
</table>

<br />

<table class="vis" width="100%">
    <tr>
        <th><?= __('screens.ally.description') ?></th>
    </tr>
    <tr>
        <td>
            <?php $bbParser = new \App\Helpers\BBCodeParser(); ?>
            <?= $bbParser->parse($ally['description'] ?: __('screens.ally.no_description')) ?>
        </td>
    </tr>
</table>

<?php if (!empty($ally['internal_text'])): ?>
    <br />
    <table class="vis" width="100%">
        <tr>
            <th><?= __('screens.ally.internal_text_title') ?></th>
        </tr>
        <tr>
            <td><?= (isset($bbParser) ? $bbParser : new \App\Helpers\BBCodeParser())->parse($ally['internal_text']) ?></td>
        </tr>
    </table>
<?php endif; ?>

<?php if (!$is_leader): ?>
    <br />
    <a href="game.php?village=<?= $village['id'] ?>&screen=ally&mode=profile&action=leave&h=<?= $session['hkey'] ?>"
        onclick="return confirm('<?= __('screens.ally.leave_tribe_confirm_profile') ?>')">
        <?= __('screens.ally.leave_tribe_action') ?>
    </a>
<?php endif; ?>
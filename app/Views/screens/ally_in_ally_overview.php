<table width="100%">
    <tr>
        <td valign="top">

            <table class="vis" width="100%">
                <?php if ($num_pages > 1): ?>
                    <tr>
                        <td align="center" colspan="3">
                            <?php for ($i = 1; $i <= $num_pages; $i++): ?>
                                <?php if ($site == $i): ?>
                                    <strong> &gt;<?= $i ?>&lt; </strong>
                                <?php else: ?>
                                    <a href="game.php?village=<?= $village['id'] ?>&screen=ally&site=<?= $i ?>"> [<?= $i ?>] </a>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <th><?= __('screens.ally.date') ?></th>
                    <th><?= __('screens.ally.event') ?></th>
                </tr>

                <?php 
                    $bbParser = new \App\Helpers\BBCodeParser();
                    foreach ($events as $arr): 
                ?>
                    <tr>
                        <td><?= is_numeric($arr['time']) ? format_date((int)$arr['time']) : htmlspecialchars($arr['time']) ?></td>
                        <td><?= compile_ally_events($arr['message']) ?></td>
                    </tr>
                <?php endforeach; ?>

            </table>

        </td>
        <td valign="top" width="400">
            <table class="vis" width="100%">
                <tr>
                    <td>
                        <a href="game.php?village=<?= $village['id'] ?>&screen=ally&mode=profile&action=leave&h=<?= $user['hkey'] ?? '' ?>"
                            onclick="return confirm('<?= __('screens.ally.leave_tribe_confirm') ?>');">
                            <?= __('screens.ally.leave_tribe') ?>
                        </a>
                    </td>
                </tr>
            </table>

            <?php if (!empty($previews)): ?>
                <table class="vis" width="100%">
                    <tr>
                        <th colspan="2"><?= __('screens.ally.preview') ?></th>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><?= $previews ?></td>
                    </tr>
                </table>
            <?php endif; ?>

            <!-- BBCode scripts would go here if needed, simplified for now -->
            <!-- Assuming BBCode handling is done via existing JS or simplified -->

            <table class="vis" width="100%">
                <tr>
                    <th colspan="2" width="100%"><?= __('screens.ally.internal_text') ?></th>
                </tr>
                <tr align="center">
                    <td colspan="2">
                        <?php $bbParser = new \App\Helpers\BBCodeParser(); ?>
                        <?= $bbParser->parse($ally['internal_text'] ?? '') ?>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
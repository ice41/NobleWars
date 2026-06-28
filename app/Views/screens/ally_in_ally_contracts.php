<h3><?= __('screens.ally.diplomacy') ?></h3>

<?php if ($is_leader): ?>
    <form action="game.php?village=<?= $village['id'] ?>&screen=ally&mode=contracts&action=create&h=<?= $session['hkey'] ?>"
        method="post">
        <table class="vis" width="100%">
            <tr>
                <th colspan="2"><?= __('screens.ally.create_contract') ?></th>
            </tr>
            <tr>
                <td width="200"><?= __('screens.ally.ally_tag') ?></td>
                <td><input type="text" name="ally_tag" size="10" required /></td>
            </tr>
            <tr>
                <td><?= __('screens.ally.type') ?></td>
                <td>
                    <select name="type" required>
                        <option value="nap"><?= __('screens.ally.contract_nap') ?></option>
                        <option value="alliance"><?= __('screens.ally.contract_alliance') ?></option>
                        <option value="war"><?= __('screens.ally.contract_war') ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?= __('screens.ally.message') ?></td>
                <td><textarea name="text" rows="5" cols="50"></textarea></td>
            </tr>
            <tr>
                <td colspan="2" class="center">
                    <input type="submit" value="<?= __('screens.ally.send_proposal') ?>" class="btn" />
                </td>
            </tr>
        </table>
    </form>
    <br />
<?php endif; ?>

<h3><?= __('screens.ally.active_contracts') ?></h3>
<table class="vis" width="100%">
    <tr>
        <th width="150"><?= __('screens.ally.tribe') ?></th>
        <th width="100"><?= __('screens.ally.type') ?></th>
        <th width="150"><?= __('screens.ally.date') ?></th>
        <th><?= __('screens.ally.status') ?></th>
        <?php if ($is_leader): ?>
            <th width="100"><?= __('screens.ally.actions') ?></th>
        <?php endif; ?>
    </tr>

    <?php if (empty($contracts)): ?>
        <tr>
            <td colspan="<?= $is_leader ? 5 : 4 ?>" class="center"><?= __('screens.ally.no_contracts') ?></td>
        </tr>
    <?php else: ?>
        <?php foreach ($contracts as $contract): ?>
            <tr>
                <td>
                    <?php if (!empty($contract['other_ally_short'])): ?>
                        <a
                            href="game.php?village=<?= $village['id'] ?>&screen=info_ally&id=<?= $contract['to_ally'] == $ally['id'] ? $contract['from_ally'] : $contract['to_ally'] ?>">
                            <?= htmlspecialchars($contract['other_ally_short']) ?>
                        </a>
                    <?php else: ?>
                        <?= __('screens.ally.unknown_tribe') ?>
                    <?php endif; ?>
                </td>
                <td class="center">
                    <?php
                    $types = [
                        'nap' => __('screens.ally.type_nap'),
                        'alliance' => __('screens.ally.type_alliance'),
                        'war' => __('screens.ally.type_war'),
                    ];
                    echo $types[$contract['type']] ?? $contract['type'];
                    ?>
                </td>
                <td class="center"><?= date('d/m/Y H:i', $contract['date']) ?></td>
                <td class="center">
                    <?php
                    $statuses = [
                        'pending' => __('screens.ally.status_pending'),
                        'accepted' => __('screens.ally.status_accepted'),
                        'rejected' => __('screens.ally.status_rejected'),
                        'cancelled' => __('screens.ally.status_cancelled'),
                    ];
                    echo $statuses[$contract['status']] ?? $contract['status'];
                    ?>
                </td>
                <?php if ($is_leader): ?>
                    <td class="center">
                        <?php if ($contract['status'] == 'pending'): ?>
                            <a
                                href="game.php?village=<?= $village['id'] ?>&screen=ally&mode=contracts&action=cancel&id=<?= $contract['id'] ?>&h=<?= $session['hkey'] ?>">
                                <?= __('screens.ally.cancel') ?>
                            </a>
                        <?php endif; ?>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
<div class="flags-commerce-container">
    <p><?= __('screens.flags.commerce_desc') ?></p>

    <!-- Add Trade Offer -->
    <h3><?= __('screens.flags.add_offer') ?></h3>
    <form method="post" class="trade-form">
        <input type="hidden" name="action" value="create_trade">

        <table class="vis">
            <tr>
                <th><?= __('screens.flags.offer') ?></th>
                <th><?= __('screens.flags.search_for') ?></th>
            </tr>
            <tr>
                <td>
                    <select name="offered_type" required>
                        <option value=""><?= __('screens.flags.select_flag') ?></option>
                        <?php foreach ($user_flags as $flag): ?>
                            <option value="<?= $flag['flag_type'] ?>_<?= $flag['flag_level'] ?>">
                                <?= \App\Models\FlagsModel::getFlagName($flag['flag_type']) ?>
                                (<?= __('screens.common.level') ?>
                                <?= $flag['flag_level'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select name="requested_type" required>
                        <option value=""><?= __('screens.flags.select_flag') ?></option>
                        <!-- All possible flags -->
                        <?php
                        $allTypes = ['resource_wood', 'resource_clay', 'resource_iron', 'recruitment', 'attack', 'defense', 'luck', 'population', 'coin_cost', 'cargo'];
                        foreach ($allTypes as $type):
                            for ($lvl = 1; $lvl <= 3; $lvl++):
                                ?>
                                <option value="<?= $type ?>_<?= $lvl ?>">
                                    <?= \App\Models\FlagsModel::getFlagName($type) ?> (<?= __('screens.common.level') ?>
                                    <?= $lvl ?>)
                                </option>
                                <?php
                            endfor;
                        endforeach;
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="text" name="to_username" placeholder="<?= __('screens.flags.player_name_placeholder') ?>" required>
                    <input type="hidden" name="to_user_id" value="0">
                    <button type="submit" class="btn"><?= __('screens.flags.create') ?></button>
                </td>
            </tr>
        </table>
    </form>

    <!-- Tribe's Trade Offers -->
    <h3><?= __('screens.flags.tribe_offers') ?></h3>
    <?php if (empty($pending_trades)): ?>
        <p><?= __('screens.flags.no_offers') ?></p>
    <?php else: ?>
        <table class="vis">
            <tr>
                <th><?= __('screens.flags.from') ?></th>
                <th><?= __('screens.flags.to') ?></th>
                <th><?= __('screens.flags.offer') ?></th>
                <th><?= __('screens.flags.search_for') ?></th>
                <th><?= __('screens.flags.action') ?></th>
            </tr>
            <?php foreach ($pending_trades as $trade): ?>
                <tr>
                    <td><?= htmlspecialchars($trade['from_username']) ?></td>
                    <td><?= htmlspecialchars($trade['to_username']) ?></td>
                    <td>
                        <img src="/graphic/flags/small/<?= $trade['offered_flag_type'] ?>_<?= $trade['offered_flag_level'] ?>.png"
                            alt="<?= \App\Models\FlagsModel::getFlagName($trade['offered_flag_type']) ?>"
                            onerror="this.src='/graphic/flags/flag_disabled.png'">
                        <?= \App\Models\FlagsModel::getFlagName($trade['offered_flag_type']) ?>
                        (<?= $trade['offered_flag_level'] ?>)
                    </td>
                    <td>
                        <img src="/graphic/flags/small/<?= $trade['requested_flag_type'] ?>_<?= $trade['requested_flag_level'] ?>.png"
                            alt="<?= \App\Models\FlagsModel::getFlagName($trade['requested_flag_type']) ?>"
                            onerror="this.src='/graphic/flags/flag_disabled.png'">
                        <?= \App\Models\FlagsModel::getFlagName($trade['requested_flag_type']) ?>
                        (<?= $trade['requested_flag_level'] ?>)
                    </td>
                    <td>
                        <?php if ($trade['to_user_id'] == $user['id']): ?>
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="action" value="accept_trade">
                                <input type="hidden" name="trade_id" value="<?= $trade['id'] ?>">
                                <button type="submit" class="btn"><?= __('screens.flags.accept') ?></button>
                            </form>
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="action" value="reject_trade">
                                <input type="hidden" name="trade_id" value="<?= $trade['id'] ?>">
                                <button type="submit" class="btn btn-cancel"><?= __('screens.flags.reject') ?></button>
                            </form>
                        <?php else: ?>
                            <em><?= __('screens.flags.waiting') ?></em>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <!-- Your Offers -->
    <h3><?= __('screens.flags.my_offers') ?></h3>
    <?php if (empty($my_offers)): ?>
        <p><?= __('screens.flags.no_my_offers') ?></p>
    <?php else: ?>
        <table class="vis">
            <tr>
                <th><?= __('screens.flags.offer') ?></th>
                <th><?= __('screens.flags.search_for') ?></th>
                <th><?= __('screens.flags.to') ?></th>
                <th><?= __('screens.flags.created_at') ?></th>
                <th><?= __('screens.flags.action') ?></th>
            </tr>
            <?php foreach ($my_offers as $offer): ?>
                <tr>
                    <td>
                        <img src="/graphic/flags/small/<?= $offer['offered_flag_type'] ?>_<?= $offer['offered_flag_level'] ?>.png"
                            title="<?= \App\Models\FlagsModel::getFlagName($offer['offered_flag_type']) ?>">
                        <?= \App\Models\FlagsModel::getFlagName($offer['offered_flag_type']) ?>
                        (<?= $offer['offered_flag_level'] ?>)
                    </td>
                    <td>
                        <img src="/graphic/flags/small/<?= $offer['requested_flag_type'] ?>_<?= $offer['requested_flag_level'] ?>.png"
                            title="<?= \App\Models\FlagsModel::getFlagName($offer['requested_flag_type']) ?>">
                        <?= \App\Models\FlagsModel::getFlagName($offer['requested_flag_type']) ?>
                        (<?= $offer['requested_flag_level'] ?>)
                    </td>
                    <td><?= $offer['to_username'] ? htmlspecialchars($offer['to_username']) : __('screens.flags.tribe_all') ?></td>
                    <td><?= date('d/m/Y H:i', $offer['created_at']) ?></td>
                    <td>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="action" value="cancel_trade">
                            <input type="hidden" name="trade_id" value="<?= $offer['id'] ?>">
                            <button type="submit" class="btn btn-cancel"><?= __('screens.flags.cancel') ?></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
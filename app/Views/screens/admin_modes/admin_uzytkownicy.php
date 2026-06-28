<h2><i class="fas fa-users"></i> <?= __('admin.users.manage_players') ?></h2>
<p style="color: #5c3a1e;"><?= __('admin.users.manage_desc') ?></p>

<div class="admin-card">
    <h3><i class="fas fa-search"></i> <?= __('admin.users.search_player') ?></h3>
    <form action="<?= $adminBaseUrl ?>&mode=uzytkownicy" method="get">
        <input type="hidden" name="village" value="<?= $village['id'] ?>">
        <input type="hidden" name="screen" value="admin">
        <input type="hidden" name="mode" value="uzytkownicy">
        <table class="vis" width="100%">
            <tr>
                <td width="150"><strong><?= __('admin.users.player_name') ?></strong></td>
                <td>
                    <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                        style="width: 300px;">
                    <button type="submit" class="btn" style="background: #2196f3; border-color: #1976d2; color: white;"><i class="fas fa-search"></i> <?= __('admin.users.search_btn') ?></button>
                </td>
            </tr>
        </table>
    </form>
</div>

<div class="admin-card">
    <h3><i class="fas fa-list"></i> <?= __('admin.users.player_list') ?></h3>
    <table class="vis" width="100%">
        <tr>
            <th><?= __('admin.users.col_id') ?></th>
            <th><?= __('admin.users.col_name') ?></th>
            <th><?= __('admin.users.col_points') ?></th>
            <th><?= __('admin.users.col_villages') ?></th>
            <th><?= __('admin.users.col_rank') ?></th>
            <th><?= __('admin.users.col_actions') ?></th>
        </tr>
        <?php if (!empty($players)): ?>
            <?php foreach ($players as $player): ?>
                <tr>
                    <td><?= $player['id'] ?></td>
                    <td>
                        <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $player['id'] ?>">
                            <?= htmlspecialchars($player['username']) ?>
                        </a>
                    </td>
                    <td align="right"><?= number_format($player['points'] ?? 0, 0, ',', '.') ?></td>
                    <td align="center"><?= $player['villages'] ?? 0 ?></td>
                    <td align="center"><?= $player['rang'] ?? 0 ?></td>
                    <td align="center">
                        <a href="<?= $adminBaseUrl ?>&mode=bany&gracz=<?= $player['id'] ?>"
                            class="btn" style="padding: 2px 8px; font-size: 10px;">
                            <i class="fas fa-ban"></i> <?= __('admin.users.action_ban') ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" align="center" style="padding: 20px;">
                    <i class="fas fa-info-circle" style="color: #999; font-size: 24px;"></i><br>
                    <?= __('admin.users.no_players') ?>
                </td>
            </tr>
        <?php endif; ?>
    </table>
</div>
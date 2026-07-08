<?php
$tab = $_GET['tab'] ?? 'list';
$is_standalone_admin = (strpos($_SERVER['REQUEST_URI'], 'admin.php') !== false);
$adminBaseUrl = $is_standalone_admin ? 'admin.php?action=dashboard' : 'game.php?village=' . $village['id'] . '&screen=admin';
?>

<h2><i class="fas fa-users"></i> Gestão de Jogadores & Banimentos</h2>
<p style="color: #5c3a1e;">Pesquise contas de jogadores, audite perfis e aplique/remova banimentos temporários ou permanentes.</p>

<!-- Tabs Navigation -->
<div class="diamond-tabs-container" style="display: flex; border-bottom: 2px solid #8b5a2b; margin-bottom: 20px; gap: 5px;">
    <a href="<?= $adminBaseUrl ?>&mode=jogadores&tab=list" class="diamond-tab <?= $tab === 'list' ? 'active' : '' ?>">
        <i class="fas fa-users"></i> Lista de Jogadores
    </a>
    <a href="<?= $adminBaseUrl ?>&mode=jogadores&tab=bans" class="diamond-tab <?= $tab === 'bans' ? 'active' : '' ?>">
        <i class="fas fa-gavel"></i> Banimentos
    </a>
</div>

<!-- ============================================== -->
<!-- TAB 1: PLAYERS LIST (LISTA DE JOGADORES)      -->
<!-- ============================================== -->
<?php if ($tab === 'list'): ?>
    <div class="admin-card" style="margin-bottom: 20px;">
        <h3><i class="fas fa-search"></i> <?= __('admin.users.search_player') ?></h3>
        <form action="<?= $adminBaseUrl ?>" method="get">
            <?php if (!$is_standalone_admin): ?>
                <input type="hidden" name="village" value="<?= $village['id'] ?>">
                <input type="hidden" name="screen" value="admin">
            <?php else: ?>
                <input type="hidden" name="action" value="dashboard">
            <?php endif; ?>
            <input type="hidden" name="mode" value="jogadores">
            <input type="hidden" name="tab" value="list">
            
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

    <div class="admin-card" style="margin-bottom: 30px;">
        <h3><i class="fas fa-list"></i> <?= __('admin.users.player_list') ?></h3>
        <table class="vis" width="100%">
            <tr>
                <th><?= __('admin.users.col_id') ?></th>
                <th><?= __('admin.users.col_name') ?></th>
                <th><?= __('admin.users.col_points') ?></th>
                <th><?= __('admin.users.col_villages') ?></th>
                <th><?= __('admin.users.col_rank') ?></th>
                <th width="150"><?= __('admin.users.col_actions') ?></th>
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
                            <a href="<?= $adminBaseUrl ?>&mode=jogadores&tab=bans&gracz=<?= $player['id'] ?>"
                                class="btn" style="padding: 2px 8px; font-size: 10px; background: #8b0000; color: white; border-color: #5c0000;">
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
<?php endif; ?>

<!-- ============================================== -->
<!-- TAB 2: BANS MANAGEMENT (BANIMENTOS)           -->
<!-- ============================================== -->
<?php if ($tab === 'bans'): ?>
    <div class="admin-card" style="margin-bottom: 20px;">
        <?php if (!empty($gr['username'])): ?>
            <h3><i class="fas fa-user-slash"></i> <?= __('admin.bans.ban_player') ?>: <?= htmlspecialchars($gr['username']) ?></h3>
        <?php else: ?>
            <h3><i class="fas fa-user-slash"></i> <?= __('admin.bans.ban_player') ?></h3>
        <?php endif; ?>

        <form action="<?= $adminBaseUrl ?>&mode=jogadores&tab=bans&gracz=<?= $gracz ?? 0 ?>" method="post">
            <table class="vis" width="100%">
                <tr>
                    <td width="150"><strong><?= __('admin.bans.player_nick') ?></strong></td>
                    <td>
                        <input id="id" name="id" class="text" value="<?= htmlspecialchars($gr['username'] ?? '') ?>"
                            type="text" <?php if (!empty($gr['username'])) echo 'readonly'; ?> style="width: 200px;">
                        <?php if (empty($gr['username'])): ?>
                            <br><small><?= __('admin.bans.insert_id_or_name') ?></small>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.bans.duration') ?></strong></td>
                    <td>
                        <label><input type="radio" name="czas" value="1" /> <?= __('admin.bans.second') ?></label><br>
                        <label><input type="radio" name="czas" value="60" /> <?= __('admin.bans.minute') ?></label><br>
                        <label><input type="radio" name="czas" value="3600" /> <?= __('admin.bans.hour') ?></label><br>
                        <label><input type="radio" checked="checked" name="czas" value="86400" /> <?= __('admin.bans.day') ?></label><br>
                        <label><input type="radio" name="czas" value="604800" /> <?= __('admin.bans.week') ?></label><br>
                        <label><input type="radio" name="czas" value="2419200" /> <?= __('admin.bans.month') ?></label><br>
                        <label><input type="radio" name="czas" value="29030400" /> <?= __('admin.bans.year') ?></label>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.bans.ban_end') ?></strong></td>
                    <td>
                        <input id="koniec" name="koniec" class="text" value="<?= date('d.m.Y H:i', time() + 86400) ?>"
                            type="text" style="width: 200px;">
                        <i class="far fa-calendar-alt"></i>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.bans.reason') ?></strong></td>
                    <td>
                        <textarea style="height:80px;width:300px;" id="message" name="powod"><?= __('admin.bans.default_reason') ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <button name="sub" type="submit" class="btn" style="background: #e53935; border-color: #b71c1c; color: white;"><i class="fas fa-ban"></i> <?= __('admin.bans.action_ban') ?></button>
                        <button type="reset" class="btn" style="background: #555; color: white;"><i class="fas fa-eraser"></i> <?= __('admin.bans.action_clear') ?></button>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <div class="admin-card" style="margin-bottom: 30px;">
        <h3><i class="fas fa-list"></i> <?= __('admin.bans.banned_players') ?></h3>
        <table class="vis" width="100%">
            <tr>
                <th><?= __('admin.bans.col_nick') ?></th>
                <th><?= __('admin.bans.col_ban_end') ?></th>
                <th width="150"><?= __('admin.bans.col_actions') ?></th>
            </tr>
            <?php if (!empty($bany)): ?>
                <?php foreach ($bany as $ban): ?>
                    <tr>
                        <td>
                            <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $ban['id'] ?>"
                                style="color: #8b0000; font-weight: bold;">
                                <i class="fas fa-user-circle"></i> <?= htmlspecialchars($ban['username']) ?>
                            </a>
                        </td>
                        <td>
                            <?php
                            $is_permanent = ($ban['ban_end'] ?? 0) > time() + 315360000; // > 10 years
                            if ($is_permanent) {
                                echo '<span style="color:red; font-weight:bold;">' . __('admin.bans.permanent') . '</span>';
                            } else {
                                echo date('d.m.Y H:i:s', $ban['ban_end'] ?? 0);
                            }
                            ?>
                        </td>
                        <td align="center">
                            <a href="<?= $adminBaseUrl ?>&mode=jogadores&tab=bans&action=unban&gracz=<?= $ban['id'] ?>"
                                class="btn" style="padding: 2px 8px; font-size: 10px; background: #4caf50; color: white; border-color: #2e7d32;">
                                <i class="fas fa-check"></i> <?= __('admin.bans.action_unban') ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" align="center" style="padding: 20px;">
                        <i class="fas fa-check-circle" style="color: green; font-size: 24px;"></i><br>
                        <?= __('admin.bans.no_bans') ?>
                    </td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <script type="text/javascript">
        document.querySelectorAll('input[name="czas"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                var duration = parseInt(this.value);
                var now = new Date();
                var targetDate = new Date(now.getTime() + duration * 1000);

                var day = ("0" + targetDate.getDate()).slice(-2);
                var month = ("0" + (targetDate.getMonth() + 1)).slice(-2);
                var year = targetDate.getFullYear();
                var hours = ("0" + targetDate.getHours()).slice(-2);
                var minutes = ("0" + targetDate.getMinutes()).slice(-2);

                var formattedDate = day + "." + month + "." + year + " " + hours + ":" + minutes;

                document.getElementById('koniec').value = formattedDate;
            });
        });
    </script>
<?php endif; ?>

<style>
.diamond-tab {
    display: inline-block;
    padding: 10px 20px;
    background: #e6dfd3;
    border: 1px solid #8b5a2b;
    border-bottom: none;
    border-radius: 4px 4px 0 0;
    color: #5c3a1e;
    text-decoration: none;
    font-weight: bold;
    font-size: 12px;
    transition: all 0.2s ease-in-out;
}
.diamond-tab:hover {
    background: #d4cbb8;
}
.diamond-tab.active {
    background: #8b5a2b;
    color: #F4E4BC;
}
</style>

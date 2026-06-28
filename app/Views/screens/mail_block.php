<div class="mail-container">
    <h3 style="margin-bottom: 20px; color: var(--medieval-brown);"><?= __('screens.mail.block_senders_title') ?></h3>

    <?php
    // Handle block/unblock actions
    if (isset($_GET['action']) && isset($_GET['id']) && isset($_GET['h']) && $_GET['h'] == $hkey) {
        $targetUserId = (int) $_GET['id'];

        if ($_GET['action'] == 'block_id') {
            // Add to blocked list
            $db->query(
                "INSERT IGNORE INTO blocked_users (user_id, blocked_user_id, blocked_at) VALUES (?, ?, ?)",
                [$user['id'], $targetUserId, time()]
            );
            echo '<div class="mail-view-btn" style="background: var(--medieval-green); color: white; margin-bottom: 15px; text-align: center;">' . __('screens.mail.sender_blocked_success') . '</div>';
        } elseif ($_GET['action'] == 'unblock') {
            // Remove from blocked list
            $db->query(
                "DELETE FROM blocked_users WHERE user_id = ? AND blocked_user_id = ?",
                [$user['id'], $targetUserId]
            );
            echo '<div class="mail-view-btn" style="background: var(--medieval-green); color: white; margin-bottom: 15px; text-align: center;">' . __('screens.mail.sender_unblocked_success') . '</div>';
        }
    }

    // Get blocked users list
    $blockedUsers = $db->fetchAll(
        "SELECT bu.blocked_user_id, bu.blocked_at, u.username 
         FROM blocked_users bu
         LEFT JOIN users u ON u.id = bu.blocked_user_id
         WHERE bu.user_id = ?
         ORDER BY bu.blocked_at DESC",
        [$user['id']]
    );
    ?>

    <!-- Block New User Form -->
    <div
        style="background: white; border: 1px solid var(--border-ornate); border-radius: 4px; padding: 20px; margin-bottom: 20px;">
        <h4 style="margin-top: 0; color: var(--medieval-brown);"><?= __('screens.mail.block_new_sender') ?></h4>
        <p style="color: #666; font-size: 13px;"><?= __('screens.mail.enter_player_name_to_block') ?></p>

        <form action="game.php?village=<?= $village['id'] ?>&screen=mail&mode=block&action=block_name&h=<?= $hkey ?>"
            method="post" style="display: flex; gap: 10px; align-items: center;">
            <input type="text" name="username" placeholder="<?= __('screens.mail.player_name_placeholder') ?>"
                class="autocomplete ui-autocomplete-input" data-type="player"
                style="flex: 1; padding: 8px; border: 1px solid var(--border-ornate); border-radius: 3px;" required>
            <button type="submit" class="mail-view-btn danger">🚫 <?= __('screens.mail.block_button') ?></button>
        </form>

        <?php
        // Handle block by username
        if (isset($_POST['username']) && isset($_GET['action']) && $_GET['action'] == 'block_name') {
            $username = trim($_POST['username']);
            $targetUser = $db->fetch("SELECT id FROM users WHERE username = ?", [$username]);

            if ($targetUser) {
                $db->query(
                    "INSERT IGNORE INTO blocked_users (user_id, blocked_user_id, blocked_at) VALUES (?, ?, ?)",
                    [$user['id'], $targetUser['id'], time()]
                );
                echo '<div class="mail-view-btn" style="background: var(--medieval-green); color: white; margin-top: 15px; text-align: center;">' . __('screens.mail.sender_blocked_success') . '</div>';
                // Refresh blocked users list
                $blockedUsers = $db->fetchAll(
                    "SELECT bu.blocked_user_id, bu.blocked_at, u.username 
                     FROM blocked_users bu
                     LEFT JOIN users u ON u.id = bu.blocked_user_id
                     WHERE bu.user_id = ?
                     ORDER BY bu.blocked_at DESC",
                    [$user['id']]
                );
            } else {
                echo '<div class="mail-view-btn danger" style="margin-top: 15px; text-align: center;">' . __('screens.mail.player_not_found') . '</div>';
            }
        }
        ?>
    </div>

    <!-- Blocked Users List -->
    <div style="background: white; border: 1px solid var(--border-ornate); border-radius: 4px; padding: 20px;">
        <h4 style="margin-top: 0; color: var(--medieval-brown);">
            <?= __('screens.mail.blocked_senders_count', ['count' => count($blockedUsers)]) ?>
        </h4>

        <?php if (count($blockedUsers) > 0): ?>
            <div class="mail-list">
                <?php foreach ($blockedUsers as $blocked): ?>
                    <div class="mail-card" style="background: #fff9e6;">
                        <div class="mail-icon" style="font-size: 24px;">🚫</div>

                        <div class="mail-content">
                            <div class="mail-header">
                                <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $blocked['blocked_user_id'] ?>"
                                    class="mail-subject">
                                    <?= htmlspecialchars($blocked['username'] ?? __('screens.mail.unknown_player')) ?>
                                </a>
                            </div>

                            <div class="mail-meta">
                                <span class="mail-date">
                                    <?= __('screens.mail.blocked_on') ?>         <?= date('d.m.Y H:i', $blocked['blocked_at']) ?>
                                </span>
                            </div>
                        </div>

                        <div class="mail-actions" style="opacity: 1;">
                            <a href="game.php?village=<?= $village['id'] ?>&screen=mail&mode=block&action=unblock&id=<?= $blocked['blocked_user_id'] ?>&h=<?= $hkey ?>"
                                class="mail-view-btn" onclick="return confirm('<?= __('screens.mail.confirm_unblock') ?>')">
                                ✓ <?= __('screens.mail.unblock_button') ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="mail-empty">
                <div class="mail-empty-icon">✅</div>
                <div class="mail-empty-text"><?= __('screens.mail.no_blocked_senders') ?></div>
                <p style="color: #999; font-size: 13px; margin-top: 10px;">
                    <?= __('screens.mail.no_blocked_senders_info') ?>
                </p>
            </div>
        <?php endif; ?>
    </div>

    <div
        style="margin-top: 20px; padding: 15px; background: var(--parchment-light); border: 1px solid var(--border-ornate); border-radius: 4px;">
        <p style="margin: 0; color: #666; font-size: 13px;">
            <strong>ℹ️ <?= __('screens.mail.note_label') ?></strong> <?= __('screens.mail.block_sender_note') ?>
        </p>
    </div>
</div>
<h2><i class="fas fa-headset"></i> <?= __('admin.mail.title') ?></h2>
<p style="color: #5c3a1e;"><?= __('admin.mail.desc') ?></p>

<?php if (!empty($error)): ?>
    <div class="admin-alert error">
        <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="admin-alert success">
        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<div class="admin-card">
    <h3><i class="fas fa-chart-bar"></i> <?= __('admin.mail.stats') ?></h3>
    <table class="vis" width="100%">
        <tr>
            <td width="33%" align="center" style="padding: 15px;">
                <div style="font-size: 32px; font-weight: bold; color: #f44336;"><?= $stats['new'] ?? 0 ?></div>
                <div style="color: #666;"><?= __('admin.mail.tk_new') ?></div>
            </td>
            <td width="33%" align="center" style="padding: 15px; border-left: 1px solid #ddd;">
                <div style="font-size: 32px; font-weight: bold; color: #2196f3;"><?= $stats['all'] ?? 0 ?></div>
                <div style="color: #666;"><?= __('admin.mail.tk_total') ?></div>
            </td>
            <td width="33%" align="center" style="padding: 15px; border-left: 1px solid #ddd;">
                <div style="font-size: 32px; font-weight: bold; color: #4caf50;"><?= $stats['closed'] ?? 0 ?></div>
                <div style="color: #666;"><?= __('admin.mail.tk_closed') ?></div>
            </td>
        </tr>
    </table>
</div>

<div class="admin-card">
    <h3><i class="fas fa-filter"></i> <?= __('admin.mail.filter_tickets') ?></h3>
    <div style="margin-bottom: 15px;">
        <a href="<?= $adminBaseUrl ?>&mode=mail&filter=new"
            class="btn <?= $filter == 'new' ? 'active' : '' ?>" style="margin-right: 10px;">
            <i class="fas fa-inbox"></i> <?= __('admin.mail.f_new') ?> (<?= $stats['new'] ?>)
        </a>
        <a href="<?= $adminBaseUrl ?>&mode=mail&filter=all"
            class="btn <?= $filter == 'all' ? 'active' : '' ?>" style="margin-right: 10px; background: #ff9800; border-color: #e65100; color: white;">
            <i class="fas fa-list"></i> <?= __('admin.mail.f_all') ?> (<?= $stats['all'] ?>)
        </a>
        <a href="<?= $adminBaseUrl ?>&mode=mail&filter=closed"
            class="btn <?= $filter == 'closed' ? 'active' : '' ?>">
            <i class="fas fa-check"></i> <?= __('admin.mail.f_closed') ?> (<?= $stats['closed'] ?>)
        </a>
    </div>
</div>

<div class="admin-card">
    <?php if (isset($_GET['view'])): ?>
        <?php
        // Find the ticket being viewed
        $viewTicket = null;
        foreach ($tickets as $t) {
            if ($t['id'] == $_GET['view']) {
                $viewTicket = $t;
                break;
            }
        }
        ?>

        <?php if ($viewTicket): ?>
            <!-- Single Ticket View (Chat Style) -->
            <div style="margin-bottom: 15px;">
                <a href="<?= $adminBaseUrl ?>&mode=mail&filter=<?= $filter ?>" class="btn">
                    <i class="fas fa-arrow-left"></i> <?= __('admin.mail.back_list') ?>
                </a>
            </div>

            <h3><i class="fas fa-comments"></i> <?= htmlspecialchars($viewTicket['subject']) ?></h3>

            <div style="background: #f9f9f9; border: 1px solid #ddd; border-radius: 4px; padding: 15px; margin-bottom: 15px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <div>
                        <strong><?= __('admin.mail.player') ?></strong>
                        <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $viewTicket['user_id'] ?>">
                            <?= htmlspecialchars($viewTicket['username']) ?>
                        </a>
                    </div>
                    <div>
                        <?php if ($viewTicket['status'] == 'open'): ?>
                            <span
                                style="background: #f44336; color: white; padding: 5px 10px; border-radius: 3px; font-size: 11px;">
                                <i class="fas fa-exclamation-circle"></i> <?= __('admin.mail.status_open') ?>
                            </span>
                        <?php else: ?>
                            <span
                                style="background: #4caf50; color: white; padding: 5px 10px; border-radius: 3px; font-size: 11px;">
                                <i class="fas fa-check"></i> <?= __('admin.mail.status_closed') ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Chat Messages -->
            <div
                style="background: #fff; border: 1px solid #ddd; border-radius: 4px; max-height: 500px; overflow-y: auto; margin-bottom: 15px;">
                <!-- Original Message -->
                <div style="padding: 15px; border-bottom: 1px solid #eee;">
                    <div style="margin-bottom: 5px;">
                        <strong style="color: #2196f3;"><?= htmlspecialchars($viewTicket['username']) ?></strong>
                        <small
                            style="color: #999; margin-left: 10px;"><?= date('d/m/Y H:i', strtotime($viewTicket['created_at'])) ?></small>
                    </div>
                    <div style="background: #e3f2fd; padding: 10px; border-radius: 4px; border-left: 3px solid #2196f3;">
                        <?= \App\Helpers\BBCodeHelper::process($viewTicket['message'], $village['id']) ?>
                    </div>
                </div>

                <!-- Responses -->
                <?php if (!empty($viewTicket['responses'])): ?>
                    <?php foreach ($viewTicket['responses'] as $response): ?>
                        <div style="padding: 15px; border-bottom: 1px solid #eee;">
                            <div style="margin-bottom: 5px;">
                                <strong style="color: <?= $response['uid'] == 0 ? '#f44336' : '#2196f3' ?>;">
                                    <?= $response['uid'] == 0 ? '<i class="fas fa-user-shield"></i> ' : '' ?>
                                    <?= htmlspecialchars($response['username']) ?>
                                </strong>
                                <small style="color: #999; margin-left: 10px;"><?= $response['date'] ?></small>
                            </div>
                            <div
                                style="background: <?= $response['uid'] == 0 ? '#fff3e0' : '#e3f2fd' ?>; padding: 10px; border-radius: 4px; border-left: 3px solid <?= $response['uid'] == 0 ? '#ff9800' : '#2196f3' ?>;">
                                <?= \App\Helpers\BBCodeHelper::process($response['message'], $village['id']) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Reply Form -->
            <?php if ($viewTicket['status'] != 'closed'): ?>
                <form method="post"
                    action="<?= $adminBaseUrl ?>&mode=mail&filter=<?= $filter ?>&view=<?= $viewTicket['id'] ?>">
                    <input type="hidden" name="ticket_id" value="<?= $viewTicket['id'] ?>">
                    <div style="background: #fff; border: 1px solid #ddd; border-radius: 4px; padding: 15px; margin-bottom: 15px;">
                        <h4><i class="fas fa-reply"></i> <?= __('admin.mail.reply_title') ?></h4>
                        <?php 
                        echo $this->view('components/bbcode_toolbar', [
                            'textareaId' => 'reply_ticket_view',
                            'prefix' => 'view_'
                        ]);
                        ?>
                        <textarea name="reply" id="reply_ticket_view" rows="5"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"
                            placeholder="<?= __('admin.mail.reply_placeholder') ?>" required></textarea>
                        <div style="margin-top: 10px;">
                            <button type="submit" name="reply_ticket" class="btn" style="padding: 8px 15px;">
                                <i class="fas fa-paper-plane"></i> <?= __('admin.mail.btn_reply') ?>
                            </button>
                            <a href="<?= $adminBaseUrl ?>&mode=mail&action=close&id=<?= $viewTicket['id'] ?>&filter=<?= $filter ?>"
                                class="btn" style="padding: 8px 15px; background: #4caf50; margin-left: 10px;">
                                <i class="fas fa-check"></i> <?= __('admin.mail.btn_close') ?>
                            </a>
                        </div>
                    </div>
                </form>
            <?php else: ?>
                <div style="background: #f5f5f5; border: 1px solid #ddd; border-radius: 4px; padding: 15px; text-align: center;">
                    <p style="color: #666; margin: 0;"><i class="fas fa-lock"></i> <?= __('admin.mail.ticket_is_closed') ?></p>
                    <a href="<?= $adminBaseUrl ?>&mode=mail&action=reopen&id=<?= $viewTicket['id'] ?>&filter=<?= $filter ?>"
                        class="btn" style="padding: 8px 15px; background: #ff9800; margin-top: 10px;">
                        <i class="fas fa-redo"></i> <?= __('admin.mail.btn_reopen') ?>
                    </a>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p style="color: red;"><?= __('admin.mail.not_found') ?></p>
        <?php endif; ?>

    <?php else: ?>
        <!-- Ticket List View -->
        <h3><i class="fas fa-ticket-alt"></i> <?= __('admin.mail.support_tickets') ?></h3>

        <?php if (!empty($tickets)): ?>
            <?php foreach ($tickets as $ticket): ?>
                <div class="<?= ($ticket['new_admin'] == '1') ? 'admin-card' : '' ?>"
                    style="border: 1px solid #ddd; margin-bottom: 15px; border-radius: 4px; background: #f9f9f9; <?= ($ticket['new_admin'] == '1') ? 'border-left: 5px solid #d32f2f;' : '' ?>">
                    <div style="padding: 15px; background: #fff; border-bottom: 1px solid #ddd;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <a href="<?= $adminBaseUrl ?>&mode=mail&filter=<?= $filter ?>&view=<?= $ticket['id'] ?>"
                                    style="font-size: 16px; font-weight: bold; color: #1976d2; text-decoration: none;">
                                    <i class="fas fa-envelope"></i> <?= htmlspecialchars($ticket['subject']) ?>
                                </a>
                                <?php if ($ticket['response_count'] > 0): ?>
                                    <span
                                        style="background: #2196f3; color: white; padding: 2px 6px; border-radius: 10px; font-size: 10px; margin-left: 5px;">
                                        <?= $ticket['response_count'] ?>
                                    </span>
                                <?php endif; ?>
                                <br>
                                <small style="color: #666;">
                                    <?= __('admin.mail.by') ?> <a
                                        href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $ticket['user_id'] ?>">
                                        <?= htmlspecialchars($ticket['username']) ?>
                                    </a> |
                                    <?= date('d/m/Y H:i', strtotime($ticket['created_at'])) ?>
                                </small>
                            </div>
                            <div>
                                <?php if ($ticket['status'] == 'open'): ?>
                                    <span
                                        style="background: #f44336; color: white; padding: 5px 10px; border-radius: 3px; font-size: 11px;">
                                        <i class="fas fa-exclamation-circle"></i> <?= __('admin.mail.status_open') ?>
                                    </span>
                                <?php elseif ($ticket['status'] == 'answered'): ?>
                                    <span
                                        style="background: #2196f3; color: white; padding: 5px 10px; border-radius: 3px; font-size: 11px;">
                                        <i class="fas fa-reply"></i> <?= __('admin.mail.status_answered') ?>
                                    </span>
                                <?php else: ?>
                                    <span
                                        style="background: #4caf50; color: white; padding: 5px 10px; border-radius: 3px; font-size: 11px;">
                                        <i class="fas fa-check"></i> <?= __('admin.mail.status_closed') ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div style="padding: 15px; background: #fff;">
                        <p style="margin: 0; white-space: pre-wrap;"><?= \App\Helpers\BBCodeHelper::process($ticket['message'], $village['id']) ?></p>
                    </div>

                    <?php if (!empty($ticket['admin_reply'])): ?>
                        <div style="padding: 15px; background: #e3f2fd; border-top: 1px solid #ddd;">
                            <strong style="color: #1976d2;"><i class="fas fa-user-shield"></i> <?= __('admin.mail.admin_reply') ?></strong>
                            <p style="margin: 10px 0 0 0; white-space: pre-wrap;"><?= \App\Helpers\BBCodeHelper::process($ticket['admin_reply'], $village['id']) ?></p>
                            <small style="color: #666;">
                                <?= __('admin.mail.answered_at') ?>
                                <?= $ticket['answered_at'] ? date('d/m/Y H:i', strtotime($ticket['answered_at'])) : '-' ?>
                            </small>
                        </div>
                    <?php endif; ?>

                    <div style="padding: 10px 15px; background: #f5f5f5; border-top: 1px solid #ddd;">
                        <a href="<?= $adminBaseUrl ?>&mode=mail&filter=<?= $filter ?>&view=<?= $ticket['id'] ?>"
                            class="btn"
                            style="padding: 5px 10px; font-size: 12px; margin-right: 5px; background: #2196f3; color: white;">
                            <i class="fas fa-eye"></i> <?= __('admin.mail.btn_view') ?>
                        </a>
                        <?php if ($ticket['status'] != 'closed'): ?>
                            <button onclick="toggleReply(<?= $ticket['id'] ?>)" class="btn"
                                style="padding: 5px 10px; font-size: 12px; margin-right: 5px;">
                                <i class="fas fa-reply"></i> <?= __('admin.mail.reply_title') ?>
                            </button>
                            <a href="<?= $adminBaseUrl ?>&mode=mail&action=close&id=<?= $ticket['id'] ?>&filter=<?= $filter ?>"
                                class="btn" style="padding: 5px 10px; font-size: 12px; background: #4caf50;">
                                <i class="fas fa-check"></i> <?= __('admin.mail.btn_close') ?>
                            </a>
                        <?php else: ?>
                            <a href="<?= $adminBaseUrl ?>&mode=mail&action=reopen&id=<?= $ticket['id'] ?>&filter=<?= $filter ?>"
                                class="btn" style="padding: 5px 10px; font-size: 12px; background: #ff9800;">
                                <i class="fas fa-redo"></i> <?= __('admin.mail.btn_reopen') ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div id="reply-<?= $ticket['id'] ?>"
                        style="display: none; padding: 15px; background: #fff; border-top: 1px solid #ddd;">
                        <form method="post"
                            action="<?= $adminBaseUrl ?>&mode=mail&filter=<?= $filter ?>">
                            <input type="hidden" name="ticket_id" value="<?= $ticket['id'] ?>">
                            <?php 
                            echo $this->view('components/bbcode_toolbar', [
                                'textareaId' => 'reply_list_' . $ticket['id'],
                                'prefix' => 'list_' . $ticket['id'] . '_'
                            ]);
                            ?>
                            <textarea name="reply" id="reply_list_<?= $ticket['id'] ?>" rows="5" style="width: 100%; padding: 10px;" placeholder="<?= __('admin.mail.reply_placeholder') ?>"
                                required></textarea>
                            <br><br>
                            <button type="submit" name="reply_ticket" class="btn" style="padding: 8px 15px;">
                                <i class="fas fa-paper-plane"></i> <?= __('admin.mail.btn_reply') ?>
                            </button>
                            <button type="button" onclick="toggleReply(<?= $ticket['id'] ?>)" class="btn"
                                style="padding: 8px 15px; background: #999;">
                                <?= __('admin.mail.btn_cancel') ?>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; padding: 40px; color: #999;">
                <i class="fas fa-inbox" style="font-size: 48px;"></i><br><br>
                <?= __('admin.mail.no_tickets') ?>
            </p>
        <?php endif; ?>
    <?php endif; ?> <!-- End view check -->
</div>

<script>
    function toggleReply(id) {
        var replyDiv = document.getElementById('reply-' + id);
        if (replyDiv.style.display === 'none') {
            replyDiv.style.display = 'block';
        } else {
            replyDiv.style.display = 'none';
        }
    }
</script>

<style>
    .admin-alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
        border-left: 4px solid;
    }

    .admin-alert.error {
        background: #ffebee;
        border-color: #f44336;
        color: #c62828;
    }

    .admin-alert.success {
        background: #e8f5e9;
        border-color: #4caf50;
        color: #2e7d32;
    }

    .btn.active {
        background: #1976d2 !important;
        color: white !important;
    }
</style>
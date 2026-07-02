<?php if (!isset($message_id) || !is_numeric($message_id) || $message_id <= 0): ?>
    <script type="text/javascript">
        function selectAll(form, checked) {
            for (var i = 0; i < form.elements.length; i++) {
                var e = form.elements[i];
                if (e.name.substr(0, 3) == 'id_') {
                    e.checked = checked;
                }
            }
        }
    </script>

    <!-- Mail List View - Inbox -->
    <div class="mail-container">
        <!-- Pagination -->
        <?php if ($num_pages > 1): ?>
            <div class="mail-pagination">
                <?php for ($i = 1; $i <= $num_pages; $i++): ?>
                    <a href="game.php?village=<?= $village['id'] ?>&screen=mail&mode=in&site=<?= $i ?>"
                        class="mail-page-link <?= $site == $i ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>

        <form action="game.php?village=<?= $village['id'] ?>&screen=mail&mode=in&h=<?= $hkey ?>" method="post">

            <!-- Mail Cards -->
            <?php if (count($mails) > 0): ?>
                <div class="mail-list">
                    <?php foreach ($mails as $id => $arr): ?>
                        <div class="mail-card <?= $arr['is_read'] == 0 ? 'unread' : '' ?>">
                            <!-- Checkbox -->
                            <input name="id_<?= $arr['id'] ?>" type="checkbox" class="mail-checkbox" />

                            <!-- Icon -->
                            <!-- <img src="graphic/<?= $arr['is_read'] == 0 ? 'new_mail' : ($arr['is_answered'] == 1 ? 'answered_mail' : 'read_mail') ?>.png"
                                class="mail-icon"
                                alt="<?= $arr['is_read'] == 0 ? __('screens.mail.new_badge') : ($arr['is_answered'] == 1 ? __('screens.mail.answered_badge') : __('screens.mail.read_badge')) ?>"> -->

                            <!-- Content -->
                            <div class="mail-content">
                                <div class="mail-header">
                                    <a href="game.php?village=<?= $village['id'] ?>&screen=mail&mode=in&view=<?= $arr['id'] ?>"
                                        class="mail-subject">
                                        <?= htmlspecialchars($arr['subject']) ?>
                                    </a>

                                    <div class="mail-badges">
                                        <?php if ($arr['is_read'] == 0): ?>
                                            <span class="mail-badge new"><?= __('screens.mail.new_badge') ?></span>
                                        <?php endif; ?>
                                        <?php if ($arr['is_answered'] == 1): ?>
                                            <span class="mail-badge answered"><?= __('screens.mail.answered_badge') ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if (!empty($arr['text'])): ?>
                                    <div class="mail-preview">
                                        <?php 
                                            $processedText = \App\Helpers\BBCodeHelper::process($arr['text'], $user['id']);
                                            $cleanText = strip_tags($processedText);
                                        ?>
                                        <?= htmlspecialchars(mb_substr($cleanText, 0, 100)) ?>
                                        <?= mb_strlen($cleanText) > 100 ? '...' : '' ?>
                                    </div>
                                <?php endif; ?>

                                <div class="mail-meta">
                                    <span>
                                        <?= __('screens.mail.from') ?>
                                        <?php if ($arr['from_id'] == -1): ?>
                                            <strong class="mail-from"><?= htmlspecialchars($arr['from_username']) ?></strong>
                                        <?php else: ?>
                                            <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $arr['from_id'] ?>"
                                                class="mail-from">
                                                <?= htmlspecialchars($arr['from_username']) ?>
                                            </a>
                                        <?php endif; ?>
                                    </span>
                                    <span class="mail-date"><?= $arr['time'] ?></span>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="mail-actions">
                                <?php if ($arr['from_id'] != -1): ?>
                                    <a href="game.php?village=<?= $village['id'] ?>&screen=mail&mode=new&reply=<?= $arr['id'] ?>"
                                        class="mail-action-btn" title="<?= __('screens.mail.reply_tooltip') ?: 'Responder' ?>">
                                        ↩
                                    </a>
                                <?php endif; ?>
                                <a href="game.php?village=<?= $village['id'] ?>&screen=mail&action=arch&id=<?= $arr['id'] ?>&mode=in&h=<?= $hkey ?>"
                                    class="mail-action-btn" title="<?= __('screens.mail.archive_tooltip') ?: 'Arquivar' ?>">
                                    📁
                                </a>
                                <a href="game.php?village=<?= $village['id'] ?>&screen=mail&action=del&id=<?= $arr['id'] ?>&mode=in&h=<?= $hkey ?>"
                                    class="mail-action-btn delete" title="<?= __('screens.mail.delete_tooltip') ?: 'Excluir' ?>"
                                    onclick="return confirm('<?= __('screens.mail.confirm_delete') ?>')">
                                    🗑
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="mail-empty">
                    <div class="mail-empty-icon">📭</div>
                    <div class="mail-empty-text"><?= __('screens.mail.empty_inbox') ?></div>
                </div>
            <?php endif; ?>

            <!-- Toolbar (moved below list) -->
            <div class="mail-toolbar">
                <div class="mail-toolbar-group">
                    <label class="mail-select-all">
                        <input name="all" type="checkbox" onclick="selectAll(this.form, this.checked)">
                        <span><?= __('screens.mail.select_all') ?></span>
                    </label>
                </div>

                <div class="mail-toolbar-separator"></div>

                <div class="mail-toolbar-group">
                    <input type="submit" value="<?= __('screens.mail.delete_button') ?>" name="del"
                        class="btn btn-cancel" />
                    <input type="submit" value="<?= __('screens.mail.archive_button') ?>" name="arch" class="btn" />
                </div>

                <div style="flex: 1"></div>

                <div class="mail-toolbar-group">
                    <span style="font-size: 12px; color: #666;">
                        <?= count($mails) ?>
                        <?= count($mails) != 1 ? __('screens.mail.messages') : __('screens.mail.message') ?>
                    </span>
                </div>
            </div>

        </form>
    </div>

<?php else: ?>
    <!-- Single Message View -->
    <?php if (empty($error)): ?>
        <?php if ($mail['from_id'] == -1): ?>
            <!-- System/Admin Massmail View (Full Message, No Chat) -->
            <div class="mail-view">
                <div class="mail-view-header">
                    <h3 class="mail-view-subject"><?= htmlspecialchars($mail['subject']) ?></h3>
                    <div class="mail-view-meta">
                        <div class="mail-view-meta-item">
                            <span class="mail-view-meta-label"><?= __('screens.mail.from') ?></span>
                            <span><strong><?= htmlspecialchars($mail['from_username']) ?></strong></span>
                        </div>
                        <div class="mail-view-meta-item">
                            <span class="mail-view-meta-label"><?= __('screens.mail.date') ?></span>
                            <span><?= date('d.m.Y H:i', $mail['time']) ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="mail-view-actions">
                    <a href="game.php?village=<?= $village['id'] ?>&screen=mail&mode=<?= $mode ?>" class="mail-view-btn">
                        ← <?= __('screens.mail.back_to_inbox') ?>
                    </a>
                    <a href="game.php?village=<?= $village['id'] ?>&screen=mail&action=arch&id=<?= $mail['id'] ?>&mode=<?= $mode ?>&h=<?= $hkey ?>" class="mail-view-btn">
                        📁 <?= __('screens.mail.archive_button') ?>
                    </a>
                    <a href="game.php?village=<?= $village['id'] ?>&screen=mail&action=del&id=<?= $mail['id'] ?>&mode=<?= $mode ?>&h=<?= $hkey ?>" class="mail-view-btn danger" onclick="return confirm('<?= __('screens.mail.confirm_delete') ?>')">
                        🗑 <?= __('screens.mail.delete_button') ?>
                    </a>
                </div>
                
                <div class="mail-view-body" style="background: var(--parchment-light); border-top: 1px solid var(--border-ornate); padding: 25px; min-height: 150px; color: var(--medieval-brown);">
                    <?= \App\Helpers\BBCodeHelper::process($mail['text'], $user['id']) ?>
                </div>
            </div>
        <?php else: ?>
            <!-- WhatsApp/Messenger style Chat View for regular players -->
            <?php
            // Build a list of all messages in chronological order (including the current mail)
            $chatMessages = [];
            $foundMail = false;
            if (isset($conversation) && !empty($conversation)) {
                foreach ($conversation as $msg) {
                    // Deduplicate by database ID if available
                    if ($msg['id'] == $mail['id']) {
                        $foundMail = true;
                    }
                    $chatMessages[] = $msg;
                }
            }
            if (!$foundMail) {
                $mailMsg = $mail;
                $mailMsg['time_formatted'] = date('d.m.Y H:i', $mail['time']);
                $mailMsg['mail_type'] = ($mail['from_id'] == $user['id']) ? 'out' : 'in';
                $chatMessages[] = $mailMsg;
            }
            
            // Always sort chronologically (ascending time: oldest to newest)
            usort($chatMessages, function($a, $b) {
                return $a['time'] - $b['time'];
            });
            
            $other_username = ($mail['from_id'] == $user['id']) ? $mail['to_username'] : $mail['from_username'];
            $other_user_id = ($mail['from_id'] == $user['id']) ? $mail['to_id'] : $mail['from_id'];
            $reply_subject = $mail['subject'];
            if (stripos($reply_subject, 'Re:') !== 0) {
                $reply_subject = 'Re: ' . $reply_subject;
            }
            ?>
            <div class="mail-chat-container">
                <!-- Chat Header -->
                <div class="mail-chat-header">
                    <a href="game.php?village=<?= $village['id'] ?>&screen=mail&mode=in" class="mail-chat-back" title="<?= __('screens.mail.back_to_inbox') ?>">
                        ←
                    </a>
                    <div class="mail-chat-header-info">
                        <div class="mail-chat-partner">
                            <?php if ($other_user_id == -1): ?>
                                <strong><?= htmlspecialchars($other_username) ?></strong>
                            <?php else: ?>
                                <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $other_user_id ?>">
                                    <?= htmlspecialchars($other_username) ?>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="mail-chat-subject"><?= htmlspecialchars($mail['subject']) ?></div>
                    </div>
                    <div class="mail-chat-actions">
                        <a href="game.php?village=<?= $village['id'] ?>&screen=mail&action=arch&id=<?= $mail['id'] ?>&mode=<?= $mode ?>&h=<?= $hkey ?>"
                            class="mail-chat-action-btn" title="<?= __('screens.mail.archive_button') ?>">
                            📁
                        </a>
                        <a href="game.php?village=<?= $village['id'] ?>&screen=mail&action=del&id=<?= $mail['id'] ?>&mode=<?= $mode ?>&h=<?= $hkey ?>"
                            class="mail-chat-action-btn danger" onclick="return confirm('<?= __('screens.mail.confirm_delete') ?>')" title="<?= __('screens.mail.delete_button') ?>">
                            🗑
                        </a>
                    </div>
                </div>

                <!-- Chat Window -->
                <div class="mail-chat-window" id="chatWindow">
                    <div class="mail-chat-messages">
                        <?php foreach ($chatMessages as $msg): ?>
                            <?php 
                                $isSent = ($msg['from_id'] == $user['id']);
                                $bubbleClass = $isSent ? 'sent' : 'received';
                            ?>
                            <div class="chat-bubble-wrapper <?= $bubbleClass ?>">
                                <?php if (!$isSent): ?>
                                    <span class="chat-bubble-sender"><?= htmlspecialchars($msg['from_username']) ?></span>
                                <?php endif; ?>
                                <div class="chat-bubble <?= $bubbleClass ?>">
                                    <div class="chat-text">
                                        <?php 
                                            $msgText = $msg['text'];
                                            // Strip legacy "Assunto: ..." if it's at the very beginning of the body
                                            $msgText = preg_replace('/^Assunto:.*(\r\n|\n|$)/i', '', $msgText);
                                            echo \App\Helpers\BBCodeHelper::process($msgText, $user['id']); 
                                        ?>
                                    </div>
                                    <div class="chat-time">
                                        <?= $msg['time_formatted'] ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Inline Reply Area -->
                <?php if ($other_user_id != -1): ?>
                    <div class="mail-reply-box">
                        <form action="game.php?village=<?= $village['id'] ?>&screen=mail&mode=new&reply=<?= $mail['id'] ?>&h=<?= $hkey ?>" method="post" id="chatReplyForm">
                            <input type="hidden" name="to" value="<?= htmlspecialchars($other_username) ?>">
                            <input type="hidden" name="subject" value="<?= htmlspecialchars($reply_subject) ?>">
                            
                            <!-- BBCode Toolbar -->
                            <?php 
                            $textareaId = 'reply_message';
                            $prefix = 'chat_';
                            include __DIR__ . '/../components/bbcode_toolbar.php'; 
                            ?>

                            <div class="mail-reply-input-wrapper">
                                <textarea id="reply_message" name="text" rows="3" placeholder="<?= __('screens.mail.write_reply_placeholder', 'Escreva uma resposta...') ?>" required></textarea>
                                <button type="submit" name="send" class="btn mail-reply-send-btn">
                                    <span>Enviar</span>
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>

            <script type="text/javascript">
                $(document).ready(function() {
                    var chatWindow = document.getElementById('chatWindow');
                    if (chatWindow) {
                        chatWindow.scrollTop = chatWindow.scrollHeight;
                    }
                });
            </script>
        <?php endif; ?>
    <?php else: ?>
        <div class="mail-container">
            <div class="mail-empty">
                <div class="mail-empty-icon">⚠️</div>
                <div class="mail-empty-text"><?= htmlspecialchars($error) ?></div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
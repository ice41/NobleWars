<?php if ($preview): ?>
    <div class="mail-preview-box">
        <h3><?= __('screens.mail.preview_title') ?></h3>
        <div class="mail-preview-content">
            <?= $preview_message ?>
        </div>
    </div>
<?php endif; ?>

<div class="mail-new-container">
    <h2><?= __('screens.mail.compose_title') ?></h2>

    <?php if (!empty($error)): ?>
        <div class="mail-error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form name="header" action="game.php?village=<?= $village['id'] ?>&screen=mail&mode=new&h=<?= $hkey ?>"
        method="post">
        <table class="vis" width="100%">
            <tbody>
                <tr>
                    <td width="15%">
                        <acronym
                            title="<?= __('screens.mail.to_tooltip') ?>"><?= __('screens.mail.to_label') ?></acronym>
                    </td>
                    <td>
                        <input autocomplete="off" title="<?= __('screens.mail.to_tooltip') ?>" id="to" name="to"
                            tabindex="1" size="50" value="<?= htmlspecialchars($inputs['to'] ?? '') ?>"
                            class="autocomplete ui-autocomplete-input" data-type="player" type="text">

                        <div style="display:inline; margin-left: 10px;">
                            <a href="#" id="open-tribe-modal"
                                style="margin-right: 5px;"><?= __('screens.mail.tribe_link') ?></a> |
                            <a href="#" id="open-friends-modal"
                                style="margin-left: 5px;"><?= __('screens.mail.friends_link') ?></a>
                        </div>
                    </td>
                </tr>

                <!-- Tribe Modal -->
                <div id="tribe-modal" class="ui-draggable-handle"
                    style="display: none; position: absolute; z-index: 1000; background: #f4e4bc; border: 2px solid #7d510f; padding: 0; width: 300px;">
                    <div
                        style="background: #c1a264; color: white; padding: 5px 10px; cursor: move; position: relative;">
                        <strong><?= __('screens.mail.tribe_members_title') ?></strong>
                        <a href="#" class="close-modal"
                            style="position: absolute; right: 10px; top: 5px; color: white; text-decoration: none; font-weight: bold;">×</a>
                    </div>
                    <div style="padding: 10px; max-height: 300px; overflow-y: auto;">
                        <?php if (($user['ally'] ?? -1) != -1): ?>
                            <?php
                            // Load tribe members
                            $members = $db->fetchAll(
                                "SELECT id, username FROM users WHERE ally = ? ORDER BY username ASC",
                                [$user['ally']]
                            );
                            ?>
                            <?php if (!empty($members)): ?>
                                <div id="tribe-members-list">
                                    <?php foreach ($members as $member): ?>
                                        <div style="padding: 3px 0;">
                                            <a href="#" class="add-recipient"
                                                data-username="<?= htmlspecialchars($member['username']) ?>"
                                                style="color: #7d510f;">
                                                <?= htmlspecialchars($member['username']) ?>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p style="color: #888;"><em><?= __('screens.mail.no_tribe_members') ?></em></p>
                            <?php endif; ?>
                        <?php else: ?>
                            <p><?= __('screens.mail.not_in_tribe') ?></p>
                        <?php endif; ?>
                    </div>
                    <div style="background: #e8dcc0; padding: 5px 10px; text-align: right;">
                        <a href="#" class="clear-recipients"
                            style="color: #7d510f;"><?= __('screens.mail.clear_recipients') ?></a>
                    </div>
                </div>

                <!-- Friends Modal -->
                <div id="friends-modal" class="ui-draggable-handle"
                    style="display: none; position: absolute; z-index: 1000; background: #f4e4bc; border: 2px solid #7d510f; padding: 0; width: 300px;">
                    <div
                        style="background: #c1a264; color: white; padding: 5px 10px; cursor: move; position: relative;">
                        <strong><?= __('screens.mail.friends_title') ?></strong>
                        <a href="#" class="close-modal"
                            style="position: absolute; right: 10px; top: 5px; color: white; text-decoration: none; font-weight: bold;">×</a>
                    </div>
                    <div style="padding: 10px; max-height: 300px; overflow-y: auto;">
                        <p><?= __('screens.mail.friends_list_label') ?></p>
                        <div id="friends-list">
                            <!-- Friends will be loaded here -->
                            <p style="color: #888;"><em><?= __('screens.mail.no_friends') ?></em></p>
                        </div>
                    </div>
                    <div style="background: #e8dcc0; padding: 5px 10px; text-align: right;">
                        <a href="#" class="clear-recipients"
                            style="color: #7d510f;"><?= __('screens.mail.clear_recipients') ?></a>
                    </div>
                </div>

                <script type="text/javascript">
                    $(document).ready(function () {
                        // Make modals draggable
                        $('#tribe-modal, #friends-modal').draggable({
                            handle: 'div:first',
                            containment: 'window'
                        });

                        // Open tribe modal
                        $('#open-tribe-modal').click(function (e) {
                            e.preventDefault();
                            $('#friends-modal').hide();
                            $('#tribe-modal').css({
                                left: $(this).offset().left,
                                top: $(this).offset().top + 25
                            }).show();
                        });

                        // Open friends modal
                        $('#open-friends-modal').click(function (e) {
                            e.preventDefault();
                            $('#tribe-modal').hide();
                            $('#friends-modal').css({
                                left: $(this).offset().left,
                                top: $(this).offset().top + 25
                            }).show();
                        });

                        // Close modals
                        $('.close-modal').click(function (e) {
                            e.preventDefault();
                            $(this).closest('.ui-draggable-handle').hide();
                        });

                        // Clear recipients
                        $('.clear-recipients').click(function (e) {
                            e.preventDefault();
                            $('#to').val('');
                        });

                        // Add recipient on click
                        $(document).on('click', '.add-recipient', function (e) {
                            e.preventDefault();
                            var username = $(this).data('username');
                            var currentVal = $('#to').val();
                            if (currentVal) {
                                $('#to').val(currentVal + '; ' + username);
                            } else {
                                $('#to').val(username);
                            }
                        });
                    });
                </script>

                <tr>
                    <td>
                        <?= __('screens.mail.subject') ?>
                    </td>
                    <td>
                        <input name="subject" tabindex="2" size="50"
                            value="<?= htmlspecialchars($inputs['subject'] ?? '') ?>" type="text">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <!-- BBCode Toolbar -->
                        <?php 
                        $textareaId = 'message';
                        include __DIR__ . '/../components/bbcode_toolbar.php'; 
                        ?>

                        <!-- Message Textarea -->
                        <textarea id="message" name="text" tabindex="3" rows="20" cols="60"
                            style="width: 100%; margin-top: 10px;"><?= htmlspecialchars($inputs['text'] ?? '') ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center; padding: 15px;">
                        <input type="submit" name="send" value="<?= __('screens.mail.send_button') ?>" class="btn" tabindex="4">
                        <input type="submit" name="preview" value="<?= __('screens.mail.preview_button') ?>" class="btn" tabindex="5">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>

<?php if (isset($conversation) && !empty($conversation)): ?>
<div class="mail-chat-history">
    <h3><?= __('screens.mail.conversation_history', 'Histórico da Conversa') ?></h3>
    <div class="mail-chat-window" id="chatWindow" style="max-height: 400px; border: 2px solid var(--border-ornate); border-radius: 6px; box-shadow: 0 4px 15px var(--shadow-medium); background: var(--parchment-bg);">
        <div class="mail-chat-messages" style="margin-top: 0; padding: 15px;">
            <?php foreach ($conversation as $msg): ?>
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
                            <?= $msg['time_formatted'] ?? date('d.m.Y H:i', $msg['time']) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
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

<style>
    .mail-new-container {
        padding: 15px;
    }

    .mail-new-container h2 {
        color: #5a4a3a;
        margin-bottom: 15px;
    }

    .mail-error {
        background: #ffebee;
        border: 2px solid #f44336;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 15px;
        color: #c62828;
    }

    .mail-preview-box {
        background: #fff;
        border: 2px solid #c4b5a0;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .mail-preview-box h3 {
        margin-top: 0;
        color: #5a4a3a;
        border-bottom: 2px solid #e0d5c7;
        padding-bottom: 10px;
    }

    .mail-preview-content {
        padding: 10px;
        min-height: 100px;
    }

    /* Chat History Styles */
    .mail-chat-history {
        margin-top: 30px;
        padding: 0 15px;
    }
    
    .mail-chat-history h3 {
        color: #5a4a3a;
        font-size: 1.1em;
        margin-bottom: 15px;
        border-bottom: 1px solid #c4b5a0;
        padding-bottom: 5px;
    }
</style>
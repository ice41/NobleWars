<?php
// BB Code Parser instance
require_once __DIR__ . '/../../Helpers/BBCodeParser.php';
$bbParser = new \App\Helpers\BBCodeParser();
?>

<!-- Category Tabs -->
<table class="vis" width="100%" style="margin-bottom: 5px;">
    <tr>
        <?php foreach ($sections as $sec): ?>
            <td style="padding: 0;">
                <a href="game.php?village=<?= $village['id'] ?>&screen=ally&mode=forum&section_id=<?= $sec['id'] ?>"
                    class="forum-tab <?= ($sec['id'] == $section['id']) ? 'active' : '' ?>">
                    <?php if (!empty($sec['icon'])): ?>
                        <?= $sec['icon'] ?>
                    <?php endif; ?>
                    <?= htmlspecialchars($sec['name']) ?>
                </a>
            </td>
        <?php endforeach; ?>
        <?php if ($can_moderate): ?>
            <td style="padding: 0;">
                <a href="game.php?village=<?= $village['id'] ?>&screen=ally&mode=forum&action=manage_categories"
                    class="forum-tab">
                    ⚙️
                </a>
            </td>
        <?php endif; ?>
    </tr>
</table>

<!-- New Messages Box -->
<div id="new_messages_box" style="border: 2px solid #804000; background-color: #f4e4bc; margin-bottom: 10px;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr class="head">
            <td style="padding: 5px; font-style: italic;">
                <?= __('screens.ally_forum.new_messages') ?: 'Novas mensagens no fórum' ?>
            </td>
            <td align="right" style="padding: 5px;">
                <input type="checkbox" id="exclude_muted" style="vertical-align: middle;">
                <span style="font-size: 11px;"><?= __('screens.ally_forum.exclude_muted') ?: 'Excluir publicações de fóruns silenciados' ?></span>
                <a href="javascript:void(0)" onclick="toggleNewMessages()" id="toggle_new_messages"
                    style="margin-left: 10px;">
                    <img src="graphic/icons/minus.png" alt="<?= __('screens.ally_forum.hide') ?: 'Esconder' ?>" id="toggle_icon">
                </a>
            </td>
        </tr>
    </table>

    <div id="new_messages_content">
        <table class="vis" width="100%" style="margin: 0;">
            <tr>
                <th width="40%"><?= __('screens.ally_forum.topics') ?: 'Tópico' ?></th>
                <th width="30%"><?= __('screens.ally_forum.forum') ?: 'Fórum' ?></th>
                <th width="30%"><?= __('screens.ally_forum.last_message') ?: 'Última mensagem' ?></th>
            </tr>
            <?php
            // Get recent threads from all sections
            $recentThreadsQuery = "SELECT t.*, s.name as section_name, u.username as author_name,
                        (SELECT username FROM users WHERE id = t.last_post_user_id) as last_post_author,
                        (SELECT COUNT(*) FROM ally_forum_posts p WHERE p.thread_id = t.id AND p.created_at > COALESCE(
                            (SELECT last_read_time FROM ally_forum_read WHERE user_id = ? AND thread_id = t.id), 0
                        )) as unread_count
                 FROM ally_forum_threads t
                 JOIN ally_forum_sections s ON t.section_id = s.id
                 LEFT JOIN users u ON t.user_id = u.id
                 WHERE t.ally_id = ?
                 ORDER BY t.last_post_time DESC
                 LIMIT 5";

            $recentThreads = $db->fetchAll($recentThreadsQuery, [$user['id'], $ally['id']]);

            if (!empty($recentThreads)):
                foreach ($recentThreads as $thread):
                    ?>
                    <tr class="row_b">
                        <td style="padding: 4px;">
                                    <?php if ($thread['unread_count'] > 0): ?>
                                <img src="graphic/icons/new_report.png" alt="<?= __('screens.ally_forum.new') ?: 'Novo' ?>" style="vertical-align: middle; margin-right: 3px;">
                                    <?php endif; ?>
                            <a
                                href="game.php?village=<?= $village['id'] ?>&screen=ally&mode=forum&thread_id=<?= $thread['id'] ?>">
                                        <?= htmlspecialchars($thread['title']) ?>
                            </a>
                        </td>
                        <td style="padding: 4px;"><?= htmlspecialchars($thread['section_name']) ?></td>
                        <td style="padding: 4px;">
                            <strong><?= htmlspecialchars($thread['last_post_author'] ?? $thread['author_name']) ?></strong><br>
                            <small><?= sprintf(__('screens.ally_forum.at_date_time'), date('d.m.Y', $thread['last_post_time'] ?? $thread['created_at']), date('H:i', $thread['last_post_time'] ?? $thread['created_at'])) ?></small>
                        </td>
                    </tr>
                   <?php
                endforeach;
            else:
                ?>
                    <tr>
                    <td colspan="3" align="center" style="padding: 10px;">
                        <i><?= __('screens.ally_forum.no_new_messages') ?: 'Nenhuma mensagem nova' ?></i>
                    </td>
                </tr>
                    <?php
            endif;
            ?>
         <tr>
                <td colspan="3" align="center" style="padding: 5px; background-color: #c1a264;">
                    <a href="game.php?village=<?= $village['id'] ?>&screen=ally&mode=forum" style="color: #000;"><?= __('screens.ally_forum.next_5') ?: 'Próximo 5' ?> &gt;&gt;</a>
                </td>
            </tr>
        </table>
    </div>
</div>

<script>
    function toggleNewMessages() {
        var content = document.getElementById('new_messages_content');
        var icon = document.getElementById('toggle_icon');

        if (content.style.display === 'none') {
            content.style.display = 'block';
            icon.src = 'graphic/icons/minus.png';
            icon.alt = '<?= __('screens.ally_forum.hide') ?: 'Esconder' ?>';
        } else {
            content.style.display = 'none';
            icon.src = 'graphic/icons/plus.png';
            icon.alt = '<?= __('screens.ally_forum.show') ?: 'Mostrar' ?>';
        }
    }
</script>

<!-- Category Title -->
<h2 style="margin: 20px 0 10px 0;"><?= htmlspecialchars($section['name']) ?></h2>

<!-- Action Links (Right side) -->
<div style="text-align: right; margin-bottom: 10px;">
    <a href="javascript:void(0)">&raquo; <?= __('screens.ally_forum.mark_forum_read') ?: 'Marcar fórum como lido' ?></a>
    <a href="javascript:void(0)" style="margin-left: 15px;">&raquo; <?= __('screens.ally_forum.mark_all_read') ?: 'Marcar todos fóruns como lidos' ?></a>
    <a href="javascript:void(0)" style="margin-left: 15px;">&raquo; <?= __('screens.ally_forum.disable_notifications') ?: 'Desativar notificações de fórum' ?></a>
</div>

<!-- Action Buttons -->
<table style="margin-bottom: 10px;">
    <tr>
        <td>
            <a href="game.php?village=<?= $village['id'] ?>&screen=ally&mode=forum&section_id=<?= $section['id'] ?>&action=new_thread"
                class="forum-button">
                📝 <?= __('screens.ally_forum.new_thread') ?: 'Novo tópico' ?>
            </a>
        </td>
        <td style="padding-left: 5px;">
            <a href="game.php?village=<?= $village['id'] ?>&screen=ally&mode=forum&section_id=<?= $section['id'] ?>&action=new_poll"
                class="forum-button">
                📊 <?= __('screens.ally_forum.new_poll') ?: 'Nova sondagem' ?>
            </a>
        </td>
        <td style="padding-left: 20px;">
            <input type="text" placeholder="<?= __('screens.ally_forum.search_placeholder') ?: 'Procurar nos fóruns' ?>" style="width: 200px; padding: 3px;">
            <button class="forum-button" style="padding: 3px 10px;">🔍</button>
        </td>
    </tr>
</table>

<!-- Thread List -->
<table class="vis" width="100%">
    <tr>
        <th width="5%"></th>
        <th width="40%"><?= __('screens.ally_forum.topics') ?: 'Tópicos' ?></th>
        <th width="20%"><?= __('screens.ally_forum.author') ?: 'Autor' ?></th>
        <th width="20%"><?= __('screens.ally_forum.last_message') ?: 'Última mensagem' ?></th>
        <th width="15%"><?= __('screens.ally_forum.replies') ?: 'Respostas' ?></th>
    </tr>

    <?php if (empty($threads)): ?>
        <tr>
            <td colspan="5" align="center" style="padding: 20px;">
                <i><?= __('screens.ally_forum.no_threads_in_forum') ?: 'Nenhum tópico neste fórum' ?></i><br><br>
                <a href="game.php?village=<?= $village['id'] ?>&screen=ally&mode=forum&section_id=<?= $section['id'] ?>&action=new_thread"
                    class="forum-button">
                    <?= __('screens.ally_forum.create_first_thread') ?: 'Criar primeiro tópico' ?>
                </a>
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($threads as $thread): ?>
            <tr class="<?= $thread['is_sticky'] ? 'row_a' : 'row_b' ?>">
                <td align="center">
                    <?php if ($thread['is_sticky']): ?>
                        📌
                    <?php elseif ($thread['is_locked']): ?>
                        🔒
                    <?php elseif ($thread['is_poll']): ?>
                        📊
                    <?php else: ?>
                        💬
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($thread['is_sticky']): ?>
                        <img src="graphic/forwarded.png" alt="" style="vertical-align: middle;">
                    <?php endif; ?>
                    <a href="game.php?village=<?= $village['id'] ?>&screen=ally&mode=forum&thread_id=<?= $thread['id'] ?>">
                        <?= htmlspecialchars($thread['title']) ?>
                    </a>
                </td>
                <td>
                    <strong><?= htmlspecialchars($thread['author_name'] ?? (__('screens.report.unknown') ?: 'Desconhecido')) ?></strong><br>
                    <small><?= sprintf(__('screens.ally_forum.at_date_time'), date('d.m.Y', $thread['created_at']), date('H:i', $thread['created_at'])) ?></small>
                </td>
                <td>
                    <?php if ($thread['last_post_time']): ?>
                        <strong><?= htmlspecialchars($thread['last_post_author'] ?? (__('screens.report.unknown') ?: 'Desconhecido')) ?></strong><br>
                        <small><?= sprintf(__('screens.ally_forum.at_date_time'), date('d.m.Y', $thread['last_post_time']), date('H:i', $thread['last_post_time'])) ?></small>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td align="center">
                    <?= $thread['replies'] ?? 0 ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

<style>
    .forum-tab {
        display: inline-block;
        background-color: #f4e4bc;
        border: 1px solid #c0a070;
        border-bottom: none;
        padding: 5px 15px;
        text-decoration: none;
        color: #000;
        margin-right: 2px;
    }

    .forum-tab:hover {
        background-color: #e0d0a0;
    }

    .forum-tab.active {
        background-color: #fff;
        font-weight: bold;
        border-bottom: 1px solid #fff;
        position: relative;
        z-index: 1;
    }

    .forum-button {
        background-color: #f4e4bc;
        border: 1px solid #c0a070;
        padding: 5px 10px;
        text-decoration: none;
        color: #000;
        display: inline-block;
        cursor: pointer;
    }

    .forum-button:hover {
        background-color: #e0d0a0;
    }
</style>
        background-color: #e0d0a0;
    }
</style>
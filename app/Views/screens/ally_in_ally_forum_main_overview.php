<?php
/**
 * Forum Main Overview — screen=ally&mode=forum (no section selected)
 */
require_once __DIR__ . '/../../Helpers/BBCodeParser.php';

$baseUrl = 'game.php?village=' . $village['id'] . '&screen=ally&mode=forum';
$currentSection = $_GET['section_id'] ?? null;

$activeSection = null;
if ($currentSection) {
    foreach ($sections as $s) {
        if ($s['id'] == $currentSection) {
            $activeSection = $s;
            break;
        }
    }
}
if (!$activeSection && !empty($sections)) {
    $activeSection = $sections[0];
}
?>

<!-- ══ Category Tabs ══ -->
<div  style="margin-bottom: 0; padding: 0;">
    <?php foreach ($sections as $sec): ?>
        <a href="<?= $baseUrl ?>&section_id=<?= $sec['id'] ?>"
            class="menu_item2<?= ($activeSection && $sec['id'] == $activeSection['id']) ? ' selected' : '' ?>"
            style="display:inline-block; margin-right:2px;">
            <?= htmlspecialchars($sec['name']) ?>
        </a>
    <?php endforeach; ?>
</div>

<!-- ══ New messages bar ══ -->
<table width="100%" cellpadding="0" cellspacing="0"
     class="mt-5" style="margin-bottom:8px; border:1px solid #b0955a; background:#c8a87a;">
    <tr>
        <td  class="bold" style="padding:4px 8px; font-style:italic; font-size:12px;">
            <?= __('screens.ally_forum.new_messages') ?>
        </td>
        <td align="right"  style="padding:4px 8px;">
            <input type="checkbox" id="exclude_muted" checked>
            <label for="exclude_muted"
                 style="font-style:italic; font-size:11px;"><?= __('screens.ally_forum.exclude_muted') ?></label>
            &nbsp;
            <a href="javascript:void(0)" onclick="toggleNewMessages()" id="toggle_nm_btn"
                 class="bold" style="border:1px solid #b0955a; background:#e8c87a; padding:2px 5px; text-decoration:none; color:#000;">+</a>
        </td>
    </tr>
    <tr id="new_messages_content"  style="display:none;">
        <td colspan="2"  style="padding:0;">
            <table class="vis" width="100%"  style="margin:0;">
                <tr>
                    <th width="50%"><?= __('screens.ally_forum.topics') ?></th>
                    <th width="25%"><?= __('screens.ally_forum.forum') ?: 'Fórum' ?></th>
                    <th width="25%"><?= __('screens.ally_forum.last_message') ?></th>
                </tr>
                <?php
                $recentThreadsQuery =
                    "SELECT t.*, s.name as section_name,
                            u.username as author_name,
                            (SELECT username FROM users WHERE id = t.last_post_user_id) as last_post_author,
                            (SELECT COUNT(*) FROM ally_forum_posts p
                             WHERE p.thread_id = t.id
                               AND p.created_at > COALESCE(
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
                    foreach ($recentThreads as $rt):
                        ?>
                        <tr class="row_b">
                            <td  style="padding:3px 5px;">
                                <?php if ($rt['unread_count'] > 0): ?>
                                    <img src="graphic/icons/new_report.png" alt=""  class="v-align-middle">
                                <?php endif; ?>
                                <a href="<?= $baseUrl ?>&thread_id=<?= $rt['id'] ?>"><?= htmlspecialchars($rt['title']) ?></a>
                            </td>
                            <td  style="padding:3px 5px;"><?= htmlspecialchars($rt['section_name']) ?></td>
                            <td  style="padding:3px 5px;">
                                <strong><?= htmlspecialchars($rt['last_post_author'] ?? $rt['author_name']) ?></strong><br>
                                <small><?= date('H:i', $rt['last_post_time'] ?? $rt['created_at']) ?></small>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="3" align="center"  style="padding:8px;">
                            <i><?= __('screens.ally_forum.no_threads') ?></i></td>
                    </tr>
                <?php endif; ?>
            </table>
        </td>
    </tr>
</table>

<!-- ══ Active Section ══ -->
<?php if ($activeSection): ?>

    <table width="100%" cellpadding="0" cellspacing="0"  style="margin-bottom:6px;">
        <tr>
            <td>
                <h2  style="margin:0; font-size:18px;"><?= htmlspecialchars($activeSection['name']) ?></h2>
            </td>
            <td align="right"  style="font-size:11px; vertical-align:bottom;">
                <a
                    href="<?= $baseUrl ?>&section_id=<?= $activeSection['id'] ?>&action=mark_read&h=<?= $session['hkey'] ?>"><?= __('screens.ally_forum.mark_forum_read') ?></a>
                &nbsp;&nbsp;
                <a
                    href="<?= $baseUrl ?>&action=mark_all_read&h=<?= $session['hkey'] ?>"><?= __('screens.ally_forum.mark_all_read') ?></a><br>
                <a
                    href="<?= $baseUrl ?>&section_id=<?= $activeSection['id'] ?>&action=toggle_notif&h=<?= $session['hkey'] ?>"><?= __('screens.ally_forum.toggle_notifications') ?></a>
            </td>
        </tr>
    </table>

    <table width="100%" cellpadding="0" cellspacing="4"  style="margin-bottom:6px;">
        <tr>
            <td>
                <a href="<?= $baseUrl ?>&action=new_thread&section_id=<?= $activeSection['id'] ?>" class="btn">
                    <img src="graphic/forum/new_thread.png" alt=""  class="v-align-middle" style="margin-right:3px;"
                        onerror="this.style.display='none'">
                    <?= __('screens.ally_forum.new_thread') ?>
                </a>
                &nbsp;
                <a href="<?= $baseUrl ?>&action=new_poll&section_id=<?= $activeSection['id'] ?>" class="btn">
                    <img src="graphic/forum/new_poll.png" alt=""  class="v-align-middle" style="margin-right:3px;"
                        onerror="this.style.display='none'">
                    <?= __('screens.ally_forum.new_poll') ?>
                </a>
            </td>
            <td align="right">
                <form method="get" action="game.php"  class="inline">
                    <input type="hidden" name="village" value="<?= $village['id'] ?>">
                    <input type="hidden" name="screen" value="ally">
                    <input type="hidden" name="mode" value="forum">
                    <input type="hidden" name="action" value="search">
                    <input type="hidden" name="section_id" value="<?= $activeSection['id'] ?>">
                    <input type="text" name="q" placeholder="<?= __('screens.ally_forum.search_placeholder') ?>" size="20"
                        style="border:1px solid #b0955a; padding:2px 4px;">
                    <input type="submit" value="🔍" class="btn">
                </form>
            </td>
        </tr>
    </table>

    <?php
    $sectionThreads = $db->fetchAll(
        "SELECT t.*,
                u.username as author_name,
                (SELECT username FROM users WHERE id = t.last_post_user_id) as last_post_author,
                (SELECT COUNT(*) FROM ally_forum_posts p
                 WHERE p.thread_id = t.id
                   AND p.created_at > COALESCE(
                       (SELECT last_read_time FROM ally_forum_read WHERE user_id = ? AND thread_id = t.id), 0
                   )) as unread_count
         FROM ally_forum_threads t
         LEFT JOIN users u ON t.user_id = u.id
         WHERE t.section_id = ? AND t.ally_id = ?
         ORDER BY t.is_sticky DESC, t.last_post_time DESC",
        [$user['id'], $activeSection['id'], $ally['id']]
    );
    ?>

    <form method="post" id="threads_form" action="<?= $baseUrl ?>&action=bulk&h=<?= $session['hkey'] ?>">
        <table class="vis" width="100%">
            <tr>
                <th width="20"  style="padding:2px;"></th>
                <th width="20"  style="padding:2px;"></th>
                <th><?= __('screens.ally_forum.topics') ?></th>
                <th width="20"  style="padding:2px;"></th>
                <th width="160"><?= __('screens.ally_forum.author') ?></th>
                <th width="160"><?= __('screens.ally_forum.last_message') ?></th>
                <th width="80"><?= __('screens.ally_forum.replies') ?></th>
            </tr>

            <?php if (empty($sectionThreads)): ?>
                <tr>
                    <td colspan="7" align="center"  style="padding:15px;">
                        <i><?= __('screens.ally_forum.no_threads') ?></i><br><br>
                        <a href="<?= $baseUrl ?>&action=new_thread&section_id=<?= $activeSection['id'] ?>"
                            class="btn"><?= __('screens.ally_forum.create_first_thread') ?></a>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($sectionThreads as $thread): ?>
                    <tr class="row_b">
                        <td align="center"  style="padding:2px;">
                            <input type="checkbox" name="thread_ids[]" value="<?= $thread['id'] ?>">
                        </td>
                        <td align="center"  style="padding:2px;">
                            <?php if ($thread['unread_count'] > 0): ?>
                                <img src="graphic/icons/new_report.png" alt="<?= __('screens.ally_forum.new') ?: 'Novo' ?>" title="<?= __('screens.ally_forum.new') ?: 'Novo' ?>" style="width:16px;">
                            <?php elseif ($thread['is_sticky']): ?>📌
                            <?php elseif ($thread['is_locked']): ?>🔒
                            <?php elseif ($thread['is_poll']): ?>📊
                            <?php else: ?>
                                <img src="graphic/forum/thread.png" alt=""  style="width:16px;" onerror="this.style.display='none'">
                            <?php endif; ?>
                        </td>
                        <td  style="padding:3px 5px;">
                            <a href="<?= $baseUrl ?>&thread_id=<?= $thread['id'] ?>"><?= htmlspecialchars($thread['title']) ?></a>
                            <?php if ($thread['is_locked']): ?>
                                <span  style="color:#999; font-size:10px;"><?= __('screens.ally_forum.locked') ?></span>
                            <?php endif; ?>
                        </td>
                        <td align="center"  style="padding:2px;">
                            <a href="<?= $baseUrl ?>&thread_id=<?= $thread['id'] ?>&goto=last"
                                title="<?= __('screens.ally_forum.goto_last_post') ?>">
                                <img src="graphic/topbar/arrow.png" alt="&raquo;"  style="width:14px;" onerror="this.outerHTML='&raquo;'">
                            </a>
                        </td>
                        <td align="center"  style="padding:3px;">
                            <strong><?= htmlspecialchars($thread['author_name'] ?? '?') ?></strong><br>
                            <small><?= date('H:i', $thread['created_at']) ?></small>
                        </td>
                        <td align="center"  style="padding:3px;">
                            <?php if ($thread['last_post_time']): ?>
                                <strong><?= htmlspecialchars($thread['last_post_author'] ?? $thread['author_name']) ?></strong><br>
                                <small><?= date('H:i', $thread['last_post_time']) ?></small>
                            <?php else: ?>-<?php endif; ?>
                        </td>
                        <td align="center"><?= $thread['replies'] ?? 0 ?></td>
                    </tr>
                <?php endforeach; ?>

                <tr class="row_a">
                    <td colspan="7"  style="padding:3px 5px;">
                        <input type="checkbox" id="select_all_threads" onclick="toggleAllThreads(this)">
                        <label for="select_all_threads"><?= __('screens.ally_forum.select_all') ?></label>
                    </td>
                </tr>
            <?php endif; ?>
        </table>

        <?php if (!empty($sectionThreads)): ?>
            <div  style="margin-top:4px;">
                <?php if ($can_moderate): ?>
                    <input type="submit" name="action_delete" value="✕" class="btn" title="<?= __('screens.ally_forum.delete') ?>">
                    <input type="submit" name="action_sticky" value="📌" class="btn">
                    <input type="submit" name="action_lock" value="🔒" class="btn">
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </form>

<?php else: ?>
    <p><i><?= __('screens.ally_forum.no_categories') ?></i></p>
<?php endif; ?>

<?php if ($can_moderate): ?>
    <div  class="text-center mt-15">
        <a href="<?= $baseUrl ?>&action=manage_categories"
            style="font-weight:bold;"><?= __('screens.ally_forum.admin_forum') ?></a>
    </div>
<?php endif; ?>

<script>
    function toggleNewMessages() {
        var row = document.getElementById('new_messages_content');
        var btn = document.getElementById('toggle_nm_btn');
        if (row.style.display === 'none') { row.style.display = ''; btn.textContent = '-'; }
        else { row.style.display = 'none'; btn.textContent = '+'; }
    }
    function toggleAllThreads(cb) {
        document.querySelectorAll('input[name="thread_ids[]"]').forEach(c => c.checked = cb.checked);
    }
</script>
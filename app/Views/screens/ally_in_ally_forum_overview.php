<?php
/**
 * Forum Per-Section Overview — screen=ally&mode=forum&section_id=X
 */
$baseUrl = 'game.php?village=' . $village['id'] . '&screen=ally&mode=forum';
$activeSectionId = $section['id'] ?? 0;
?>

<!-- ══ Category Tabs ══ -->
<div style="margin-bottom: 0; padding: 0;">
    <?php foreach ($sections as $sec): ?>
        <a href="<?= $baseUrl ?>&section_id=<?= $sec['id'] ?>"
            class="menu_item2<?= ($sec['id'] == $activeSectionId) ? ' selected' : '' ?>"
            style="display:inline-block; margin-right:2px;">
            <?= htmlspecialchars($sec['name']) ?>
        </a>
    <?php endforeach; ?>
</div>

<!-- ══ New messages bar ══ -->
<table width="100%" cellpadding="0" cellspacing="0"
    style="margin-top:5px; margin-bottom:8px; border:1px solid #b0955a; background:#c8a87a;">
    <tr>
        <td style="padding:4px 8px; font-weight:bold; font-style:italic; font-size:12px;">
            <?= __('screens.ally_forum.new_messages') ?>
        </td>
        <td align="right" style="padding:4px 8px;">
            <input type="checkbox" id="exclude_muted_ov" checked>
            <label for="exclude_muted_ov"
                style="font-style:italic; font-size:11px;"><?= __('screens.ally_forum.exclude_muted') ?></label>
            &nbsp;
            <a href="<?= $baseUrl ?>" id="nm_expand_btn"
                style="border:1px solid #b0955a; background:#e8c87a; padding:2px 5px; text-decoration:none; color:#000; font-weight:bold;">+</a>
        </td>
    </tr>
</table>

<!-- ══ Section Title + Action Links ══ -->
<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:6px;">
    <tr>
        <td>
            <h2 style="margin:0; font-size:18px;"><?= htmlspecialchars($section['name'] ?? 'Fórum') ?></h2>
        </td>
        <td align="right" style="font-size:11px; vertical-align:bottom; line-height:1.8;">
            <a
                href="<?= $baseUrl ?>&section_id=<?= $activeSectionId ?>&action=mark_read&h=<?= $session['hkey'] ?>"><?= __('screens.ally_forum.mark_forum_read') ?></a>
            &nbsp;&nbsp;
            <a
                href="<?= $baseUrl ?>&action=mark_all_read&h=<?= $session['hkey'] ?>"><?= __('screens.ally_forum.mark_all_read') ?></a><br>
            <a
                href="<?= $baseUrl ?>&section_id=<?= $activeSectionId ?>&action=toggle_notif&h=<?= $session['hkey'] ?>"><?= __('screens.ally_forum.toggle_notifications') ?></a>
        </td>
    </tr>
</table>

<!-- ══ Action buttons + Search ══ -->
<table width="100%" cellpadding="0" cellspacing="4" style="margin-bottom:6px;">
    <tr>
        <td>
            <a href="<?= $baseUrl ?>&action=new_thread&section_id=<?= $activeSectionId ?>" class="btn">
                <img src="graphic/forum/new_thread.png" alt="" style="vertical-align:middle; margin-right:3px;"
                    onerror="this.style.display='none'">
                <?= __('screens.ally_forum.new_thread') ?>
            </a>
            &nbsp;
            <a href="<?= $baseUrl ?>&action=new_poll&section_id=<?= $activeSectionId ?>" class="btn">
                <img src="graphic/forum/new_poll.png" alt="" style="vertical-align:middle; margin-right:3px;"
                    onerror="this.style.display='none'">
                <?= __('screens.ally_forum.new_poll') ?>
            </a>
        </td>
        <td align="right">
            <form method="get" action="game.php" style="display:inline;">
                <input type="hidden" name="village" value="<?= $village['id'] ?>">
                <input type="hidden" name="screen" value="ally">
                <input type="hidden" name="mode" value="forum">
                <input type="hidden" name="action" value="search">
                <input type="hidden" name="section_id" value="<?= $activeSectionId ?>">
                <input type="text" name="q" placeholder="<?= __('screens.ally_forum.search_placeholder') ?>" size="20"
                    style="border:1px solid #b0955a; padding:2px 4px;">
                <input type="submit" value="🔍" class="btn">
            </form>
        </td>
    </tr>
</table>

<!-- ══ Thread Table ══ -->
<form method="post" id="ov_threads_form"
    action="<?= $baseUrl ?>&action=bulk&section_id=<?= $activeSectionId ?>&h=<?= $session['hkey'] ?>">
    <table class="vis" width="100%">
        <tr>
            <th width="20" style="padding:2px;"></th>
            <th width="20" style="padding:2px;"></th>
            <th><?= __('screens.ally_forum.topics') ?></th>
            <th width="20" style="padding:2px;"></th>
            <th width="160"><?= __('screens.ally_forum.author') ?></th>
            <th width="160"><?= __('screens.ally_forum.last_message') ?></th>
            <th width="80"><?= __('screens.ally_forum.replies') ?></th>
        </tr>

        <?php if (empty($threads)): ?>
            <tr>
                <td colspan="7" align="center" style="padding:20px;">
                    <i><?= __('screens.ally_forum.no_threads') ?></i><br><br>
                    <a href="<?= $baseUrl ?>&action=new_thread&section_id=<?= $activeSectionId ?>" class="btn">
                        <?= __('screens.ally_forum.create_first_thread') ?>
                    </a>
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($threads as $thread): ?>
                <tr class="<?= $thread['is_sticky'] ? 'row_a' : 'row_b' ?>">
                    <td align="center" style="padding:2px;">
                        <input type="checkbox" name="thread_ids[]" value="<?= $thread['id'] ?>">
                    </td>
                    <td align="center" style="padding:2px;">
                        <?php if ($thread['is_sticky']): ?>📌
                        <?php elseif ($thread['is_locked']): ?>🔒
                        <?php elseif ($thread['is_poll']): ?>📊
                        <?php else: ?>
                            <img src="graphic/forum/thread.png" alt="" style="width:16px;" onerror="this.style.display='none'">
                        <?php endif; ?>
                    </td>
                    <td style="padding:3px 5px;">
                        <a href="<?= $baseUrl ?>&thread_id=<?= $thread['id'] ?>">
                            <b><?= htmlspecialchars($thread['title']) ?></b>
                        </a>
                        <?php if ($thread['is_locked']): ?>
                            <span style="color:#999;font-size:10px;"><?= __('screens.ally_forum.locked') ?></span>
                        <?php endif; ?>
                    </td>
                    <td align="center" style="padding:2px;">
                        <a href="<?= $baseUrl ?>&thread_id=<?= $thread['id'] ?>&goto=last"
                            title="<?= __('screens.ally_forum.goto_last_post') ?>">
                            <img src="graphic/topbar/arrow.png" alt="&raquo;" style="width:14px;" onerror="this.outerHTML='&raquo;'">
                        </a>
                    </td>
                    <td align="center" style="padding:3px;">
                        <strong><?= htmlspecialchars($thread['author_name'] ?? '?') ?></strong><br>
                        <small><?= date('H:i', $thread['created_at']) ?></small>
                    </td>
                    <td align="center" style="padding:3px;">
                        <?php if ($thread['last_post_time']): ?>
                            <strong><?= htmlspecialchars($thread['last_post_author'] ?? $thread['author_name']) ?></strong><br>
                            <small><?= date('H:i', $thread['last_post_time']) ?></small>
                        <?php else: ?>-<?php endif; ?>
                    </td>
                    <td align="center"><?= $thread['replies'] ?? 0 ?></td>
                </tr>
            <?php endforeach; ?>

            <tr class="row_a">
                <td colspan="7" style="padding:3px 5px;">
                    <input type="checkbox" id="ov_select_all"
                        onclick="document.querySelectorAll('input[name=\'thread_ids[]\']').forEach(c=>c.checked=this.checked)">
                    <label for="ov_select_all"><?= __('screens.ally_forum.select_all') ?></label>
                </td>
            </tr>
        <?php endif; ?>
    </table>

    <?php if (!empty($threads) && $can_moderate): ?>
        <div style="margin-top:4px;">
            <input type="submit" name="action_delete" value="✕" class="btn" title="<?= __('screens.ally_forum.delete') ?>">
            <input type="submit" name="action_sticky" value="📌" class="btn">
            <input type="submit" name="action_lock" value="🔒" class="btn">
        </div>
    <?php endif; ?>
</form>

<?php if ($can_moderate): ?>
    <div style="text-align:center; margin-top:15px;">
        <a href="<?= $baseUrl ?>&action=manage_categories"
            style="font-weight:bold;"><?= __('screens.ally_forum.admin_forum') ?></a>
    </div>
<?php endif; ?>
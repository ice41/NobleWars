<?php
/**
 * Thread View — screen=ally&mode=forum&thread_id=X
 */
use App\Helpers\BBCodeParser;

$bbParser = new BBCodeParser();
$baseUrl  = 'game.php?village=' . $village['id'] . '&screen=ally&mode=forum';
$threadUrl = $baseUrl . '&thread_id=' . $thread['id'];
?>

<!-- ── Back + Title ── -->
<h3>
    <?= htmlspecialchars($thread['title']) ?>
    <span  class="float-right" style="font-size:11px; font-weight:normal;">
        <a href="<?= $baseUrl ?>"><?= __('screens.ally_forum.back_to_forum') ?></a>
    </span>
</h3>

<?php if (!empty($error)): ?>
    <div class="error mb-10"  style="padding:8px; background:#ffdddd; border:1px solid #c00;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <div class="success mb-10"  style="padding:8px; background:#ddffdd; border:1px solid #070;">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<!-- ── Thread meta bar ── -->
<table class="vis" width="100%" cellpadding="3" cellspacing="0"  style="margin-bottom:8px;">
    <tr class="row_a">
        <td>
            <b><?= __('screens.ally_forum.author') ?>:</b> <?= htmlspecialchars($thread['author_name']) ?> &nbsp;|&nbsp;
            <b><?= __('screens.ally_forum.created') ?>:</b> <?= date('d.m.Y H:i', $thread['created_at']) ?>
            &nbsp;|&nbsp;
            <b><?= __('screens.ally_forum.replies') ?>:</b> <?= $thread['replies'] ?> &nbsp;|&nbsp;
            <b><?= __('screens.ally_forum.views') ?>:</b> <?= $thread['views'] ?>
        </td>
        <?php if ($can_moderate): ?>
            <td align="right">
                <a href="<?= $threadUrl ?>&action=toggle_sticky&h=<?= $session['hkey'] ?>">
                    <?= $thread['is_sticky'] ? '📌 ' . __('screens.ally_forum.unpin') : '📌 ' . __('screens.ally_forum.pin') ?>
                </a> |
                <a href="<?= $threadUrl ?>&action=toggle_lock&h=<?= $session['hkey'] ?>">
                    <?= $thread['is_locked'] ? '🔓 ' . __('screens.ally_forum.unlock') : '🔒 ' . __('screens.ally_forum.lock') ?>
                </a> |
                <a href="<?= $threadUrl ?>&action=delete_thread&h=<?= $session['hkey'] ?>"
                    onclick="return confirm('<?= __('screens.ally_forum.delete_thread_confirm') ?>')">
                    🗑️ <?= __('screens.ally_forum.delete') ?>
                </a>
            </td>
        <?php endif; ?>
    </tr>
</table>

<!-- ── Posts ── -->
<?php foreach ($posts as $i => $post): ?>
    <table class="vis mb-10" width="100%" >
        <tr>
            <th colspan="2">
                #<?= $i + 1 ?> — <?= htmlspecialchars($post['author_name']) ?>
                <span  class="float-right" style="font-weight:normal; font-size:11px;">
                    <?= date('d.m.Y H:i', $post['created_at']) ?>
                    <?php if ($post['edited_at']): ?>
                        <small>(<?= __('screens.ally_forum.edited_at') ?>         <?= date('d.m.Y H:i', $post['edited_at']) ?>
                            <?= __('screens.ally_forum.by') ?>         <?= htmlspecialchars($post['edited_by_name']) ?>)</small>
                    <?php endif; ?>
                </span>
            </th>
        </tr>
        <tr>
            <!-- Left: avatar / member info -->
            <td width="130" valign="top" class="row_b text-center"
                 style="padding:8px; border-right:1px solid #b0955a;">
                <b><?= htmlspecialchars($post['author_name']) ?></b><br>
                <small  style="color:#666;"><?= __('screens.ally_forum.member') ?></small>
            </td>
            <!-- Right: post body rendered with BBCode -->
            <td class="row_a p-10 v-align-top" >
                <?= $bbParser->parse($post['content']) ?>
            </td>
        </tr>
    </table>
<?php endforeach; ?>

<!-- ── Reply Form ── -->
<?php if (!$thread['is_locked']): ?>
    <form id="reply_form" method="POST" action="<?= $threadUrl ?>&action=reply&h=<?= $session['hkey'] ?>">
        <table class="vis" width="100%">
            <tr>
                <th><?= __('screens.ally_forum.new_reply') ?></th>
            </tr>
            <tr>
                <td  style="padding:6px;">

                    <!-- BBCode toolbar (shared component) -->
                    <?php include __DIR__ . '/../components/bbcode_toolbar.php'; ?>

                    <textarea id="reply_content" name="content" rows="8"
                         class="w-100" style="border:1px solid #b0955a; padding:4px; font-family:inherit; font-size:12px;"
                        required></textarea>
                </td>
            </tr>
            <tr>
                <td  style="padding:6px;">
                    <input type="submit" value="<?= __('screens.ally_forum.send') ?>" class="btn">
                </td>
            </tr>
        </table>
    </form>
<?php else: ?>
    <div  class="text-center" style="padding:15px; background:#fff3cd; border:1px solid #b0955a;">
        🔒 <b><?= __('screens.ally_forum.thread_locked_msg') ?></b>
    </div>
<?php endif; ?>

<?php if (isset($can_moderate) && $can_moderate): ?>
    <div  class="text-center mt-20">
        <a href="<?= $baseUrl ?>&action=manage_categories"
            style="font-weight:bold;"><?= __('screens.ally_forum.admin_forum') ?></a>
    </div>
<?php endif; ?>

<script>
$(document).ready(function () {
    BBCodes.init({
        target: '#reply_content',
        ajax_unit_url: 'ajax/unit_bb.php',
        ajax_building_url: 'ajax/build_bb.php'
    });
});
</script>

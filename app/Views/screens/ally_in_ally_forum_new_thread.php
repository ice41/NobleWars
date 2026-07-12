<?php
/**
 * New Thread Form — screen=ally&mode=forum&action=new_thread&section_id=X
 */
$baseUrl = 'game.php?village=' . $village['id'] . '&screen=ally&mode=forum';
$activeSectionId = $section['id'] ?? 0;
?>

<!-- ══ Category Tabs ══ -->
<div  style="margin-bottom:0; padding:0;">
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
     class="mt-5" style="margin-bottom:8px; border:1px solid #b0955a; background:#c8a87a;">
    <tr>
        <td  class="bold" style="padding:4px 8px; font-style:italic; font-size:12px;">
            <?= __('screens.ally_forum.new_messages') ?>
        </td>
        <td align="right"  style="padding:4px 8px;">
            <input type="checkbox" id="exclude_muted_nt" checked>
            <label for="exclude_muted_nt"
                 style="font-style:italic; font-size:11px;"><?= __('screens.ally_forum.exclude_muted') ?></label>
            &nbsp;
            <a href="<?= $baseUrl ?>" style="border:1px solid #b0955a; background:#e8c87a; padding:2px 5px;
                      text-decoration:none; color:#000; font-weight:bold;">+</a>
        </td>
    </tr>
</table>

<?php if (!empty($error)): ?>
    <div  class="mb-10" style="padding:8px; background:#ffe0e0; border:1px solid #c00;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<h2  style="margin:15px 0 12px 0; font-size:18px;"><?= __('screens.ally_forum.create_new_thread') ?></h2>

<form id="new_thread_form" method="post"
    action="<?= $baseUrl ?>&action=new_thread&section_id=<?= $activeSectionId ?>&h=<?= $session['hkey'] ?>">

    <table width="100%" cellpadding="3" cellspacing="0">
        <tr>
            <td width="90" valign="top"  style="padding-top:4px;"><b><?= __('screens.ally_forum.title') ?>:</b></td>
            <td>
                <input type="text" name="title" size="50" maxlength="255" required
                    value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
                    style="border:1px solid #b0955a; padding:2px; width:350px;">
            </td>
        </tr>

        <!-- BBCode Toolbar (shared component) -->
        <tr>
            <td colspan="2">
                <?php include __DIR__ . '/../components/bbcode_toolbar.php'; ?>
            </td>
        </tr>

        <tr>
            <td valign="top"  style="padding-top:4px;"><b><?= __('screens.ally_forum.text') ?>:</b></td>
            <td>
                <textarea name="content" id="thread_content_area" rows="12"
                     class="w-100" style="min-width:400px; border:1px solid #b0955a; padding:4px;"
                    required><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>
            </td>
        </tr>
    </table>

    <div  class="mt-10">
        <input type="submit" name="preview" value="<?= __('screens.ally_forum.preview') ?>" class="btn">
        &nbsp;
        <input type="submit" name="submit" value="<?= __('screens.ally_forum.send') ?>" class="btn">
    </div>
</form>

<?php if (isset($can_moderate) && $can_moderate): ?>
    <div  class="text-center mt-20">
        <a href="<?= $baseUrl ?>&action=manage_categories"
            style="font-weight:bold;"><?= __('screens.ally_forum.admin_forum') ?></a>
    </div>
<?php endif; ?>

<script>
    $(document).ready(function () {
        BBCodes.init({
            target: '#thread_content_area',
            ajax_unit_url: 'ajax/unit_bb.php',
            ajax_building_url: 'ajax/build_bb.php'
        });
    });
</script>
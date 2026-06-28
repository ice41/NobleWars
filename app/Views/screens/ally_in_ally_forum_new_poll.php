<?php
/**
 * New Poll Form — screen=ally&mode=forum&action=new_poll&section_id=X
 */
$baseUrl = 'game.php?village=' . $village['id'] . '&screen=ally&mode=forum';
$activeSectionId = $section['id'] ?? 0;
?>

<!-- ══ Category Tabs ══ -->
<div style="margin-bottom:0; padding:0;">
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
            <input type="checkbox" id="exclude_muted_np" checked>
            <label for="exclude_muted_np"
                style="font-style:italic; font-size:11px;"><?= __('screens.ally_forum.exclude_muted') ?></label>
            &nbsp;
            <a href="<?= $baseUrl ?>" style="border:1px solid #b0955a; background:#e8c87a; padding:2px 5px;
                      text-decoration:none; color:#000; font-weight:bold;">+</a>
        </td>
    </tr>
</table>

<?php if (!empty($error)): ?>
    <div style="padding:8px; background:#ffe0e0; border:1px solid #c00; margin-bottom:10px;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<h2 style="margin:15px 0 12px 0; font-size:18px;"><?= __('screens.ally_forum.create_new_poll') ?></h2>

<form id="new_poll_form" method="post"
    action="<?= $baseUrl ?>&action=new_poll&section_id=<?= $activeSectionId ?>&h=<?= $session['hkey'] ?>">

    <table width="100%" cellpadding="3" cellspacing="0">
        <!-- Title -->
        <tr>
            <td width="90" valign="top" style="padding-top:4px;"><b><?= __('screens.ally_forum.title') ?>:</b></td>
            <td>
                <input type="text" name="title" size="50" maxlength="255"
                    value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
                    style="border:1px solid #b0955a; padding:2px; width:350px;">
            </td>
        </tr>

        <!-- Question -->
        <tr>
            <td valign="top" style="padding-top:4px;"><b><?= __('screens.ally_forum.question') ?>:</b></td>
            <td>
                <input type="text" name="question" id="question_input" size="50" maxlength="100"
                    value="<?= htmlspecialchars($_POST['question'] ?? '') ?>"
                    style="border:1px solid #b0955a; padding:2px; width:350px;"
                    oninput="document.getElementById('q_counter').textContent=this.value.length">
                &nbsp;<span id="q_counter">0</span>/100
            </td>
        </tr>

        <!-- Answers -->
        <tr>
            <td valign="top" style="padding-top:6px;"><b><?= __('screens.ally_forum.answers') ?>:</b></td>
            <td id="answers_container">
                <?php
                $existingOptions = $_POST['options'] ?? ['', '', ''];
                foreach ($existingOptions as $opt):
                    ?>
                    <input type="text" name="options[]" size="35" maxlength="100" value="<?= htmlspecialchars($opt) ?>"
                        style="border:1px solid #b0955a; padding:2px; margin-bottom:3px; display:block; width:330px;"><br>
                <?php endforeach; ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <a href="javascript:void(0)" onclick="addAnswerRow()" style="color:#a05000; font-weight:bold;">
                    <?= __('screens.ally_forum.add_answer') ?>
                </a>
            </td>
        </tr>

        <!-- Settings -->
        <tr>
            <td colspan="2" style="padding-top:8px;">
                <label>
                    <input type="checkbox" name="has_end_date" id="has_end_date" <?= !empty($_POST['has_end_date']) ? 'checked' : '' ?>>
                    <?= __('screens.ally_forum.end_after_days') ?>
                    <input type="text" name="end_days" size="4" maxlength="4"
                        value="<?= htmlspecialchars($_POST['end_days'] ?? '0') ?>"
                        style="border:1px solid #b0955a; padding:1px 3px; width:40px;">
                    <?= __('screens.ally_forum.days') ?>
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label>
                    <input type="checkbox" name="show_before_vote" value="1" <?= !empty($_POST['show_before_vote']) ? 'checked' : '' ?>>
                    <?= __('screens.ally_forum.show_before_vote') ?>
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-bottom:8px;">
                <?= __('screens.ally_forum.max_choices') ?>
                <input type="text" name="max_choices" size="3" maxlength="2"
                    value="<?= htmlspecialchars($_POST['max_choices'] ?? '1') ?>"
                    style="border:1px solid #b0955a; padding:1px 3px; width:35px;">
                <?= __('screens.ally_forum.choices') ?>
            </td>
        </tr>

        <!-- BBCode Toolbar (shared component) -->
        <tr>
            <td colspan="2">
                <?php include __DIR__ . '/../components/bbcode_toolbar.php'; ?>
            </td>
        </tr>

        <!-- Text body -->
        <tr>
            <td valign="top" style="padding-top:4px;"><b><?= __('screens.ally_forum.text') ?>:</b></td>
            <td>
                <textarea name="content" id="poll_content_area" rows="10"
                    style="width:100%; min-width:400px; border:1px solid #b0955a; padding:4px;"><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>
            </td>
        </tr>
    </table>

    <div style="margin-top:10px;">
        <input type="submit" name="preview" value="<?= __('screens.ally_forum.preview') ?>" class="btn">
        &nbsp;
        <input type="submit" name="submit" value="<?= __('screens.ally_forum.send') ?>" class="btn">
    </div>
</form>

<?php if (isset($can_moderate) && $can_moderate): ?>
    <div style="text-align:center; margin-top:20px;">
        <a href="<?= $baseUrl ?>&action=manage_categories"
            style="font-weight:bold;"><?= __('screens.ally_forum.admin_forum') ?></a>
    </div>
<?php endif; ?>

<script>
    function addAnswerRow() {
        var container = document.getElementById('answers_container');
        var input = document.createElement('input');
        input.type = 'text';
        input.name = 'options[]';
        input.size = 35;
        input.maxLength = 100;
        input.style.cssText = 'border:1px solid #b0955a; padding:2px; margin-bottom:3px; display:block; width:330px;';
        container.appendChild(input);
        container.appendChild(document.createElement('br'));
        input.focus();
    }

    document.addEventListener('DOMContentLoaded', function () {
        var q = document.getElementById('question_input');
        if (q) document.getElementById('q_counter').textContent = q.value.length;
    });

    $(document).ready(function () {
        BBCodes.init({
            target: '#poll_content_area',
            ajax_unit_url: 'ajax/unit_bb.php',
            ajax_building_url: 'ajax/build_bb.php'
        });
    });
</script>
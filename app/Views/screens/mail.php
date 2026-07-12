<link rel="stylesheet" href="/css/mail_modern.css">
<h2><?= __('screens.mail.title') ?></h2>

<?php if (!empty($error)): ?>
    <div  class="text-red" style="font-size:large;"><?= $error ?></div>
<?php endif; ?>

<table>
    <tr>
        <td valign="top">
            <table class="vis" width="100">
                <?php foreach ($links as $f_name => $f_mode): ?>
                    <tr>
                        <td class="<?= $mode === $f_mode ? 'selected' : '' ?>" width="120">
                            <a
                                href="game.php?village=<?= $village['id'] ?>&screen=mail&mode=<?= $f_mode ?>"><?= $f_name ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </td>
        <td valign="top" width="100%">
            <?php
            if (in_array($mode, $allow_mods)) {
                $viewPath = __DIR__ . '/mail_' . $mode . '.php';
                if (file_exists($viewPath)) {
                    include $viewPath;
                } else {
                    echo __('screens.mail.mode_not_implemented') . " " . htmlspecialchars($mode);
                }
            }
            ?>
        </td>
    </tr>
</table>

<script type="text/javascript">
$(document).ready(function() {
    // Make mail cards clickable
    $('.mail-list').on('click', '.mail-card', function(e) {
        // Don't trigger if clicking on links, buttons, checkboxes or their containers
        if ($(e.target).closest('a, input, button, .mail-actions, .mail-checkbox, .mail-from').length) {
            return;
        }
        
        var viewLink = $(this).find('.mail-subject').attr('href');
        if (viewLink) {
            window.location.href = viewLink;
        }
    });
});
</script>
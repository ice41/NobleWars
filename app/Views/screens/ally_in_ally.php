<h2><?= __('screens.ally.tribe') ?>
    <font color="blue"><?= htmlspecialchars($ally['name']) ?></font>
</h2>
<?php if (!empty($error)): ?>
    <h2 class="error"><?= $error ?></h2>
<?php endif; ?>
<table class="vis ally-nav-tabs">
    <tr>
        <?php foreach ($links as $f_name => $f_mode): ?>
            <td class="<?= ($f_mode == $mode) ? 'selected' : '' ?>" width="100">
                <a href="game.php?village=<?= $village['id'] ?>&screen=ally&mode=<?= $f_mode ?>"><?= $f_name ?></a>
            </td>
        <?php endforeach; ?>
    </tr>
</table>
<br />

<?php
if ($mode == 'profile') {
    $viewPath = __DIR__ . '/ally_in_ally_profile.php';
} else {
    $viewPath = __DIR__ . '/ally_in_ally_' . $mode . '.php';
}

if (file_exists($viewPath)) {
    include $viewPath;
} else {
    echo __('screens.ally.mode_not_implemented') . " " . htmlspecialchars($mode);
}
?>
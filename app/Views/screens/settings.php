<?php if (!empty($error)): ?>
    <span class="error"><?= $error ?></span>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <span class="success"><?= $success ?></span>
<?php endif; ?>

<h2><?= __('screens.settings.title') ?></h2>

<!-- Tab Navigation (Horizontal) -->
<table class="vis submenu-vis" width="100%">
    <tr>
        <?php foreach ($links as $link_name => $link_mode): ?>
            <?php
            $is_active = ($link_mode == $mode);
            $bg_color = $is_active ? '#e5c389' : '#f4e4bc';
            ?>
            <td align="center" class="nowrap" style="background-color: <?= $bg_color ?>; padding: 4px 10px; border: 1px solid #7d510f;">
                <a href="game.php?village=<?= $village['id'] ?>&screen=settings&mode=<?= $link_mode ?>"
                   style="text-decoration: none; font-weight: bold; color: #5d2f09;">
                    <?= $link_name ?>
                </a>
            </td>
        <?php endforeach; ?>
    </tr>
</table>
<br>

<!-- Settings View Content -->
<?php
// Use 'game_options' view for empty mode
$viewMode = empty($mode) ? 'game_options' : $mode;
$viewPath = __DIR__ . '/settings_' . $viewMode . '.php';
if (file_exists($viewPath)) {
    include $viewPath;
} else {
    echo "Modo não implementado: " . htmlspecialchars($mode);
}
?>
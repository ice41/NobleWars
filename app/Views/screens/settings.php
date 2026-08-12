<?php if (!empty($error)): ?>
    <span class="error"><?= $error ?></span>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <span class="success"><?= $success ?></span>
<?php endif; ?>

<?php
// Fallback robusto: a aldeia actual pode não estar sempre presente nos dados da view
$settingsVillageId = $village['id'] ?? ($_GET['village'] ?? 1);
?>

<h2><?= __('screens.settings.title') ?></h2>

<<<<<<< Updated upstream
<table>
    <tbody>
        <tr>
            <td valign="top">
                <table class="vis modemenu" style="width: 125px;">
                    <tbody>
                        <?php foreach ($links as $link_name => $link_mode): ?>
                            <tr>
                                <td width="100" class="<?= ($link_mode == $mode) ? 'selected' : '' ?>">
                                    <a
                                        href="game.php?village=<?= $village['id'] ?>&screen=settings&mode=<?= $link_mode ?>"><?= $link_name ?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
=======
<!-- Tab Navigation (Horizontal) -->
<table class="vis submenu-vis" width="100%">
    <tr>
        <?php foreach ($links as $link_name => $link_mode): ?>
            <?php
            $is_active = ($link_mode == $mode);
            $bg_color = $is_active ? '#e5c389' : '#f4e4bc';
            ?>
            <td align="center" class="nowrap" style="background-color: <?= $bg_color ?>; padding: 4px 10px; border: 1px solid #7d510f;">
                <a href="game.php?village=<?= $settingsVillageId ?>&screen=settings&mode=<?= $link_mode ?>"
                   style="text-decoration: none; font-weight: bold; color: #5d2f09;">
                    <?= $link_name ?>
                </a>
>>>>>>> Stashed changes
            </td>
            <td valign="top">
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
            </td>
        </tr>
    </tbody>
</table>
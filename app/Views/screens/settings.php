<?php if (!empty($error)): ?>
    <span class="error"><?= $error ?></span>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <span class="success"><?= $success ?></span>
<?php endif; ?>

<h2><?= __('screens.settings.title') ?></h2>

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
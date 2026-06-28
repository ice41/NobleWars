<?php if (!empty($error)): ?>
    <span class="error" /><?= $error ?></span>
<?php endif; ?>

<h2><?= __('screens.ranking.title') ?></h2>

<table width="100%">
    <tbody>
        <tr>
            <td valign="top" width="130">
                <table class="vis modemenu">
                    <tbody>
                        <?php foreach ($ranking_modes as $name => $dbmode): ?>
                            <?php if ($dbmode == $mode): ?>
                                <tr>
                                    <td class="selected" width="100">
                                        <a href="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=<?= $dbmode ?>"><?= $name ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td width="100">
                                        <a href="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=<?= $dbmode ?>"><?= $name ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </td>
            <td valign="top">
                <?php
                $viewPath = __DIR__ . '/ranking_' . $mode . '.php';
                if (file_exists($viewPath)) {
                    include $viewPath;
                } else {
                    echo __('screens.ranking.mode_not_implemented', ['mode' => htmlspecialchars($mode)]);
                }
                ?>
            </td>
        </tr>
    </tbody>
</table>
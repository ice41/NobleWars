<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<center>
    <table class="vis padding2" width="100%">
        <?php if (!empty($bookmarks)): ?>
            <tr>
                <th><?= __('screens.place.village_col') ?></th>
                <th><?= __('screens.place.coords_col') ?></th>
                <th width="80"><?= __('screens.place.action_col') ?></th>
            </tr>
            <?php foreach ($bookmarks as $bookmark): ?>
                <tr>
                    <td height="18px">
                        <a href="#"
                            onclick="insertNumId('x','<?= $bookmark['x'] ?>');insertNumId('y','<?= $bookmark['y'] ?>');javascript:inlinePopupClose()">
                            <?= htmlspecialchars($bookmark['name']) ?>
                        </a>
                        <?php if (!empty($bookmark['text'])): ?>
                            <span  style="font-size: 0.9em; color: #555;"> - <?= htmlspecialchars($bookmark['text']) ?></span>
                        <?php endif; ?>
                    </td>
                    <td align="center">
                        (<?= $bookmark['x'] ?>|<?= $bookmark['y'] ?>) K<?= $bookmark['continent'] ?>
                    </td>
                    <td align="center">
                        <a class="del-favorite-link btn btn-cancel" href="game.php?village=<?= $village['id'] ?>&amp;screen=popup&amp;mode=bookmark&amp;action=del&amp;id=<?= $bookmark['id'] ?>"><?= __('screens.place.remove_btn') ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td height="18px" align="center">Nenhum favorito adicionado.</td>
            </tr>
        <?php endif; ?>
    </table>
</center>
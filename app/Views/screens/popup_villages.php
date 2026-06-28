<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<center>
    <table class="vis padding2" width="100%">
        <?php if (!empty($villages)): ?>
            <tr>
                <th><?= __('screens.place.village_col') ?></th>
                <th><?= __('screens.place.coords_col') ?></th>
            </tr>
            <?php foreach ($villages as $v): ?>
                <tr>
                    <td height="18px">
                        <a href="#"
                            onclick="insertNumId('x','<?= $v['x'] ?>');insertNumId('y','<?= $v['y'] ?>');javascript:inlinePopupClose()">
                            <?= htmlspecialchars($v['name']) ?>
                        </a>
                    </td>
                    <td align="center">
                        (<?= $v['x'] ?>|<?= $v['y'] ?>) K<?= $v['continent'] ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td height="18px" align="center">Não possui outras aldeias.</td>
            </tr>
        <?php endif; ?>
    </table>
</center>
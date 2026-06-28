<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<center>
    <table class="vis padding2" width="100%">
        <?php if (!empty($history)): ?>
            <tr>
                <th><?= __('screens.place.village_col') ?></th>
                <th><?= __('screens.place.coords_col') ?></th>
            </tr>
            <?php foreach ($history as $item): ?>
                <tr>
                    <td height="18px">
                        <a href="#"
                            onclick="insertNumId('x','<?= $item['x'] ?>');insertNumId('y','<?= $item['y'] ?>');javascript:inlinePopupClose()">
                            <?= htmlspecialchars($item['name']) ?>
                        </a>
                    </td>
                    <td align="center">
                        (<?= $item['x'] ?>|<?= $item['y'] ?>) K<?= $item['continent'] ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td height="18px" align="center">Nenhum histórico de ataques.</td>
            </tr>
        <?php endif; ?>
    </table>
</center>
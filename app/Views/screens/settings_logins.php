<h3><?= __('screens.settings_logins.title') ?></h3>
<p><?= __('screens.settings_logins.description') ?></p>

<h4><?= __('screens.settings_logins.last_20_logins') ?></h4>

<table class="vis">
    <tbody>
        <tr>
            <th><?= __('screens.settings_logins.date') ?></th>
            <th><?= __('screens.settings_logins.ip') ?></th>
            <th><?= __('screens.settings_logins.deputy') ?></th>
        </tr>
        <?php if (!empty($logins)): ?>
            <?php foreach ($logins as $login): ?>
                <tr>
                    <td><?= $login['time'] ?></td>
                    <td><?= $login['ip'] ?></td>
                    <td>
                        <?php if (!empty($login['uv'])): ?>
                            <a
                                href="game.php?village=<?= $village['id'] ?>&screen=info_user&id=<?= $login['uv'] ?>"><?= $login['uv_name'] ?></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3"><?= __('screens.settings_logins.no_logins') ?></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
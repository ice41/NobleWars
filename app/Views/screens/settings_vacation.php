<h3><?= __('screens.settings_vacation.title') ?></h3>
<p><?= __('screens.settings_vacation.description') ?></p>

<form action="game.php?village=<?= $village['id'] ?>&screen=settings&mode=vacation&action=activate&h=<?= $hkey ?>"
    method="post">
    <table class="vis">
        <tbody>
            <tr>
                <td><?= __('screens.settings_vacation.substitute') ?></td>
                <td><input name="substitute" type="text" value="<?= htmlspecialchars($vacation_substitute ?? '') ?>">
                </td>
                <td><input class="btn btn-default" value="OK" type="submit"></td>
            </tr>
        </tbody>
    </table>
</form>

<br>
<?php if (!empty($vacation_id)): ?>
    <table class="vis" width="100%">
        <tbody>
            <tr>
                <th><?= __('screens.settings_vacation.substitute') ?></th>
                <th><?= __('screens.settings_vacation.start') ?></th>
                <th><?= __('screens.settings_vacation.end') ?></th>
                <th><?= __('screens.settings_vacation.action') ?></th>
            </tr>
            <tr>
                <td><a
                        href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $vacation_id ?>"><?= $vacation_name ?></a>
                </td>
                <td><?= $vacation_date ?></td>
                <td>-</td>
                <td><a
                        href="game.php?village=<?= $village['id'] ?>&screen=settings&mode=vacation&action=cancel_vacation&h=<?= $hkey ?>"><?= __('screens.settings_vacation.end_substitution') ?></a>
                </td>
            </tr>
        </tbody>
    </table>
<?php endif; ?>
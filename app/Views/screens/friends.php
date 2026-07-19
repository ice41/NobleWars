<?php if (!empty($error)): ?>
    <div class="error"><?= $error ?></div>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <div class="success"><?= $success ?></div>
<?php endif; ?>

<h3><?= __('screens.profile.friends_title') ?></h3>

<p><?= __('screens.profile.friends_description') ?></p>

<table class="vis" width="100%">
    <tr>
        <th><?= __('screens.profile.name') ?></th>
        <th><?= __('screens.profile.points') ?></th>
        <th><?= __('screens.profile.villages') ?></th>
        <th><?= __('screens.profile.tribe') ?></th>
        <th><?= __('screens.profile.actions') ?></th>
    </tr>
    <?php if (!empty($friends)): ?>
        <?php foreach ($friends as $friend): ?>
            <tr>
                <td>
                    <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $friend['id'] ?>">
                        <?= $friend['username'] ?>
                    </a>
                </td>
                <td><?= format_number($friend['points']) ?></td>
                <td><?= format_number($friend['villages']) ?></td>
                <td>
                    <?php if ($friend['ally'] != 0 && !empty($friend['ally_short'])): ?>
                        <a href="game.php?village=<?= $village['id'] ?>&screen=info_ally&id=<?= $friend['ally'] ?>">
                            <?= htmlspecialchars($friend['ally_short']) ?>
                        </a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td>
                    <a
                        href="game.php?village=<?= $village['id'] ?>&screen=friends&action=remove&id=<?= $friend['id'] ?>&h=<?= $hkey ?>"><?= __('screens.profile.remove') ?></a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5" align="center"><?= __('screens.profile.no_friends_found') ?></td>
        </tr>
    <?php endif; ?>
</table>

<br>

<table class="vis" width="100%">
    <tr>
        <th colspan="2"><?= __('screens.profile.add_friend') ?></th>
    </tr>
    <tr>
        <td colspan="2">
            <form action="game.php?village=<?= $village['id'] ?>&screen=profile&mode=friends&action=add&h=<?= $hkey ?>"
                method="post" style="display: inline;">
                <input type="text" name="friend_name" placeholder="<?= __('screens.profile.player_name') ?>" size="20">
                <input type="submit" value="<?= __('screens.profile.add') ?>" class="btn">
            </form>
            <span  class="float-right text-right">
                <?= __('screens.profile.friends_not_playing') ?><br>
                <?= __('screens.profile.invite_to_help') ?><br>
                <a
                    href="game.php?village=<?= $village['id'] ?>&screen=profile&mode=invite"><b><?= __('screens.profile.invite_friends') ?></b></a>
            </span>
        </td>
    </tr>
</table>
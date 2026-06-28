<?php if (empty($error)): ?>
    <h3><?= __('screens.ranking.enemies_defeated') ?></h3>

    <div>
        <table id="kill_player_ranking_table" class="vis" width="100%">
            <tbody>
                <tr>
                    <?php foreach ($modes_types as $type_name => $db_type): ?>
                        <?php if ($db_type == $type): ?>
                            <td style="text-align: center;" class="selected" width="33%">
                                <a
                                    href="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=kill_player&type=<?= $db_type ?>"><?= $type_name ?></a>
                            </td>
                        <?php else: ?>
                            <td style="text-align: center;" width="33%">
                                <a
                                    href="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=kill_player&type=<?= $db_type ?>"><?= $type_name ?></a>
                            </td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>

        <table class="vis" width="100%">
            <tbody>
                <tr>
                    <th width="15%"><?= __('screens.ranking.rank') ?></th>
                    <th width="60%"><?= __('screens.ranking.name') ?></th>
                    <th width="25%"><?= __('screens.ranking.eliminated') ?></th>
                </tr>
                <?php foreach ($user_rangs as $userinfo): ?>
                    <tr class="<?= ($userinfo['rang'] == $aktu) ? 'lit' : '' ?>">
                        <td class="lit-item">
                            <?= $userinfo['rang'] ?>
                        </td>
                        <td class="lit-item">
                            <?php
                            $avatarId = $userinfo['avatar'] ?? 0;
                            $avatarPath = $avatarId > 0 ? "graphic/player/profile/{$avatarId}.webp" : "graphic/player/profile/default.webp";
                            ?>
                            <img src="<?= $avatarPath ?>"
                                style="width: 20px; height: 20px; vertical-align: middle; margin-right: 5px; border: 1px solid #3e2723;">
                            <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $userinfo['id'] ?>">
                                <?= $userinfo['username'] ?>
                            </a>

                            <?php if (($userinfo['ally'] ?? -1) != '-1'): ?>
                                [<a
                                    href="game.php?village=<?= $village['id'] ?>&screen=info_ally&id=<?= $userinfo['ally'] ?>"><?= $userinfo['allyshort'] ?></a>]
                            <?php endif; ?>
                        </td>
                        <td class="lit-item"><?= format_number($userinfo['score']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if (!$is_search): ?>
            <table class="vis" width="100%">
                <tbody>
                    <tr>
                        <?php if ($aktu_page_ra > 0): ?>
                            <td align="center" width="50%">
                                <a
                                    href="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=kill_player&type=<?= $type ?>&page=<?= $aktu_page_ra - 1 ?>">&lt;&lt;&lt;
                                    <?= __('screens.ranking.previous') ?></a>
                            </td>
                        <?php endif; ?>
                        <td align="center" width="50%">
                            <a
                                href="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=kill_player&type=<?= $type ?>&page=<?= $aktu_page_ra + 1 ?>"><?= __('screens.ranking.next') ?>
                                &gt;&gt;&gt;</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
<?php endif; ?>


<table class="vis" width="100%">
    <tbody>
        <tr>
            <td style="padding-right: 10px;">
                <form action="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=kill_player&type=<?= $type ?>"
                    method="post">
                    <?= __('screens.ranking.position_goto') ?> <input name="from" value="" size="6" type="text">
                    <input class="btn btn-default" value="<?= __('screens.ranking.go') ?>" type="submit">
                </form>
            </td>
            <td style="padding-right: 10px;">
                <form action="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=kill_player&type=<?= $type ?>"
                    method="post">
                    <?= __('screens.ranking.search') ?> <input name="search" value="" size="20" type="text">
                    <input class="btn btn-default" value="<?= __('screens.ranking.go') ?>" type="submit">
                </form>
            </td>
        </tr>
    </tbody>
</table>
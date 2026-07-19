<?php if (empty($error)): ?>
    <h3><?= str_replace('{con}', $RA_continent, __('screens.ranking.continent_player_title')) ?></h3>

    <div>

        <table id="con_player_ranking_table" class="vis" width="100%">
            <tbody>
                <tr>
                    <th width="60"><?= __('screens.ranking.rank') ?></th>
                    <th width="160"><?= __('screens.ranking.name') ?></th>
                    <th width="60"><?= __('screens.ranking.tribe') ?></th>
                    <th width="100"><?= __('screens.ranking.points') ?></th>
                    <th width="60"><?= __('screens.ranking.villages') ?></th>
                    <th width="60"><?= __('screens.ranking.total_villages') ?></th>
                </tr>
                <?php foreach ($continent_rangs as $userinfo): ?>
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
                        </td>
                        <td class="lit-item">
                            <?php if (($userinfo['ally'] ?? -1) != '-1'): ?>
                                <a href="game.php?village=<?= $village['id'] ?>&screen=info_ally&id=<?= $userinfo['ally'] ?>">
                                    <?= $userinfo['allyshort'] ?>
                                </a>
                            <?php endif; ?>
                        </td>
                        <td class="lit-item">
                            <?= format_number($userinfo['points']) ?>
                        </td>
                        <td class="lit-item">
                            <?= format_number($userinfo['villages_con']) ?>
                        </td>
                        <td class="lit-item">
                            <?= format_number($userinfo['villages']) ?>
                        </td>
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
                                    href="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=con_player&con=<?= $RA_continent ?>&page=<?= $aktu_page_ra - 1 ?>">&lt;&lt;&lt;
                                    <?= __('screens.ranking.previous') ?></a>
                            </td>
                        <?php endif; ?>
                        <td align="center" width="50%">
                            <a
                                href="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=con_player&con=<?= $RA_continent ?>&page=<?= $aktu_page_ra + 1 ?>"><?= __('screens.ranking.next') ?>
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
            <td  style="padding-right: 10px;">
                <form action="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=con_player" method="post">
                    <?= __('screens.ranking.continent') ?> <input name="continent" value="" size="2" type="text">
                    <input value="OK" type="submit">
                </form>
            </td>
            <td  style="padding-right: 10px;">
                <form
                    action="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=con_player&con=<?= $RA_continent ?>"
                    method="post">
                    <?= __('screens.ranking.ranking_goto') ?> <input name="from" value="" size="6" type="text">
                    <input class="btn btn-default" value="<?= __('screens.ranking.go') ?>" type="submit">
                </form>
            </td>
            <td  style="padding-right: 10px;">
                <form
                    action="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=con_player&con=<?= $RA_continent ?>"
                    method="post">
                    <?= __('screens.ranking.search') ?> <input name="search" value="" size="20" type="text">
                    <input class="btn btn-default" value="<?= __('screens.ranking.go') ?>" type="submit">
                </form>
            </td>
        </tr>
    </tbody>
</table>
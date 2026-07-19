<!-- Include Name Cosmetics CSS -->
<link rel="stylesheet" href="/css/name_cosmetics.css">

<?php if (empty($error)): ?>
    <?php if (!empty($top3_players)): ?>
        <div class="ranking-top3">
            <?php if (isset($top3_players[1])): // Silver (2nd) ?>
                <div class="silver">
                    <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $top3_players[1]['id'] ?>"
                        title="<?= htmlspecialchars($top3_players[1]['username']) ?>">
                        <?= htmlspecialchars($top3_players[1]['username']) ?>
                    </a>
                </div>
            <?php endif; ?>
            <?php if (isset($top3_players[0])): // Gold (1st) ?>
                <div class="gold">
                    <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $top3_players[0]['id'] ?>"
                        title="<?= htmlspecialchars($top3_players[0]['username']) ?>">
                        <?= htmlspecialchars($top3_players[0]['username']) ?>
                    </a>
                </div>
            <?php endif; ?>
            <?php if (isset($top3_players[2])): // Bronze (3rd) ?>
                <div class="bronze">
                    <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $top3_players[2]['id'] ?>"
                        title="<?= htmlspecialchars($top3_players[2]['username']) ?>">
                        <?= htmlspecialchars($top3_players[2]['username']) ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div>
        <table id="player_ranking_table" class="vis" width="100%">
            <tbody>
                <tr>
                    <th width="60"><?= __('screens.ranking.rank') ?></th>
                    <th width="180"><?= __('screens.ranking.name') ?></th>
                    <th width="100"><?= __('screens.ranking.tribe') ?></th>
                    <th width="60"><?= __('screens.ranking.points') ?></th>
                    <th><?= __('screens.ranking.villages') ?></th>
                    <th><?= __('screens.ranking.points_per_village') ?></th>
                </tr>
                <?php foreach ($user_rangs as $userinfo): ?>
                    <tr <?= ($userinfo['rang'] == $aktu) ? 'class="lit"' : (($userinfo['rang'] == $from || ($userinfo['ally'] == $ally && $ally != '-1')) ? 'class="lit2"' : '') ?>>
                        <td class="lit-item">
                            <?= $userinfo['rang'] ?>
                        </td>
                        <td class="lit-item">
                            <?php
                            // Display small avatar thumbnail
                            $avatarId = $userinfo['avatar'] ?? 0;
                            $avatarPath = $avatarId > 0 ? "graphic/player/profile/{$avatarId}.webp" : "graphic/player/profile/default.webp";
                            ?>
                            <img src="<?= $avatarPath ?>"
                                style="width: 20px; height: 20px; vertical-align: middle; margin-right: 5px; border: 1px solid #3e2723;">
                            <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $userinfo['id'] ?>">
                                <?= \App\Helpers\CosmeticHelper::formatUsername($userinfo['username'], $userinfo['id']) ?>
                            </a>
                        </td>
                        <td class="lit-item">
                            <?php if ($userinfo['ally'] != '-1'): ?>
                                <a href="game.php?village=<?= $village['id'] ?>&screen=info_ally&id=<?= $userinfo['ally'] ?>">
                                    <?= htmlspecialchars($userinfo['allyshort']) ?>
                                </a>
                            <?php endif; ?>
                        </td>
                        <td class="lit-item">
                            <?= number_format($userinfo['points'], 0, ',', '.') ?>
                        </td>
                        <td class="lit-item">
                            <?= number_format($userinfo['villages'], 0, ',', '.') ?>
                        </td>
                        <td class="lit-item">
                            <?= number_format($userinfo['srednia_pkt_na_vg'], 0, ',', '.') ?>
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
                                    href="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=player&page=<?= $aktu_page_ra - 1 ?>">&lt;&lt;&lt;
                                    <?= __('screens.ranking.previous') ?></a>
                            </td>
                        <?php endif; ?>
                        <td align="center" width="50%">
                            <a
                                href="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=player&page=<?= $aktu_page_ra + 1 ?>"><?= __('screens.ranking.next') ?>
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
                <form action="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=player" method="post">
                    <?= __('screens.ranking.position_goto') ?> <input name="from" value="" size="6" type="text">
                    <input class="btn btn-default" value="<?= __('screens.ranking.go') ?>" type="submit">
                </form>
            </td>
            <td  style="padding-right: 10px;">
                <form action="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=player" method="post">
                    <?= __('screens.ranking.search') ?> <input name="search" value="" size="20" type="text">
                    <input class="btn btn-default" value="<?= __('screens.ranking.go') ?>" type="submit">
                </form>
            </td>
        </tr>
    </tbody>
</table>
<?php if (empty($error)): ?>

    <div class="ranking-top3">
        <div class="gold">
            <?php if (isset($top3_allies[0])): ?>
                <a
                    href="game.php?village=<?= $village['id'] ?>&screen=info_ally&id=<?= $top3_allies[0]['id'] ?>"><?= htmlspecialchars($top3_allies[0]['short']) ?></a>
            <?php else: ?>
                <span>-</span>
            <?php endif; ?>
        </div>
        <div class="silver">
            <?php if (isset($top3_allies[1])): ?>
                <a
                    href="game.php?village=<?= $village['id'] ?>&screen=info_ally&id=<?= $top3_allies[1]['id'] ?>"><?= htmlspecialchars($top3_allies[1]['short']) ?></a>
            <?php else: ?>
                <span>-</span>
            <?php endif; ?>
        </div>
        <div class="bronze">
            <?php if (isset($top3_allies[2])): ?>
                <a
                    href="game.php?village=<?= $village['id'] ?>&screen=info_ally&id=<?= $top3_allies[2]['id'] ?>"><?= htmlspecialchars($top3_allies[2]['short']) ?></a>
            <?php else: ?>
                <span>-</span>
            <?php endif; ?>
        </div>
    </div>
    <div>
        <table id="player_ranking_table" class="vis" width="100%">
            <tbody>
                <tr>
                    <th width="50"><?= __('screens.ranking.rank') ?></th>
                    <th width="120"><?= __('screens.ranking.tribe_name') ?></th>
                    <th width="100"><?= __('screens.ranking.best_40_points') ?></th>
                    <th width="80"><?= __('screens.ranking.total_points') ?></th>
                    <th width="70"><?= __('screens.ranking.members') ?></th>
                    <th width="90"><?= __('screens.ranking.points_per_player') ?></th>
                    <th width="60"><?= __('screens.ranking.villages') ?></th>
                    <th width="90"><?= __('screens.ranking.points_per_village') ?></th>
                </tr>

                <?php foreach ($ally_rangs as $allyinfo): ?>
                    <tr <?= ($allyinfo['id'] == ($user['ally'] ?? -1)) ? 'class="lit"' : (($allyinfo['rang'] == $from) ? 'class="lit2"' : '') ?>>
                        <td class="lit-item"><?= $allyinfo['rang'] ?></td>
                        <td class="lit-item">
                            <?php
                            // Display small ally logo thumbnail (always show, use default if none)
                            $allyImage = !empty($allyinfo['image']) ? "{$allyinfo['image']}" : "graphic/ally/profile/default.webp";
                            ?>
                            <img src="<?= $allyImage ?>"
                                style="width: 20px; height: 20px; vertical-align: middle; margin-right: 5px; border: 1px solid #3e2723;">
                            <a
                                href="game.php?village=<?= $village['id'] ?>&screen=info_ally&id=<?= $allyinfo['id'] ?>"><?= htmlspecialchars($allyinfo['short']) ?></a>
                        </td>
                        <td class="lit-item"><?= number_format($allyinfo['points'], 0, ',', '.') ?></td>
                        <td class="lit-item"><?= number_format($allyinfo['best_points'] ?? 0, 0, ',', '.') ?></td>
                        <td class="lit-item"><?= number_format($allyinfo['members'], 0, ',', '.') ?></td>
                        <td class="lit-item"><?= number_format($allyinfo['sr_pkt_na_gracza'], 0, ',', '.') ?></td>
                        <td class="lit-item"><?= number_format($allyinfo['villages'], 0, ',', '.') ?></td>
                        <td class="lit-item"><?= number_format($allyinfo['sr_pkt_na_wioske'], 0, ',', '.') ?></td>
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
                                    href="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=ally&page=<?= $aktu_page_ra - 1 ?>">&lt;&lt;&lt;
                                    <?= __('screens.ranking.previous') ?></a>
                            </td>
                        <?php endif; ?>
                        <td align="center" width="50%">
                            <a
                                href="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=ally&page=<?= $aktu_page_ra + 1 ?>"><?= __('screens.ranking.next') ?>
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
                <form action="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=ally" method="post">
                    <?= __('screens.ranking.ranking_goto') ?> <input name="from" value="" size="6" type="text">
                    <input class="btn btn-default" value="<?= __('screens.ranking.go') ?>" type="submit">
                </form>
            </td>
            <td  style="padding-right: 10px;">
                <form action="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=ally" method="post">
                    <?= __('screens.ranking.search') ?> <input name="search" value="" size="20" type="text">
                    <input class="btn btn-default" value="<?= __('screens.ranking.go') ?>" type="submit">
                </form>
            </td>
        </tr>
    </tbody>
</table>
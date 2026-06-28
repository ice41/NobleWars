<?php if (empty($error)): ?>
    <h3><?= str_replace('{con}', $RA_continent, __('screens.ranking.continent_ally_title')) ?></h3>

    <div>

        <table id="con_player_ranking_table" class="vis" width="100%">
            <tbody>
                <tr>
                    <th width="60"><?= __('screens.ranking.rank') ?></th>
                    <th width="160"><?= __('screens.ranking.tribe_name') ?></th>
                    <th width="100"><?= __('screens.ranking.points') ?></th>
                    <th width="60"><?= __('screens.ranking.villages') ?></th>
                </tr>
                <?php foreach ($continent_rangs as $allyinfo): ?>
                    <tr class="<?= ($allyinfo['id'] == $ally) ? 'lit' : '' ?>">
                        <td class="lit-item">
                            <?= $allyinfo['rang'] ?>
                        </td>
                        <td class="lit-item">
                            <?php
                            $allyImage = !empty($allyinfo['image']) ? "{$allyinfo['image']}" : "graphic/ally/profile/default.webp";
                            ?>
                            <img src="<?= $allyImage ?>"
                                style="width: 20px; height: 20px; vertical-align: middle; margin-right: 5px; border: 1px solid #3e2723;">
                            <a href="game.php?village=<?= $village['id'] ?>&screen=info_ally&id=<?= $allyinfo['id'] ?>">
                                <?= $allyinfo['short'] ?>
                            </a>
                        </td>
                        <td class="lit-item">
                            <?= format_number($allyinfo['points']) ?>
                        </td>
                        <td class="lit-item">
                            <?= format_number($allyinfo['villages']) ?>
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
                                    href="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=con_ally&con=<?= $RA_continent ?>&page=<?= $aktu_page_ra - 1 ?>">&lt;&lt;&lt;
                                    <?= __('screens.ranking.previous') ?></a>
                            </td>
                        <?php endif; ?>
                        <td align="center" width="50%">
                            <a
                                href="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=con_ally&con=<?= $RA_continent ?>&page=<?= $aktu_page_ra + 1 ?>"><?= __('screens.ranking.next') ?>
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
                <form action="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=con_ally" method="post">
                    <?= __('screens.ranking.continent') ?> <input name="continent" value="" size="2" type="text">
                    <input value="OK" type="submit">
                </form>
            </td>
            <td style="padding-right: 10px;">
                <form
                    action="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=con_ally&con=<?= $RA_continent ?>"
                    method="post">
                    <?= __('screens.ranking.ranking_goto') ?> <input name="from" value="" size="6" type="text">
                    <input class="btn btn-default" value="<?= __('screens.ranking.go') ?>" type="submit">
                </form>
            </td>
            <td style="padding-right: 10px;">
                <form
                    action="game.php?village=<?= $village['id'] ?>&screen=ranking&mode=con_ally&con=<?= $RA_continent ?>"
                    method="post">
                    <?= __('screens.ranking.search') ?> <input name="search" value="" size="20" type="text">
                    <input class="btn btn-default" value="<?= __('screens.ranking.go') ?>" type="submit">
                </form>
            </td>
        </tr>
    </tbody>
</table>
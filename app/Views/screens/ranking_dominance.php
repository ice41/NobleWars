<?php
/**
 * Ranking Dominance View
 * Shows tribe world dominance percentages
 */
?>

<h2><?= __('screens.ranking.dominance_title') ?></h2>

<p><?= __('screens.ranking.dominance_intro') ?><br />
    <?= __('screens.ranking.dominance_intro2') ?></p>

<table width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td valign="top" width="50%"  style="padding-right: 5px;">
            <!-- Left side: Tribe rankings -->
            <h3><?= __('screens.ranking.top_tribes_dominance') ?></h3>
            <table class="vis" width="100%">
                <tr>
                    <th width="60"><?= __('screens.ranking.rank') ?></th>
                    <th><?= __('screens.ranking.tribe') ?></th>
                    <th width="80"><?= __('screens.ranking.villages') ?></th>
                    <th><?= __('screens.ranking.world_dominance') ?></th>
                </tr>

                <?php if (empty($dominance_rankings)): ?>
                    <tr>
                        <td colspan="4" class="center"><?= __('screens.ranking.no_tribes_found') ?></td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($dominance_rankings as $ranking): ?>
                        <tr <?= ($ranking['id'] == ($ally ?? -1)) ? 'class="lit-item"' : '' ?>>
                            <td class="center"><?= $ranking['rang'] ?></td>
                            <td>
                                <a href="game.php?village=<?= $village['id'] ?>&screen=info_ally&id=<?= $ranking['id'] ?>">
                                    <?= htmlspecialchars($ranking['short']) ?>
                                </a>
                            </td>
                            <td class="center"><?= number_format($ranking['villages']) ?></td>
                            <td class="center"><?= $ranking['dominance_percent'] ?>% / 60%</td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
        </td>

        <td valign="top" width="50%"  style="padding-left: 10px;">
            <!-- Right side: Victory conditions -->
            <h3><?= __('screens.ranking.victory_conditions') ?></h3>

            <table class="vis" width="100%">
                <tr>
                    <th width="40%"><?= __('screens.ranking.condition') ?></th>
                    <th width="60%"><?= __('screens.ranking.status') ?></th>
                </tr>
                <tr>
                    <td><?= __('screens.ranking.world_age') ?></td>
                    <td>
                        <?php
                        $age_percent = min(100, (($world_age_days ?? 10) / 180) * 100);
                        ?>
                        <div class="progress-bar"  style="position: relative;">
                            <div  style="width: <?= $age_percent ?>%;" <?= $age_percent >= 100 ? 'class="full"' : '' ?>></div>
                            <span  class="w-100 bold text-center" style="position: absolute; top: 0; left: 0; line-height: 20px; color: #321c08; text-shadow: 0 0 2px #fff, 0 0 2px #fff; font-size: 11px; display: block;"><?= ($world_age_days ?? 10) ?> / 180 <?= __('screens.premium.days') ?></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><?= __('screens.ranking.top_dominance') ?></td>
                    <td>
                        <?php
                        $top_dominance = !empty($dominance_rankings) ? $dominance_rankings[0]['dominance_percent'] : 0;
                        $dom_percent = min(100, ($top_dominance / 60) * 100);
                        ?>
                        <div class="progress-bar"  style="position: relative;">
                            <div  style="width: <?= $dom_percent ?>%;" <?= $dom_percent >= 100 ? 'class="full"' : '' ?>></div>
                            <span  class="w-100 bold text-center" style="position: absolute; top: 0; left: 0; line-height: 20px; color: #321c08; text-shadow: 0 0 2px #fff, 0 0 2px #fff; font-size: 11px; display: block;"><?= $top_dominance ?>% / 60%</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><?= __('screens.ranking.total_villages') ?></td>
                    <td><?= number_format($total_villages ?? 0) ?></td>
                </tr>
                <tr>
                    <td><?= __('screens.ranking.hold_dominance') ?></td>
                    <td>
                        <?php
                        $hold_percent = min(100, (($days_held ?? 0) / 14) * 100);
                        ?>
                        <div class="progress-bar"  style="position: relative;">
                            <div  style="width: <?= $hold_percent ?>%;" <?= $hold_percent >= 100 ? 'class="full"' : '' ?>></div>
                            <span  class="w-100 bold text-center" style="position: absolute; top: 0; left: 0; line-height: 20px; color: #321c08; text-shadow: 0 0 2px #fff, 0 0 2px #fff; font-size: 11px; display: block;"><?= ($days_held ?? 0) ?> / 14 <?= __('screens.premium.days') ?></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><?= __('screens.ranking.your_contribution') ?></td>
                    <td>
                        <?php
                        $tribe_villages = !empty($dominance_rankings) ? $dominance_rankings[0]['villages'] : 1;
                        $contribution_percent = $tribe_villages > 0 ? (($user_villages ?? 0) / $tribe_villages) * 100 : 0;
                        ?>
                        <div class="progress-bar"  style="position: relative;">
                            <div  style="width: <?= min(100, $contribution_percent) ?>%;" <?= $contribution_percent >= 100 ? 'class="full"' : '' ?>></div>
                            <span  class="w-100 bold text-center" style="position: absolute; top: 0; left: 0; line-height: 20px; color: #321c08; text-shadow: 0 0 2px #fff, 0 0 2px #fff; font-size: 11px; display: block;"><?= round($contribution_percent, 2) ?>%</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><?= __('screens.ranking.world_dominance') ?></td>
                    <td>
                        <?= (($world_age_days ?? 10) >= 180 && $top_dominance >= 60) ? __('screens.ranking.tribe_dominates') : __('screens.ranking.no_tribe_dominates') ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br />

<p><?= __('screens.ranking.dominance_hold_note') ?></p>

<?php if (!empty($dominance_rankings) && $dominance_rankings[0]['dominance_percent'] >= 60): ?>
    <div class="success">
        <h3>🏆
            <?= str_replace('{tribe}', htmlspecialchars($dominance_rankings[0]['short']), __('screens.ranking.tribe_dominating')) ?>
        </h3>
        <p><?= __('screens.ranking.dominance_percent_label') ?> <b><?= $dominance_rankings[0]['dominance_percent'] ?>%</b>
        </p>
    </div>
<?php endif; ?>
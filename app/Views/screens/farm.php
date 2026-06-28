<table>
    <tr>
        <td>
            <img src="graphic/big_buildings/farm1.png" title="<?= __('screens.farm.farm') ?>" alt="" />
        </td>
        <td>
            <h2><?= __('screens.farm.farm') ?> (<?= __('screens.common.level') ?> <?php echo $village['farm']; ?>)</h2>
            <p><?= __('screens.farm.farm_description') ?>
            </p>
        </td>
    </tr>
</table>
<br />

<table width="100%">
    <tr>
        <td valign="top" width="300">
            <img src="graphic/reports/militia.jpg" alt="Milícia">
        </td>
        <td valign="top">
            <table class="vis" width="100%">
                <tr>
                    <th colspan="2"></span><?= __('screens.farm.max_population') ?></th>
                </tr>
                <tr>
                    <td width="80%"><span class="icon header population"></span><?= __('screens.farm.max_population') ?>
                    </td>
                    <td align="right"><b><?php echo $max_bh; ?></b></td>
                </tr>
                <tr>
                    <td><span class="icon header population"></span><?= __('screens.farm.max_population_at_level') ?>
                        <?php echo $village['farm'] + 1; ?>
                    </td>
                    <td align="right"><b><?php echo $max_bh_next; ?></b></td>
                </tr>
            </table>
            <br />
            <table class="vis" width="100%">
                <tr>
                    <th colspan="2"><?= __('screens.farm.current_population') ?></th>
                </tr>
                <tr>
                    <td width="80%"><?= __('screens.farm.buildings_construction_included') ?></td>
                    <td align="right"><b><?php echo $buildings_bh; ?></b></td>
                </tr>
                <tr>
                    <td><?= __('screens.farm.troops') ?></td>
                    <td align="right"><b><?php echo $units_bh; ?></b></td>
                </tr>
                <tr>
                    <td><?= __('screens.farm.troops_in_production') ?></td>
                    <td align="right"><b>0</b></td>
                </tr>
                <tr>
                    <th><?= __('screens.farm.all') ?></th>
                    <th align="right"><?php echo $current_bh; ?></th>
                </tr>
            </table>
            <br />
            <table>
                <tr>
                    <th colspan="2"><img src="graphic/unit/unit_militia.png">
                        <?= __('screens.farm.militia_in_village') ?></th>
                </tr>
                <td class="vis" width="100%">
                    <table class="vis" width="100%">
                        <td valign="top" width="100%">
                            <p><?= __('screens.farm.militia_description') ?></p>
                            <ul>
                                <li><?= __('screens.farm.militia_effect_1') ?></li>
                                <li><?= __('screens.farm.militia_effect_2') ?></li>
                                <li><?= __('screens.farm.militia_effect_3') ?></li>
                                <li style="color: #aa0000; font-weight: bold;">
                                    <?= __('screens.farm.militia_effect_4') ?></li>
                            </ul>

                            <div style="text-align: center; margin-top: 10px;">
                                <?php if ($error): ?>
                                    <div class="error"><?php echo $error; ?></div>
                                <?php endif; ?>

                                <?php if ($militia_active): ?>
                                    <p style="font-weight: bold; color: green;"><?= __('screens.farm.militia_active') ?></p>
                                    <p><?= __('screens.farm.production_returns_in') ?> <span
                                            class="timer"><?php echo format_time($militia_end_time - time()); ?></span></p>
                                <?php else: ?>
                                    <?php if ($villages_count > 2): ?>
                                        <span class="inactive"><?= __('screens.farm.cannot_call_militia') ?></span>
                                    <?php else: ?>
                                        <form
                                            action="game.php?village=<?php echo $village['id']; ?>&screen=farm&action=call_militia&h=<?php echo $hkey; ?>"
                                            method="post">
                                            <input type="submit" value="<?= __('screens.farm.call_militia') ?>" class="btn"
                                                onclick="return confirm('<?= __('screens.farm.call_militia_confirm') ?>');">
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </td>
                </td>
            </table>

        </td>
</table>
</td>
</tr>
</table>
<br />

<!-- Militia Section -->

</div>
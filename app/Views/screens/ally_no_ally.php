<h2><?= __('screens.ally.tribe') ?></h2>

<?php if (!empty($error)): ?>
    <div class="error"><?= $error ?></div>
<?php endif; ?>

<p><?= __('screens.ally.tribes_description_1') ?></p>
<p><?= __('screens.ally.tribes_description_2') ?></p>

<!-- Benefits Section -->
<div  class="text-center" style="margin: 40px 0;">
    <h1  style="color: #8B4513; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); font-size: 36px; margin: 20px 0;"><?= __('screens.ally.benefits') ?></h1>
</div>

<div  style="max-width: 600px; margin: 0 auto 40px; padding: 20px; background-color: rgba(255,255,255,0.3); border-radius: 10px;">
    <table width="100%" cellpadding="8">
        <tr>
            <td width="30"  class="v-align-top text-center">⚔</td>
            <td><?= __('screens.ally.benefit_trade') ?></td>
        </tr>
        <tr>
            <td  class="v-align-top text-center">⚔</td>
            <td><?= __('screens.ally.benefit_skills') ?></td>
        </tr>
        <tr>
            <td  class="v-align-top text-center">⚔</td>
            <td><?= __('screens.ally.benefit_coordinate') ?></td>
        </tr>
        <tr>
            <td  class="v-align-top text-center">⚔</td>
            <td><?= __('screens.ally.benefit_socialize') ?></td>
        </tr>
        <tr>
            <td  class="v-align-top text-center">⚔</td>
            <td><?= __('screens.ally.benefit_support') ?></td>
        </tr>
        <tr>
            <td  class="v-align-top text-center">⚔</td>
            <td><?= __('screens.ally.benefit_conquer') ?></td>
        </tr>
    </table>
</div>

<!-- Bottom 3 Sections -->
<table width="100%" cellpadding="5" cellspacing="10">
    <tr valign="top">
        <!-- Convites -->
        <td width="33%">
            <table class="vis" width="100%">
                <tr><th colspan="3"><?= __('screens.ally.invites') ?></th></tr>
                <?php if (!empty($invites)): ?>
                    <?php foreach ($invites as $invite): ?>
                        <tr>
                            <td>
                                <a href="game.php?village=<?= $village['id'] ?>&screen=info_ally&id=<?= $invite['from_ally'] ?>">
                                    <?= htmlspecialchars($invite['short']) ?>
                                </a>
                            </td>
                            <td align="center">
                                <a href="game.php?village=<?= $village['id'] ?>&screen=ally&action=accept&id=<?= $invite['from_ally'] ?>&h=<?= $session['hkey'] ?>">
                                    <?= __('screens.ally.accept') ?>
                                </a>
                            </td>
                            <td align="center">
                                <a href="game.php?village=<?= $village['id'] ?>&screen=ally&action=reject&id=<?= $invite['from_ally'] ?>&h=<?= $session['hkey'] ?>">
                                    <?= __('screens.ally.reject') ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3" align="center"><?= __('screens.ally.no_invites') ?></td></tr>
                <?php endif; ?>
            </table>
        </td>
        
        <!-- Fundar Tribo -->
        <td width="33%">
            <form action="game.php?village=<?= $village['id'] ?>&screen=ally&action=create&h=<?= $session['hkey'] ?>" method="post">
                <table class="vis" width="100%">
                    <tr><th colspan="2"><?= __('screens.ally.found_tribe') ?></th></tr>
                    <tr>
                        <td><?= __('screens.ally.tribe_name') ?></td>
                        <td><input type="text" name="name" size="15" required /></td>
                    </tr>
                    <tr>
                        <td><?= __('screens.ally.tribe_tag') ?><br><small><?= __('screens.ally.tribe_tag_hint') ?></small></td>
                        <td><input type="text" name="short" maxlength="6" size="10" required /></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="submit" value="<?= __('screens.ally.found') ?>" class="btn" />
                        </td>
                    </tr>
                </table>
            </form>
        </td>
        
        <!-- Tribos na sua área -->
        <td width="33%">
            <table class="vis" width="100%">
                <tr>
                    <th><?= __('screens.ally.nearby_tribes') ?></th>
                    <th><?= __('screens.ally.members') ?></th>
                    <th><?= __('screens.ally.points') ?></th>
                </tr>
                <?php if (!empty($nearby_allies)): ?>
                    <?php foreach ($nearby_allies as $ally): ?>
                        <tr>
                            <td>
                                <a href="game.php?village=<?= $village['id'] ?>&screen=info_ally&id=<?= $ally['id'] ?>">
                                    <?= htmlspecialchars($ally['short']) ?>
                                </a>
                            </td>
                            <td align="center"><?= $ally['members'] ?></td>
                            <td align="right"><?= number_format($ally['points']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3" align="center"><?= __('screens.ally.no_nearby_tribes') ?></td></tr>
                <?php endif; ?>
            </table>
        </td>
    </tr>
</table>
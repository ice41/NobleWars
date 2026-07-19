<?php
// Check if user has access to Account Manager
if (isset($has_access) && !$has_access) {
    ?>
    <h3><?= __('screens.am_main.title') ?></h3>
    <br>

    <div
         class="text-center" style="padding: 60px 20px; background: #F4E4BC; border: 2px solid #8B4513; border-radius: 8px;">
        <img src="graphic/new/premium/AccountManager_large.webp" alt="Account Manager"
             class="mb-20" style="width: 150px; height: 150px;">

        <h2  class="mb-15" style="color: #8B4513;"><?= __('screens.am_main.premium_title') ?></h2>

        <p
             style="font-size: 16px; color: #666; margin-bottom: 25px; max-width: 600px; margin-left: auto; margin-right: auto;">
            <?= __('screens.am_main.premium_description') ?>
        </p>

        <p  style="font-size: 18px; margin-bottom: 30px;">
            <strong  style="color: #D9534F;"><?= __('screens.am_main.premium_warning') ?></strong>
        </p>

        <a href="game.php?village=<?= $village['id'] ?>&screen=premium&tab=subscriptions" class="btn"
            style="display: inline-block; background: #5CB85C; color: white; padding: 15px 40px; font-size: 18px; text-decoration: none; border-radius: 5px; font-weight: bold;">
            <?= __('screens.am_main.premium_button') ?>
        </a>

        <p  class="mt-20" style="font-size: 14px; color: #999;">
            <?= __('screens.am_main.premium_price') ?>
        </p>
    </div>
    <?php
    return; // Stop rendering the rest
}

// Ensure variables exist
$mode = $mode ?? 'overview';
$tabs = $tabs ?? [];
$help_text = $help_text ?? '';
?>
<div  class="text-right" style="margin: 10px 0;">
    <span target="_blank" class="quest_link">&raquo; <a target="_blank"
            href="https://help.tribos.com.pt/wiki/Gestão_de_contas"><?= __('screens.am_main.help_link') ?></a></span>
</div>
<h3><?= __('screens.am_main.title') ?></h3>

</br>
<!-- Tab Navigation -->
<table class="vis submenu-vis" width="100%">
    <tr>
        <?php foreach ($tabs as $tab_name => $tab_mode): ?>
            <?php if ($mode == $tab_mode): ?>
                <td class="selected nowrap" width="100" ><a
                        href="game.php?village=<?= $village['id'] ?>&screen=accountmanager&mode=<?= $tab_mode ?>"><?= $tab_name ?></a>
                </td>
            <?php else: ?>
                <td width="100"  class="nowrap"><a
                        href="game.php?village=<?= $village['id'] ?>&screen=accountmanager&mode=<?= $tab_mode ?>"><?= $tab_name ?></a>
                </td>
            <?php endif; ?>
        <?php endforeach; ?>
    </tr>
</table>
<br>

<!-- Help Text -->
<?php if (!empty($help_text)): ?>
    <div  class="p-10 mb-15" style="background: #f9f9f9; border: 1px solid #ddd;">
        <?= $help_text ?>
    </div>
<?php endif; ?>

<!-- Mode-specific content -->
<?php
$mode_file = __DIR__ . "/accountmanager_{$mode}.php";
if (file_exists($mode_file)) {
    include $mode_file;
} else {
    echo '<p  class="text-center" style="padding: 40px; color: #999;">' . __('screens.am_main.mode_not_found') . '</p>';
}
?>
<?php
/**
 * Proteção de Dados / Política de Privacidade
 */
?>
<h2><?= __('screens.premium.data_protection') ?></h2>

<div class="content-box"  style="background: #F4E4BC; border: 1px solid #8B4513; padding: 20px; line-height: 1.8;">

    <h3><?= __('screens.privacy.controller_title') ?></h3>
    <p>
        <?php 
        $supportLink = '<a href="game.php?village=' . htmlspecialchars($village['id']) . '&screen=support">' . __('screens.premium.support_request') . '</a>';
        echo __('screens.privacy.controller_desc', ['link' => $supportLink]); 
        ?>
    </p>

    <h3><?= __('screens.privacy.collected_title') ?></h3>
    <p><?= __('screens.privacy.collected_desc') ?></p>
    <ul  style="padding-left: 20px;">
        <li><?= __('screens.privacy.collected_item_1') ?></li>
        <li><?= __('screens.privacy.collected_item_2') ?></li>
        <li><?= __('screens.privacy.collected_item_3') ?></li>
        <li><?= __('screens.privacy.collected_item_4') ?></li>
    </ul>

    <h3><?= __('screens.privacy.purpose_title') ?></h3>
    <p><?= __('screens.privacy.purpose_desc') ?></p>
    <ul  style="padding-left: 20px;">
        <li><?= __('screens.privacy.purpose_item_1') ?></li>
        <li><?= __('screens.privacy.purpose_item_2') ?></li>
        <li><?= __('screens.privacy.purpose_item_3') ?></li>
        <li><?= __('screens.privacy.purpose_item_4') ?></li>
        <li><?= __('screens.privacy.purpose_item_5') ?></li>
    </ul>

    <h3><?= __('screens.privacy.sharing_title') ?></h3>
    <p><?= __('screens.privacy.sharing_desc') ?></p>

    <h3><?= __('screens.privacy.retention_title') ?></h3>
    <p><?= __('screens.privacy.retention_desc') ?></p>

    <h3><?= __('screens.privacy.rights_title') ?></h3>
    <p><?= __('screens.privacy.rights_desc') ?></p>
    <ul  style="padding-left: 20px;">
        <li><?= __('screens.privacy.rights_item_1') ?></li>
        <li><?= __('screens.privacy.rights_item_2') ?></li>
        <li><?= __('screens.privacy.rights_item_3') ?></li>
        <li><?= __('screens.privacy.rights_item_4') ?></li>
    </ul>
    <p>
        <?php 
        echo __('screens.privacy.rights_footer', ['link' => $supportLink]); 
        ?>
    </p>

    <h3><?= __('screens.privacy.cookies_title') ?></h3>
    <p><?= __('screens.privacy.cookies_desc') ?></p>

    <p  class="mt-20" style="font-size: 12px; color: #666;"><?= __('screens.privacy.last_update') ?></p>
</div>

<p  class="mt-15">
    <a href="game.php?village=<?= $village['id'] ?>&screen=premium" class="btn"><?= __('screens.privacy.back_to_premium') ?></a>
</p>

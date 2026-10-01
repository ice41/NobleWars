<?php
/**
 * Informação Legal / Aviso Legal
 */
?>
<h2><?= __('screens.premium.legal_info') ?></h2>

<div class="content-box"  style="background: #F4E4BC; border: 1px solid #8B4513; padding: 20px; line-height: 1.8;">

    <h3><?= __('screens.legal.operator_title') ?></h3>
    <p><?= __('screens.legal.operator_desc') ?></p>

    <h3><?= __('screens.legal.donations_title') ?></h3>
    <p><?= __('screens.legal.donations_desc_1') ?></p>
    <p><?= __('screens.legal.donations_desc_2') ?></p>

    <h3><?= __('screens.legal.ip_title') ?></h3>
    <p><?= __('screens.legal.ip_desc') ?></p>

    <h3><?= __('screens.legal.liability_title') ?></h3>
    <p><?= __('screens.legal.liability_desc') ?></p>
    <ul  style="padding-left: 20px;">
        <li><?= __('screens.legal.liability_item_1') ?></li>
        <li><?= __('screens.legal.liability_item_2') ?></li>
        <li><?= __('screens.legal.liability_item_3') ?></li>
    </ul>

    <h3><?= __('screens.legal.third_party_title') ?></h3>
    <p><?= __('screens.legal.third_party_desc') ?></p>

    <h3><?= __('screens.legal.disputes_title') ?></h3>
    <p>
        <?php 
        $supportLink = '<a href="game.php?village=' . htmlspecialchars($village['id']) . '&screen=support">' . __('screens.premium.support_request') . '</a>';
        echo __('screens.legal.disputes_desc', ['link' => $supportLink]); 
        ?>
    </p>

    <h3><?= __('screens.legal.minors_title') ?></h3>
    <p><?= __('screens.legal.minors_desc') ?></p>

    <h3><?= __('screens.legal.changes_title') ?></h3>
    <p><?= __('screens.legal.changes_desc') ?></p>

    <p  class="mt-20" style="font-size: 12px; color: #666;"><?= __('screens.legal.last_update') ?></p>
</div>

<p  class="mt-15">
    <a href="game.php?village=<?= $village['id'] ?>&screen=premium" class="btn"><?= __('screens.legal.back_to_premium') ?></a>
</p>
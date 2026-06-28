<?php
/**
 * Condições Contratuais Gerais
 */
?>
<h2><?= __('terms.title') ?></h2>

<div class="content-box" style="background: #F4E4BC; border: 1px solid #8B4513; padding: 20px; line-height: 1.8;">

    <h3><?= __('terms.section1.title') ?></h3>
    <p><?= __('terms.section1.p1') ?></p>
    <p><?= __('terms.section1.p2') ?></p>

    <h3><?= __('terms.section2.title') ?></h3>
    <p><?= __('terms.section2.p1') ?></p>

    <h3><?= __('terms.section3.title') ?></h3>
    <p><?= __('terms.section3.p1') ?></p>
    <p><?= __('terms.section3.p2') ?></p>
    <p><?= __('terms.section3.p3') ?></p>
    <p><?= __('terms.section3.p4') ?></p>

    <h3><?= __('terms.section4.title') ?></h3>
    <p><?= __('terms.section4.p1') ?></p>
    <ul style="padding-left: 20px;">
        <li><?= __('terms.section4.item1') ?></li>
        <li><?= __('terms.section4.item2') ?></li>
        <li><?= __('terms.section4.item3') ?></li>
        <li><?= __('terms.section4.item4') ?></li>
        <li><?= __('terms.section4.item5') ?></li>
    </ul>

    <h3><?= __('terms.section5.title') ?></h3>
    <p><?= __('terms.section5.p1') ?></p>

    <h3><?= __('terms.section6.title') ?></h3>
    <p><?= __('terms.section6.p1') ?></p>

    <h3><?= __('terms.section7.title') ?></h3>
    <p><?= __('terms.section7.p1') ?></p>

    <p style="margin-top: 20px; font-size: 12px; color: #666;"><?= __('terms.last_update') ?></p>
</div>

<p style="margin-top: 15px;">
    <a href="game.php?village=<?= $village['id'] ?>&screen=premium" class="btn"><?= __('terms.back_to_premium') ?></a>
</p>

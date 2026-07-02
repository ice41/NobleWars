<?php
// Combat Help View
global $config;
?>
<h1><?= __('help.combat.title') ?></h1>
<p><?= __('help.combat.intro') ?></p>

<h3><?= __('help.combat.morale') ?></h3>
<p><?= __('help.combat.morale_desc') ?></p>
<p><b><?= __('help.combat.morale_status') ?>:</b>
    <?= $config['moral_activ'] ? __('help.combat.active') : __('help.combat.disabled') ?></p>

<h3><?= __('help.combat.night_bonus') ?></h3>
<p><?= __('help.combat.night_bonus_desc') ?></p>
<p><b><?= __('help.combat.schedule') ?>:</b>
    <?= $config['noc'] ? $config['noc_poczatek'] . ':00h - ' . $config['noc_koniec'] . ':00h' : __('help.combat.disabled') ?>
</p>

<h3><?= __('help.combat.luck') ?> <img src="graphic/icons/rabe.png" alt="screens.common.bad_luck"> <img src="graphic/icons/klee.png" alt="screens.common.good_luck"> </h3>
<p><?= __('help.combat.luck_desc') ?></p>

<h3><?= __('help.combat.wall') ?> <img src="graphic/buildings/wall.png" alt="Muralha"></h3>
<p><?= __('help.combat.wall_desc') ?></p>

<hr>

<h1><?= __('help.combat.conquest_title') ?></h1>
<p><?= __('help.combat.conquest_intro') ?> <img src="graphic/unit/snob.png" title="Nobre" alt=""></p>

<h3><?= __('help.combat.loyalty') ?></h3>
<p><?= __('help.combat.loyalty_desc') ?></p>
<ul>
    <li><b><?= __('help.combat.reduction_per_attack') ?>:</b> <?= $config['pop_min'] ?> <?= __('help.combat.to') ?>
        <?= $config['pop_max'] ?> <?= __('help.combat.points') ?>.
    </li>
    <li><b><?= __('help.combat.recovery') ?>:</b> <?= __('help.combat.loyalty_recovery_prefix') ?>
        <?= $config['agreement_per_hour'] ?> <?= __('help.combat.loyalty_recovery_suffix') ?></li>
</ul>

<p><?= __('help.combat.conquest_desc') ?></p>
<p><b><?= __('help.combat.note') ?>:</b> <?= __('help.combat.conquest_note') ?></p>
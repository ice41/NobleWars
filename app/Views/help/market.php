<?php
// Market Help View
global $config;
?>
<h1><?= __('help.market.title') ?></h1>
<p><?= __('help.market.intro') ?></p>

<h3><?= __('help.market.basic_info') ?></h3>
<table class="vis" width="100%">
    <tr>
        <td width="200"><?= __('help.market.capacity_per_merchant') ?>:</td>
        <td><?= __('help.market.resources_1000') ?></td>
    </tr>
    <tr>
        <td><?= __('help.market.merchant_speed') ?>:</td>
        <td><?= $config['dealer_time'] ?> <?= __('help.market.minutes_per_field') ?></td>
    </tr>
</table>

<h3><?= __('help.market.merchants_per_level') ?></h3>
<p><?= __('help.market.merchants_desc') ?></p>

<table class="vis" width="100%">
    <tr>
        <th><?= __('help.market.market_level') ?></th>
        <th><?= __('help.market.merchants') ?></th>
    </tr>
    <?php
    if (isset($config['arr_dealers'])) {
        foreach ($config['arr_dealers'] as $level => $dealers) {
            if ($level == 0)
                continue;
            echo "<tr><td>$level</td><td>$dealers</td></tr>";
        }
    }
    ?>
</table>
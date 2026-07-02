<?php
/**
 * Account Manager - Stock Mode (Simplified)
 * Manage warehouse distribution settings
 */

$settings = $stock_settings ?? [];
?>

<h3><?= __('screens.accountmanager.stock.title') ?></h3>

<div style="background: #f4e4bc; padding: 15px; margin-bottom: 20px; border: 1px solid #7d510f;">
    <h4 style="margin-top: 0;"><?= __('screens.accountmanager.stock.distribute') ?></h4>
    <p style="margin: 0;">
        <?= __('screens.accountmanager.stock.distribute_desc') ?>
    </p>
</div>

<form method="post" action="game.php?village=<?= $village['id'] ?>&screen=accountmanager&mode=stock&action=save">

    <!-- Settings -->
    <h4><?= __('screens.accountmanager.stock.settings') ?></h4>
    <table class="vis" width="100%">
        <tr>
            <td width="300"><strong><?= __('screens.accountmanager.stock.merchant_reserve') ?></strong></td>
            <td>
                <input type="number" name="merchant_reserve" value="<?= $settings['merchant_reserve'] ?? 2 ?>" min="0"
                    max="100" style="width: 60px;">
                <span style="margin-left: 10px; color: #666;"><?= __('screens.accountmanager.stock.merchant_reserve_desc') ?></span>
            </td>
        </tr>
        <tr>
            <td><strong><?= __('screens.accountmanager.stock.max_travel_time') ?></strong></td>
            <td>
                <input type="number" name="max_travel_time" value="<?= $settings['max_travel_time'] ?? 60 ?>" min="1"
                    max="999" style="width: 60px;">
                <span style="margin-left: 10px; color: #666;"><?= __('screens.accountmanager.stock.max_travel_time_desc') ?></span>
            </td>
        </tr>
    </table>

    <br>

    <div style="text-align: center;">
        <button type="submit" class="btn"><?= __('screens.accountmanager.stock.save_changes') ?></button>
    </div>

    <br>

    <!-- Reserves -->
    <h4><?= __('screens.accountmanager.stock.reserves') ?></h4>
    <p><?= __('screens.accountmanager.stock.reserves_desc') ?></p>

    <table class="vis" width="100%">
        <tr>
            <td>
                <a href="#" onclick="document.getElementById('reserves_section').style.display='block'; return false;">
                    <?= __('screens.accountmanager.stock.edit') ?>
                </a>
            </td>
        </tr>
    </table>

    <div id="reserves_section" style="display: none; margin-top: 10px;">
        <table class="vis" width="100%">
            <tr>
                <td>
                    <input type="checkbox" name="reserve_church" id="reserve_church"
                        <?= !empty($settings['reserve_church']) ? 'checked' : '' ?>>
                    <label for="reserve_church"><?= __('screens.accountmanager.stock.church') ?></label>
                </td>
            </tr>
        </table>
    </div>

    <br>

    <!-- Advanced Settings -->
    <h4><?= __('screens.accountmanager.stock.advanced') ?></h4>
    <p>
        <?= __('screens.accountmanager.stock.advanced_desc') ?>
    </p>

    <table class="vis" width="100%">
        <tr>
            <td>
                <input type="radio" name="advanced_mode" value="yes" id="adv_yes" <?= ($settings['advanced_mode'] ?? 'no') === 'yes' ? 'checked' : '' ?>>
                <label for="adv_yes"><?= __('screens.accountmanager.stock.yes') ?></label>

                <input type="radio" name="advanced_mode" value="no" id="adv_no" style="margin-left: 20px;"
                    <?= ($settings['advanced_mode'] ?? 'no') === 'no' ? 'checked' : '' ?>>
                <label for="adv_no"><?= __('screens.accountmanager.stock.no') ?></label>
            </td>
        </tr>
    </table>

    <br>

    <p><?= __('screens.accountmanager.stock.shortage_desc') ?></p>

    <table class="vis" width="100%">
        <tr>
            <td width="100">
                <img src="graphic/icons/wood.png" alt="Wood" style="vertical-align: middle;">
            </td>
            <td>
                <input type="number" name="shortage_wood" value="<?= $settings['shortage_wood'] ?? 20 ?>" min="0"
                    max="100" style="width: 60px;">
                <span style="margin-left: 5px;">%</span>
            </td>
        </tr>
        <tr>
            <td>
                <img src="graphic/icons/stone.png" alt="Clay" style="vertical-align: middle;">
            </td>
            <td>
                <input type="number" name="shortage_clay" value="<?= $settings['shortage_clay'] ?? 20 ?>" min="0"
                    max="100" style="width: 60px;">
                <span style="margin-left: 5px;">%</span>
            </td>
        </tr>
        <tr>
            <td>
                <img src="graphic/icons/iron.png" alt="Iron" style="vertical-align: middle;">
            </td>
            <td>
                <input type="number" name="shortage_iron" value="<?= $settings['shortage_iron'] ?? 20 ?>" min="0"
                    max="100" style="width: 60px;">
                <span style="margin-left: 5px;">%</span>
            </td>
        </tr>
    </table>

    <br>

    <p><?= __('screens.accountmanager.stock.surplus_desc') ?></p>

    <table class="vis" width="100%">
        <tr>
            <td width="100">
                <img src="graphic/icons/wood.png" alt="Wood" style="vertical-align: middle;">
            </td>
            <td>
                <input type="number" name="surplus_wood" value="<?= $settings['surplus_wood'] ?? 80 ?>" min="0"
                    max="100" style="width: 60px;">
                <span style="margin-left: 5px;">%</span>
            </td>
        </tr>
        <tr>
            <td>
                <img src="graphic/icons/stone.png" alt="Clay" style="vertical-align: middle;">
            </td>
            <td>
                <input type="number" name="surplus_clay" value="<?= $settings['surplus_clay'] ?? 80 ?>" min="0"
                    max="100" style="width: 60px;">
                <span style="margin-left: 5px;">%</span>
            </td>
        </tr>
        <tr>
            <td>
                <img src="graphic/icons/iron.png" alt="Iron" style="vertical-align: middle;">
            </td>
            <td>
                <input type="number" name="surplus_iron" value="<?= $settings['surplus_iron'] ?? 80 ?>" min="0"
                    max="100" style="width: 60px;">
                <span style="margin-left: 5px;">%</span>
            </td>
        </tr>
    </table>

    <br>

    <p><?= __('screens.accountmanager.stock.treatment_desc') ?></p>

    <table class="vis" width="100%">
        <tr>
            <td>
                <input type="radio" name="treatment_mode" value="warehouse" id="treat_warehouse"
                    <?= ($settings['treatment_mode'] ?? 'warehouse') === 'warehouse' ? 'checked' : '' ?>>
                <label for="treat_warehouse"><?= __('screens.accountmanager.stock.treat_warehouse') ?></label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="radio" name="treatment_mode" value="production" id="treat_production"
                    <?= ($settings['treatment_mode'] ?? '') === 'production' ? 'checked' : '' ?>>
                <label for="treat_production"><?= __('screens.accountmanager.stock.treat_production') ?></label>
            </td>
        </tr>
    </table>

    <br>

    <div style="text-align: center;">
        <button type="submit" class="btn"><?= __('screens.accountmanager.stock.save_changes') ?></button>
        <button type="button" class="btn" style="margin-left: 10px;"
            onclick="if(confirm('<?= __('screens.accountmanager.stock.confirm_reset') ?>')) window.location.href='game.php?village=<?= $village['id'] ?>&screen=accountmanager&mode=stock&action=reset';">
            <?= __('screens.accountmanager.stock.reset_default') ?>
        </button>
    </div>

    <input type="hidden" name="h" value="<?= $session['hkey'] ?? '' ?>">
</form>
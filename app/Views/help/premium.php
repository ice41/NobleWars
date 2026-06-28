<h1>
    <?= __('help.premium.title') ?>
</h1>
<p>
    <?= __('help.premium.intro') ?>
</p>

<h3>
    <?= __('help.premium.main_advantages') ?>
</h3>
<ul style="list-style-type: square; margin-left: 20px; line-height: 1.5;">
    <li><b>
            <?= __('help.premium.build_queue') ?>:
        </b>
        <?= __('help.premium.build_queue_desc') ?>
    </li>
    <li><b>
            <?= __('help.premium.quick_bar') ?>:
        </b>
        <?= __('help.premium.quick_bar_desc') ?>
    </li>
    <li><b>
            <?= __('help.premium.map_view') ?>:
        </b>
        <?= __('help.premium.map_view_desc') ?>
    </li>
    <li><b>
            <?= __('help.premium.village_overview') ?>:
        </b>
        <?= __('help.premium.village_overview_desc') ?>
    </li>
    <li><b>
            <?= __('help.premium.map_info') ?>:
        </b>
        <?= __('help.premium.map_info_desc') ?>
    </li>
    <li><b>
            <?= __('help.premium.account_manager') ?>:
        </b>
        <?= __('help.premium.account_manager_desc') ?>
    </li>
</ul>

<br>
<h3><?= __('help.premium.farm_assistant') ?></h3>
<p><?= __('help.premium.farm_assistant_intro') ?></p>

<table class="vis" width="100%">
    <tr>
        <th><?= __('help.premium.resource') ?></th>
        <th><?= __('help.premium.description') ?></th>
    </tr>
    <tr>
        <td width="200" align="center">
            <img src="graphic/new/premium/FarmAssistent_large.webp"
                style="max-width: 150px; border: 1px solid #7d510f;">
        </td>
        <td valign="top">
            <h4><?= __('help.premium.farm_assistant') ?></h4>
            <p><?= __('help.premium.farm_assistant_desc') ?></p>
            <ul>
                <li><b><?= __('help.premium.recent_reports') ?>:</b> <?= __('help.premium.recent_reports_desc') ?></li>
                <li><b><?= __('help.premium.buttons_ab') ?>:</b> <?= __('help.premium.buttons_ab_desc') ?></li>
            </ul>
        </td>
    </tr>
    <tr>
        <td align="center">
            <img src="graphic/new/premium/AccountManager_large.webp"
                style="max-width: 150px; border: 1px solid #7d510f;">
        </td>
        <td valign="top">
            <h4><?= __('help.premium.account_manager') ?></h4>
            <p><?= __('help.premium.account_manager_intro') ?></p>
            <ul>
                <li><b><?= __('help.premium.construction') ?>:</b> <?= __('help.premium.construction_desc') ?></li>
                <li><b><?= __('help.premium.stock') ?>:</b> <?= __('help.premium.stock_desc') ?></li>
                <li><b><?= __('help.premium.recruitment') ?>:</b> <?= __('help.premium.recruitment_desc') ?></li>
            </ul>
        </td>
    </tr>
    <tr>
        <td align="center">
            <div style="display: flex; gap: 5px; justify-content: center;">
                <img src="graphic/new/premium/WoodProduction_large.webp"
                    style="height: 50px; border: 1px solid #7d510f;">
                <img src="graphic/new/premium/StoneProduction_large.webp"
                    style="height: 50px; border: 1px solid #7d510f;">
                <img src="graphic/new/premium/IronProduction_large.webp"
                    style="height: 50px; border: 1px solid #7d510f;">
            </div>
        </td>
        <td valign="top">
            <h4><?= __('help.premium.production_bonus') ?></h4>
            <p><?= __('help.premium.production_bonus_desc') ?></p>
            <ul>
                <li><b><?= __('help.premium.wood_bonus') ?></b></li>
                <li><b><?= __('help.premium.clay_bonus') ?></b></li>
                <li><b><?= __('help.premium.iron_bonus') ?></b></li>
            </ul>
        </td>
    </tr>
    <tr>
        <td align="center">
            <!--<img src="graphic/new/premium/product_01.png" style="max-width: 150px; border: 1px solid #7d510f;">-->
            <img src="graphic/new/premium/name/effect/name_effect_orange.webp"
                style="height: 40px; border: 1px solid #7d510f;">
            <img src="graphic/new/premium/name/color/name_effect_red.webp"
                style="height: 40px; border: 1px solid #7d510f;">
            <img src="graphic/new/premium/name/village/skins_orange.webp"
                style="height: 40px; border: 1px solid #7d510f;">
            <img src="graphic/new/throbber.gif" style="height: 40px; border: 1px solid #7d510f;">
        </td>
        <td valign="top">
            <h4><?= __('help.premium.cosmetics') ?></h4>
            <p><?= __('help.premium.cosmetics_desc') ?></p>
            <ul>
                <li><b><?= __('help.premium.graphic_packs') ?>:</b> <?= __('help.premium.graphic_packs_desc') ?> <b><?= __('help.premium.animated') ?>:</b><img
                        src="graphic/new/premium/name/effect/name_effect_orange.webp"
                        style="height: 25px; border: 1px solid #7d510f;"> <b><?= __('help.premium.colorful') ?>:</b><img
                        src="graphic/new/premium/name/color/name_effect_red.webp"
                        style="height: 25px; border: 1px solid #7d510f;"> </li>
                <li><b><?= __('help.premium.village_skins') ?>:</b> <?= __('help.premium.village_skins_desc') ?>
                    <b><?= __('help.premium.example') ?>:</b><img src="graphic/new/premium/villages/blue/banner_blue_v5.png"
                        style="height: 25px; border: 1px solid #7d510f;" </li>
                <li><b><?= __('help.premium.coats_of_arms') ?>:</b> <?= __('help.premium.coats_of_arms_desc') ?></li>
            </ul>
        </td>
    </tr>
</table>
<h2><?= __('info_world.title', ['world' => $serwerid]) ?></h2>

<table class="vis" width="100%">
    <tbody>
        <tr>
            <th colspan="2"><?= __('info_world.definitions') ?></th>
        </tr>
        <tr>
            <td width="50%"><?= __('info_world.game_speed') ?></td>
            <td width="50%"><?= $speed ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.unit_speed') ?></td>
            <td><?= $units_speed ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.building_demolition') ?></td>
            <td><?= $buildings_destroy ? __('common.active') : __('common.inactive') ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.morale') ?></td>
            <td><?= $morals ? __('common.active') : __('common.inactive') ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.farm_limit') ?></td>
            <td><?= __('common.inactive') ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.basic_defense') ?></td>
            <td><?= $basic_village_defense ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.milliseconds') ?></td>
            <td><?= __('common.inactive') ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.fake_limit') ?></td>
            <td><?= __('common.inactive') ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.research_system') ?></td>
            <td><?php if ($max_tech_level > 1): ?><?= __('info_world.research_expanded', ['level' => $max_tech_level]) ?><?php else: ?><?= __('info_world.research_simple') ?><?php endif; ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.osso') ?></td>
            <td><?= __('common.inactive') ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.medals') ?></td>
            <td><?= $display_awards ? __('common.active') : __('common.inactive') ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.barbarian_growth') ?></td>
            <td>
                <?php if ($bot_barbar_disp): ?>
                    <?= __('info_world.barbarian_growth_active', ['points' => $bot_barbar_limit]) ?>
                <?php else: ?>
                    <?= __('common.inactive') ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td><?= __('info_world.barbarian_villages') ?></td>
            <td><?= __('info_world.barbarian_enhanced') ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.attack_cancel_time') ?></td>
            <td><?= $time_att_pz ?> <?= __('info_world.minutes') ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.trade_cancel_time') ?></td>
            <td><?= $cancel_dealers ?> <?= __('info_world.minutes') ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.night_bonus') ?></td>
            <td><?php if ($noc): ?><?= __('info_world.night_bonus_active', ['start' => $noc_poczatek, 'end' => $noc_koniec]) ?><?php else: ?> <?= __('common.inactive') ?><?php endif; ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.beginner_protection') ?></td>
            <td>
                <?php if ($protect_new_users != '-1'): ?>    <?= round($protect_new_users / 60, 1) ?> <?= __('info_world.hours') ?><?php else: ?><?= __('info_world.no_protection') ?><?php endif; ?>
            </td>
        </tr>
        <tr>
            <td><?= __('info_world.max_ratio') ?></td>
            <td><?= __('info_world.unlimited') ?></td>
        </tr>
    </tbody>
</table>

<table class="vis" width="98%">
    <tbody>
        <tr>
            <th colspan="2"><?= __('info_world.units') ?></th>
        </tr>
        <tr>
            <td width="50%"><?= __('info_world.archers') ?></td>
            <td width="50%"><?= $archers ? __('common.active') : __('common.inactive') ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.scouts') ?></td>
            <td><?= __('info_world.scouts_desc') ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.paladin') ?></td>
            <td><?= $paladin ? __('common.active') : __('common.inactive') ?><?= $paladin ? __('info_world.paladin_items') : '' ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.church') ?></td>
            <td><?= $church ? __('common.active') : __('common.inactive') ?></td>
        </tr>
    </tbody>
</table>

<table class="vis" width="98%">
    <tbody>
        <tr>
            <th colspan="2"><?= __('info_world.nobleman') ?></th>
        </tr>

        <tr>
            <td width="50%"><?= __('info_world.noble_price_increase') ?></td>
            <td width="50%">
                <?= $snob_text ?>
            </td>
        </tr>
        <tr>
            <td><?= __('info_world.cheap_rebuild') ?></td>
            <td><?= __('common.active') ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.max_noble_range') ?></td>
            <td><?php if ($snob_range != '-1'): ?><?= $snob_range ?> <?= __('info_world.fields') ?><?php else: ?><?= __('info_world.no_limit') ?><?php endif; ?>
            </td>
        </tr>
        <tr>
            <td><?= __('info_world.noble_loyalty_loss') ?></td>
            <td><?= $pop_min ?>-<?= $pop_max ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.loyalty_gain_hour') ?></td>
            <td><?= $pop_per_hour ?></td>
        </tr>
    </tbody>
</table>

<table class="vis" width="98%">
    <tbody>
        <tr>
            <th colspan="2"><?= __('screens.ally.menu_properties') ?></th>
        </tr>
        <tr>
            <td><?= __('info_world.tribe_limit') ?></td>
            <td><?= __('common.inactive') ?></td>
        </tr>
        <tr>
            <td width="50%"><?= __('info_world.defeated_opponents') ?></td>
            <td width="50%"><?= __('common.active') ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.sitter') ?></td>
            <td><?= __('common.inactive') ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.direction_select') ?></td>
            <td><?= $village_choose_direction ? __('common.active') : __('common.inactive') ?></td>
        </tr>
        <tr>
            <td><?= __('info_world.start_date') ?></td>
            <td><?= $server_start ?></td>
        </tr>
    </tbody>
</table>
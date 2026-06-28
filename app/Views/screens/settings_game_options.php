<?php
/**
 * Game Options Settings View
 * Complete game configuration page
 */
?>

<h2><?= __('screens.settings.game_options_title') ?></h2>

<form method="post"
    action="game.php?village=<?= $village['id'] ?>&screen=settings&mode=game_options&action=save&h=<?= $hkey ?>">

    <!-- Configurações gerais -->
    <h3><?= __('screens.settings.general_settings') ?></h3>
    <table class="vis">
        <tr>
            <td><?= __('screens.settings.last_access') ?></td>
            <td><input type="checkbox" name="show_last_login" value="1"> <?= __('screens.settings.show_main_page') ?>
            </td>
        </tr>
        <tr>
            <td><?= __('screens.settings.troop_speed_arriving') ?></td>
            <td><input type="checkbox" name="show_troop_speed" value="1">
                <?= __('screens.settings.show_troop_speed_calculator') ?>
            </td>
        </tr>
        <tr>
            <td><?= __('screens.settings.less_graphics') ?></td>
            <td><input type="checkbox" name="less_graphics" value="1">
                <?= __('screens.settings.disable_remaining_graphics') ?></td>
        </tr>
        <tr>
            <td><?= __('screens.settings.keyboard_analysis') ?></td>
            <td><input type="checkbox" name="keyboard_analysis" value="1">
                <?= __('screens.settings.enable_keyboard_analysis') ?></td>
        </tr>
        <tr>
            <td><?= __('screens.settings.attack_sound') ?></td>
            <td><input type="checkbox" name="attack_sound" value="1">
                <?= __('screens.settings.play_sound_when_attacked') ?></td>
        </tr>
        <tr>
            <td><?= __('screens.settings.adjust_archived_reports') ?></td>
            <td>
                <select name="archived_reports_days">
                    <option value="7">7 <?= __('screens.settings.days') ?></option>
                    <option value="14">14 <?= __('screens.settings.days') ?></option>
                    <option value="30">30 <?= __('screens.settings.days') ?></option>
                    <option value="60">60 <?= __('screens.settings.days') ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td><?= __('screens.settings.notifications') ?></td>
            <td><input type="checkbox" name="notifications" value="1">
                <?= __('screens.settings.receive_important_report_notification') ?></td>
        </tr>
        <tr>
            <td colspan="2"><input class="btn btn-default" type="submit"
                    value="<?= __('screens.settings.save_changes') ?>"></td>
        </tr>
    </table>

    <br>

    <!-- Salvar página de boas-vindas -->
    <h3><?= __('screens.settings.save_welcome_page') ?></h3>
    <table class="vis">
        <tr>
            <td><?= __('screens.settings.once_daily') ?></td>
            <td><input type="radio" name="welcome_page" value="once_daily"> <?= __('screens.settings.once_daily') ?>
            </td>
        </tr>
        <tr>
            <td><?= __('screens.settings.not_always') ?></td>
            <td><input type="radio" name="welcome_page" value="never"> <?= __('screens.settings.not_always') ?></td>
        </tr>
        <tr>
            <td colspan="2"><input class="btn btn-default" type="submit" value="Guardar alterações"></td>
        </tr>
    </table>

    <br>

    <!-- Chat ativado -->
    <h3><?= __('screens.settings.chat_enabled') ?></h3>
    <table class="vis">
        <tr>
            <td><input type="checkbox" name="enable_chat" value="1">
                <?= __('screens.settings.enable_chat_with_players') ?></td>
        </tr>
        <tr>
            <td><input type="checkbox" name="chat_sound" value="1"> <?= __('screens.settings.enable_chat_sound') ?></td>
        </tr>
        <tr>
            <td><input type="checkbox" name="disable_barbarian_area" value="1">
                <?= __('screens.settings.disable_background_individual_flags') ?></td>
        </tr>
        <tr>
            <td><input type="checkbox" name="disable_barbarian_area_all" value="1">
                <?= __('screens.settings.disable_background_all_flags') ?></td>
        </tr>
        <tr>
            <td colspan="2"><input class="btn btn-default" type="submit" value="Guardar alterações"></td>
        </tr>
    </table>

    <br>

    <!-- Configurações da tribo -->
    <h3><?= __('screens.settings.tribe_settings') ?></h3>
    <table class="vis">
        <tr>
            <td><?= __('screens.settings.share_premium_status') ?></td>
            <td><input type="checkbox" name="share_premium_status" value="1">
                <?= __('screens.settings.allow_tribe_see_premium') ?></td>
        </tr>
        <tr>
            <td><?= __('screens.settings.share_own_troops') ?></td>
            <td><input type="checkbox" name="share_own_troops" value="1">
                <?= __('screens.settings.allow_tribe_see_own_troops') ?></td>
        </tr>
        <tr>
            <td><?= __('screens.settings.share_foreign_troops') ?></td>
            <td><input type="checkbox" name="share_foreign_troops" value="1">
                <?= __('screens.settings.allow_tribe_see_foreign_troops') ?></td>
        </tr>
        <tr>
            <td><?= __('screens.settings.share_support') ?></td>
            <td><input type="checkbox" name="share_support" value="1">
                <?= __('screens.settings.allow_tribe_see_stationed_troops') ?></td>
        </tr>
        <tr>
            <td><?= __('screens.settings.share_incoming_attacks') ?></td>
            <td><input type="checkbox" name="share_incoming_attacks" value="1">
                <?= __('screens.settings.allow_tribe_see_incoming_attacks') ?></td>
        </tr>
        <tr>
            <td><?= __('screens.settings.share_transports') ?></td>
            <td><input type="checkbox" name="share_transports" value="1">
                <?= __('screens.settings.allow_tribe_see_transport_resources') ?></td>
        </tr>
        <tr>
            <td><?= __('screens.settings.forum_notifications') ?></td>
            <td><input type="checkbox" name="forum_notifications" value="1">
                <?= __('screens.settings.disable_forum_popup_notification') ?></td>
        </tr>
        <tr>
            <td colspan="2"><input class="btn btn-default" type="submit"
                    value="<?= __('screens.settings.save_changes') ?>"></td>
        </tr>
    </table>

    <br>

    <!-- Configurações dos Amigos -->
    <h3><?= __('screens.settings.friends_settings') ?></h3>
    <table class="vis">
        <tr>
            <td><input type="checkbox" name="allow_friend_emails" value="1">
                <?= __('screens.settings.allow_friends_see_transport_resources') ?></td>
        </tr>
        <tr>
            <td colspan="2"><input class="btn btn-default" type="submit"
                    value="<?= __('screens.settings.save_changes') ?>"></td>
        </tr>
    </table>

    <br>

    <!-- Definições do edifício principal -->
    <h3><?= __('screens.settings.main_building_settings') ?></h3>
    <table class="vis">
        <tr>
            <td><?= __('screens.settings.show_all_buildings') ?></td>
            <td><input type="checkbox" name="show_all_buildings" value="1">
                <?= __('screens.settings.show_all_buildings_desc') ?></td>
        </tr>
        <tr>
            <td><?= __('screens.settings.hide_completed_buildings') ?></td>
            <td><input type="checkbox" name="hide_completed_buildings" value="1">
                <?= __('screens.settings.hide_completed_buildings_desc') ?></td>
        </tr>
        <tr>
            <td><?= __('screens.settings.enable_village_construction') ?></td>
            <td><input type="checkbox" name="enable_village_construction" value="1">
                <?= __('screens.settings.enable_village_construction_desc') ?></td>
        </tr>
        <tr>
            <td colspan="2"><input class="btn btn-default" type="submit"
                    value="<?= __('screens.settings.save_changes') ?>"></td>
        </tr>
    </table>

    <br>

    <!-- Definições de visualização geral da aldeia -->
    <h3><?= __('screens.settings.village_overview_settings') ?></h3>
    <table class="vis">
        <tr>
            <td><?= __('screens.settings.show_graphical_mode') ?></td>
            <td><input type="checkbox" name="show_graphical_mode" value="1">
                <?= __('screens.settings.show_graphical_mode_desc') ?></td>
        </tr>
        <tr>
            <td><?= __('screens.settings.show_building_levels') ?></td>
            <td><input type="checkbox" name="show_building_levels" value="1">
                <?= __('screens.settings.show_building_levels_desc') ?></td>
        </tr>
        <tr>
            <td colspan="2"><input class="btn btn-default" type="submit"
                    value="<?= __('screens.settings.save_changes') ?>"></td>
        </tr>
    </table>

    <br>

    <!-- Configurações do mapa -->
    <h3><?= __('screens.settings.map_settings') ?></h3>
    <table class="vis">
        <tr>
            <td><?= __('screens.settings.enable_context_menu') ?></td>
            <td><input type="checkbox" name="enable_context_menu" value="1">
                <?= __('screens.settings.enable_context_menu_desc') ?></td>
        </tr>
        <tr>
            <td><?= __('screens.settings.send_commands_resources') ?></td>
            <td><input type="checkbox" name="send_commands_resources" value="1">
                <?= __('screens.settings.send_commands_resources_desc') ?></td>
        </tr>
        <tr>
            <td colspan="2"><?= __('screens.settings.show_only_context_menus') ?></td>
        </tr>
        <tr>
            <td colspan="2"><input class="btn btn-default" type="submit"
                    value="<?= __('screens.settings.save_changes') ?>"></td>
        </tr>
    </table>

    <br>

    <!-- Janela de confirmação de uso de pontos Premium -->
    <h3><?= __('screens.settings.premium_confirmation_window') ?></h3>
    <table class="vis">
        <tr>
            <td colspan="2"><?= __('screens.settings.premium_confirmation_desc') ?></td>
        </tr>
        <tr>
            <td colspan="2"><input class="btn btn-default" type="submit"
                    value="<?= __('screens.settings.use_default_settings') ?>"></td>
        </tr>
    </table>

</form>
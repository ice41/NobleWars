<form action="game.php?village=<?= $village['id'] ?>&screen=ally&mode=members&action=kick&h=<?= $user['hkey'] ?? '' ?>"
    method="post" id="form_rights">
    <table class="vis">
        <tr>
            <th width="280" class="nowrap"><?= __('screens.ally.name') ?></th>
            <th width="40" class="nowrap"><?= __('screens.ally.ranking') ?></th>
            <th width="80" class="nowrap"><?= __('screens.ally.points') ?></th>
            <th width="60" class="nowrap"><?= __('screens.ally.global_ranking') ?></th>
            <th width="40" class="nowrap"><?= __('screens.ally.villages') ?></th>
            <?php if (($user['ally_lead'] ?? 0) == 1 || ($user['ally_found'] ?? 0) == 1): ?>
                <th><img src="graphic/ally/ally_rights/found.png" title="<?= __('screens.ally.founder') ?>"></th>
                <th><img src="graphic/ally/ally_rights/lead.png" title="<?= __('screens.ally.tribe_administration') ?>">
                </th>
                <th><img src="graphic/ally/ally_rights/invite.png" title="<?= __('screens.ally.invite') ?>"></th>
                <th><img src="graphic/ally/ally_rights/diplomacy.png" title="<?= __('screens.ally.diplomacy') ?>"></th>
                <th><img src="graphic/ally/ally_rights/mass_mail.png" title="<?= __('screens.ally.mass_mail') ?>"></th>
                <th><img src="graphic/ally/ally_rights/forum_mod.png"
                        title="<?= __('screens.ally.internal_forum_moderator') ?>"></th>
                <th><img src="graphic/ally/ally_rights/internal_forum.png" title="<?= __('screens.ally.hidden_forum') ?>">
                </th>
                <th><img src="graphic/ally/ally_rights/trusted.png" title="<?= __('screens.ally.trusted_member') ?>"></th>
                <th class="nowrap"><?= __('screens.ally.replacement') ?></th>
            <?php endif; ?>
        </tr>
        <?php $rank = 0;
        foreach ($members as $arr):
            $rank++; ?>
            <tr <?= ($arr['id'] == $user['id']) ? 'class="selected"' : (($rank % 2 == 0) ? 'class="row_b"' : 'class="row_a"') ?>>
                <td class="lit-item">
                    <?php if (($user['ally_lead'] ?? 0) == 1 || ($user['ally_found'] ?? 0) == 1): ?>
                        <input type="radio" name="id" value="<?= $arr['id'] ?>" />
                        <?php if (!empty($arr['icons'])): ?>
                            <?php foreach ($arr['icons'] as $graphic): ?>
                                <img src="graphic/stat/<?= $graphic ?>.png" title="" alt="" />
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $arr['id'] ?>">
                        <?= htmlspecialchars($arr['username']) ?>
                    </a>
                    <?php if (!empty($arr['ally_titel'])): ?>
                        (<?= htmlspecialchars($arr['ally_titel']) ?>)
                    <?php endif; ?>
                </td>
                <td class="lit-item"><?= $rank ?></td>
                <td class="lit-item"><?= format_number($arr['points']) ?></td>
                <td class="lit-item"><?= $arr['rang'] ?></td>
                <td class="lit-item"><?= format_number($arr['villages']) ?></td>

                <?php if (($user['ally_lead'] ?? 0) == 1 || ($user['ally_found'] ?? 0) == 1): ?>
                    <td class="lit-item">
                        <div class="show_toggle">
                            <img src="graphic/dots/<?= ($arr['ally_found'] ?? 0) == 1 ? 'green' : 'grey' ?>.png?1" alt="" />
                        </div>
                        <input type="checkbox" <?= (($user['ally_lead'] ?? 0) == 1 && ($user['ally_found'] ?? 0) == 0) ? 'disabled="disabled"' : '' ?> name="player_id[<?= $arr['id'] ?>][found]"
                            id="player_id[<?= $arr['id'] ?>][found]" onclick="set_found_right(<?= $arr['id'] ?>)"
                            <?= ($arr['ally_found'] ?? 0) == 1 ? 'checked="checked"' : '' ?> class="hide_toggle"
                            style="display:none" />
                    </td>

                    <td class="lit-item">
                        <div class="show_toggle">
                            <img src="graphic/dots/<?= ($arr['ally_lead'] ?? 0) == 1 ? 'green' : 'grey' ?>.png?1" alt="" />
                        </div>
                        <input type="checkbox" <?= (($user['ally_lead'] ?? 0) == 1 && ($user['ally_found'] ?? 0) == 0) ? 'disabled="disabled"' : '' ?> name="player_id[<?= $arr['id'] ?>][lead]"
                            id="player_id[<?= $arr['id'] ?>][lead]" onclick="set_lead_right(<?= $arr['id'] ?>)"
                            <?= ($arr['ally_lead'] ?? 0) == 1 ? 'checked="checked"' : '' ?> class="hide_toggle"
                            style="display:none" />
                    </td>

                    <td class="lit-item">
                        <div class="show_toggle">
                            <img src="graphic/dots/<?= ($arr['ally_invite'] ?? 0) == 1 ? 'green' : 'grey' ?>.png?1" alt="" />
                        </div>
                        <input type="checkbox" name="player_id[<?= $arr['id'] ?>][invite]"
                            id="player_id[<?= $arr['id'] ?>][invite]" <?= ($arr['ally_invite'] ?? 0) == 1 ? 'checked="checked"' : '' ?> class="hide_toggle" style="display:none" />
                    </td>

                    <td class="lit-item">
                        <div class="show_toggle">
                            <img src="graphic/dots/<?= ($arr['ally_diplomacy'] ?? 0) == 1 ? 'green' : 'grey' ?>.png?1"
                                alt="" />
                        </div>
                        <input type="checkbox" name="player_id[<?= $arr['id'] ?>][diplomacy]"
                            id="player_id[<?= $arr['id'] ?>][diplomacy]" <?= ($arr['ally_diplomacy'] ?? 0) == 1 ? 'checked="checked"' : '' ?> class="hide_toggle" style="display:none" />
                    </td>

                    <td class="lit-item">
                        <div class="show_toggle">
                            <img src="graphic/dots/<?= ($arr['ally_mass_mail'] ?? 0) == 1 ? 'green' : 'grey' ?>.png?1"
                                alt="" />
                        </div>
                        <input type="checkbox" name="player_id[<?= $arr['id'] ?>][mass_mail]"
                            id="player_id[<?= $arr['id'] ?>][mass_mail]" <?= ($arr['ally_mass_mail'] ?? 0) == 1 ? 'checked="checked"' : '' ?> class="hide_toggle" style="display:none" />
                    </td>

                    <td class="lit-item">
                        <div class="show_toggle">
                            <img src="graphic/dots/<?= ($arr['ally_mod_forum'] ?? 0) == 1 ? 'green' : 'grey' ?>.png?1"
                                alt="" />
                        </div>
                        <input type="checkbox" name="player_id[<?= $arr['id'] ?>][forum_mod]"
                            id="player_id[<?= $arr['id'] ?>][forum_mod]" <?= ($arr['ally_mod_forum'] ?? 0) == 1 ? 'checked="checked"' : '' ?> class="hide_toggle" style="display:none" />
                    </td>

                    <td class="lit-item">
                        <div class="show_toggle">
                            <img src="graphic/dots/<?= ($arr['ally_forum_switch'] ?? 0) == 1 ? 'green' : 'grey' ?>.png?1"
                                alt="" />
                        </div>
                        <input type="checkbox" name="player_id[<?= $arr['id'] ?>][internal_forum]"
                            id="player_id[<?= $arr['id'] ?>][internal_forum]" <?= ($arr['ally_forum_switch'] ?? 0) == 1 ? 'checked="checked"' : '' ?> class="hide_toggle" style="display:none" />
                    </td>

                    <td class="lit-item">
                        <div class="show_toggle">
                            <img src="graphic/dots/<?= ($arr['ally_forum_trust'] ?? 0) == 1 ? 'green' : 'grey' ?>.png?1"
                                alt="" />
                        </div>
                        <input type="checkbox" name="player_id[<?= $arr['id'] ?>][trusted_member]"
                            id="player_id[<?= $arr['id'] ?>][trusted_member]" <?= ($arr['ally_forum_trust'] ?? 0) == 1 ? 'checked="checked"' : '' ?> class="hide_toggle" style="display:none" />
                    </td>

                    <td class="lit-item">
                        <?php if (!empty($arr['vacation_id'])): ?>
                            <a
                                href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $arr['vacation_id'] ?>"><?= htmlspecialchars($arr['vacation_name']) ?></a>
                        <?php endif; ?>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        <?php if (($user['ally_lead'] ?? 0) == 1 || ($user['ally_found'] ?? 0) == 1): ?>
            <tr>
                <td class="no_bg">
                    <div class="show_toggle">
                        <select name="ally_action"
                            onchange="if(this.value != '') { document.getElementById('form_rights').submit(); }">
                            <option value=""><?= __('screens.ally.choose_action') ?></option>
                            <option value="rights"><?= __('screens.ally.rights_and_title') ?></option>
                            <option value="kick"><?= __('screens.ally.kick') ?></option>
                        </select>
                    </div>
                    <input type="submit" value="<?= __('screens.ally.save_rights') ?>" class="hide_toggle"
                        style="display:none" />
                </td>
                <td colspan="11" class="no_bg align_right">
                    <a href="#"
                        onclick="toggle_visibility_by_class('hide_toggle','inline'); toggle_visibility_by_class('show_toggle'); toggle_form_action('form_rights', 'game.php?village=<?= $village['id'] ?>&screen=ally&mode=members&action=edit_rights&h=<?= $user['hkey'] ?? '' ?>'); return false;"
                        class="show_toggle">
                        &raquo; <?= __('screens.ally.manage_rights') ?>
                    </a>
                </td>
            </tr>
        <?php endif; ?>
    </table>
</form>

<br />

<table class="vis">
    <tr>
        <th><?= __('screens.ally.status') ?></th>
    </tr>
    <tr>
        <td><img src="graphic/dots/stat/green.png?1" alt="" /> <?= __('screens.ally.active') ?></td>
    </tr>
    <tr>
        <td><img src="graphic/dots/stat/yellow.png?1" alt="" /> <?= __('screens.ally.inactive_2_days') ?></td>
    </tr>
    <tr>
        <td><img src="graphic/dots/stat/red.png?1" alt="" /> <?= __('screens.ally.inactive_week') ?></td>
    </tr>
    <tr>
        <td><img src="graphic/dots/stat/vacation.png?1" alt="" /> <?= __('screens.ally.replacement_status') ?></td>
    </tr>
    <tr>
        <td><img src="graphic/dots/stat/birthday.png?1" alt="" /> <?= __('screens.ally.birthday') ?></td>
    </tr>
    <tr>
        <td><img src="graphic/dots/stat/banned.png?1" alt="" /> <?= __('screens.ally.blocked') ?></td>
    </tr>
</table>

<div style="font-size: 7pt;">
    <?= __('screens.ally.only_admins_see_status') ?>
</div>

<script type="text/javascript">
    function toggle_visibility_by_class(classname, display) {
        if (display == 'table-row') display = '';
        var elements = document.getElementsByClassName(classname);
        for (var i = 0; i < elements.length; i++) {
            if (elements[i].style.display == 'none') {
                elements[i].style.display = display || '';
            } else {
                elements[i].style.display = 'none';
            }
        }
    }

    function set_found_right(memberid) {
        check_and_disable('player_id[' + memberid + '][lead]', document.getElementById('player_id[' + memberid + '][found]').checked);
        set_lead_right(memberid);
    }

    function set_lead_right(memberid) {
        var checked = document.getElementById('player_id[' + memberid + '][lead]').checked;
        check_and_disable('player_id[' + memberid + '][invite]', checked);
        check_and_disable('player_id[' + memberid + '][diplomacy]', checked);
        check_and_disable('player_id[' + memberid + '][mass_mail]', checked);
        check_and_disable('player_id[' + memberid + '][forum_mod]', checked);
        check_and_disable('player_id[' + memberid + '][internal_forum]', checked);
        check_and_disable('player_id[' + memberid + '][trusted_member]', checked);
    }

    function check_and_disable(name, check) {
        var el = document.getElementById(name);
        if (el) {
            el.disabled = check;
            if (check == true) {
                el.checked = check;
            }
        }
    }

    function toggle_form_action(name, action) {
        document.getElementById(name).action = action;
    }
</script>
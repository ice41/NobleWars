<?php if (!empty($error)): ?>
    <div class="error"><?= $error ?></div>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <div class="success"><?= $success ?></div>
<?php endif; ?>

<!-- Tabs Navigation Container -->
<table class="content-border" width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td>
            <table class="main" width="100%" align="center">
                <tr>
                    <td id="content_value">
                        <!-- Navigation Tabs -->
                        <table class="vis" width="100%">
                            <tr>
                                <?php foreach ($tabs as $key => $label): ?>
                                    <?php
                                    $is_active = ($key === $current_tab);
                                    $bg_color = $is_active ? '#e5c389' : '#f4e4bc';
                                    $label_display = ($key === 'profile') ? \App\Helpers\CosmeticHelper::formatUsername($user['username'], $user['id']) : htmlspecialchars($label);
                                    ?>
                                    <td align="center"
                                        style="background-color: <?= $bg_color ?>; padding: 4px 10px; border: 1px solid #7d510f;">
                                        <a href="game.php?village=<?= $village['id'] ?>&screen=profile&mode=<?= $key ?>"
                                            style="text-decoration: none; font-weight: bold; color: #5d2f09;">
                                            <?= $label_display ?>
                                        </a>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        </table>

                        <!-- Main Content -->
                        <div
                            style="background-color: #fceec4; padding: 10px; border: 1px solid #c1a264; margin-top: 5px;">

                            <h2><?= __('screens.profile.invite_players') ?></h2>

                            <table width="100%">
                                <tr>
                                    <td width="50%" valign="top">
                                        <!-- Convite por email -->
                                        <table class="vis" width="100%">
                                            <tr>
                                                <th colspan="2"
                                                    style="background-color: #c1a264; color: #000; text-align: left; padding: 3px;">
                                                    <i><?= __('screens.profile.invite_by_email') ?></i>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <form
                                                        action="game.php?village=<?= $village['id'] ?>&screen=profile&mode=invite&action=send&h=<?= $hkey ?>"
                                                        method="post">
                                                        <?php if (isset($_GET['invite_x']) && isset($_GET['invite_y'])): ?>
                                                            <input type="hidden" name="invite_x" value="<?= (int)$_GET['invite_x'] ?>">
                                                            <input type="hidden" name="invite_y" value="<?= (int)$_GET['invite_y'] ?>">
                                                            <div style="background-color: #ebdcae; border: 1px solid #aa7c11; border-radius: 4px; padding: 10px; margin-bottom: 12px; font-weight: bold; color: #5d2f09; text-shadow: 0 0 10px rgba(212, 175, 55, 0.2);">
                                                                Convidar amigo para a posição: <?= (int)$_GET['invite_x'] ?>|<?= (int)$_GET['invite_y'] ?>
                                                            </div>
                                                        <?php endif; ?>

                                                        <!-- Seleção de tipo de convite -->
                                                        <div class="invite-type-selector" style="margin-bottom: 15px; display: flex; gap: 20px; font-weight: bold; background: #ebdcae; padding: 10px; border-radius: 4px; border: 1px solid #7d510f;">
                                                            <label style="cursor: pointer; display: flex; align-items: center; gap: 5px; color: #5d2f09;">
                                                                <input type="radio" name="invite_type" value="email" checked onclick="toggleInviteForm('email')" />
                                                                Convidar por E-mail
                                                            </label>
                                                            <label style="cursor: pointer; display: flex; align-items: center; gap: 5px; color: #5d2f09;">
                                                                <input type="radio" name="invite_type" value="username" onclick="toggleInviteForm('username')" />
                                                                Convidar por Nome de Utilizador (Amigo)
                                                            </label>
                                                        </div>

                                                        <table width="100%">
                                                            <!-- Convite por E-mail -->
                                                            <tr id="invite_email_row">
                                                                <td colspan="2">
                                                                    <label for="email"><?= __('screens.profile.email_required') ?></label><br>
                                                                    <input type="email" name="email" id="email"
                                                                        size="40" required style="width: 95%;">
                                                                </td>
                                                            </tr>

                                                            <!-- Convite por Nome de Utilizador -->
                                                            <tr id="invite_username_row" style="display: none;">
                                                                <td colspan="2">
                                                                    <?php if (empty($friends)): ?>
                                                                        <div style="background-color: #ebdcae; border: 1px solid #aa7c11; color: #5d2f09; padding: 8px; border-radius: 4px; margin-bottom: 10px; width: 95%;">
                                                                            Não tens amigos ativos na tua lista de amigos neste mundo. Convida por E-mail.
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <label for="username_select">Selecciona um amigo da tua lista:</label><br>
                                                                        <select id="username_select" style="width: 95%; padding: 5px; font-size: 14px; background: #fff; border: 1px solid #7d510f; border-radius: 4px; margin-bottom: 10px;" onchange="syncUsernameInput(this.value)">
                                                                            <option value="">-- Selecciona um amigo --</option>
                                                                            <?php foreach ($friends as $f): ?>
                                                                                <option value="<?= htmlspecialchars($f['username']) ?>"><?= htmlspecialchars($f['username']) ?> (<?= $f['points'] ?> pts)</option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <div style="margin: 5px 0;"><b>ou</b> introduz o nome de utilizador manualmente:</div>
                                                                    <?php endif; ?>
                                                                    <input type="text" name="username" id="username_text" size="40" style="width: 95%;" placeholder="Nome de utilizador do amigo" oninput="syncUsernameSelect(this.value)">
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td colspan="2">
                                                                    <label
                                                                        for="message"><?= __('screens.profile.personal_text_optional') ?></label><br>
                                                                    <textarea name="message" id="message" rows="6"
                                                                        style="width: 95%;"></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <label
                                                                        for="your_name"><?= __('screens.profile.your_name_optional') ?></label><br>
                                                                    <input type="text" name="your_name" id="your_name"
                                                                        size="30" style="width: 95%;">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <label
                                                                        for="friend_name"><?= __('screens.profile.friend_name_optional') ?></label><br>
                                                                    <input type="text" name="friend_name"
                                                                        id="friend_name" size="30" style="width: 95%;">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <input type="submit"
                                                                        value="<?= __('screens.profile.send') ?>"
                                                                        class="btn">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </form>

                                                    <script type="text/javascript">
                                                        function toggleInviteForm(type) {
                                                            if (type === 'email') {
                                                                document.getElementById('invite_email_row').style.display = 'table-row';
                                                                document.getElementById('invite_username_row').style.display = 'none';
                                                                document.getElementById('email').required = true;
                                                                document.getElementById('username_text').required = false;
                                                            } else {
                                                                document.getElementById('invite_email_row').style.display = 'none';
                                                                document.getElementById('invite_username_row').style.display = 'table-row';
                                                                document.getElementById('email').required = false;
                                                                document.getElementById('username_text').required = true;
                                                            }
                                                        }

                                                        function syncUsernameInput(val) {
                                                            if (val) {
                                                                document.getElementById('username_text').value = val;
                                                            }
                                                        }

                                                        function syncUsernameSelect(val) {
                                                            var sel = document.getElementById('username_select');
                                                            if (sel) {
                                                                sel.value = '';
                                                                for (var i = 0; i < sel.options.length; i++) {
                                                                    if (sel.options[i].value.toLowerCase() === val.toLowerCase()) {
                                                                        sel.value = sel.options[i].value;
                                                                        break;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    </script>
                                                </td>
                                            </tr>
                                        </table>

                                        <br>

                                        <!-- Convidar contactos antigos -->
                                        <h3><?= __('screens.profile.invite_old_contacts') ?></h3>
                                        <p><?= __('screens.profile.reestablish_contact') ?></p>
                                        <p>
                                            <?= __('screens.profile.invite_to') ?>
                                            <select name="village_id">
                                                <option value="0"><?= __('screens.profile.somewhere_on_map') ?></option>
                                                <?php if (!empty($villages_list)): ?>
                                                    <?php foreach ($villages_list as $v): ?>
                                                        <option value="<?= $v['id'] ?>">
                                                            <?= htmlspecialchars($v['name']) ?> (<?= $v['x'] ?>|<?= $v['y'] ?>)
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </p>
                                        <p>
                                            <?= __('screens.profile.username') ?>:
                                            <input type="text" name="username" size="20">
                                            <input type="submit" value="<?= __('screens.profile.invite_button') ?>"
                                                class="btn">
                                        </p>

                                        <?php if (!empty($old_contacts)): ?>
                                            <table class="vis" width="100%">
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Mundo</th>
                                                    <th>Duração</th>
                                                    <th>Último contacto</th>
                                                    <th>Convidar</th>
                                                </tr>
                                                <?php foreach ($old_contacts as $contact): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($contact['name']) ?></td>
                                                        <td><?= htmlspecialchars($contact['world']) ?></td>
                                                        <td><?= $contact['duration'] ?> dias</td>
                                                        <td><?= $contact['last_contact'] ?></td>
                                                        <td><a href="#">Convidar</a></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </table>
                                        <?php endif; ?>
                                    </td>

                                    <td width="50%" valign="top">
                                        <!-- Recompensa da missão -->
                                        <table class="vis" width="100%" style="text-align: center;">
                                            <tr>
                                                <th colspan="2"><?= __('screens.profile.mission_reward') ?></th>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <p><?= __('screens.profile.reward_description') ?></p>
                                                    <table width="100%" style="margin-top: 10px;">
                                                        <tr>
                                                            <td style="text-align: center;">
                                                                <img src="graphic/new/premium/Premium_large.webp"
                                                                    alt="Coroa" style="width: 60px;"><br>
                                                                <b>5 <?= __('screens.profile.days') ?></b>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <img src="graphic/flags/package3.png" alt="Bandeira"
                                                                    style="width: 60px;"><br>
                                                                <b><?= __('screens.common.level') ?> 3</b>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                        <br>

                                        <!-- Link do convite -->
                                        <table class="vis" width="100%">
                                            <tr>
                                                <th
                                                    style="background-color: #c1a264; color: #000; text-align: left; padding: 3px;">
                                                    <i><?= __('screens.profile.invite_link') ?></i>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p><?= __('screens.profile.copy_paste_link') ?></p>
                                                    <input type="text" value="<?= $invite_link ?>" readonly
                                                        onclick="this.select();"
                                                        style="width: 95%; padding: 5px; margin-bottom: 10px;">
                                                    <br>
                                                    <!-- <a href="#" onclick="return false;"><img src="publicgraphic/icons/facebook.png" alt="Facebook"
                                style="width: 32px;"></a>
                        <a href="#" onclick="return false;"><img src="publicgraphic/icons/twitter.png" alt="Twitter"
                                style="width: 32px; margin-left: 10px;"></a> -->
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<h2><i class="fas fa-gavel"></i> <?= __('admin.bans.title') ?></h2>
<p style="color: #5c3a1e;"><?= __('admin.bans.desc') ?>
</p>

<div class="admin-card">
    <?php if (!empty($gr['username'])): ?>
        <h3><i class="fas fa-user-slash"></i> <?= __('admin.bans.ban_player') ?>: <?= htmlspecialchars($gr['username']) ?></h3>
    <?php else: ?>
        <h3><i class="fas fa-user-slash"></i> <?= __('admin.bans.ban_player') ?></h3>
    <?php endif; ?>

    <form action="<?= $adminBaseUrl ?>&mode=bany&akcja=zbanuj&gracz=<?= $gracz ?? 0 ?>"
        method="post">
        <table class="vis" width="100%">
            <tr>
                <td width="150"><strong><?= __('admin.bans.player_nick') ?></strong></td>
                <td>
                    <input id="id" name="id" class="text" value="<?= htmlspecialchars($gr['username'] ?? '') ?>"
                        type="text" <?php if (!empty($gr['username']))
                            echo 'readonly'; ?> style="width: 200px;">
                    <?php if (empty($gr['username'])): ?>
                        <br><small><?= __('admin.bans.insert_id_or_name') ?></small>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td><strong><?= __('admin.bans.duration') ?></strong></td>
                <td>
                    <label><input type="radio" name="czas" value="1" /> <?= __('admin.bans.second') ?></label><br>
                    <label><input type="radio" name="czas" value="60" /> <?= __('admin.bans.minute') ?></label><br>
                    <label><input type="radio" name="czas" value="3600" /> <?= __('admin.bans.hour') ?></label><br>
                    <label><input type="radio" checked="checked" name="czas" value="86400" /> <?= __('admin.bans.day') ?></label><br>
                    <label><input type="radio" name="czas" value="604800" /> <?= __('admin.bans.week') ?></label><br>
                    <label><input type="radio" name="czas" value="2419200" /> <?= __('admin.bans.month') ?></label><br>
                    <label><input type="radio" name="czas" value="29030400" /> <?= __('admin.bans.year') ?></label>
                </td>
            </tr>
            <tr>
                <td><strong><?= __('admin.bans.ban_end') ?></strong></td>
                <td>
                    <input id="koniec" name="koniec" class="text" value="<?= date('d.m.Y H:i', time() + 86400) ?>"
                        type="text" style="width: 200px;">
                    <i class="far fa-calendar-alt"></i>
                </td>
            </tr>
            <tr>
                <td><strong><?= __('admin.bans.reason') ?></strong></td>
                <td>
                    <textarea style="height:80px;width:300px;" id="message" name="powod"><?= __('admin.bans.default_reason') ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <button name="sub" type="submit" class="btn"><i class="fas fa-ban"></i> <?= __('admin.bans.action_ban') ?></button>
                    <button type="reset" class="btn" style="background: #555;"><i class="fas fa-eraser"></i>
                        <?= __('admin.bans.action_clear') ?></button>
                </td>
            </tr>
        </table>
    </form>
</div>

<div class="admin-card">
    <h3><i class="fas fa-list"></i> <?= __('admin.bans.banned_players') ?></h3>
    <table class="vis" width="100%">
        <tr>
            <th><?= __('admin.bans.col_nick') ?></th>
            <th><?= __('admin.bans.col_ban_end') ?></th>
            <th><?= __('admin.bans.col_actions') ?></th>
        </tr>
        <?php if (!empty($bany)): ?>
            <?php foreach ($bany as $ban): ?>
                <tr>
                    <td>
                        <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $ban['id'] ?>"
                            style="color: #8b0000; font-weight: bold;">
                            <i class="fas fa-user-circle"></i> <?= htmlspecialchars($ban['username']) ?>
                        </a>
                    </td>
                    <td>
                        <?php
                        $is_permanent = ($ban['ban_end'] ?? 0) > time() + 315360000; // > 10 years
                        if ($is_permanent) {
                            echo '<span style="color:red; font-weight:bold;">' . __('admin.bans.permanent') . '</span>';
                        } else {
                            echo date('d.m.Y H:i:s', $ban['ban_end'] ?? 0);
                        }
                        ?>
                    </td>
                    <td>
                        <a href="<?= $adminBaseUrl ?>&mode=bany&action=unban&gracz=<?= $ban['id'] ?>"
                            class="btn" style="padding: 2px 8px; font-size: 10px;">
                            <i class="fas fa-check"></i> <?= __('admin.bans.action_unban') ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" align="center" style="padding: 20px;">
                    <i class="fas fa-check-circle" style="color: green; font-size: 24px;"></i><br>
                    <?= __('admin.bans.no_bans') ?>
                </td>
            </tr>
        <?php endif; ?>
    </table>
</div>

<script type="text/javascript">
    document.querySelectorAll('input[name="czas"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            var duration = parseInt(this.value);
            var now = new Date();
            var targetDate = new Date(now.getTime() + duration * 1000);

            var day = ("0" + targetDate.getDate()).slice(-2);
            var month = ("0" + (targetDate.getMonth() + 1)).slice(-2);
            var year = targetDate.getFullYear();
            var hours = ("0" + targetDate.getHours()).slice(-2);
            var minutes = ("0" + targetDate.getMinutes()).slice(-2);

            var formattedDate = day + "." + month + "." + year + " " + hours + ":" + minutes;

            document.getElementById('koniec').value = formattedDate;
        });
    });
</script>
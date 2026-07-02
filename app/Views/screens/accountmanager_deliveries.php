<?php
/**
 * Account Manager - Deliveries Mode
 * Create and manage supply routes between villages
 */
?>

<h3><?= __('screens.accountmanager.deliveries.title') ?></h3>

<form method="post" action="game.php?village=<?= $village['id'] ?>&screen=accountmanager&mode=deliveries&action=create">

    <table class="vis" width="100%">
        <tr>
            <th colspan="2"><?= __('screens.accountmanager.deliveries.start') ?></th>
        </tr>
        <tr>
            <td width="150"><strong><?= __('screens.accountmanager.deliveries.village') ?></strong></td>
            <td>
                <select name="source_village" style="width: 300px;">
                    <option value=""><?= __('screens.accountmanager.deliveries.choose_village') ?></option>
                    <?php if (!empty($villages)): ?>
                        <?php foreach ($villages as $v): ?>
                            <option value="<?= $v['id'] ?>">
                                <?= htmlspecialchars($v['name']) ?> (<?= $v['x'] ?>|<?= $v['y'] ?>) K<?= $v['continent'] ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>

                <div style="float: right;">
                    <a href="#" id="link_src_fav"><?= __('screens.accountmanager.deliveries.favorites') ?></a><br>
                    <a href="#" id="link_src_recent"><?= __('screens.accountmanager.deliveries.last_villages') ?></a><br>
                    <a href="#" id="link_src_history"><?= __('screens.accountmanager.deliveries.history') ?></a>
                </div>
            </td>
        </tr>
    </table>

    <br>

    <table class="vis" width="100%">
        <tr>
            <th colspan="2"><?= __('screens.accountmanager.deliveries.target') ?></th>
        </tr>
        <tr>
            <td width="150"><strong><?= __('screens.accountmanager.deliveries.village') ?></strong></td>
            <td>
                <select name="target_village" style="width: 300px;">
                    <option value=""><?= __('screens.accountmanager.deliveries.choose_village') ?></option>
                    <?php if (!empty($villages)): ?>
                        <?php foreach ($villages as $v): ?>
                            <option value="<?= $v['id'] ?>">
                                <?= htmlspecialchars($v['name']) ?> (<?= $v['x'] ?>|<?= $v['y'] ?>) K<?= $v['continent'] ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>

                <div style="float: right;">
                    <a href="#" id="link_tgt_all"><?= __('screens.accountmanager.deliveries.all_villages') ?></a><br>
                    <a href="#" id="link_tgt_own"><?= __('screens.accountmanager.deliveries.your_villages') ?></a><br>
                    <a href="#" id="link_tgt_history"><?= __('screens.accountmanager.deliveries.history') ?></a>
                </div>
            </td>
        </tr>
    </table>

    <br>

    <table class="vis" width="100%">
        <tr>
            <th colspan="2"><?= __('screens.accountmanager.deliveries.resources') ?></th>
        </tr>
        <tr>
            <td width="150">
                <img src="graphic/icons/wood.png" style="vertical-align: middle;" /> <strong><?= __('screens.accountmanager.deliveries.wood') ?></strong>
            </td>
            <td>
                <input type="number" name="wood" value="0" min="0" style="width: 100px;">
            </td>
        </tr>
        <tr>
            <td>
                <img src="graphic/icons/stone.png" style="vertical-align: middle;" /> <strong><?= __('screens.accountmanager.deliveries.clay') ?></strong>
            </td>
            <td>
                <input type="number" name="clay" value="0" min="0" style="width: 100px;">
            </td>
        </tr>
        <tr>
            <td>
                <img src="graphic/icons/iron.png" style="vertical-align: middle;" /> <strong><?= __('screens.accountmanager.deliveries.iron') ?></strong>
            </td>
            <td>
                <input type="number" name="iron" value="0" min="0" style="width: 100px;">
            </td>
        </tr>
    </table>

    <br>

    <table class="vis" width="100%">
        <tr>
            <th colspan="8"><?= __('screens.accountmanager.deliveries.days_time') ?></th>
        </tr>
        <tr>
            <td><input type="checkbox" name="days[]" value="monday" id="day_mon"><label for="day_mon"><?= __('screens.accountmanager.deliveries.monday') ?></label>
            </td>
            <td><input type="checkbox" name="days[]" value="tuesday" id="day_tue"><label for="day_tue"><?= __('screens.accountmanager.deliveries.tuesday') ?></label>
            </td>
            <td><input type="checkbox" name="days[]" value="wednesday" id="day_wed"><label for="day_wed"><?= __('screens.accountmanager.deliveries.wednesday') ?></label>
            </td>
            <td><input type="checkbox" name="days[]" value="thursday" id="day_thu"><label for="day_thu"><?= __('screens.accountmanager.deliveries.thursday') ?></label>
            </td>
            <td><input type="checkbox" name="days[]" value="friday" id="day_fri"><label for="day_fri"><?= __('screens.accountmanager.deliveries.friday') ?></label></td>
            <td><input type="checkbox" name="days[]" value="saturday" id="day_sat"><label for="day_sat"><?= __('screens.accountmanager.deliveries.saturday') ?></label>
            </td>
            <td><input type="checkbox" name="days[]" value="sunday" id="day_sun"><label for="day_sun"><?= __('screens.accountmanager.deliveries.sunday') ?></label>
            </td>
            <td>
                <input type="checkbox" name="all_days" id="all_days"><label for="all_days"><?= __('screens.accountmanager.deliveries.all_days') ?></label>

                <strong style="margin-left: 20px;"><?= __('screens.accountmanager.deliveries.time') ?></strong>
                <input type="time" name="time" value="00:00" style="width: 80px;">

                <img src="graphic/new/questionmark.webp" style="background-position: 0 0; width: 14px; height: 14px;"
                    alt="<?= __('screens.accountmanager.deliveries.info') ?>">
            </td>
        </tr>
    </table>

    <br>

    <div style="text-align: center;">
        <input type="hidden" name="h" value="<?= $hkey ?>">
        <button type="submit" class="btn"><?= __('screens.accountmanager.deliveries.create') ?></button>
    </div>
</form>

<script>
    // Toggle all days checkbox
    document.getElementById('all_days').addEventListener('change', function () {
        const dayCheckboxes = document.querySelectorAll('input[name="days[]"]');
        dayCheckboxes.forEach(cb => cb.checked = this.checked);
    });

    // Source village filters
    const sourceSelect = document.querySelector('select[name="source_village"]');
    const sourceOptions = Array.from(sourceSelect.options).slice(1); // Skip first "Escolher aldeia..."

    // Favoritos - Show favorite villages (placeholder - would need backend support)
    document.getElementById('link_src_fav').addEventListener('click', function (e) {
        e.preventDefault();
        // For now, just show all villages
        // In future: filter by favorites from user preferences
        alert('<?= __('screens.accountmanager.deliveries.alert_fav') ?>');
    });

    // Últimas aldeias - Show recently used source villages
    document.getElementById('link_src_recent').addEventListener('click', function (e) {
        e.preventDefault();
        // Get from localStorage
        const recent = JSON.parse(localStorage.getItem('recentSourceVillages') || '[]');
        if (recent.length === 0) {
            alert('<?= __('screens.accountmanager.deliveries.alert_no_recent_src') ?>');
            return;
        }

        // Filter select to show only recent
        sourceSelect.innerHTML = '<option value=""><?= __('screens.accountmanager.deliveries.choose_village') ?></option>';
        sourceOptions.forEach(opt => {
            if (recent.includes(opt.value)) {
                sourceSelect.appendChild(opt.cloneNode(true));
            }
        });
    });

    // Histórico - Show history of source villages
    document.getElementById('link_src_history').addEventListener('click', function (e) {
        e.preventDefault();
        // Reset to show all
        sourceSelect.innerHTML = '<option value=""><?= __('screens.accountmanager.deliveries.choose_village') ?></option>';
        sourceOptions.forEach(opt => sourceSelect.appendChild(opt.cloneNode(true)));
    });

    // Target village filters
    const targetSelect = document.querySelector('select[name="target_village"]');
    const targetOptions = Array.from(targetSelect.options).slice(1);

    // Todas as aldeias - Show all villages in world (would need backend)
    document.getElementById('link_tgt_all').addEventListener('click', function (e) {
        e.preventDefault();
        alert('<?= __('screens.accountmanager.deliveries.alert_all_villages') ?>');
    });

    // As suas aldeias - Show only user villages (already default)
    document.getElementById('link_tgt_own').addEventListener('click', function (e) {
        e.preventDefault();
        // Reset to user villages (default)
        targetSelect.innerHTML = '<option value=""><?= __('screens.accountmanager.deliveries.choose_village') ?></option>';
        targetOptions.forEach(opt => targetSelect.appendChild(opt.cloneNode(true)));
    });

    // Histórico - Show history of target villages
    document.getElementById('link_tgt_history').addEventListener('click', function (e) {
        e.preventDefault();
        const recent = JSON.parse(localStorage.getItem('recentTargetVillages') || '[]');
        if (recent.length === 0) {
            alert('<?= __('screens.accountmanager.deliveries.alert_no_recent_tgt') ?>');
            return;
        }

        targetSelect.innerHTML = '<option value=""><?= __('screens.accountmanager.deliveries.choose_village') ?></option>';
        targetOptions.forEach(opt => {
            if (recent.includes(opt.value)) {
                targetSelect.appendChild(opt.cloneNode(true));
            }
        });
    });

    // Save to history when form is submitted
    document.querySelector('form').addEventListener('submit', function () {
        const sourceValue = sourceSelect.value;
        const targetValue = targetSelect.value;

        if (sourceValue) {
            let recent = JSON.parse(localStorage.getItem('recentSourceVillages') || '[]');
            if (!recent.includes(sourceValue)) {
                recent.unshift(sourceValue);
                recent = recent.slice(0, 10); // Keep last 10
                localStorage.setItem('recentSourceVillages', JSON.stringify(recent));
            }
        }

        if (targetValue) {
            let recent = JSON.parse(localStorage.getItem('recentTargetVillages') || '[]');
            if (!recent.includes(targetValue)) {
                recent.unshift(targetValue);
                recent = recent.slice(0, 10); // Keep last 10
                localStorage.setItem('recentTargetVillages', JSON.stringify(recent));
            }
        }
    });
</script>
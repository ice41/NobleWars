<?php
/**
 * Info Command View - Command/Movement information screen
 * Shows details about troop movements (attacks, support, returns)
 */

// Helper functions
if (!function_exists('format_number')) {
    function format_number($num)
    {
        return number_format($num, 0, ',', '.');
    }
}

if (!function_exists('format_date')) {
    function format_date($timestamp)
    {
        return date('d.m.Y H:i:s', $timestamp);
    }
}

if (!function_exists('format_time')) {
    function format_time($seconds)
    {
        if ($seconds < 0)
            $seconds = 0;
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
    }
}

// Load world configuration and units library
$worldConfig = \App\Helpers\WorldConfig::load();
$cl_units = new \App\Models\UnitsLibrary(null, $worldConfig);

// Map unit counts to dbnames
$units_map = [];
if ($command_exists && isset($mov['units'])) {
    $db_units = array_values($cl_units->get_array("dbname"));
    foreach ($db_units as $index => $dbname) {
        $units_map[$dbname] = isset($mov['units'][$index]) ? (int)$mov['units'][$index] : 0;
    }
}
?>

<?php if ($command_exists): ?>
    <h2><?php echo $mov['message']; ?></h2>

    <?php if ($command_type == 'own'): ?>
        <table class="vis" width="400">
            <tr>
                <th colspan="2"><?= __('screens.info_command.title') ?></th>
            </tr>
            <tr>
                <td><?= __('screens.info_command.target') ?></td>
                <td><a
                        href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_village&amp;id=<?php echo $mov['to_village']; ?>"><?php echo htmlspecialchars($mov['to_villagename']); ?>
                        (<?php echo $mov['to_x']; ?>|<?php echo $mov['to_y']; ?>)</a></td>
            </tr>
            <?php if (isset($mov['to_username'])): ?>
                <tr>
                    <td><?= __('screens.info_command.player') ?></td>
                    <td><a
                            href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_player&amp;id=<?php echo $mov['to_userid']; ?>"><?php echo htmlspecialchars($mov['to_username']); ?></a>
                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <td><?= __('screens.info_command.duration') ?></td>
                <td><?php echo format_time($mov['duration']); ?></td>
            </tr>
            <tr>
                <td><?= __('screens.info_command.arrival') ?></td>
                <td><?php echo format_date($mov['arrival']); ?></td>
            </tr>
            <tr>
                <td><?= __('screens.info_command.arrival_in') ?></td>
                <td><span class="timer"><?php echo format_time($mov['arrival_in']); ?></span></td>
            </tr>
            <tr>
                <td><?= __('screens.info_command.origin') ?></td>
                <td><a
                        href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_village&amp;id=<?php echo $mov['from_village']; ?>"><?php echo htmlspecialchars($mov['from_villagename']); ?>
                        (<?php echo $mov['from_x']; ?>|<?php echo $mov['from_y']; ?>)</a></td>
            </tr>

            <tr>
                <td colspan="2"><a href="game.php?village=<?php echo $village['id']; ?>&amp;screen=place">&raquo; <?= __('screens.info_command.rally_point') ?></a></td>
            </tr>
            <?php if ($mov['cancel']): ?>
                <tr>
                    <td colspan="2"><a
                            href="game.php?village=<?php echo $village['id']; ?>&amp;screen=place&amp;action=cancel&amp;id=<?php echo $mov['id']; ?>&amp;h=<?php echo $_SESSION['hkey'] ?? ''; ?>">&raquo;
                            <?= __('screens.info_command.send_troops') ?></a></td>
                </tr>
            <?php endif; ?>
        </table>
        <br />

        <table class="vis">
            <tr>
                <?php foreach ($units_map as $dbname => $num_units): ?>
                    <th width="50">
                        <img src="graphic/unit/<?= $dbname ?>.png" title="<?= htmlspecialchars($cl_units->get_name($dbname)) ?>" alt="" />
                    </th>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach ($units_map as $dbname => $num_units): ?>
                    <?php if ($num_units > 0): ?>
                        <td><?php echo format_number($num_units); ?></td>
                    <?php else: ?>
                        <td class="hidden">0</td>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        </table>

        <?php if ($mov['wood'] != 0 || $mov['stone'] != 0 || $mov['iron'] != 0): ?>
            <table class="vis">
                <tr>
                    <td>Saque</td>
                    <td>
                        <?php if ($mov['wood'] > 0): ?>
                            <img src="graphic/icons/wood.png" title="Madeira" alt="" /><?php echo format_number($mov['wood']); ?>
                        <?php endif; ?>
                        <?php if ($mov['stone'] > 0): ?>
                            <img src="graphic/icons/stone.png" title="Argila" alt="" /><?php echo format_number($mov['stone']); ?>
                        <?php endif; ?>
                        <?php if ($mov['iron'] > 0): ?>
                            <img src="graphic/icons/iron.png" title="Ferro" alt="" /><?php echo format_number($mov['iron']); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        <?php endif; ?>

    <?php else: ?>
        <!-- Other's command (incoming) -->
        <table class="vis" width="300">
            <tr>
                <th colspan="2"><?= __('screens.info_command.title') ?></th>
            </tr>
            <tr>
                <td><?= __('screens.info_command.target') ?></td>
                <td><a
                        href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_village&amp;id=<?php echo $mov['to_village']; ?>"><?php echo htmlspecialchars($mov['to_villagename']); ?>
                        (<?php echo $mov['to_x']; ?>|<?php echo $mov['to_y']; ?>)</a></td>
            </tr>
            <tr>
                <td><?= __('screens.info_command.origin') ?></td>
                <td><a
                        href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_village&amp;id=<?php echo $mov['from_village']; ?>"><?php echo htmlspecialchars($mov['from_villagename']); ?>
                        (<?php echo $mov['from_x']; ?>|<?php echo $mov['from_y']; ?>)</a></td>
            </tr>
            <?php if (isset($mov['from_username'])): ?>
                <tr>
                    <td><?= __('screens.info_command.player') ?></td>
                    <td><a
                            href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_player&amp;id=<?php echo $mov['from_userid']; ?>"><?php echo htmlspecialchars($mov['from_username']); ?></a>
                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <td><?= __('screens.info_command.arrival') ?></td>
                <td><?php echo format_date($mov['arrival']); ?></td>
            </tr>
            <tr>
                <td><?= __('screens.info_command.arrival_in') ?></td>
                <td><span class="timer"><?php echo format_time($mov['arrival_in']); ?></span></td>
            </tr>
        </table>
    <?php endif; ?>

<?php else: ?>
    <span class="error">O comando não existe</span>
<?php endif; ?>
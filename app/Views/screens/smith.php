<?php
// Helper for formatting time
if (!function_exists('format_time')) {
    function format_time($seconds)
    {
        if ($seconds < 0)
            return '00:00:00';
        return gmdate('H:i:s', $seconds);
    }
}

// Group units for display - only include units that are in $research (already filtered by controller)
$all_groups = [
    __('screens.smith.infantry') => ['unit_spear', 'unit_sword', 'unit_axe', 'unit_archer'],
    __('screens.smith.cavalry') => ['unit_spy', 'unit_light', 'unit_cav_archer', 'unit_heavy'],
    __('screens.smith.siege_machines') => ['unit_ram', 'unit_catapult']
];

// Filter groups to only include units present in $research
$groups = [];
foreach ($all_groups as $group_name => $unit_list) {
    $filtered_units = array_filter($unit_list, function ($unit) use ($research) {
        return array_key_exists($unit, $research);
    });
    if (!empty($filtered_units)) {
        $groups[$group_name] = array_values($filtered_units);
    }
}

// Helper to check requirements
function check_req($unit, $village, $cl_units)
{
    // Basic implementation: if building levels allow
    // Ideally this should use UnitsLibrary::check_needed, but for now we assume Smithy is open so basic units are available.
    // TODO: Add strict requirement check
    return true;
}

// Config
$base_cost = ['wood' => 800, 'stone' => 600, 'iron' => 1000];
?>

<table>
    <tr>
        <td>
            <?php
            $dbname = 'smith';
            $max_stage = 20; // Standard max level for Smithy
            $current_stage = $village[$dbname];
            $stage_percent = $current_stage / $max_stage;
            $img_suffix = '1';
            if ($max_stage > 3) {
                if ($stage_percent > 0.5)
                    $img_suffix = '3';
                elseif ($stage_percent > 0.2)
                    $img_suffix = '2';
            }
            ?>
            <img src="graphic/big_buildings/<?= $dbname ?><?= $img_suffix ?>.png"
                title="<?= $cl_builds->get_name($dbname) ?>" alt="" />
        </td>
        <td>
            <h2><?= $cl_builds->get_name($dbname) ?>
                (<?php if ($village[$dbname] > 0): ?><?= __('screens.common.level') ?>
                    <?= $village[$dbname] ?><?php else: ?>     <?= __('screens.common.not_built') ?><?php endif; ?>)
            </h2>
            <?= $cl_builds->get_description_bydbname($dbname) ?>
            <br>
            <a class="btn btn-research"
                href="game.php?village=<?= $village['id'] ?>&screen=smith&action=ulepsz_wszystkie_tech"><?= __('screens.smith.research_all_tech') ?></a>
        </td>
    </tr>
</table>
<br />

<?php if (!empty($error)): ?>
    <font class="error"><?= $error ?></font>
<?php endif; ?>

<!-- Research Queue Container - Updated via AJAX -->
<div id="research-queue-container">
    <?php if (count($research_queue) > 0): ?>
        <table class="vis">
            <tr>
                <th width="220"><?= __('screens.smith.technology') ?></th>
                <th width="100"><?= __('screens.smith.duration') ?></th>
                <th width="120"><?= __('screens.smith.completion') ?></th>
                <th><?= __('screens.smith.finish') ?></th>
            </tr>
            <?php foreach ($research_queue as $q): ?>
                <?php
                $countdown = $q['end_time'] - time();
                $unit_name = $cl_units->get_name($q['unit']);
                ?>
                <tr class="lit">
                    <td><?= $unit_name ?></td>
                    <td><span class="timer"><?= format_time($countdown) ?></span></td>
                    <td><?= date('d.m.Y H:i:s', $q['end_time']) ?></td>
                    <td>
                        <a
                            href="game.php?village=<?= $village['id'] ?>&amp;screen=smith&amp;action=cancel&amp;id=<?= $q['id'] ?>&amp;h=<?= $session['hkey'] ?? '' ?>"><?= __('screens.smith.stop') ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br />
    <?php endif; ?>
</div>

<table class="vis" width="100%">
    <tr>
        <?php foreach ($groups as $group_name => $units): ?>
            <th width="33%"><?= $group_name ?></th>
        <?php endforeach; ?>
    </tr>
    <tr>
        <?php foreach ($groups as $group_name => $units): ?>
            <td valign="top">
                <?php foreach ($units as $unit): ?>
                    <?php
                    // Calculate costs and times dynamically (Logic duplicated from Controller for View)
                    $current_level = $research[$unit] ?? 0;
                    $next_level = $current_level + 1;
                    $cost_multiplier = pow(1.2, $current_level);

                    $wood_cost = floor($base_cost['wood'] * $cost_multiplier);
                    $stone_cost = floor($base_cost['stone'] * $cost_multiplier);
                    $iron_cost = floor($base_cost['iron'] * $cost_multiplier);

                    global $config;
                    $speed = isset($config['speed']) ? $config['speed'] : 1;
                    $base_time = 3600;
                    $time_sec = ceil(($base_time * $cost_multiplier / ($smith_level * 0.1 + 1)) / $speed);

                    $can_afford = ($village['r_wood'] >= $wood_cost && $village['r_stone'] >= $stone_cost && $village['r_iron'] >= $iron_cost);
                    // Check if max level reached (Simple world: max 3/10/simple tech? Let's assume 3 for this layout style or 10. Let's stick to 10 from Controller)
                    $max_tech_level = 10;
                    $is_max = $current_level >= $max_tech_level;

                    // Simple queue check
                    $is_researching = false;
                    foreach ($research_queue as $q) {
                        if ($q['unit'] == $unit)
                            $is_researching = true;
                    }
                    ?>

                    <table class="vis" width="100%">
                        <tr>
                            <td>
                                <?php
                                $img_name = str_replace('unit_', '', $unit);
                                $status = $research_status[$unit] ?? ['has_requirements' => true, 'is_researched' => false, 'missing' => []];

                                // Determine icon based on status
                                // Priority: requirements ALWAYS first, then research status
                                // This ensures _cross.png shows even for researched units when
                                // the current village doesn't meet building requirements
                                if (!$status['has_requirements']) {
                                    // Missing requirements = always cross (even if researched)
                                    $icon = "graphic/unit_big/{$img_name}_cross.png";
                                } elseif ($status['is_researched']) {
                                    // Researched AND has requirements = normal icon
                                    $icon = "graphic/unit_big/{$img_name}.png";
                                } else {
                                    // Not researched but has requirements = grey
                                    $icon = "graphic/unit_big/{$img_name}_grey.png";
                                }

                                // DEBUG
                                echo "<!-- $unit: has_req=" . ($status['has_requirements'] ? 'YES' : 'NO') .
                                    ", is_researched=" . ($status['is_researched'] ? 'YES' : 'NO') .
                                    ", icon=$icon -->";
                                ?>
                                <a href="#"><img src="<?= $icon ?>" alt="" data-unit-icon="<?= $unit ?>" /></a>
                            </td>
                            <td valign="top">
                                <a href="#"><?= $cl_units->get_name($unit) ?></a>
                                <span data-unit-level="<?= $unit ?>">
                                    <?php if ($current_level > 0): ?>
                                        (<?= __('screens.common.level') ?>             <?= $current_level ?>)
                                    <?php else: ?>
                                        (<?= __('screens.smith.not_researched') ?>)
                                    <?php endif; ?>
                                </span>
                                <br />

                                <?php if ($is_researching): ?>
                                    <span class="inactive"><?= __('screens.smith.researching') ?></span>
                                <?php elseif ($is_max): ?>
                                    <a class="btn btn-research-disabled"><?= __('screens.common.max_level') ?></a>
                                <?php elseif (!$status['has_requirements']): ?>
                                    <a class="btn btn-research-disabled"><?= __('screens.smith.research') ?></a>
                                    <br />
                                    <div class="requirements-missing mt-5"  style="color: #666; font-size: 10px;">
                                        <strong><?= __('screens.smith.missing_requirements') ?></strong><br>
                                        <?php foreach ($status['missing'] as $req): ?>
                                            <?= $req['building'] ?> (<?= $req['required'] ?>)<br>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <img src="graphic/icons/wood.png" title="<?= __('screens.smith.wood') ?>" alt="" /> <?= $wood_cost ?>
                                    <img src="graphic/icons/stone.png" title="<?= __('screens.smith.stone') ?>" alt="" /> <?= $stone_cost ?>
                                    <img src="graphic/icons/iron.png" title="<?= __('screens.smith.iron') ?>" alt="" /> <?= $iron_cost ?>
                                    <br />

                                    <?php if ($can_afford): ?>
                                        <a class="btn btn-research"
                                            href="game.php?village=<?= $village['id'] ?>&amp;screen=smith&amp;action=research&amp;unit=<?= $unit ?>&amp;h=<?= $session['hkey'] ?? '' ?>">
                                            <?= __('screens.smith.research') ?>
                                        </a>
                                        (<?= format_time($time_sec) ?>)
                                    <?php else: ?>
                                        <span class="inactive"><?= __('screens.smith.insufficient_resources') ?>
                                            (<?= format_time($time_sec) ?>)</span>
                                        <br>
                                        <span class="inactive"><?= __('screens.smith.available_in') ?> <span
                                                class="timer_replace">--:--:--</span></span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                <?php endforeach; ?>
            </td>
        <?php endforeach; ?>
    </tr>
</table>

<script>
    // AJAX-based auto-refresh - Updates without page reload
    (function () {
        let lastQueueCount = <?= count($research_queue) ?>;
        let lastTechLevels = <?= json_encode($research) ?>;
        let checkInterval = null;

        // Update tech level display
        function updateTechLevel(unit, newLevel) {
            const levelElement = document.querySelector(`[data-unit-level="${unit}"]`);
            if (levelElement) {
                // Add highlight animation
                levelElement.classList.add('level-updated');

                // Update text
                if (newLevel > 0) {
                    levelElement.textContent = `(${__('screens.common.level')} ${newLevel})`;
                } else {
                    levelElement.textContent = '(<?= __('screens.smith.not_researched') ?>)';
                }

                // Remove animation class after it completes
                setTimeout(() => levelElement.classList.remove('level-updated'), 600);
            }
        }

        // Update unit icon (from grey to normal when first researched)
        function updateUnitIcon(unit, newLevel, oldLevel) {
            if (oldLevel === 0 && newLevel > 0) {
                const iconElement = document.querySelector(`[data-unit-icon="${unit}"]`);
                if (iconElement) {
                    // Change from grey to normal icon
                    const currentSrc = iconElement.src;
                    const newSrc = currentSrc.replace('_grey.png', '.png');
                    if (currentSrc !== newSrc) {
                        iconElement.src = newSrc;
                    }
                }
            }
        }

        // Update research queue table
        function updateResearchQueue(villageId, world) {
            fetch(`/ajax/get_research_queue.php?village=${villageId}&world=${world}`)
                .then(response => response.text())
                .then(html => {
                    const container = document.getElementById('research-queue-container');
                    if (container) {
                        container.innerHTML = html;
                    }
                })
                .catch(error => {
                    console.error('Error updating research queue:', error);
                });
        }

        // Main status check function
        function checkResearchStatus() {
            const villageId = <?= $village['id'] ?>;
            const world = <?= $_GET['world'] ?? 1 ?>;

            fetch(`/ajax/check_research_status.php?village=${villageId}&world=${world}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const currentQueueCount = data.queue.length;

                        // Research just completed (queue shrank)
                        if (currentQueueCount < lastQueueCount) {
                            console.log('Research completed! Updating display...');

                            // Stop polling immediately
                            if (checkInterval) {
                                clearInterval(checkInterval);
                                checkInterval = null;
                            }

                            // Update research queue display
                            updateResearchQueue(villageId, world);

                            // Check which units leveled up
                            for (const [unit, newLevel] of Object.entries(data.tech_levels)) {
                                const oldLevel = lastTechLevels[unit] || 0;
                                if (newLevel > oldLevel) {
                                    updateTechLevel(unit, newLevel);
                                    updateUnitIcon(unit, newLevel, oldLevel);
                                    console.log(`Updated ${unit}: ${oldLevel} -> ${newLevel}`);
                                }
                            }

                            lastTechLevels = data.tech_levels;
                            lastQueueCount = currentQueueCount;

                            // Reload page in 2 seconds to refresh buttons, costs and requirements
                            setTimeout(() => {
                                console.log('Reloading page to refresh all UI elements...');
                                location.reload();
                            }, 2000);

                        } else {
                            // Queue unchanged, keep polling
                            lastQueueCount = currentQueueCount;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error checking research status:', error);
                });
        }

        // Only poll when there is active research in the queue.
        // When queue is empty at page load, nothing to watch — avoid infinite loop.
        if (lastQueueCount > 0) {
            console.log(`Starting AJAX auto-refresh (${lastQueueCount} research in queue)`);
            checkInterval = setInterval(checkResearchStatus, 1000); // Check every second
        }
        // No else — do NOT start "minimal polling" when idle.
        // Research buttons do a normal navigation → next page load will
        // see lastQueueCount > 0 and start intensive polling automatically.

        document.addEventListener('DOMContentLoaded', function () {
            const researchButtons = document.querySelectorAll('a.btn-research[href*="action=research"]');
            researchButtons.forEach(button => {
                button.addEventListener('click', function () {
                    console.log('Research button clicked, polling will start on next page load...');
                });
            });
        });
    })();
</script>
<!-- Unit Info Modal -->
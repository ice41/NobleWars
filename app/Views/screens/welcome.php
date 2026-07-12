<script src="js/chart.umd.min.js"></script>

<div class="welcome-cols">
    <!-- Left Column -->
    <div class="welcome-col-left">
        <!-- Profile summary card -->
        <table class="vis welcome-table">
            <thead>
                <tr>
                    <th class="welcome-th">
                        <?= __('welcome.welcome_back', ['username' => htmlspecialchars($user['username'])]) ?>
                        <a class="welcome-th-link" href="game.php?village=<?= $village['id'] ?>&amp;id=<?= $user['id'] ?>&amp;screen=info_player">» <?= __('welcome.profile') ?></a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="welcome-td-plain">
                        <table class="vis welcome-table-inner">
                            <tr class="row_a">
                                <td class="welcome-td-label"><?= __('welcome.rank_label') ?></td>
                                <td class="welcome-td-value"><?= format_number($user['rang']) ?></td>
                            </tr>
                            <tr class="row_b">
                                <td class="welcome-td-label-no-width"><?= __('welcome.villages_label') ?></td>
                                <td class="welcome-td-value"><?= format_number($user['villages']) ?></td>
                            </tr>
                            <tr class="row_a">
                                <td class="welcome-td-label-no-border"><?= __('welcome.points_label') ?></td>
                                <td class="welcome-td-value-no-border"><?= format_number($user['points']) ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Statistics Widget -->
        <table class="vis welcome-table">
            <thead>
                <tr>
                    <th class="welcome-th"><?= __('welcome.stats') ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="welcome-stats-container">
                        <!-- Statistics metric switcher tabs -->
                        <div class="stats-tabs-container">
                            <ul class="stats-tabs">
                                <li class="tab-item">
                                    <a href="#" class="tab-link active" data-metric="points" title="<?= __('welcome.tab_points') ?>">
                                        <img src="graphic/icons/player_points.png" alt="<?= __('welcome.tab_points') ?>">
                                    </a>
                                </li>
                                <li class="tab-item">
                                    <a href="#" class="tab-link" data-metric="villages" title="<?= __('welcome.tab_villages') ?>">
                                        <img src="graphic/icons/player_villages.png" alt="<?= __('welcome.tab_villages') ?>">
                                    </a>
                                </li>
                                <li class="tab-item">
                                    <a href="#" class="tab-link" data-metric="rank" title="<?= __('welcome.tab_rank') ?>">
                                        <img src="graphic/buildings/main.png" alt="<?= __('welcome.tab_rank') ?>">
                                    </a>
                                </li>
                                <li class="tab-item">
                                    <a href="#" class="tab-link" data-metric="units_defeated" title="<?= __('welcome.tab_od') ?>">
                                        <img src="graphic/icons/kill.png" alt="<?= __('welcome.tab_od') ?>">
                                    </a>
                                </li>
                                <li class="tab-item">
                                    <a href="#" class="tab-link" data-metric="resources_looted" title="<?= __('welcome.tab_looted') ?>">
                                        <img src="graphic/icons/resources.png" alt="<?= __('welcome.tab_looted') ?>">
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Chart Container -->
                        <div class="welcome-notes-box">
                            <canvas id="welcome_stats_chart"></canvas>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Right Column -->
    <div class="welcome-col-right">
        <!-- Announcements box -->
        <table class="vis welcome-table">
            <thead>
                <tr>
                    <th class="welcome-th"><?= __('welcome.latest_news') ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="welcome-news-container">
                        <?php if (!empty($news)): ?>
                            <?php 
                            $bbParser = new \App\Helpers\BBCodeParser();
                            $total_news = count($news);
                            $counter = 0;
                            foreach ($news as $item): 
                                $counter++;
                            ?>
                                <div class="news-item welcome-news-item" style="<?= $counter < $total_news ? 'border-bottom: 1px dashed #dfbc7a;' : '' ?>">
                                    <span class="<?= ($item['typ'] != 0) ? 'global-' : '' ?>news welcome-news-title"><?= htmlspecialchars($item['nazwa']) ?></span>
                                    <span class="welcome-news-date">(<?= htmlspecialchars($item['data']) ?>)</span>
                                    <div class="welcome-news-text"><?= $bbParser->parse($item['text']) ?></div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?= __('welcome.no_news') ?>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Alliance activity box -->
        <table class="vis welcome-table">
            <thead>
                <tr>
                    <th class="welcome-th"><?= __('welcome.tribe_activity') ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="welcome-td-plain">
                        <?php if (($user['ally'] ?? -1) <= 0): ?>
                            <div class="welcome-tribe-empty"><?= __('welcome.no_tribe') ?></div>
                        <?php elseif (empty($events)): ?>
                            <div class="welcome-tribe-empty"><?= __('welcome.no_tribe_events') ?></div>
                        <?php else: ?>
                            <table class="vis welcome-table-inner">
                                <tbody>
                                    <?php 
                                    $bbParser = new \App\Helpers\BBCodeParser();
                                    foreach ($events as $idx => $event): 
                                    ?>
                                        <tr class="<?= $idx % 2 == 0 ? 'row_a' : 'row_b' ?>">
                                            <td class="welcome-tribe-event-time">
                                                <?= htmlspecialchars($event['formatted_time']) ?>
                                            </td>
                                            <td class="welcome-tribe-event-text">
                                                <?= compile_ally_events($event['message']) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Continue button -->
        <div class="welcome-footer">
            <a class="btn-green" href="game.php?village=<?= $village['id'] ?>&amp;screen=overview"><?= __('welcome.continue_to_game') ?></a>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('welcome_stats_chart').getContext('2d');
    const datasets = <?= json_encode($chart_datasets) ?>;
    
    let activeMetric = 'points';
    let currentData = datasets[activeMetric];
    
    const localizations = {
        points: "<?= __('welcome.tab_points') ?>",
        villages: "<?= __('welcome.tab_villages') ?>",
        rank: "<?= __('welcome.tab_rank') ?>",
        units_defeated: "<?= __('welcome.tab_od') ?>",
        resources_looted: "<?= __('welcome.tab_looted') ?>"
    };

    // Helper to format metric title in tooltips
    function getMetricLabel(metric) {
        return localizations[metric] || '';
    }

    // Default data point if no stats exist
    if (!currentData || !currentData.labels || currentData.labels.length === 0) {
        currentData = {
            labels: [new Date().toLocaleDateString('<?= str_replace('_', '-', current_locale()) ?>', {day:'2-digit', month:'2-digit'})],
            data: [<?= (int)$user['points'] ?>]
        };
    }

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: currentData.labels,
            datasets: [{
                data: currentData.data,
                borderColor: '#2b8a3e',
                backgroundColor: 'rgba(43, 138, 62, 0.05)',
                borderWidth: 2.5,
                pointBackgroundColor: '#2b8a3e',
                pointBorderColor: '#fff',
                pointRadius: 4,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#2b8a3e',
                pointHoverBorderColor: '#fff',
                fill: true,
                tension: 0.15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(60, 30, 0, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff5da',
                    borderColor: '#7d510f',
                    borderWidth: 1,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return getMetricLabel(activeMetric) + ': ' + context.raw.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        color: '#e6d5b0',
                        drawOnChartArea: true,
                        drawTicks: false
                    },
                    ticks: {
                        color: '#603000',
                        font: {
                            family: 'Verdana, Arial, sans-serif',
                            size: 9
                        }
                    }
                },
                y: {
                    grid: {
                        color: '#e6d5b0',
                        drawOnChartArea: true,
                        drawTicks: false
                    },
                    ticks: {
                        color: '#603000',
                        font: {
                            family: 'Verdana, Arial, sans-serif',
                            size: 9
                        },
                        precision: 0,
                        callback: function(value) {
                            if (value % 1 === 0) {
                                if (value >= 1000) {
                                    return (value / 1000).toFixed(0) + 'k';
                                }
                                return value;
                            }
                        }
                    }
                }
            }
        }
    });

    // Tab click handler
    document.querySelectorAll('.tab-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            document.querySelectorAll('.tab-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            
            activeMetric = this.getAttribute('data-metric');
            let targetData = datasets[activeMetric];
            
            if (!targetData || !targetData.labels || targetData.labels.length === 0) {
                let fallbackVal = 0;
                if (activeMetric === 'points') fallbackVal = <?= (int)$user['points'] ?>;
                else if (activeMetric === 'villages') fallbackVal = <?= (int)$user['villages'] ?>;
                else if (activeMetric === 'rank') fallbackVal = <?= (int)$user['rang'] ?>;
                
                targetData = {
                    labels: [new Date().toLocaleDateString('<?= str_replace('_', '-', current_locale()) ?>', {day:'2-digit', month:'2-digit'})],
                    data: [fallbackVal]
                };
            }
            
            chart.data.labels = targetData.labels;
            chart.data.datasets[0].data = targetData.data;
            
            // Reversing the Y scale when viewing ranking so 1st place is at the top
            if (activeMetric === 'rank') {
                chart.options.scales.y.reverse = true;
            } else {
                chart.options.scales.y.reverse = false;
            }
            
            chart.update();
        });
    });
});
</script>
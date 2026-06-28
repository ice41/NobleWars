<script src="js/chart.umd.min.js"></script>

<style>
.welcome-cols {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    margin-top: 10px;
}
.welcome-col-left {
    flex: 1.2 1 500px;
    min-width: 300px;
}
.welcome-col-right {
    flex: 1 1 400px;
    min-width: 300px;
}
.stats-tabs {
    display: flex;
    gap: 4px;
    margin: 0 0 10px 0;
    padding: 0;
    list-style: none;
}
.stats-tabs .tab-item {
    margin: 0;
    padding: 0;
}
.stats-tabs .tab-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    border: 1px solid #7d510f;
    border-radius: 4px;
    background: #dfbc7a;
    background: linear-gradient(to bottom, #f5d79e 0%, #c9a463 100%);
    cursor: pointer;
    box-shadow: 0 1px 1px rgba(0,0,0,0.15), inset 0 1px 0 rgba(255,255,255,0.3);
    transition: all 0.2s ease;
}
.stats-tabs .tab-link:hover {
    background: linear-gradient(to bottom, #ffebc2 0%, #deb877 100%);
}
.stats-tabs .tab-link.active {
    background: #fff5da;
    border-color: #603000;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.2);
}
.stats-tabs .tab-link img {
    max-width: 18px;
    max-height: 18px;
    display: block;
}
.btn-green {
    display: inline-block;
    padding: 8px 20px;
    font-size: 13px;
    font-weight: bold;
    color: #fff !important;
    text-shadow: 0 1px 0 rgba(0,0,0,0.4);
    text-decoration: none !important;
    text-align: center;
    background: #2b8a3e;
    background: linear-gradient(to bottom, #40c057 0%, #2b8a3e 100%);
    border: 1px solid #1c6b2e;
    border-radius: 4px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.3), inset 0 1px 0 rgba(255,255,255,0.2);
    cursor: pointer;
}
.btn-green:hover {
    background: #37b24d;
    background: linear-gradient(to bottom, #51cf66 0%, #37b24d 100%);
    border-color: #247a35;
    box-shadow: 0 1px 3px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.3);
}
.btn-green:active {
    background: #2b8a3e;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.2);
}
</style>

<div class="welcome-cols">
    <!-- Left Column -->
    <div class="welcome-col-left">
        <!-- Profile summary card -->
        <table class="vis" style="width: 100%; margin-bottom: 15px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="padding: 6px 8px; font-weight: bold; font-size: 12px; height: 18px;">
                        <?= __('welcome.welcome_back', ['username' => htmlspecialchars($user['username'])]) ?>
                        <a style="float: right; font-weight: normal; font-size: 11px; text-decoration: none;" href="game.php?village=<?= $village['id'] ?>&amp;id=<?= $user['id'] ?>&amp;screen=info_player">» <?= __('welcome.profile') ?></a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 0; border: none;">
                        <table class="vis" style="width: 100%; border-collapse: collapse; margin: 0; border: none;">
                            <tr class="row_a">
                                <td style="padding: 6px 8px; font-weight: bold; width: 40%; border-bottom: 1px solid #dfbc7a;"><?= __('welcome.rank_label') ?></td>
                                <td style="padding: 6px 8px; text-align: right; border-bottom: 1px solid #dfbc7a; font-weight: bold;"><?= format_number($user['rang']) ?></td>
                            </tr>
                            <tr class="row_b">
                                <td style="padding: 6px 8px; font-weight: bold; border-bottom: 1px solid #dfbc7a;"><?= __('welcome.villages_label') ?></td>
                                <td style="padding: 6px 8px; text-align: right; border-bottom: 1px solid #dfbc7a; font-weight: bold;"><?= format_number($user['villages']) ?></td>
                            </tr>
                            <tr class="row_a">
                                <td style="padding: 6px 8px; font-weight: bold;"><?= __('welcome.points_label') ?></td>
                                <td style="padding: 6px 8px; text-align: right; font-weight: bold;"><?= format_number($user['points']) ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Statistics Widget -->
        <table class="vis" style="width: 100%; margin-bottom: 15px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="padding: 6px 8px; font-weight: bold; font-size: 12px; height: 18px;"><?= __('welcome.stats') ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 10px; background: #f4e4bc;">
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
                        <div style="background: #fff5da; border: 1px solid #7d510f; padding: 10px; border-radius: 3px; height: 230px; position: relative;">
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
        <table class="vis" style="width: 100%; margin-bottom: 15px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="padding: 6px 8px; font-weight: bold; font-size: 12px; height: 18px;"><?= __('welcome.latest_news') ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 12px 10px; line-height: 1.45; font-size: 11px;">
                        <?php if (!empty($news)): ?>
                            <?php 
                            $bbParser = new \App\Helpers\BBCodeParser();
                            $total_news = count($news);
                            $counter = 0;
                            foreach ($news as $item): 
                                $counter++;
                            ?>
                                <div class="news-item" style="margin-bottom: 12px; padding-bottom: 10px; <?= $counter < $total_news ? 'border-bottom: 1px dashed #dfbc7a;' : '' ?>">
                                    <span class="<?= ($item['typ'] != 0) ? 'global-' : '' ?>news" style="font-weight: bold; font-size: 12px; color: #7d510f;"><?= htmlspecialchars($item['nazwa']) ?></span>
                                    <span style="font-size: 10px; color: #666; margin-left: 6px;">(<?= htmlspecialchars($item['data']) ?>)</span>
                                    <div style="margin-top: 6px; line-height: 1.4;"><?= $bbParser->parse($item['text']) ?></div>
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
        <table class="vis" style="width: 100%; margin-bottom: 15px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="padding: 6px 8px; font-weight: bold; font-size: 12px; height: 18px;"><?= __('welcome.tribe_activity') ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 0; border: none;">
                        <?php if (($user['ally'] ?? -1) <= 0): ?>
                            <div style="padding: 12px 10px; font-size: 11px;"><?= __('welcome.no_tribe') ?></div>
                        <?php elseif (empty($events)): ?>
                            <div style="padding: 12px 10px; font-size: 11px;"><?= __('welcome.no_tribe_events') ?></div>
                        <?php else: ?>
                            <table class="vis" style="width: 100%; border-collapse: collapse; margin: 0; border: none;">
                                <tbody>
                                    <?php 
                                    $bbParser = new \App\Helpers\BBCodeParser();
                                    foreach ($events as $idx => $event): 
                                    ?>
                                        <tr class="<?= $idx % 2 == 0 ? 'row_a' : 'row_b' ?>">
                                            <td style="padding: 6px 8px; width: 65px; text-align: center; color: #666; font-size: 10px; border-bottom: 1px solid #dfbc7a;">
                                                <?= htmlspecialchars($event['formatted_time']) ?>
                                            </td>
                                            <td style="padding: 6px 8px; font-size: 11px; border-bottom: 1px solid #dfbc7a;">
                                                <?= $bbParser->parse(compile_ally_events($event['message'])) ?>
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
        <div style="text-align: right; margin-top: 15px; padding-right: 5px;">
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
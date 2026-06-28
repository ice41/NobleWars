<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title><?php echo __("screens.stats.world_x", ["world" => $world]) ?> - <?php echo __("common.game_name") ?> -
        <?php echo __("screens.stats.world_x", ["world" => $world]) ?>
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="stylesheet" type="text/css" href="css/game_new.css" />
    <link rel="stylesheet" type="text/css" href="css/stats.css" />
    <link rel="shortcut icon" href="graphic/icons/nwfavicon.ico" />
</head>

<body id="stats-page">

    <?php
    // Navigation links (same as index.php)
    $linki = [
        'index.php' => __("screens.hall_of_fame.home"),
        'rules.php' => __("screens.hall_of_fame.rules"),
        'info_world.php' => __("screens.stats.world_settings"),
        'rounds_speed.php' => 'Rounds Speed',
        'support.php' => 'Suporte',
        'help.php' => 'Ajuda',
        'forum.php' => __("screens.hall_of_fame.forum")
    ];
    ?>

    <div id="pbar">
        <div class="pb-outer pb-outer-pl">
            <div class="pb-inner">
                <div class="pb-cntnt">
                    <div class="pb-home">
                        <a href="https://ice41.pt" target="_blank" title="ice41"><span>ice41</span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="pb-tab"></div>
    </div>

    <div id="index_body">
        <div id="main">
            <div id="header">
                <h1>
                    <a href="index.php" style="background:url(graphic/index/bg-noble2.jpg) no-repeat 100% 0;">
                        <p style="position: absolute; top: -300px"><?php echo __("common.game_name") ?> - O jogo de
                            browser</p>
                    </a>
                </h1>
                <div class="navigation">
                    <div class="navigation-holder">
                        <div class="navigation-wrapper">
                            <div id="navigation_span">
                                <?php
                                $lcount = count($linki);
                                $i = 0;
                                foreach ($linki as $link => $value):
                                    $i++;
                                    ?>
                                    <a href="<?= $link ?>"><?= $value ?></a>
                                    <?php if ($lcount != $i)
                                        echo " - "; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="paladin"><img src="graphic/index/bg-ice41.png" alt="" /></span>
            </div>

            <div id="content">
                <div class="container-block-full">
                    <div class="container-top-full"></div>
                    <div class="container">
                        <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 15px; text-align: center;">
                            <?php echo __("screens.stats.title", ["world" => $world]) ?>
                        </h2>

                        <table width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <!-- LEFT COLUMN: CONTENT -->
                                <td valign="top" style="padding-right: 10px;">
                                    <?php if ($mode === 'stats'): ?>
                                        <!-- Chart.js Local -->
                                        <script src="js/chart.umd.min.js"></script>

                                        <!-- Statistics Box -->
                                        <div class="stats-box">
                                            <div class="stats-box-top">
                                                <div class="stats-box-title">
                                                    <?php echo __("screens.stats.world_statistics") ?>
                                                </div>
                                            </div>
                                            <div class="stats-box-body">
                                                <!-- World Progress Charts -->
                                                <div class="world-charts-container"
                                                    style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 20px;">
                                                    <div class="world-chart-box"
                                                        style="background: #f4e4bc; border: 1px solid #7d510f; padding: 5px;">
                                                        <div
                                                            style="font-weight: bold; font-size: 11px; text-align: center; margin-bottom: 5px;">
                                                            <?php echo __("screens.stats.total_players") ?>
                                                        </div>
                                                        <canvas id="playersChart" height="150"></canvas>
                                                    </div>
                                                    <div class="world-chart-box"
                                                        style="background: #f4e4bc; border: 1px solid #7d510f; padding: 5px;">
                                                        <div
                                                            style="font-weight: bold; font-size: 11px; text-align: center; margin-bottom: 5px;">
                                                            <?php echo __("screens.stats.total_villages") ?>
                                                        </div>
                                                        <canvas id="villagesChart" height="150"></canvas>
                                                    </div>
                                                    <div class="world-chart-box"
                                                        style="background: #f4e4bc; border: 1px solid #7d510f; padding: 5px;">
                                                        <div
                                                            style="font-weight: bold; font-size: 11px; text-align: center; margin-bottom: 5px;">
                                                            Total de pontos</div>
                                                        <canvas id="pointsChart" height="150"></canvas>
                                                    </div>
                                                </div>

                                                <script>
                                                    const chartOptions = {
                                                        responsive: true,
                                                        maintainAspectRatio: false,
                                                        plugins: { legend: { display: false } },
                                                        scales: {
                                                            x: {
                                                                grid: { display: false },
                                                                ticks: { font: { size: 9 }, maxRotation: 0 }
                                                            },
                                                            y: {
                                                                beginAtZero: false,
                                                                grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false },
                                                                ticks: {
                                                                    precision: 0,
                                                                    font: { size: 9 },
                                                                    callback: function (value) {
                                                                        if (value >= 1000000) return (value / 1000000) + 'M';
                                                                        if (value >= 1000) return (value / 1000) + 'k';
                                                                        return value;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    };

                                                    const worldCharts = ['players', 'villages', 'points'];
                                                    worldCharts.forEach(type => {
                                                        const ctx = document.getElementById(type + 'Chart');
                                                        if (!ctx) return;

                                                        const data = <?= json_encode($charts) ?>[type];
                                                        if (!data || !data.labels || data.labels.length === 0) {
                                                            const container = ctx.parentElement;
                                                            container.innerHTML = '<div style="display:flex; align-items:center; justify-content:center; height:100px; color:#999; font-size:10px;"><?= __("screens.profile.waiting_for_data") ?></div>';
                                                            return;
                                                        }

                                                        new Chart(ctx, {
                                                            type: 'line',
                                                            data: {
                                                                labels: data.labels,
                                                                datasets: [{
                                                                    data: data.data,
                                                                    borderColor: '#008000',
                                                                    backgroundColor: 'rgba(0, 128, 0, 0.1)',
                                                                    borderWidth: 2,
                                                                    pointRadius: 3,
                                                                    pointHoverRadius: 5,
                                                                    fill: true,
                                                                    tension: 0.1
                                                                }]
                                                            },
                                                            options: chartOptions
                                                        });
                                                    });
                                                </script>

                                                <table class="stats-table">
                                                    <tr>
                                                        <td class="stats-label">
                                                            <?php echo __("screens.stats.total_players") ?>
                                                        </td>
                                                        <td class="stats-value"><?= number_format($players, 0, ',', '.') ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="stats-label">
                                                            <?php echo __("screens.stats.total_villages") ?>
                                                        </td>
                                                        <td class="stats-value">
                                                            <?= number_format($villages, 0, ',', '.') ?>
                                                            (<?= $players > 0 ? number_format($villages / $players, 2, ',', '.') : 0 ?>
                                                            por jogador)
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="stats-label">
                                                            <?php echo __("screens.stats.player_villages") ?>
                                                        </td>
                                                        <td class="stats-value">
                                                            <?= number_format($player_villages, 0, ',', '.') ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="stats-label">
                                                            <?php echo __("screens.stats.barbarian_villages") ?>
                                                        </td>
                                                        <td class="stats-value">
                                                            <?= number_format($barbarian_villages, 0, ',', '.') ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="stats-label">
                                                            <?php echo __("screens.stats.bonus_villages") ?>
                                                        </td>
                                                        <td class="stats-value">
                                                            <?= number_format($bonus_villages, 0, ',', '.') ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="stats-label">
                                                            <?php echo __("screens.stats.server_status") ?>
                                                        </td>
                                                        <td class="stats-value"><?php echo __("screens.stats.open") ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="stats-label">
                                                            <?php echo __("screens.stats.server_execution_duration") ?>
                                                        </td>
                                                        <td class="stats-value">
                                                            <?php echo __("screens.stats.days_count", ["count" => floor((time() - (isset($worldConfig['start_date']) ? $worldConfig['start_date'] : time())) / 86400)]) ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="stats-label">
                                                            <?php echo __("screens.stats.online_players") ?>
                                                        </td>
                                                        <td class="stats-value"><?= number_format($online, 0, ',', '.') ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="stats-label">
                                                            <?php echo __("screens.stats.messages_sent") ?>
                                                        </td>
                                                        <td class="stats-value">
                                                            <?= number_format($messages_sent, 0, ',', '.') ?>
                                                            (<?= $players > 0 ? number_format($messages_sent / $players, 2, ',', '.') : 0 ?>
                                                            por jogador)
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="stats-label">
                                                            <?php echo __("screens.stats.forum_posts") ?>
                                                        </td>
                                                        <td class="stats-value">
                                                            <?= number_format($forum_posts, 0, ',', '.') ?>
                                                            (<?= $players > 0 ? number_format($forum_posts / $players, 2, ',', '.') : 0 ?>
                                                            por jogador)
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="stats-label">
                                                            <?php echo __("screens.stats.troop_movements") ?>
                                                        </td>
                                                        |
                                                        <td class="stats-value">
                                                            <?= number_format($movements, 0, ',', '.') ?>
                                                            (<?= $players > 0 ? number_format($movements / $players, 2, ',', '.') : 0 ?>
                                                            por jogador)
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="stats-label">
                                                            <?php echo __("screens.stats.number_of_tribes") ?>
                                                        </td>
                                                        <td class="stats-value"><?= number_format($tribes, 0, ',', '.') ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="stats-label">
                                                            <?php echo __("screens.stats.players_in_tribes") ?>
                                                        </td>
                                                        |
                                                        <td class="stats-value">
                                                            <?= number_format($players_in_tribes, 0, ',', '.') ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="stats-label">Total de pontos:</td>
                                                        <td class="stats-value">
                                                            <?= number_format($total_points, 0, ',', '.') ?>
                                                            (<?= $players > 0 ? number_format($total_points / $players, 0, ',', '.') : 0 ?>
                                                            por jogador,
                                                            <?= $villages > 0 ? number_format($total_points / $villages, 0, ',', '.') : 0 ?>
                                                            <?php echo __("screens.stats.per_vill") ?>)
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="stats-label">
                                                            <?php echo __("screens.stats.total_resources") ?>
                                                        </td>
                                                        <td class="stats-value">
                                                            <div class="res-box">
                                                                <img src="graphic/icons/wood.png"
                                                                    title="<?php echo __("overview.wood") ?>" />
                                                                <?= number_format($total_wood, 0, ',', '.') ?>
                                                            </div>
                                                            <div class="res-box">
                                                                <img src="graphic/icons/stone.png"
                                                                    title="<?php echo __("overview.clay") ?>" />
                                                                <?= number_format($total_stone, 0, ',', '.') ?>
                                                            </div>
                                                            <div class="res-box">
                                                                <img src="graphic/icons/iron.png"
                                                                    title="<?php echo __("overview.iron") ?>" />
                                                                <?= number_format($total_iron, 0, ',', '.') ?>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Total de Tropas -->
                                                    <?php if (!empty($units)): ?>
                                                        <tr>
                                                            <td class="stats-label">
                                                                <?php echo __("screens.stats.total_troops") ?>
                                                            </td>
                                                            <td class="stats-value">
                                                                <div class="unit-grid">
                                                                    <?php foreach ($units as $unitName => $count): ?>
                                                                        <div class="unit-cell">
                                                                            <img src="graphic/unit/<?= $unitName ?>.png"
                                                                                title="<?= $unitName ?>" />
                                                                            <span><?= number_format($count, 0, ',', '.') ?></span>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <!-- Média por Jogador -->
                                                        <tr>
                                                            <td class="stats-label">
                                                                <?php echo __("screens.stats.average_per_player") ?>
                                                            </td>
                                                            <td class="stats-value">
                                                                <div class="unit-grid">
                                                                    <?php foreach ($units as $unitName => $count): ?>
                                                                        <div class="unit-cell">
                                                                            <img src="graphic/unit/<?= $unitName ?>.png"
                                                                                title="<?= $unitName ?>" />
                                                                            <span><?= $players > 0 ? number_format($count / $players, 0, ',', '.') : 0 ?></span>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <!-- Média por Aldeia -->
                                                        <tr>
                                                            <td class="stats-label">
                                                                <?php echo __("screens.stats.average_per_village") ?>
                                                            </td>
                                                            <td class="stats-value">
                                                                <div class="unit-grid">
                                                                    <?php foreach ($units as $unitName => $count): ?>
                                                                        <div class="unit-cell">
                                                                            <img src="graphic/unit/<?= $unitName ?>.png"
                                                                                title="<?= $unitName ?>" />
                                                                            <span><?= $villages > 0 ? number_format($count / $villages, 0, ',', '.') : 0 ?></span>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>

                                                    <tr>
                                                        <td class="stats-label">
                                                            <?php echo __("screens.stats.latest_player") ?>
                                                        </td>
                                                        <td class="stats-value"><?= htmlspecialchars($latest_player) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="stats-label">
                                                            <?php echo __("screens.stats.latest_tribe") ?>
                                                        </td>
                                                        <td class="stats-value"><?= htmlspecialchars($latest_tribe) ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2"
                                                            style="text-align: right; font-size: 10px; color: #603000; padding-top: 10px;">
                                                            <?php echo __("screens.stats.aggregated_data_last_update", ["time" => date('H:i')]) ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="stats-box-bottom"></div>
                                        </div>

                                    <?php elseif ($mode === 'config'): ?>
                                        <!-- Configuration Box -->
                                        <div class="stats-box">
                                            <div class="stats-box-top">
                                                <div class="stats-box-title">
                                                    <?php echo __("screens.stats.world_config_title", ["world" => $world]) ?>
                                                </div>
                                            </div>
                                            <div class="stats-box-body">
                                                <table class="stats-table">
                                                    <?php if (!empty($worldConfig)): ?>
                                                        <tr>
                                                            <td class="stats-label"><?php echo __("screens.stats.game_speed") ?>
                                                            </td>
                                                            <td class="stats-value"><?= $worldConfig['speed'] ?? 1 ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="stats-label"><?php echo __("screens.stats.unit_speed") ?>
                                                            </td>
                                                            <td class="stats-value"><?= $worldConfig['unit_speed'] ?? 1 ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="stats-label"><?php echo __("screens.stats.moral") ?></td>
                                                            <td class="stats-value">
                                                                <?= ($worldConfig['moral_activ'] ?? false) ? __("screens.stats.active") : __("screens.stats.inactive") ?>
                                                            </td>
                                                        </tr>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="2"><?php echo __("screens.stats.config_load_error") ?>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </table>
                                            </div>
                                            <div class="stats-box-bottom"></div>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <!-- RIGHT COLUMN: WORLD SELECTION -->
                                <td valign="top" width="180" style="padding-left: 10px;">
                                    <div class="hof-sidebar-box">
                                        <div class="hof-sidebar-top">
                                            <div class="hof-sidebar-title"><?php echo __("screens.stats.select_view") ?>
                                            </div>
                                        </div>
                                        <div class="hof-sidebar-body">
                                            <ul class="hof-world-list">
                                                <li class="<?= $mode === 'stats' ? 'selected' : '' ?>">
                                                    <a
                                                        href="stats.php?world=<?= $world ?>&mode=stats"><?php echo __("screens.stats.world_statistics") ?></a>
                                                </li>
                                                <li class="<?= $mode === 'config' ? 'selected' : '' ?>">
                                                    <a
                                                        href="stats.php?world=<?= $world ?>&mode=config"><?php echo __("screens.stats.world_config_title", ["world" => ""]) ?></a>
                                                </li>
                                                <li>
                                                    <a
                                                        href="index.php"><?php echo __("screens.stats.guest_access") ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="hof-sidebar-bottom"></div>
                                    </div>

                                    <div class="hof-sidebar-box" style="margin-top: 15px;">
                                        <div class="hof-sidebar-top">
                                            <div class="hof-sidebar-title">
                                                <?php echo __("screens.stats.select_world") ?>
                                            </div>
                                        </div>
                                        <div class="hof-sidebar-body">
                                            <ul class="hof-world-list">
                                                <li class="selected">
                                                    <a
                                                        href="stats.php?world=1&mode=<?= $mode ?>"><?php echo __("screens.stats.world_x", ["world" => 1]) ?></a>
                                                    |
                                                    <img src="graphic/icons/lock.png"
                                                        style="float: right; opacity: 0.5;" alt="">
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="hof-sidebar-bottom"></div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="container-bottom-full"></div>
                </div>
            </div><!-- content -->

            <div class="closure">
                Traduzido e revisado by ice41 | Motor Tribos PL-Lan Versão 8.4 &copy;
                <br>
                &copy; 2009 - <?php echo date("Y") ?>
                <a target="_blank" href="https://www.ice41.pt">ice41</a> &middot;
            </div>
        </div>
    </div>

</body>

</html>
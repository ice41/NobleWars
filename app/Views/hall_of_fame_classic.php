<?php
// Dynamic data passed from HallOfFameScreen controller
$world = $world ?? '1';
$worlds_list = $worlds_list ?? [];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Noblewars - Regras do Jogo</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="stylesheet" type="text/css" href="css/hall_of_fame.css" />
    <link rel="stylesheet" type="text/css" href="css/hof_fixes.css" />
    <link rel="shortcut icon" href="graphic/icons/nwfavicon.ico" />
</head>

<body class="no-paladin" id="hof">
    <div id="index_body">
        <div id="main">
            <br>

            <div id="header">
                <h1>
                    <a href="index.php"  style="background:url(graphic/index/bg-noble2.jpg) no-repeat 100% 0;">
                        <p  style="position: absolute; top: -200px;">Noblewars</p>
                    </a>
                </h1>

                <div class="navigation">
                    <div class="navigation-holder">
                        <div class="navigation-wrapper">
                            <div id="navigation_span">
                                <a href="index.php"><?= __('screens.hall_of_fame.home') ?></a> -
                                <a href="rules.php"><?= __('screens.hall_of_fame.rules') ?></a> -
                                <a href="team.php"><?= __('screens.hall_of_fame.team') ?></a> -
                                <a href="hall_of_fame.php">Hall da Fama</a> -
                                <a href="help.php">Ajuda</a>

                                <!-- Language Selector -->
                                <span  class="float-right" style="margin-right: 10px;">
                                    <?php include __DIR__ . '/components/language_selector.php'; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- inicio do conteudo-->

            <div id="content" align="center">
                <div class="content box-border red">
                    <div class="top-left"></div>
                    <div class="top-right"></div>
                    <div class="middle-top"></div>
                    <div class="middle-bottom"></div>
                    <div class="middle"></div>
                    <div class="middle-left"></div>
                    <div class="middle-right"></div>
                    <div class="bottom-left"></div>
                    <div class="bottom-right"></div>

                    <div class="inner">
                        <div class="paladin"></div>
                        <div class="full-content">
                            <h2><?= __('screens.hall_of_fame.title', ['world' => htmlspecialchars($world)]) ?></h2>
                            <p><?= __('screens.hall_of_fame.select_world') ?>:</p>
                            <!-- World Selection Sidebar - Right -->
                            <aside class="pull-right">
                                <div class="content-selector">
                                    <h3>Selecionar mundo</h3>
                                    <ul>
                                        <?php foreach ($worlds_list as $w): ?>
                                            <li class="<?= $world == $w['id'] ? 'active' : 'inactive' ?> <?= !empty($w['is_closed']) ? 'closed-world' : '' ?>">
                                                <a href="hall_of_fame.php?world=<?= $w['id'] ?>">
                                                    <?= $w['name'] ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </aside>

                            <!-- Top Players -->
                            <div class="bordered-box hof-sidebar">
                                <h3><?= __('screens.hall_of_fame.top_players') ?></h3>
                                <div class="bordered-box-content">
                                    <div class="placements">
                                        <?php if (!empty($top_players)): ?>
                                            <?php foreach ($top_players as $index => $player): ?>
                                                <div class="placement place<?= $index + 1 ?>">
                                                    <a href="guest.php?world=<?= htmlspecialchars($world) ?>&screen=info_player&id=<?= $player['id'] ?>"><?= htmlspecialchars($player['username']) ?></a>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p><?= __('screens.hall_of_fame.no_data') ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Top Tribes -->
                            <div class="bordered-box hof-sidebar">
                                <h3><?= __('screens.hall_of_fame.top_tribes') ?></h3>
                                <div class="bordered-box-content">
                                    <div class="placements">
                                        <?php if (!empty($top_tribes)): ?>
                                            <?php foreach ($top_tribes as $index => $tribe): ?>
                                                <div class="placement place<?= $index + 1 ?>">
                                                    <a href="guest.php?world=<?= htmlspecialchars($world) ?>&screen=info_ally&id=<?= $tribe['id'] ?>"><?= htmlspecialchars($tribe['tag']) ?></a>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p><?= __('screens.hall_of_fame.no_data') ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($top_tribes[0])): ?>
                                        <h4 align='left'><?= __('screens.hall_of_fame.members') ?>:</h4>
                                        <div class="hof-tribe-members-list mt-10 text-center"
                                             style="color: #3e2723; font-size: 11px; padding: 0 20px;">
                                            <?= !empty($top_tribes[0]['members']) ? htmlspecialchars($top_tribes[0]['members']) : '-' ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php foreach ($achievements as $category => $catData): ?>
                                <div class="bordered-box hof-sidebar">
                                    <h3>
                                        <?= htmlspecialchars($catData['title']) ?>
                                    </h3>
                                    <div class="bordered-box-content">
                                        <?php foreach ($catData['items'] as $ach): ?>
                                            <div class="milestone-group">
                                                <div class="award level4">
                                                    <img src="<?= $ach['image'] ?>" alt="" class="content-box-image">
                                                </div>
                                                <p> <?= htmlspecialchars($ach['label']) ?><br> 
                                                    <strong><?= htmlspecialchars($ach['winner']) ?></strong>
                                                </p>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <!-- <div class="bordered-box hof-fullwidth"> -->
                            <div class="bordered-box hof-sidebar">
                                <h3>Metas diárias</h3>
                                <div class="bordered-box-content">
                                    <?php if (!empty($daily_awards)): ?>
                                        <?php foreach ($daily_awards as $ach): ?>
                                            <div class="milestone-group">
                                                <div class="award level4">
                                                    <img src="<?= $ach['image'] ?>" alt="" class="content-box-image">
                                                </div>
                                                <p> <?= htmlspecialchars($ach['name']) ?><br> 
                                                    <strong><?= htmlspecialchars($ach['winner']) ?></strong>
                                                </p>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                        <div class="award-group-foot">&nbsp;</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="closure">
        &copy; <?= date('Y') ?> by ice41 - NobleWars
    </div>
    </div>
    </div>

    <script>
        function toggleRule(id) {
            const content = document.getElementById('rule-content-' + id);
            const header = content.previousElementSibling;

            if (content.classList.contains('collapsed')) {
                content.classList.remove('collapsed');
                header.classList.remove('collapsed');
            } else {
                content.classList.add('collapsed');
                header.classList.add('collapsed');
            }
        }

        // Collapse all sections by default except the first one
        document.addEventListener('DOMContentLoaded', function () {
            const contents = document.querySelectorAll('.rule-content');
            contents.forEach(function (content, index) {
                if (index > 0) { // Keep first section open
                    content.classList.add('collapsed');
                    content.previousElementSibling.classList.add('collapsed');
                }
            });
        });
    </script>
</body>

</html>
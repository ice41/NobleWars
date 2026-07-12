<?php
// Default vars to avoid warnings
$world = $world ?? '1';
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title><?= htmlspecialchars(str_replace('{world}', $world, __('statistics.title', 'Estatísticas - Mundo {world}'))) ?></title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="/css/game_new.css">
</head>

<body id="ds_body" class="scrollableMenu">

    <div class="top_bar">
        <div class="bg_left"> </div>
        <div class="bg_right"> </div>
    </div>
    <div class="top_shadow"> </div>
    <div class="top_background"> </div>

    <table id="main_layout" cellspacing="0" align="center">
        <tr  style="height: 48px;">
            <td class="topbar left"></td>
            <td class="topbar center">
                <div id="topContainer">
                    <!-- Header Content placeholder -->
                    <center>
                        <h2  class="mt-10" style="color:#fff;"><?= htmlspecialchars(str_replace('{world}', $world, __('statistics.header', 'Estatísticas - Mundo {world}'))) ?></h2>
                    </center>
                </div>
            </td>
            <td class="topbar right"></td>
        </tr>
        <tr class="shadedBG">
            <td class="bg_left" id="SkyScraperAdCellLeft">
                <div id="SkyScraperAdLeft"></div>
                <div class="bg_left"> </div>
            </td>

            <!-- MAIN CONTENT CELL -->
            <td class="maincell p-10" id="content_value"  style="width: 850px; background: none;">
                <link rel="stylesheet" href="/css/mail_modern.css">

                <table class="vis" width="100%">
                    <tr>
                        <th colspan="2"><?= __('statistics.menu', 'Menu') ?></th>
                    </tr>
                    <tr>
                        <td width="200" valign="top">
                            <table class="vis" width="100%">
                                <tr>
                                    <td <?php if ($type == 'player')
                                        echo 'class="selected"'; ?>><a
                                             href="stats.php?mode=player"><?= __('statistics.players', 'Jogadores') ?></a></td>
                                </tr>
                                <tr>
                                    <td <?php if ($type == 'ally')
                                        echo 'class="selected"'; ?>><a
                                             href="stats.php?mode=ally"><?= __('statistics.tribes', 'Tribos') ?></a></td>
                                </tr>
                                <tr>
                                    <td <?php if ($type == 'village')
                                        echo 'class="selected"'; ?>><a
                                             href="stats.php?mode=village"><?= __('statistics.villages', 'Aldeias') ?></a></td>
                                </tr>
                            </table>
                        </td>
                        <td valign="top">
                            <?php if ($type === 'player'): ?>
                                <h3><?= __('statistics.player_stats', 'Estatísticas do Jogador') ?></h3>
                                <table class="vis" width="100%">
                                    <tr>
                                        <td><?= __('statistics.attacks_performed', 'Ataques Realizados:') ?></td>
                                        <td><?= number_format($stats['total_attacks'] ?? 0) ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __('statistics.defenses_performed', 'Defesas Realizadas:') ?></td>
                                        <td><?= number_format($stats['total_defenses'] ?? 0) ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __('statistics.villages_conquered', 'Aldeias Conquistadas:') ?></td>
                                        <td><?= number_format($stats['villages_conquered'] ?? 0) ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __('statistics.villages_lost', 'Aldeias Perdidas:') ?></td>
                                        <td><?= number_format($stats['villages_lost'] ?? 0) ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __('statistics.resources_sent', 'Recursos Enviados:') ?></td>
                                        <td><?= number_format($stats['resources_sent'] ?? 0) ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __('statistics.resources_received', 'Recursos Recebidos:') ?></td>
                                        <td><?= number_format($stats['resources_received'] ?? 0) ?></td>
                                    </tr>
                                </table>

                            <?php elseif ($type === 'ally'): ?>
                                <h3><?= __('statistics.tribe_stats', 'Estatísticas da Tribo') ?></h3>
                                <table class="vis" width="100%">
                                    <tr>
                                        <td><?= __('statistics.name', 'Nome:') ?></td>
                                        <td><?= htmlspecialchars($ally_data['name'] ?? 'N/A') ?>
                                            (<?= htmlspecialchars($ally_data['tag'] ?? '') ?>)</td>
                                    </tr>
                                    <tr>
                                        <td><?= __('statistics.members', 'Membros:') ?></td>
                                        <td><?= number_format($stats['total_members'] ?? 0) ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __('statistics.total_villages', 'Aldeias Totais:') ?></td>
                                        <td><?= number_format($stats['total_villages'] ?? 0) ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __('statistics.total_points', 'Pontos Totais:') ?></td>
                                        <td><?= number_format($stats['total_points'] ?? 0) ?></td>
                                    </tr>
                                </table>

                            <?php elseif ($type === 'village'): ?>
                                <h3><?= __('statistics.village_stats', 'Estatísticas da Aldeia') ?></h3>
                                <table class="vis" width="100%">
                                    <tr>
                                        <td><?= __('statistics.name', 'Nome:') ?></td>
                                        <td><?= htmlspecialchars($village_data['name'] ?? 'N/A') ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __('statistics.points', 'Pontos:') ?></td>
                                        <td><?= number_format($stats['total_points'] ?? 0) ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __('statistics.total_buildings', 'Total de Edifícios:') ?></td>
                                        <td><?= number_format($stats['buildings_count'] ?? 0) ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __('statistics.military_population', 'População Militar:') ?></td>
                                        <td><?= number_format($stats['units_count'] ?? 0) ?></td>
                                    </tr>
                                </table>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>

            </td>

            <!-- SKY SCRAPER AD CELL -->
            <td class="bg_right" id="SkyScraperAdCell">
                <div class="bg_right"> </div>
                <div id="SkyScraperAd"  style="height: 840px;"></div>
            </td>
        </tr>
        <tr class="newStyleOnly">
            <td class="bg_bottomleft">&nbsp;</td>
            <td class="bg_bottomcenter">&nbsp;</td>
            <td class="bg_bottomright">&nbsp;</td>
        </tr>
    </table>

</body>

</html>
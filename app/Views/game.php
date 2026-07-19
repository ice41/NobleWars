<?php
// Helper para formatar números
if (!function_exists('format_number')) {
    function format_number($number)
    {
        return number_format($number, 0, ',', '.');
    }
}

// Valores padrão para evitar erros
$village = $village ?? [];
$user = $user ?? [];
$screen = $screen ?? 'welcome';
$mode = $mode ?? null;
$serverid = $server ?? 1;
$hkey = $hkey ?? 'hkey_dummy';
$premium = $premium ?? false;
$conta = $conta ?? 0;
$load_msec = $load_msec ?? 0;
$servertime = $servertime ?? date('H:i:s');
$wood_per_hour = $wood_per_hour ?? 0;
$stone_per_hour = $stone_per_hour ?? 0;
$iron_per_hour = $iron_per_hour ?? 0;
$max_storage = $max_storage ?? 0;
$max_bh = $max_bh ?? 0;
$pop_current = $village['r_bh'] ?? 0;
$wood_s = $wood_s ?? 0;
$stone_s = $stone_s ?? 0;
$iron_s = $iron_s ?? 0;

?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title><?= $village['name'] ?? __('common.game_village') ?> (<?= $village['x'] ?? 0 ?>|<?= $village['y'] ?? 0 ?>) -
        <?= __('common.game_name') ?> - <?= __('common.game_world') ?>
        <?= $serverid ?>
    </title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <link id="favicon" rel="shortcut icon" href="graphic/icons/nwfavicon.ico" />
    <?php if (!in_array($ingame_theme ?? 'classic', ['classic', 'new'])): ?>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Inter:wght@300;400;600;700&family=MedievalSharp&family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <?php endif; ?>
    <?php if (isset($user['css'])): ?>
        <link rel="stylesheet" type="text/css" href="<?= $user['css'] ?>" />
    <?php endif; ?>
    <?php
    $assetVersion = function ($path) {
        $absPath = __DIR__ . '/../../public/' . $path;
        $v = file_exists($absPath) ? filemtime($absPath) : '1';
        return $path . '?v=' . $v;
    };
    ?>
    <link rel="stylesheet" type="text/css" href="<?= $assetVersion('css/game_new.css') ?>" />
    <?php
    $themeCode = $ingame_theme ?? 'classic';
    if ($themeCode !== 'classic' && $themeCode !== 'new') {
        $themeStylePath = "css/game_{$themeCode}.css";
        if (file_exists(__DIR__ . '/../../public/' . $themeStylePath)) {
            ?>
            <link rel="stylesheet" type="text/css" href="<?= $assetVersion($themeStylePath) ?>" />
            <?php
        }
    }
    ?>

    <?php if ($screen != 'map_s'): ?>
        <script src="<?= $assetVersion('js/game_combined.js') ?>" type="text/javascript"></script>
        <script src="<?= $assetVersion('js/jquery-ui.js') ?>" type="text/javascript"></script>
        <script src="<?= $assetVersion('js/core_combined.js') ?>" type="text/javascript"></script>
    <?php endif; ?>

    <?php if ($screen == 'map'): ?>
        <link rel="stylesheet" type="text/css" href="css/map.css" />
        <script type="text/javascript" src="<?= $assetVersion('js/map_classic_combined.js') ?>"></script>
    <?php endif; ?>

    <script type="text/javascript">
        // Kill-switch for Google Analytics (private server - GA not needed here).
        // game.js and game_old.js contain legacy code that tries to inject a <script src="http://www.google-analytics.com/ga.js">
        // which is blocked by the Content Security Policy and pollutes the console.
        // We intercept document.createElement to silently swallow that injection before it happens.
        (function () {
            // 1. Stub out _gaq so push() calls in game.js don't throw ReferenceErrors.
            var _noop = { push: function () {} };
            try { Object.defineProperty(window, '_gaq', { value: _noop, writable: true }); }
            catch (e) { window._gaq = _noop; }

            // 2. Wrap document.createElement to intercept the GA <script> element.
            var _origCreate = document.createElement.bind(document);
            document.createElement = function (tag) {
                var el = _origCreate(tag);
                if (typeof tag === 'string' && tag.toLowerCase() === 'script') {
                    // Shadow the src setter so GA url is swallowed silently.
                    var _src = '';
                    Object.defineProperty(el, 'src', {
                        get: function () { return _src; },
                        set: function (val) {
                            if (typeof val === 'string' && val.indexOf('google-analytics.com/ga.js') !== -1) {
                                return; // Swallow — never set src, never appended to DOM
                            }
                            _src = val;
                            el.setAttribute('src', val);
                        },
                        configurable: true
                    });
                }
                return el;
            };
        })();
    </script>
    <?php if ($screen == 'map_s'): ?>
        <script type="text/javascript" src="<?= $assetVersion('js/game_combined.js') ?>"></script>
        <script type="text/javascript" src="<?= $assetVersion('js/jquery-ui.js') ?>"></script>
        <script type="text/javascript" src="<?= $assetVersion('js/core_combined.js') ?>"></script>
    <?php endif; ?>

    <?php if ($screen == 'overview'): ?>
        <link rel="stylesheet" type="text/css" href="<?= $assetVersion('css/overniew.css') ?>" />
    <?php endif; ?>

    <script type="text/javascript">
        //<![CDATA[
        var sds = false;
        var image_base = "graphic/";
        var mobile = false;
        var mobile_on_normal = false;
        var premium = <?= $premium ? 'true' : 'false' ?>;

        // CSRF token for all AJAX POST requests
        var csrf_token = <?= json_encode($_SESSION['csrf_token'] ?? '') ?>;

        var game_data = {
            "player": {
                "id": "<?= $user['id'] ?? 0 ?>",
                "name": "<?= $user['username'] ?? 'Guest' ?>",
                "ally_id": "<?= $user['ally'] ?? 0 ?>",
                "villages": "<?= $user['villages'] ?? 0 ?>",
                "points": "<?= $user['points'] ?? 0 ?>",
                "rank": "<?= $user['rang'] ?? 0 ?>",
                "incomings": "<?= $user['attacks'] ?? 0 ?>",
                "sitter_id": "0",
                "quest_progress": "0",
                "premium": <?= $premium ? 'true' : 'false' ?>,
                "admin": <?= ($user['admin'] ?? 0) == 0 ? 'true' : 'false' ?>,
                "account_manager": true,
                "farm_manager": true
            },
            "nav": { "parent": 2 },
            "village": {
                "id": <?= $village['id'] ?? 0 ?>,
                "name": "<?= $village['name'] ?? 'Village' ?>",
                "coord": "<?= $village['x'] ?? 0 ?>|<?= $village['y'] ?? 0 ?>",
                "con": "K<?= $village['continent'] ?? 0 ?>",
                "bonus": <?= $village['bonus'] ?? 0 ?>,
                "group": "<?= $village['group'] ?? 'all' ?>",
                "res": [<?= $village['r_wood'] ?? 0 ?>, <?= $wood_s ?>, <?= $village['r_stone'] ?? 0 ?>, <?= $stone_s ?>, <?= $village['r_iron'] ?? 0 ?>, <?= $iron_s ?>, "<?= $max_storage ?>", "<?= $pop_current ?>", "<?= $max_bh ?>"],
                "buildings": {
                    "main": "<?= $village['main'] ?? 0 ?>",
                    "farm": "<?= $village['farm'] ?? 0 ?>",
                    "storage": "<?= $village['storage'] ?? 0 ?>",
                    "place": "<?= $village['place'] ?? 0 ?>",
                    "barracks": "<?= $village['barracks'] ?? 0 ?>",
                    "church": "<?= $village['church'] ?? 0 ?>",
                    "smith": "<?= $village['smitch'] ?? 0 ?>", // smitch typo in original?
                    "wood": "<?= $village['wood'] ?? 0 ?>",
                    "stone": "<?= $village['stone'] ?? 0 ?>",
                    "iron": "<?= $village['iron'] ?? 0 ?>",
                    "market": "<?= $village['market'] ?? 0 ?>",
                    "stable": "<?= $village['stable'] ?? 0 ?>",
                    "wall": "<?= $village['wall'] ?? 0 ?>",
                    "garage": "<?= $village['garage'] ?? 0 ?>",
                    "hide": "<?= $village['hide'] ?? 0 ?>",
                    "snob": "<?= $village['snob'] ?? 0 ?>",
                    "statue": "<?= $village['statue'] ?? 0 ?>"
                },
                "link_base": "game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=",
                "link_base_pure": "game.php?village=<?= $village['id'] ?? 0 ?>&screen=",
                "csrf": "<?= $hkey ?>",
                "world": "mundo<?= $serverid ?>",
                "market": "mundo",
                "RTL": false,
                "version": "18588 8.1",
                "majorVersion": "8.1",
                "screen": "<?= $screen ?>",
                "mode": <?= !empty($mode) ? "'$mode'" : 'null' ?>,
                "device": "desktop"
            }
        };

        UI.AutoComplete.url = 'game.php?village=<?= $village['id'] ?? 0 ?>&ajaxaction=autocomplete&h=2223&screen=api';
        ScriptAPI.url = 'game.php?village=<?= $village['id'] ?? 0 ?>&ajax=save_script&screen=api';
        ScriptAPI.version = parseFloat(game_data.majorVersion);

        var userCSS = false;
        var isIE7 = false;
        var topmenuIsAlwaysVisible = false;

        $(function () { if (document.location.hash == "#questcomplete") UI.SuccessMessage("<?= __('common.game_quest_complete') ?>", 3000); });
        $(function () { if (document.location.hash == "#conta") UI.SuccessMessage("<?= sprintf(__('common.game_players_on_world'), $serverid, $conta) ?>", 5000); });
        $(function () { if (document.location.hash == "#admin") { <?php if (($user['admin'] ?? 0) == 0): ?>UI.SuccessMessage("<?= __('common.game_admin_panel_enter') ?>", 10000); <?php else: ?> UI.ErrorMessage("<?= __('common.game_no_admin_rank') ?>", 10000); <?php endif; ?> } });

        VillageContext._urls.overview = 'game.php?village=__village__&screen=overview';
        VillageContext._urls.info = 'game.php?village=<?= $village['id'] ?? 0 ?>&id=__village__&screen=info_village';
        VillageContext._urls.fav = 'game.php?village=<?= $village['id'] ?? 0 ?>&id=__village__&ajaxaction=add_target&h=f7ef&json=1&screen=info_village';
        VillageContext._urls.unfav = 'game.php?village=<?= $village['id'] ?? 0 ?>&id=__village__&ajaxaction=del_target&h=f7ef&json=1&screen=info_village';
        VillageContext._urls.claim = 'game.php?village=<?= $village['id'] ?? 0 ?>&id=__village__&ajaxaction=toggle_reserve_village&h=f7ef&json=1&screen=info_village';
        VillageContext._urls.market = 'game.php?village=<?= $village['id'] ?? 0 ?>&mode=send&target=__village__&screen=market&mode=other_offer';
        VillageContext._urls.place = 'game.php?village=<?= $village['id'] ?? 0 ?>&target=__village__&screen=place';
        VillageContext._urls.recruit = 'game.php?village=__village__&screen=train';
        VillageContext._urls.map = 'game.php?village=<?= $village['id'] ?? 0 ?>&id=__village__&screen=map';
        VillageContext._urls.unclaim = VillageContext._urls.claim;

        $(document).ready(function () {
            UI.ToolTip($('.group_tooltip'), { delay: 1000 });
            VillageContext.init();
        });
        //]]>
    </script>



    <style type="text/css">
        /* force posts in the forum to obey to maximum width set in the settings */
        #forum_box .text {
            width: 950px;
            word-wrap: break-word;
        }
        .arrowLeft:hover, .arrowRight:hover {
            background-position: left top !important;
        }
    </style>
</head>


<body id="ds_body" class="scrollableMenu theme-<?= htmlspecialchars($ingame_theme ?? 'classic') ?>">

    <div class="top_bar">
        <div class="bg_left"> </div>
        <div class="bg_right"></div>
    </div>
    <div class="top_shadow"> </div>
    <div class="top_background"> </div>
    <div style="position:fixed; top: 60px; left: 10px; z-index: 1000;">
        <div class="questlog" id="questlog_new">
            <div class="quest" id="new_quest" onclick="Questlines.showDialog(0, 'main-tab')"></div>
        </div>
    </div>
    <table id="main_layout" cellspacing="0" align="center">
        <tr style="height: 48px;">
            <td class="topbar left"></td>
            <td class="topbar center">
                <div id="topContainer">
                    <table id="topTable" style="text-align: center;" cellspacing="0">
                        <tr>
                            <td style="text-align: center;">
                                <table class="menu nowrap" style="white-space: nowrap; ">
                                    <tr id="menu_row">
                                        <!-- <td class="menu-item">
                                            <a
                                                href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=overview_villages">
                                                Geral
                                            </a>
                                            <table class="menu_column" cellspacing="0">
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=overview_villages&mode=combined">
                                                            Combinado
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=mail&screen=overview_villages&mode=prod">
                                                            Produção
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=mail&amp;screen=overview_villages&mode=trader">
                                                            Transportes
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=mail&amp;screen=overview_villages&mode=units">
                                                            Unidades
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=mail&amp;screen=overview_villages&mode=commands">
                                                            Comandos
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=mail&amp;screen=overview_villages&mode=buildings">
                                                            Edifícios
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bottom">
                                                        <div class="corner"></div>
                                                        <div class="decoration"></div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td> -->
                                        <td class="menu-item <?= $screen == 'overview' ? 'selected-modern' : '' ?>">
                                            <a href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=overview">
                                                <img src="graphic/icons/overview.webp" style="vertical-align: middle;">
                                                <?= __('screens.menu.overview') ?>
                                            </a>
                                        </td>
                                        <td class="menu-item <?= $screen == 'map' ? 'selected-modern' : '' ?>">
                                            <a href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=map">
                                                <img src="graphic/icons/map2.webp" style="vertical-align: middle;">
                                                <?= __('screens.menu.map') ?>
                                            </a>
                                        </td>
                                        <td class="menu-item <?= $screen == 'report' ? 'selected-modern' : '' ?>">
                                            <a href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=report">
                                                <?php if (($user['new_report'] ?? 0) == 1): ?>
                                                    <img src="graphic/icons/report.png" class="icon header new_report" style="vertical-align: middle;width: 16px; height: 16px;" title="<?= __('common.game_new_report') ?>">
                                                <?php else: ?>
                                                    <img src="graphic/icons/no_report.png" style="vertical-align: middle;width: 16px; height: 16px;">
                                                <?php endif; ?>
                                                <?= __('screens.menu.reports') ?>
                                            </a>
                                            <table class="menu_column" cellspacing="0">
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=report">
                                                            <?= __('screens.menu.all_reports') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=report&amp;mode=attack">
                                                            <?= __('screens.menu.attacks') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=report&amp;mode=defense">
                                                            <?= __('screens.menu.defense') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=report&amp;mode=support">
                                                            <?= __('screens.menu.support') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=report&amp;mode=trade">
                                                            <?= __('screens.menu.trade') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=report&amp;mode=other">
                                                            <?= __('screens.menu.other') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bottom">
                                                        <div class="corner"></div>
                                                        <div class="decoration"></div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="menu-item <?= $screen == 'mail' ? 'selected-modern' : '' ?>">
                                           <a href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=mail">
                                                <?php if (($user['new_mail'] ?? 0) == 1): ?>
                                                    <img src="graphic/icons/mail.png" class="icon header new_mail" style="vertical-align: middle;" title="<?= __('common.menu.new_message') ?>">
                                                <?php else: ?>
                                                    <img src="graphic/icons/no_mail.png" style="vertical-align: middle;">
                                                <?php endif; ?>
                                                <?= __('common.menu.messages') ?>
                                            </a>
                                            <table class="menu_column" cellspacing="0">
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=mail">
                                                            <?= __('common.menu.messages') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=mail&amp;mode=in_ally">
                                                            <?= __('common.menu.collective_messages') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=mail&amp;mode=new">
                                                            <?= __('common.menu.write_message') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bottom">
                                                        <div class="corner"></div>
                                                        <div class="decoration"></div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>

                                        <?php if (($config['premium_enabled'] ?? true)): ?>
                                            <td>
                                                <a id="manager_icon_farm" class="manager_icon tooltip-delayed"
                                                    style="background-image:url('graphic/new/farm_assistent.webp')"
                                                    href="game.php?village=<?= $village['id'] ?? 0 ?>&screen=am_farm"
                                                    data-title="<?= __('common.menu.farm_assistant') ?>">&nbsp;</a>
                                                <a class="manager_icon tooltip-delayed"
                                                    style="background-image:url('graphic/new/account_manager.webp')"
                                                    href="game.php?village=<?= $village['id'] ?? 0 ?>&screen=accountmanager&mode=overview"
                                                    data-title="<?= __('common.menu.account_manager') ?>">&nbsp;</a>
                                            </td>
                                        <?php endif; ?>

                                        <td class="menu-item lpad"> </td>
                                        <td class="menu-item" id="topdisplay">
                                            <div class="bg">
                                                <a
                                                    href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=ranking">
                                                    <?= __('common.menu.ranking') ?>
                                                </a>
                                                <div class="rank">
                                                    (<?= $user['rang'] ?? 0 ?>.|<?= format_number($user['points'] ?? 0) ?>
                                                    <?= __('common.menu.points') ?>)
                                                </div>
                                            </div>
                                        </td>
                                        <td class="menu-item rpad"> </td>
                                        <td class="menu-item <?= $screen == 'ally' ? 'selected-modern' : '' ?>">
                                            <a href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=ally">
                                                <?php if (($user['ally'] ?? -1) != '-1'): ?>
                                                    <span class="icon header <?php if (($user['new_post'] ?? 0) == 0)
                                                        echo 'no_'; ?>new_post"
                                                        title="<?= __('common.menu.new_post') ?>"></span>
                                                <?php endif; ?>
                                                <?= __('common.menu.tribe') ?>
                                            </a>
                                            <table class="menu_column" cellspacing="0">
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=ally&mode=overview">
                                                            <?= __('common.menu.overview') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=ally&mode=properties">
                                                            <?= __('common.menu.properties') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=ally&mode=members">
                                                            <?= __('common.menu.members') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=ally&mode=contracts">
                                                            <?= __('common.menu.diplomacy') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=ally&mode=forum">
                                                            <?= __('common.menu.forum') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bottom">
                                                        <div class="corner"></div>
                                                        <div class="decoration"></div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>

                                        <!--<td class="menu-item">
                                            <a target=""
                                                href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=support">
                                                <?php if (($user['support_new'] ?? 0) == 1): ?><span
                                                        class="icon header new_mail"
                                                        title="Nova resposta"></span><?php endif; ?> Supporte</a>
                                        </td>
                                        <td class="menu-item">
                                            <a href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=memo">
                                                Notas
                                            </a>
                                        </td>-->

                                        <td class="menu-item <?= $screen == 'profile' ? 'selected-modern' : '' ?>">
                                            <a href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=profile">
                                                <img src="graphic/icons/account.webp" alt="Premium"
                                                    style="vertical-align: middle;" />
                                                <?= __('common.menu.profile') ?>
                                            </a>
                                            <table class="menu_column" cellspacing="0">
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=profile">
                                                            <?= htmlspecialchars($user['username'] ?? 'Perfil') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php if ($config['awards'] ?? true): ?>
                                                    <tr>
                                                        <td class="menu-column-item">
                                                            <a
                                                                href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=profile&mode=awards">
                                                                <?= __('common.menu.medals') ?>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if ($config['inventory_enabled'] ?? true): ?>
                                                    <tr>
                                                        <td class="menu-column-item">
                                                            <a
                                                                href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=profile&mode=inventory">
                                                                <?= __('common.menu.inventory') ?>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=profile&mode=stats">
                                                            <?= __('common.menu.statistics') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=profile&mode=friends">
                                                            <?= __('common.menu.friends') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php if ($config['daily_bonus_enabled'] ?? true): ?>
                                                    <tr>
                                                        <td class="menu-column-item">
                                                            <a
                                                                href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=profile&mode=bonus">
                                                                <?= __('common.menu.daily_bonus') ?>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=profile&mode=mentor">
                                                            <?= __('common.menu.mentor') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=profile&mode=block">
                                                            <?= __('common.menu.block_list') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bottom">
                                                        <div class="corner"></div>
                                                        <div class="decoration"></div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="menu-item">
                                            <?php if (($config['premium_enabled'] ?? true)): ?>
                                                <a href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=premium">
                                                    <img src="graphic/new/premium/coinbag_15x15.png" alt="Premium"
                                                        style="vertical-align: middle;" />
                                                    <?= number_format($premium_points) ?> <img
                                                        src="graphic/new/premium/premium_plus.webp" alt="Premium"
                                                        style="vertical-align: middle;" />
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="menu-item <?= $screen == 'settings' ? 'selected-modern' : '' ?>">
                                            <a href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=settings">
                                                <img src="graphic/icons/settings2.webp"
                                                    style="vertical-align: middle;" /> <?= __('common.menu.settings') ?>
                                            </a>
                                            <table class="menu_column" cellspacing="0">
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=settings">
                                                            <?= __('common.menu.game_options') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=settings&mode=account">
                                                            <?= __('common.menu.account') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=settings&mode=move">
                                                            <?= __('common.game_restart') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=settings&mode=toolbar">
                                                            <?= __('common.game_quickbar') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=settings&mode=vacation">
                                                            <?= __('common.game_vacation') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="menu-column-item">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=settings&mode=command_sharing">
                                                            <?= __('common.game_command_sharing') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bottom">
                                                        <div class="corner"></div>
                                                        <div class="decoration"></div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>

                                        <?php if (($user['admin'] ?? 0) == 1): ?>
                                            <td class="menu-item">
                                                <a target=""
                                                    href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=admin"><img src="graphic/icons/odkrycie.png" style="vertical-align: middle;">
                                                    <font color="red">Admin </font>
                                                </a>
                                            </td>
                                        <?php endif; ?>
                                        <!-- <td class="menu-item">
                                            <a href="#"> novo item</a>
                                        </td> -->
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
            <td class="topbar right"> </td>
        </tr>
        <tr class="shadedBG">
            <td class="bg_left" id="SkyScraperAdCellLeft">
                <div id="SkyScraperAdLeft"></div>
                <div class="bg_left"> </div>
            </td>
            <td class="maincell" style="width: 790px;">
                <div style="position:relative;">
                    <!-- Questlog placeholder -->
                    <br class="newStyleOnly" />
                    <hr class="oldStyleOnly" />



                    <!-- Announcements Section -->
                    <?php
                    // Fetch active announcements from global database
                    try {
                        $globalDb = \App\Core\Database::getInstance(\App\Core\Database::getGlobalDbName());
                        $activeAnnouncements = $globalDb->query("SELECT * FROM announcements WHERE active = 1 ORDER BY created_at DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);

                        if (!empty($activeAnnouncements)):
                            $bbParser = new \App\Helpers\BBCodeParser();
                            foreach ($activeAnnouncements as $announcement):
                                $typeColors = [
                                    'info' => ['bg' => '#e3f2fd', 'border' => '#2196f3', 'icon' => 'info-circle'],
                                    'warning' => ['bg' => '#fff3e0', 'border' => '#ff9800', 'icon' => 'exclamation-triangle'],
                                    'error' => ['bg' => '#ffebee', 'border' => '#f44336', 'icon' => 'times-circle'],
                                    'success' => ['bg' => '#e8f5e9', 'border' => '#4caf50', 'icon' => 'check-circle']
                                ];
                                $style = $typeColors[$announcement['type']] ?? $typeColors['info'];
                                ?>
                                <div id="announcement-<?= $announcement['id'] ?>" class="game-announcement"
                                    style="margin: 10px 0; padding: 12px 15px; background: <?= $style['bg'] ?>; border-left: 4px solid <?= $style['border'] ?>; border-radius: 4px; font-family: Verdana, Arial, sans-serif; position: relative; display: none;">
                                    <button onclick="closeAnnouncement(<?= $announcement['id'] ?>)"
                                        style="position: absolute; top: 8px; right: 8px; background: transparent; border: none; color: #666; font-size: 18px; cursor: pointer; padding: 0; width: 24px; height: 24px; line-height: 24px; text-align: center; border-radius: 3px; transition: all 0.2s;"
                                        onmouseover="this.style.background='rgba(0,0,0,0.1)'"
                                        onmouseout="this.style.background='transparent'"
                                        title="<?= __('common.game_close') ?>">×</button>
                                    <div style="display: flex; align-items: center; padding-right: 30px;">
                                        <i class="fas fa-<?= $style['icon'] ?>"
                                            style="color: <?= $style['border'] ?>; font-size: 20px; margin-right: 12px;"></i>
                                        <div style="flex: 1;">
                                            <strong
                                                style="color: #333; font-size: 13px;"><?= htmlspecialchars($announcement['title']) ?></strong>
                                            <p style="margin: 5px 0 0 0; color: #555; font-size: 12px; line-height: 1.4;">
                                                <?= $bbParser->parse($announcement['message']) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endforeach;
                        endif;
                    } catch (Exception $e) {
                        // Silently fail if announcements table doesn't exist yet
                    }
                    ?>

                    <script>
                        // Announcement management with sessionStorage (resets on logout/browser close)
                        function closeAnnouncement(id) {
                            const element = document.getElementById('announcement-' + id);
                            if (element) {
                                element.style.display = 'none';

                                // Save to sessionStorage (clears on logout/browser close)
                                let closedAnnouncements = JSON.parse(sessionStorage.getItem('closedAnnouncements') || '[]');
                                if (!closedAnnouncements.includes(id)) {
                                    closedAnnouncements.push(id);
                                    sessionStorage.setItem('closedAnnouncements', JSON.stringify(closedAnnouncements));
                                }
                            }
                        }

                        // Show announcements that haven't been closed in this session
                        document.addEventListener('DOMContentLoaded', function () {
                            const closedAnnouncements = JSON.parse(sessionStorage.getItem('closedAnnouncements') || '[]');
                            const announcements = document.querySelectorAll('.game-announcement');

                            announcements.forEach(function (announcement) {
                                const id = parseInt(announcement.id.replace('announcement-', ''));
                                if (!closedAnnouncements.includes(id)) {
                                    announcement.style.display = 'block';
                                }
                            });
                        });
                    </script>
                    <!-- Quickbar -->
                    <?php include __DIR__ . '/components/quickbar.php'; ?>

                    <table id="header_info" align="center" width="100%" cellspacing="0">
                        <colgroup>
                            <col width="1%" />
                            <col width="90%" />
                            <col width="1%" />
                            <col width="1%" />
                            <col width="7%" />
                        </colgroup>
                        <tr>
                            <td class="topAlign">
                                <table class="header-border">
                                    <tr>
                                        <td>
                                            <table class="box menu nowrap">
                                                <tr id="menu_row2">
                                                    <!-- <td id="menu_row2_map" class="box-item firstcell">
                                                        <a id="menu_map_link"
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=map"><span
                                                                class="icon header map"></span>Mapa</a>
                                                    </td> -->
                                                    <td style="white-space:nowrap;" id="menu_row2_village"
                                                        class="box-item icon-box nowrap">
                                                        <a class="nowrap"
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=overview"><span
                                                                class="icon header village"></span><?= $village['name'] ?? 'Village' ?></a>
                                                    </td>
                                                    <td class="box-item"><b
                                                            class="nowrap">(<?= $village['x'] ?? 0 ?>|<?= $village['y'] ?? 0 ?>)
                                                            K<?= $village['continent'] ?? 0 ?></b></td>
                                                    <!-- Village navigation controls -->
                                                    <?php if (($user['villages'] ?? 0) > 1): ?>
                                                        <td class="box-item icon-box nowrap">
                                                            <a class="arrowLeft"
                                                                href="game.php?village=<?= $village['prev_id'] ?? $village['id'] ?>&screen=<?= $screen ?>"
                                                                style="width: 16px; height: 22px; display: inline-block; vertical-align: middle;">
                                                            </a>
                                                        </td>
                                                        <td class="box-item icon-box nowrap">
                                                            <a class="arrowRight"
                                                                href="game.php?village=<?= $village['next_id'] ?? $village['id'] ?>&screen=<?= $screen ?>"
                                                                style="width: 16px; height: 22px; display: inline-block; vertical-align: middle;">
                                                            </a>
                                                        </td>
                                                    <?php endif; ?>
                                                    <td class="box-item icon-box nowrap">
                                                        &nbsp;<img src="graphic/icons/villages.png" alt=""
                                                            onclick="switchDisplay('village_drop_down')"
                                                            style="cursor: pointer;" />&nbsp;
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr class="newStyleOnly">
                                        <td class="shadow">
                                            <div class="leftshadow"></div>
                                            <div class="rightshadow"></div>
                                        </td>
                                    </tr>
                                </table>
                            </td>

                            <td align="right" class="topAlign"> </td>
                            <td align="right" class="topAlign">
                                <table align="right" class="header-border menu_block_right">
                                    <tr>
                                        <td>
                                            <table class="box smallPadding" cellspacing="0" style="empty-cells:show;">
                                                <tr style="height: 20px;">
                                                    <td class="box-item icon-box">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=wood">
                                                            <span class="icon header wood" title="<?= __('screens.common.wood') ?>"></span> </a>
                                                    </td>
                                                    <td class="box-item">
                                                        <span id="wood" title="<?= $village['r_wood'] ?>" <?php if (($village['r_wood'] ?? 0) == $max_storage)
                                                              echo 'class="warn"'; ?>>
                                                            <?= floor($village['r_wood'] ?? 0) ?>
                                                        </span>
                                                    </td>
                                                    <td class="box-item icon-box">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=stone">
                                                            <span class="icon header stone" title="<?= __('screens.common.stone') ?>"></span> </a>
                                                    </td>
                                                    <td class="box-item">
                                                        <span id="stone" title="<?= $village['r_stone'] ?>" <?php if (($village['r_stone'] ?? 0) == $max_storage)
                                                              echo 'class="warn"'; ?>>
                                                            <?= floor($village['r_stone'] ?? 0) ?>
                                                        </span>
                                                    </td>
                                                    <td class="box-item icon-box">
                                                        <a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=iron">
                                                            <span class="icon header iron" title="<?= __('screens.common.iron') ?>"></span>
                                                        </a>
                                                    </td>
                                                    <td class="box-item">
                                                        <span id="iron" title="<?= $village['r_iron'] ?>" <?php if (($village['r_iron'] ?? 0) == $max_storage)
                                                              echo 'class="warn"'; ?>>
                                                            <?= floor($village['r_iron'] ?? 0) ?>
                                                        </span>
                                                    </td>
                                                    <td class="box-item icon-box">
                                                        <a href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=storage">
                                                        <span class="icon header storage" title="<?= __('screens.am_overview.storage') ?>"></span>
                                                        </a>
                                                    </td>
                                                    <td class="box-item" id="storage" title="<?= $max_storage ?>"><?= $max_storage ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr class="newStyleOnly">
                                        <td class="shadow">
                                            <div class="leftshadow"> </div>
                                            <div class="rightshadow"> </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td align="right" class="topAlign">
                                <table class="header-border menu_block_right">
                                    <tr>
                                        <td>
                                            <table class="box smallPadding" cellspacing="0">
                                                <tr>
                                                    <td class="box-item icon-box firstcell"><a
                                                            href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=farm"
                                                            title="<?= __('screens.main.population') ?>"><span class="icon header population"></span>
                                                        </a></td>
                                                    <td class="box-item" align="center" style="margin:0;padding:0;">
                                                        <span id="pop_current_label"><?= $pop_current ?></span>/<span
                                                            id="pop_max_label"><?= $max_bh ?>&nbsp;</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr class="newStyleOnly">
                                        <td class="shadow">
                                            <div class="leftshadow"> </div>
                                            <div class="rightshadow"> </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <?php if (($config['inventory_enabled'] ?? true) || ($config['flags_enabled'] ?? true)): ?>
                                <td align="right" class="topAlign">
                                    <table class="header-border menu_block_right">
                                        <tr>
                                            <td>
                                                <table class="box smallPadding" cellspacing="0">
                                                    <tr>
                                                        <?php if ($config['inventory_enabled'] ?? true): ?>
                                                            <td class="box-item icon-box firstcell"><a
                                                                    href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=profile&mode=inventory"
                                                                    title="<?= __('common.game_inventory') ?>">
                                                                    <img src="graphic/icons/inventory.webp"
                                                                        alt="<?= __('common.game_inventory') ?>"
                                                                        style="width: 20px; height: 20px;">
                                                                </a>
                                                            </td>
                                                        <?php endif; ?>
                                                        <?php if ($config['flags_enabled'] ?? true): ?>
                                                            <td class="box-item icon-box firstcell"><a
                                                                    href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=flags"
                                                                    title="<?= __('common.game_flags') ?>">
                                                                    <img src="graphic/icons/flags.png"
                                                                        alt="<?= __('common.game_flags') ?>"
                                                                        style="width: 20px; height: 20px;">
                                                                </a>
                                                            </td>
                                                        <?php endif; ?>
                                                        <?php if ($config['event_horde_active'] ?? false): ?>
                                                            <td class="box-item icon-box firstcell">
                                                                <a href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=event_horde" title="Ataque da Horda">
                                                                    <img src="graphic/events/ataque_horda/event_icon.webp" alt="Evento" style="width: 20px; height: 20px;">
                                                                </a>
                                                            </td>
                                                        <?php endif; ?>
                                                        <?php if ($config['event_spring_active'] ?? false): ?>
                                                            <td class="box-item icon-box firstcell">
<<<<<<< Updated upstream
                                                                <a href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=event_spring" title="Festival de Primavera">
                                                                    <img src="graphic/events/festival de primavera/logo.webp" alt="Festival" style="width: 20px; height: 20px;">
=======
                                                                <a href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=event_spring"
                                                                    title="Festival de Primavera">
                                                                    <img src="graphic/events/festival_de_primavera/logo.webp"
                                                                        alt="Festival" class="icon-20">
>>>>>>> Stashed changes
                                                                </a>
                                                            </td>
                                                        <?php endif; ?>
                                                        <?php if ($config['event_horse_race_active'] ?? false): ?>
                                                            <td class="box-item icon-box firstcell">
                                                                <a href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=event_horse_race" title="Corrida de Cavalos">
                                                                    <img src="graphic/events/horse_race/event_icon.webp" alt="Corrida de Cavalos" style="width: 20px; height: 20px;">
                                                                </a>
                                                            </td>
                                                        <?php endif; ?>
                                                    </tr>
                                                </table>
                                            </td>

                                        </tr>
                                        <tr class="newStyleOnly">
                                            <td class="shadow">
                                                <div class="leftshadow"> </div>
                                                <div class="rightshadow"> </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            <?php endif; ?>
                        </tr>
                    </table>

                    <!-- Village Dropdown -->
                    <div id="container_village_drop_down">
                        <div id="village_drop_down" style="display:none;" class="padding2">
                            <center>
                                <table style="width:100%;" class="content-border">
                                    <tr>
                                        <td id="content_value2">
                                            <center>
                                                <table class="vis" width="100%">
                                                    <tr>
                                                        <th height="18px"><?= __('common.your_villages') ?></th>
                                                    </tr>
                                                    <?php
                                                    // Get all user villages
                                                    $user_villages = $user_villages ?? [];
                                                    foreach ($user_villages as $vill):
                                                        ?>
                                                        <tr>
                                                            <td<?php if ($vill['id'] == ($village['id'] ?? 0))
                                                                echo ' class="selected"'; ?> height="18px">
                                                                <a
                                                                    href="game.php?village=<?= $vill['id'] ?>&screen=<?= $screen ?>">
                                                                    <?= htmlspecialchars($vill['name']) ?>
                                                                    (<?= $vill['x'] ?>|<?= $vill['y'] ?>)
                                                                    K<?= $vill['continent'] ?>
                                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </center>
            </td>
        </tr>
    </table>
    </center>
    </div>
    </div>

    <!-- *********************** CONTENT BELOW ************************** -->
    <table align="center" id="contentContainer" width="100%">
        <tr>
            <td>
                <table class="content-border" width="100%" cellspacing="0">
                    <tr>
                        <td id="inner-border">
                            <table class="main" align="left">


                                <tr>
                                    <?php
                                    $screen_class = 'screen-' . $screen;
                                    if ($screen === 'report' && (isset($_GET['view']) || (isset($_GET['mode']) && $_GET['mode'] === 'view') || (isset($mode) && $mode === 'view'))) {
                                        $screen_class .= ' report-view';
                                    }
                                    ?>
                                    <td id="content_value" class="<?= htmlspecialchars($screen_class) ?>">
                                        <?= $screenContent ?? '' ?>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </div>
    </td>
    <td class="bg_right" id="SkyScraperAdCell">
        <div class="bg_right"> </div>
        <div id="SkyScraperAd"></div>
    </td>
    </tr>
    <tr>
        <td class="bg_leftborder">
        </td>
        <td></td>
        <td class="bg_rightborder"> </td>
    </tr>
    <tr class="newStyleOnly">
        <td class="bg_bottomleft">&nbsp;</td>
        <td class="bg_bottomcenter">&nbsp;</td>
        <td class="bg_bottomright">&nbsp;</td>
    </tr>
    <tr>
        <!-- language-selector-->
        <!-- <td colspan="3" align="center">

            <div id="AdBottom"><?php include __DIR__ . '/components/language_selector.php'; ?></div>
        </td> -->
    </tr>
    </table><!-- .main_layout -->

    <script type="text/javascript">
        //<![CDATA[
        $(document).ready(function () {
            startTimer();
            if (typeof QuestArrows != 'undefined') {
                QuestArrows.init();
            }

            // World Selection Toggle
            $('.evt-world-selection-toggle').click(function (e) {
                e.preventDefault();
                $('#world_selection_popup').toggle();
                $('#world_selection_clicktrap').toggle();
            });
        });
        //]]>
    </script>


    <div id="footer">
        <div id="linkContainer" style="float:center; position: relative;">

            <div id="world_selection_clicktrap" class="evt-world-selection-toggle"></div>
            <div id="world_selection_popup">
                <div id="servers-list-block">
                    <div style="font-weight: bold; color: #803000; font-size: 13px; margin-bottom: 12px; border-bottom: 1px solid #7d510f; padding-bottom: 5px; text-shadow: 1px 1px 0px rgba(255,255,255,0.5);">
                        <?= __('common.footer.available_worlds') ?>
                    </div>
                    <?php if (!empty($user['registered_worlds'])): ?>
                        <?php 
                        $world_count = 0;
                        foreach ($user['registered_worlds'] as $world): 
                            $world_count++;
                            $is_hidden = ($world_count > 2);
                        ?>
                            <div class="server-item <?= $is_hidden ? 'world-hidden' : '' ?>" <?= $is_hidden ? 'style="display:none;"' : '' ?>>
                                <a href="index.php?action=select_world&world=<?= urlencode($world) ?>" class="<?= ($world == $server) ? 'world_button_active' : 'world_button_inactive' ?>">
                                    Mundo <?= htmlspecialchars($world) ?>
                                </a>
                            </div>
                        <?php endforeach; ?>
                        
                        <?php if (count($user['registered_worlds']) > 2): ?>
                            <div id="show-all-worlds-container" style="margin-top: 5px;">
                                <a href="#" style="font-size: 11px; color: #803000; text-decoration: underline; font-weight: bold;" onclick="$('.world-hidden').show(); $('#show-all-worlds-container').hide(); return false;">
                                    <?= __('common.footer.show_all_worlds') ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div style="padding: 10px; color: #603000; font-size: 11px;">
                            Nenhum outro mundo encontrado.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- botão de admin
            <?php if (($user['admin'] ?? 0) == 1): ?>
                <a href="game.php?village=<?= $village['id'] ?? 0 ?>&screen=admin" class="world_button_active">Admin</a>
                &nbsp;
                <?php endif; ?> -->

            <a href="#" class="world_button_active evt-world-selection-toggle"><?= __('common.footer.world') ?>
                <?= $serverid ?></a>
            &nbsp;
            <a href="help.php" class="footer-link" target="_blank"><?= __('common.footer.help') ?></a>
            &nbsp;-&nbsp;
            <a href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=support" class="footer-link"
                target="_blank"><?= __('common.footer.support_team') ?></a>
            &nbsp;-&nbsp;
            <a href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=profile&mode=invite" class="footer-link"
                target="_blank"><?= __('common.footer.invite_friends') ?></a>
            <!-- &nbsp;-&nbsp;
                <a href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=friends" class="footer-link">Amigo
                   s</a>-->
            &nbsp;-&nbsp;
            <a href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;screen=memo"
                class="footer-link"><?= __('common.footer.notepad') ?></a>
            &nbsp;-&nbsp;
            <a href="game.php?village=<?= $village['id'] ?? 0 ?>&amp;action=logout&amp;h="
                class="footer-link"><?= __('common.footer.logout') ?></a>
            &nbsp;-&nbsp;
            <a href="https://ice41.pt" class="footer-link footer-link-ice41" target="_blank">Ice41</a>
             &nbsp;-&nbsp;
            <a href="https://discord.me/nped" class="footer-link footer-link-discord" target="_blank">Discord</a>


            <span style="float:right; padding-right: 10px;">
                <?= __('common.footer.generated_in') ?> <b><?= $load_msec ?></b> ms
                <b> | </b>
                <?= __('common.footer.server_time') ?>: <b> <span id="serverTime"><?= $servertime ?></span> </b>
                <b> | </b>
                <?= __('common.footer.premium_functions') ?>:<b><?= $premium ? __('common.footer.active') : __('common.footer.inactive') ?></b>
                <b>|</b> <?= __('common.footer.players_in_world') ?>: <b><?= $conta ?></b>

        </div>
    </div>

    <script type="text/javascript">
        //<![CDATA[
        // Update server time every second
        function updateServerTime() {
            var timeElement = document.getElementById('serverTime');
            if (timeElement) {
                var currentTime = timeElement.textContent.split(':');
                var hours = parseInt(currentTime[0]);
                var minutes = parseInt(currentTime[1]);
                var seconds = parseInt(currentTime[2]);

                seconds++;
                if (seconds >= 60) {
                    seconds = 0;
                    minutes++;
                }
                if (minutes >= 60) {
                    minutes = 0;
                    hours++;
                }
                if (hours >= 24) {
                    hours = 0;
                }

                timeElement.textContent =
                    (hours < 10 ? '0' : '') + hours + ':' +
                    (minutes < 10 ? '0' : '') + minutes + ':' +
                    (seconds < 10 ? '0' : '') + seconds;
            }
        }

        // Update every second
        setInterval(updateServerTime, 1000);
        //]]>
    </script>
</body>

</html>
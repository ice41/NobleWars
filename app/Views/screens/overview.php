<?php
// Helper for formatting numbers
if (!function_exists('format_number')) {
    function format_number($number)
    {
        return number_format($number, 0, '.', '.');
    }
}
// Helper for formatting time
if (!function_exists('format_time')) {
    function format_time($seconds)
    {
        return gmdate('H:i:s', $seconds);
    }
}
?>
<link rel="stylesheet" type="text/css" href="/css/overniew.css" />
<style>
/* Sortable placeholder - invisible and zero height when not dragging */
.vis.placeholder {
    visibility: hidden !important;
    height: 0 !important;
    min-height: 0 !important;
    padding: 0 !important;
    margin: 0 !important;
    border: none !important;
    overflow: hidden !important;
}
/* Show placeholder during drag */
#overviewtable.sorting .vis.placeholder,
.theme-modern #overviewtable.sorting .vis.placeholder,
.theme-viking #overviewtable.sorting .vis.placeholder {
    visibility: visible !important;
    height: 50px !important;
    min-height: 50px !important;
    border: 2px dashed #8c5f0d !important;
    background: transparent !important;
    background-image: none !important;
    box-shadow: none !important;
    opacity: 0.85 !important;
    margin-bottom: 12px !important;
    border-radius: 6px !important;
}
.theme-viking #overviewtable.sorting .vis.placeholder {
    border: 2px dashed #4fc3f7 !important;
}
/* Always hide toprow */
#toprow_row, #toprow { display: none !important; }
#toprow .vis.moveable { width: 100%; }
/* Ensure empty columns don't collapse to 0 height or width during dragging in all themes */
#overviewtable.sorting #leftcolumn,
#overviewtable.sorting #rightcolumn,
body #overviewtable.sorting #leftcolumn,
body #overviewtable.sorting #rightcolumn,
.theme-modern #overviewtable.sorting #leftcolumn,
.theme-modern #overviewtable.sorting #rightcolumn,
.theme-viking #overviewtable.sorting #leftcolumn,
.theme-viking #overviewtable.sorting #rightcolumn {
    padding-bottom: 150px !important;
    min-height: 150px !important;
}
/* Ensure columns have a minimum width during dragging so they don't collapse horizontally in flex layouts */
#overviewtable.sorting #leftcolumn,
.theme-modern #overviewtable.sorting #leftcolumn,
.theme-viking #overviewtable.sorting #leftcolumn {
    min-width: 300px !important;
    width: 300px !important;
    flex-basis: 300px !important;
}
#overviewtable.sorting #rightcolumn,
.theme-modern #overviewtable.sorting #rightcolumn,
.theme-viking #overviewtable.sorting #rightcolumn {
    min-width: 300px !important;
    flex: 1 1 300px !important;
}

/* Centering widgets when one column is empty (and not sorting) */
#overviewtable.right-empty:not(.sorting) #leftcolumn,
#overviewtable.left-empty:not(.sorting) #rightcolumn {
    text-align: center !important;
}
#overviewtable.right-empty:not(.sorting) #leftcolumn > .widget,
#overviewtable.left-empty:not(.sorting) #rightcolumn > .widget {
    display: inline-block !important;
    width: 100% !important;
    max-width: 820px !important;
    text-align: left !important;
    margin-left: auto !important;
    margin-right: auto !important;
}
/* Center village map inside the widget when single column */
#overviewtable.right-empty:not(.sorting) #leftcolumn #show_village_map table,
#overviewtable.left-empty:not(.sorting) #rightcolumn #show_village_map table,
#overviewtable.right-empty:not(.sorting) #leftcolumn #show_village_map div[style*="width: 600px"],
#overviewtable.left-empty:not(.sorting) #rightcolumn #show_village_map div[style*="width: 600px"] {
    margin-left: auto !important;
    margin-right: auto !important;
}
</style>

<table id="overviewtable" width="100%">
    <tr id="toprow_row">
        <td colspan="2" id="toprow" style="padding:0; vertical-align:top;"></td>
    </tr>
    <tr>
        <td id="leftcolumn" <?php if ($style == 'new'): ?>width="50%"<?php else: ?>width="600"<?php endif; ?> valign="top" style="padding-top:0; vertical-align:top;">
            <div id="show_village_map" class="vis moveable widget">
                <h4 class="head">
                    <img style="float: right; cursor: pointer;"
                        onclick="return VillageOverview.toggleWidget( 'show_village_map', this );" src="graphic/icons/minus.png">
                    <?= __('screens.overview.buildings') ?>
                </h4>
                <div class="widget_content" style="display: block;">
                    <table class="vis" width="100%">
                <?php if ($style == 'new'): ?>
                    <tr>
                        <td width="60%">
                            <a
                                href="game.php?village=<?= $village['id'] ?>&screen=overview&akcja=o_labels"><span><?php if ($labels): ?><?= __('screens.overview.hide_levels') ?><?php else: ?><?= __('screens.overview.show_levels') ?><?php endif; ?></span></a>
                        </td>
                        <td>
                            <a href="game.php?village=<?= $village['id'] ?>&screen=overview&akcja=o_style"><span
                                    style="text-align:right;"><?= __('screens.overview.classic_view') ?></span></a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table cellpadding="5">
                                <tr>
                                    <td>
                                        <?php 
                                        $village_css_filter = '';
                                        if (isset($active_effects) && is_array($active_effects)) {
                                            foreach ($active_effects as $eff) {
                                                if ($eff['effect_type'] === 'village_filter') {
                                                    $village_css_filter = $eff['effect_value'];
                                                    break;
                                                }
                                            }
                                        }
                                        ?>
                                        <div
                                            style="position: relative; width: 600px;height: 418px; background-image: url(/graphic/<?= $visual ?>/back_none.jpg); <?php if($village_css_filter): ?>filter: <?= htmlspecialchars($village_css_filter) ?>;<?php endif; ?>">
                                            <img class="empty" src="/graphic/map/empty.png" alt="" usemap="#mapa" />
                                            <map name="mapa" id="mapa">
                                                <?php foreach ($cl_builds->get_array('dbname') as $id => $dbname): ?>
                                                    <?php
                                                    // Check configuration
                                                    $config_key = ($dbname === 'church_f') ? 'church' : $dbname;
                                                    if (array_key_exists($config_key, $config) && empty($config[$config_key])) {
                                                        continue;
                                                    }
                                                    ?>
                                                    <?php if (($village[$dbname] ?? 0) > 0): ?>
                                                        <?php
                                                        $max_stage = $cl_builds->get_maxstage($dbname);
                                                        $is_single_stage = ($max_stage == 1);
                                                        $percentage = ($is_single_stage) ? 1 : ($village[$dbname] / $max_stage);

                                                        // Determine graphic stage (1, 2, or 3)
                                                        if ($is_single_stage) {
                                                            $graphic_stage = 1;
                                                        } else {
                                                            if ($percentage > 0.5) {
                                                                $graphic_stage = 3;
                                                            } elseif ($percentage > 0.2) {
                                                                $graphic_stage = 2;
                                                            } else {
                                                                $graphic_stage = 1;
                                                            }
                                                        }

                                                        // Fix for Academy (snob) - usually only has stage 1 visual
                                                        if ($dbname == 'snob') {
                                                            $graphic_stage = 1;
                                                        }

                                                        // Override for generic styling if needed, or mapping extension
                                                        $ext = 'png';
                                                        if (isset($$dbname)) {
                                                            $ext = $$dbname;
                                                        }
                                                        ?>

                                                        <area shape="poly" coords="<?= $builgraphic_coords[$dbname] ?? '' ?>"
                                                            href="game.php?village=<?= $village['id'] ?>&screen=<?= $dbname ?><?= $dbname === 'market' ? '&mode=other_offer' : '' ?>"
                                                            alt="<?= $cl_builds->get_name($dbname) ?>"
                                                            title="<?= $cl_builds->get_name($dbname) ?>" />

                                                        <?php if ($dbname == 'main'): ?>
                                                            <a href="game.php?village=<?= $village['id'] ?>&screen=main"><img
                                                                    class="align_mainflag"
                                                                    src="/graphic/<?= $visual ?>/mainflag<?= $graphic_stage ?>.gif"
                                                                    alt="" /></a>
                                                        <?php endif; ?>

                                                        <?php if ($dbname == 'smith' && !empty($is_researching)): ?>
                                                            <a href="game.php?village=<?= $village['id'] ?>&screen=smith"><img
                                                                    class="smith_anim"
                                                                    src="/graphic/<?= $visual ?>/smith_anim.gif"
                                                                    alt="" /></a>
                                                        <?php endif; ?>

                                                         <?php if ($dbname !== 'watchtower'): ?>
                                                         <a
                                                             href="game.php?village=<?= $village['id'] ?>&screen=<?= $dbname ?><?= $dbname === 'market' ? '&mode=other_offer' : '' ?>">
                                                             <img class="align_<?= $dbname ?>"
                                                                 src="/graphic/<?= $visual ?>/<?= $dbname ?><?= $graphic_stage ?>.<?= $ext ?>"
                                                                 alt=""
                                                                 <?php if ($dbname === 'wall' && ($config['watchtower'] ?? false) === true && ($village['watchtower'] ?? 0) > 0): ?>
                                                                     style="clip-path: polygon(0px 0px, 570px 0px, 570px 183px, 475px 183px, 475px 250px, 530px 250px, 530px 183px, 570px 183px, 570px 408px, 0px 408px);"
                                                                 <?php endif; ?> />
                                                         </a>
                                                         <?php endif; ?>

                                                        <?php if ($labels): ?>
                                                            <label class="stagetip label_<?= $dbname ?>"><a
                                                                    href="game.php?village=<?= $village['id'] ?>&screen=<?= $dbname ?><?= $dbname === 'market' ? '&mode=other_offer' : '' ?>"><?= $village[$dbname] ?></a></label>
                                                        <?php endif; ?>

                                                    <?php endif; ?>
                                                <?php endforeach; ?>

                                                <?php if ($anim == 1): ?>
                                                    <a href="game.php?village=<?= $village['id'] ?>&screen=<?= $dbname ?>"><img
                                                            class="align_conversation"
                                                            src="/graphic/<?= $visual ?>/conversation.gif" alt="" /></a>
                                                <?php endif; ?>
                                                <?php if ($anim == 2): ?>
                                                    <img class="align_juggler" src="/graphic/<?= $visual ?>/juggler.gif"
                                                        alt="" />
                                                <?php endif; ?>
                                                <?php if ($anim == 3): ?>
                                                    <img class="align_guard" src="/graphic/<?= $visual ?>/guard.gif" alt="" />
                                                <?php endif; ?>
                                                <?php if ($village['r_bh'] < $max_bh): ?>
                                                    <img class="align_farmer" src="/graphic/<?= $visual ?>/farmer.gif" alt="" />
                                                <?php endif; ?>

                                                <?php /* === SEASONAL EVENT OVERLAY === */ ?>
                                                <?php
                                                // Valentine's Day event: only shown on February 14th
                                                $seasonal_event = (date('m-d') === '02-14') ? 'valentine' : false;
                                                $evt_ext = (strpos($visual, 'night') !== false) ? 'n_' : '';
                                                ?>
                                                <?php if ($seasonal_event === 'valentine'): ?>
                                                    <!-- Valentine heart: center (valentines.webp) -->
                                                    <img class="align_event_valentine_center"
                                                        src="/graphic/<?= $visual ?>/event/<?= $evt_ext ?>valentines.webp"
                                                        alt="" title="<?= __('screens.overview.happy_valentines') ?>" />
                                                    <!-- Valentine heart: right (valentines.webp) -->
                                                    <img class="align_event_valentine_right"
                                                        src="/graphic/<?= $visual ?>/event/<?= $evt_ext ?>valentines.webp"
                                                        alt="" title="<?= __('screens.overview.happy_valentines') ?>" />
                                                    <!-- Valentine heart: near barracks (valentine.png) -->
                                                    <img class="align_event_valentine_left"
                                                        src="/graphic/<?= $visual ?>/event/<?= $evt_ext ?>valentine.png" alt=""
                                                        title="<?= __('screens.overview.happy_valentines') ?>" />
                                                <?php endif; ?>

                                                <?php /* === GUARDS ANIMATION === */ ?>
                                                <?php
                                                $is_night = (strpos($visual, 'night') !== false);
                                                $guards_dir = $is_night ? 'visual_night' : 'visual';
                                                $guards_prefix = $is_night ? 'n_' : '';

                                                // Evolution logic based on wall level
                                                $wall_level = $village['wall'] ?? 0;
                                                if ($wall_level == 0) {
                                                    $guard_lvl = 0;
                                                } else {
                                                    $max_wall = $cl_builds->get_maxstage('wall');
                                                    $perc = $wall_level / $max_wall;
                                                    if ($perc > 0.5) {
                                                        $guard_lvl = 3;
                                                    } elseif ($perc > 0.2) {
                                                        $guard_lvl = 2;
                                                    } else {
                                                        $guard_lvl = 1;
                                                    }
                                                }
                                                ?>
                                                <!--<img class="align_guards_right"
                                                    src="/graphic/<?= $guards_dir ?>/<?= $guards_prefix ?>ani_guards_right_lvl<?= $guard_lvl ?>.gif"
                                                    alt="" title="<?= __('screens.overview.guards') ?>" />
                                                <img class="align_guards_left"
                                                    src="/graphic/<?= $guards_dir ?>/<?= $guards_prefix ?>ani_guards_left_lvl<?= $guard_lvl ?>.gif"
                                                    alt="" title="<?= __('screens.overview.guards') ?>" />-->
                                                <?php
                                                // Halloween event: only shown on October 31st
                                                $seasonal_event_halloween = (date('m-d') === '10-31');
                                                ?>
                                                <?php if ($seasonal_event_halloween): ?>
                                                    <!-- Halloween pumpkin: near main building (halloween.png) -->
                                                    <img class="align_event_halloween"
                                                        src="/graphic/<?= $visual ?>/event/<?= (strpos($visual, 'night') !== false) ? 'n_' : '' ?>halloween.png"
                                                        alt="" title="<?= __('screens.overview.happy_halloween') ?>" />
                                                    <img class="align_event_halloween_top"
                                                        src="/graphic/<?= $visual ?>/event/<?= (strpos($visual, 'night') !== false) ? 'n_' : '' ?>halloween.png"
                                                        alt="" title="<?= __('screens.overview.happy_halloween') ?>" />
                                                <?php endif; ?>

                                                <?php
                                                // Christmas event: shown from Dec 13th to Jan 6th
                                                $m = (int) date('m');
                                                $d = (int) date('d');
                                                $seasonal_event_christmas = ($m == 12 && $d >= 13) || ($m == 1 && $d <= 6);
                                                ?>
                                                <?php if ($seasonal_event_christmas): ?>
                                                    <!-- Christmas Tree (christmas_tree.png) -->
                                                    <img class="align_event_christmas"
                                                        src="/graphic/<?= $visual ?>/event/<?= (strpos($visual, 'night') !== false) ? 'n_' : '' ?>christmas_tree.png"
                                                        alt="" title="<?= __('screens.overview.merry_christmas') ?>" />
                                                <?php endif; ?>

                                                <?php
                                                // Theater Event: Interactive building
                                                // Loaded from world configuration
                                                $seasonal_event_theater = $config['theater_enabled'] ?? true;
                                                ?>

                                                <?php if ($seasonal_event_theater): ?>
                                                    <!-- Theater Building (theater.gif) -->
                                                    <a href="game.php?village=<?= $village['id'] ?>&screen=theater">
                                                        <img class="align_theater"
                                                            src="/graphic/<?= $visual ?>/event/<?= (strpos($visual, 'night') !== false) ? 'n_' : '' ?>theater.gif"
                                                            alt="" title="<?= __('screens.overview.theater') ?>" />
                                                    </a>
                                                <?php endif; ?>

                                                <?php if ($is_birthday): ?>
                                                    <!-- Birthday overlay: covers the whole map -->
                                                    <img class="align_event_birthday"
                                                        src="/graphic/<?= $visual ?>/event/<?= (strpos($visual, 'night') !== false) ? 'n_' : '' ?>birthday.png"
                                                        alt="" title="<?= __('screens.overview.happy_birthday') ?>" />
                                                <?php endif; ?>
                                            </map>

                                            <?php if (($config['watchtower'] ?? false) === true && ($village['watchtower'] ?? 0) > 0): ?>
                                                <a href="game.php?village=<?= $village['id'] ?>&screen=watchtower">
                                                    <img class="align_watchtower" 
                                                        src="/graphic/<?= $tower_dir ?>/<?= $watchtower_prefix ?>watchtower<?= $watchtower_lvl ?>.png"
                                                        alt="" title="<?= __('screens.overview.watchtower') ?>" />
                                                </a>
                                            <?php endif; ?>


                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                <?php elseif ($style == 'classic'): ?>
                    <tr>
                        <td>
                            <a href="game.php?village=<?= $village['id'] ?>&screen=overview&akcja=o_style">
                                <span style="text-align:right;">
                                    <?= __('screens.overview.graphic_view') ?>
                                </span>
                            </a>
                        </td>
                    </tr>
                    <?php foreach ($built_builds as $dbname): ?>
                        <tr>
                            <td>
                                <a
                                    href="game.php?village=<?= $village['id'] ?>&screen=<?= $dbname ?><?= $dbname === 'market' ? '&mode=other_offer' : '' ?>"><img
                                        src="/graphic/buildings/<?= $dbname ?>.png"> <?= $cl_builds->get_name($dbname) ?></a>
                                (<?= __('screens.overview.level') ?>         <?= $village[$dbname] ?>)
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>

                    </table>
                </div>
            </div>
            <?php if ($config['event_horde_active'] ?? false): ?>
                <br />
                <!-- Horde Event Widget -->
                <div id="show_horde_event" class="vis moveable widget">
                    <h4 class="head">
                        <img style="float: right; cursor: pointer;"
                            onclick="return VillageOverview.toggleWidget( 'show_horde_event', this );" src="graphic/icons/minus.png">
                        <?= __('screens.overview.horde_event') ?>
                    </h4>
                    <div class="widget_content" style="display: block;">
                        <table class="vis" width="100%">
                            <tbody>
                                <tr>
                                    <td width="80" style="padding: 10px; border-right: 1px solid #dfd1af;">
                                        <img src="/graphic/events/ataque_horda/event_logo@2x.webp" style="width: 70px;" alt="">
                                    </td>
                                    <td style="padding: 10px;">
                                        <div style="font-weight: bold; margin-bottom: 5px;"><?= __('screens.overview.horde_event_desc') ?></div>
                                        <div style="font-weight: bold; color: #402a0a;"><?= __('screens.overview.event_ends_in') ?> <?= htmlspecialchars($config['event_horde_end'] ?? '4 dias') ?></div>
                                    </td>
                                    <td width="120" style="text-align: center; padding: 10px;">
                                        <a href="game.php?village=<?= $village['id'] ?>&screen=event_horde" class="btn-espiar-horde btn-overview-event" style="padding: 10px 15px; background: linear-gradient(to bottom, #7d510f, #402a0a); color: white; border-radius: 4px; text-decoration: none; font-weight: bold; display: inline-block;"><?= __('screens.overview.open_event') ?></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($config['event_spring_active'] ?? false): ?>
                <br />
                <!-- Spring Festival Widget -->
                <div id="show_spring_event" class="vis moveable widget">
                    <h4 class="head">
                        <img style="float: right; cursor: pointer;"
                            onclick="return VillageOverview.toggleWidget( 'show_spring_event', this );" src="graphic/icons/minus.png">
                        <?= __('screens.overview.spring_event') ?>
                    </h4>
                    <div class="widget_content" style="display: block;">
                        <table class="vis" width="100%">
                            <tbody>
                                <tr>
                                    <td width="80" style="padding: 10px; border-right: 1px solid #dfd1af;">
                                        <img src="/graphic/events/festival_de_primavera/logo.webp" style="width: 70px;" alt="">
                                    </td>
                                    <td style="padding: 10px;">
                                        <div style="font-weight: bold; margin-bottom: 5px;"><?= __('screens.overview.spring_event_desc') ?></div>
                                    </td>
                                    <td width="120" style="text-align: center; padding: 10px;">
                                        <a href="game.php?village=<?= $village['id'] ?>&screen=event_spring" class="btn-overview-event" style="padding: 10px 15px; background: linear-gradient(to bottom, #2d7a2d, #1a4d1a); color: white; border-radius: 4px; text-decoration: none; font-weight: bold; display: inline-block;"><?= __('screens.overview.open_event') ?></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($config['event_horse_race_active'] ?? false): ?>
                <br />
                <!-- Horse Race Event Widget -->
                <div id="show_horse_race_event" class="vis moveable widget">
                    <h4 class="head">
                        <img style="float: right; cursor: pointer;"
                            onclick="return VillageOverview.toggleWidget( 'show_horse_race_event', this );" src="graphic/icons/minus.png">
                        <?= __('screens.overview.horse_race_event') ?>
                    </h4>
                    <div class="widget_content" style="display: block;">
                        <table class="vis" width="100%">
                            <tbody>
                                <tr>
                                    <td width="80" style="padding: 10px; border-right: 1px solid #dfd1af;">
                                        <img src="/graphic/events/horse_race/event_logo.webp" style="height: 40px;" alt="">
                                    </td>
                                    <td style="padding: 10px;">
                                        <div style="font-weight: bold; margin-bottom: 5px;"><?= __('screens.overview.horse_race_event_desc') ?></div>
                                        <div style="font-weight: bold; color: #402a0a;"><?= __('screens.overview.event_ends_in') ?> <?= htmlspecialchars($config['event_horse_race_end'] ?? '') ?></div>
                                    </td>
                                    <td width="120" style="text-align: center; padding: 10px;">
                                        <a href="game.php?village=<?= $village['id'] ?>&screen=event_horse_race" class="btn-overview-event" style="padding: 10px 15px; background: linear-gradient(to bottom, #a36f26, #5c3a1e); color: white; border-radius: 4px; text-decoration: none; font-weight: bold; display: inline-block;"><?= __('screens.overview.open_event') ?></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (count($other_movements) > 0): ?>
                <div id="show_incoming" class="vis moveable widget">
                    <h4 class="head">
                        <img style="float: right; cursor: pointer;"
                            onclick="return VillageOverview.toggleWidget( 'show_incoming', this );" src="graphic/icons/minus.png">
                        <?= __('screens.overview.incoming') ?> (<?= count($other_movements) ?>)
                    </h4>
                    <div class="widget_content" style="display: block;">
                        <table class="vis" width="100%">
                            <tbody>
                                <tr>
                                    <th><?= __('screens.overview.incoming_commands') ?></th>
                                    <th><?= __('screens.overview.at_location') ?></th>
                                    <th><?= __('screens.overview.arrival') ?></th>
                                </tr>
                                <?php foreach ($other_movements as $array): ?>
                                    <tr>
                                        <td>
                                            <a href="game.php?village=<?= $village['id'] ?>&amp;screen=info_command&amp;id=<?= $array['id'] ?>&amp;type=other">
                                                <?php if ($array['type'] === 'attack' && $array['is_detected']): ?>
                                                    <img src="/graphic/command/watchtower_all_seeing_eye.webp" style="margin-right: 5px;">
                                                    <?php if ($array['info_type'] === 'noble'): ?>
                                                        <img src="/graphic/command/snob.webp">
                                                    <?php elseif ($array['info_type'] === 'large'): ?>
                                                        <img src="/graphic/command/attack_large.webp">
                                                    <?php elseif ($array['info_type'] === 'medium'): ?>
                                                        <img src="/graphic/command/attack_medium.webp">
                                                    <?php elseif ($array['info_type'] === 'small'): ?>
                                                        <img src="/graphic/command/attack_small.webp">
                                                    <?php else: ?>
                                                        <img src="/graphic/command/attack.webp">
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <img src="/graphic/command/<?= $array['type'] ?>.png">
                                                <?php endif; ?>
                                                <span><?= $array['message'] ?></span>
                                            </a>
                                        </td>
                                        <td><?= $array['end_time'] ?></td>
                                        <td>
                                            <?php if ($array['arrival_in'] < 0): ?>
                                                <?= format_time($array['arrival_in']) ?>
                                            <?php else: ?>
                                                <span class="timer"><?= format_time($array['arrival_in']) ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (count($my_movements) > 0): ?>
                <div id="show_commands" class="vis moveable widget">
                    <h4 class="head">
                        <img style="float: right; cursor: pointer;"
                            onclick="return VillageOverview.toggleWidget( 'show_commands', this );" src="graphic/icons/minus.png">
                        <?= __('screens.overview.own_commands') ?> (<?= count($my_movements) ?>)
                    </h4>
                    <div class="widget_content" style="display: block;">
                        <table class="vis" width="100%">
                            <tbody>
                                <tr>
                                    <th><?= __('screens.overview.command') ?></th>
                                    <th><?= __('screens.overview.at_location') ?></th>
                                    <th><?= __('screens.overview.arrival') ?></th>
                                </tr>
                                <?php foreach ($my_movements as $array): ?>
                                    <tr>
                                        <td>
                                            <a href="game.php?village=<?= $village['id'] ?>&amp;screen=info_command&amp;id=<?= $array['id'] ?>&amp;type=own">
                                                <img src="/graphic/command/<?= $array['type'] ?>.png">
                                                <?= $array['message'] ?>
                                            </a>
                                        </td>
                                        <td><?= $array['end_time'] ?></td>
                                        <td>
                                            <?php if ($array['arrival_in'] < 0): ?>
                                                <?= format_time($array['arrival_in']) ?>
                                            <?php else: ?>
                                                <span class="timer"><?= format_time($array['arrival_in']) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <?php if ($array['can_cancel']): ?>
                                            <td>
                                                <a href="game.php?village=<?= $village['id'] ?>&amp;screen=place&amp;action=cancel&amp;id=<?= $array['id'] ?>&amp;h=<?= $hkey ?>">
                                                    <?= __('screens.overview.cancel') ?>
                                                </a>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </td>

        <td id="rightcolumn" valign="top" style="padding-top:0;" <?php if ($style == 'new'): ?>width="50%" <?php endif; ?><?php if ($style == 'classic'): ?>width="40%" <?php endif; ?>>
            <?php if ($noob): ?>
                <table class="vis" width="100%">
                    <tr>
                        <th>
                            <i><?= __('screens.overview.initial_protection') ?></i>
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <?= __('screens.overview.ends') ?>     <?= $noob_end ?>
                        </td>
                    </tr>
                </table>
                <br />
            <?php endif; ?>


            <div id="show_prod" class="vis moveable widget">
                <h4 class="head">
                    <img style="float: right; cursor: pointer;"
                        onclick="return VillageOverview.toggleWidget( 'show_prod', this );" src="graphic/icons/minus.png">
                    <?= __('screens.overview.production') ?>
                </h4>
                <div class="widget_content" style="display: block;">
                    <table width="100%">
                        <tbody>
                            <tr class="nowrap">
                                <td width="70">
                                    <a href="game.php?village=<?= $village['id'] ?>&amp;screen=wood"><span
                                            class="icon header wood"> </span></a> <?= __('screens.overview.wood') ?>
                                </td>
                                <td>
                                    <strong> <?= format_number($wood_per_hour) ?></strong>
                                    <?= __('screens.overview.per_hour') ?>
                                    <a href="javascript:void(0);" onclick="openProdBonusModal('wood'); return false;">
                                        <img src="/graphic/new/premium/premium_plus.webp" alt="Premium" style="vertical-align: middle; margin-left: 5px; cursor: pointer;">
                                    </a>
                                </td>
                            </tr>
                            <tr class="nowrap">
                                <td width="70">
                                    <a href="game.php?village=<?= $village['id'] ?>&amp;screen=stone"><span
                                            class="icon header stone"> </span></a> <?= __('screens.overview.clay') ?>
                                </td>
                                <td>
                                    <strong> <?= format_number($stone_per_hour) ?></strong>
                                    <?= __('screens.overview.per_hour') ?>
                                    <a href="javascript:void(0);" onclick="openProdBonusModal('clay'); return false;">
                                        <img src="/graphic/new/premium/premium_plus.webp" alt="Premium" style="vertical-align: middle; margin-left: 5px; cursor: pointer;">
                                    </a>
                                </td>
                            </tr>
                            <tr class="nowrap">
                                <td width="70">
                                    <a href="game.php?village=<?= $village['id'] ?>&amp;screen=iron"><span
                                            class="icon header iron"> </span></a> <?= __('screens.overview.iron') ?>
                                </td>
                                <td>
                                    <strong> <?= format_number($iron_per_hour) ?></strong>
                                    <?= __('screens.overview.per_hour') ?>
                                    <a href="javascript:void(0);" onclick="openProdBonusModal('iron'); return false;">
                                        <img src="/graphic/new/premium/premium_plus.webp" alt="Premium" style="vertical-align: middle; margin-left: 5px; cursor: pointer;">
                                    </a>
                                </td>
                            </tr>
                            <tr>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php 
            $has_effects_content = !empty($active_effects) || !empty($active_flag) || ($is_religious !== null);
            ?>
            <?php if ($has_effects_content): ?>
                <div id="show_active_effects" class="vis moveable widget">
                    <h4 class="head">
                        <img style="float: right; cursor: pointer;"
                            onclick="return VillageOverview.toggleWidget( 'show_active_effects', this );" src="graphic/icons/minus.png">
                        <?= __('screens.overview.active_effects') ?>
                    </h4>
                    <div class="widget_content" style="display: block;">
                        <table width="100%">
                            <tbody>
                                <?php if ($is_religious !== null): ?>
                                    <?php
                                    $church_tooltip_id = 'tt_church_' . $village['id'];
                                    ?>
                                    <tr class="nowrap">
                                        <td width="30">
                                            <img src="graphic/buildings/church.png" width="20" height="20" alt="">
                                        </td>
                                        <td>
                                            <span id="<?= $church_tooltip_id ?>_trigger">
                                                <?php if ($is_religious === true): ?>
                                                    <?= __('screens.overview.religious') ?>
                                                <?php else: ?>
                                                    <?= __('screens.overview.no_religion') ?>
                                                <?php endif; ?>
                                            </span>
                                            <div id="<?= $church_tooltip_id ?>" style="display:none;">
                                                <?php if ($is_religious === true): ?>
                                                    <img src="graphic/buildings/church.png" style="vertical-align: middle;" width="20" height="20" alt=""> <strong><?= __('screens.overview.religious') ?></strong><br>
                                                    <?= __('screens.overview.church_influence') ?><br><br>
                                                    <ul><li><?= __('screens.overview.no_religion_penalty') ?></li></ul>
                                                <?php else: ?>
                                                    <img src="graphic/buildings/church.png" style="vertical-align: middle; filter: grayscale(100%); opacity: 0.5;" width="20" height="20" alt=""> <strong><?= __('screens.overview.no_religion') ?></strong><br>
                                                    <br><br>
                                                    <ul><li style="color: #990000;"><?= __('screens.overview.religion_penalty_desc') ?></li></ul>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (!empty($active_flag)): ?>
                                    <?php
                                    $flagTypeId = \App\Models\FlagsModel::getFlagTypeId($active_flag['flag_type']);
                                    $flagLevel  = (int)$active_flag['flag_level'];
                                    $flagName   = \App\Models\FlagsModel::getFlagName($active_flag['flag_type']);
                                    $flagEffect = \App\Models\FlagsModel::getFlagEffectDescription($active_flag['flag_type'], $active_flag['flag_level']);
                                    $flag_tooltip_id = 'tt_flag_' . $village['id'];
                                    $flagImgSrc = "graphic/flags/medium/{$flagTypeId}_{$flagLevel}.png";
                                    $flagExpiresText = '';
                                    if (!empty($active_flag['expires_at'])) {
                                        $fTime    = strtotime($active_flag['expires_at']);
                                        $fDay     = strtotime('today', $fTime);
                                        $todayTs  = strtotime('today');
                                        $tomorrowTs = strtotime('tomorrow');
                                        if ($fDay == $todayTs) {
                                            $flagExpiresText = __('screens.overview.expires_today_at') . ' ' . date('H:i:s', $fTime);
                                        } elseif ($fDay == $tomorrowTs) {
                                            $flagExpiresText = __('screens.overview.expires_tomorrow_at') . ' ' . date('H:i:s', $fTime);
                                        } else {
                                            $flagExpiresText = __('screens.overview.expires_in') . ' ' . date('d/m/Y H:i:s', $fTime);
                                        }
                                    }
                                    ?>
                                    <tr class="nowrap">
                                        <td width="30">
                                            <img src="<?= $flagImgSrc ?>" width="20" height="20" alt="">
                                        </td>
                                        <td>
                                            <span id="<?= $flag_tooltip_id ?>_trigger">
                                                <?= $flagName ?> (+<?= $flagEffect ?>)
                                            </span>
                                            <div id="<?= $flag_tooltip_id ?>" style="display:none;">
                                                <img src="<?= $flagImgSrc ?>" style="vertical-align: middle;" width="20" height="20" alt=""> <strong><?= $flagName ?> (+<?= $flagEffect ?>)</strong><br><br>
                                                <ul>
                                                    <?php if ($flagExpiresText): ?>
                                                        <li>+<?= $flagEffect ?> <?= __('screens.overview.flag_type') ?> <?= $flagExpiresText ?></li>
                                                    <?php else: ?>
                                                        <li>+<?= $flagEffect ?> <?= __('screens.overview.flag_type') ?> (<?= __('screens.overview.permanent') ?>)</li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php foreach ($active_effects as $idx => $effect): ?>
                                    <?php
                                    $fallbackIcons = [
                                        'prod_wood' => '3032.webp',
                                        'prod_stone' => '3033.webp',
                                        'prod_iron' => '3034.webp',
                                        'prod_all' => '3053.webp',
                                        'construct_speed' => '3058.webp',
                                        'recruit_all' => '3036.webp',
                                        'combat_boost_att' => '3016.webp',
                                        'combat_boost_def' => '3018.webp',
                                        'combat_boost_cav' => '3052.webp',
                                        'combat_boost_cat' => '3066.webp',
                                        'noble_cost' => '3023.webp',
                                        'farm_capacity' => '3022.webp',
                                        'merchant_capacity' => '3013.webp',
                                        'support_speed' => '3063.webp',
                                        'combat_boost_def_archer' => '3044.webp',
                                        'combat_boost_def_militia' => '3060.webp'
                                    ];
                                    $fallbackNames = [
                                        'prod_wood' => __('screens.overview.effect_prod_wood'),
                                        'prod_stone' => __('screens.overview.effect_prod_stone'),
                                        'prod_iron' => __('screens.overview.effect_prod_iron'),
                                        'prod_all' => __('screens.overview.effect_prod_all'),
                                        'construct_speed' => __('screens.overview.effect_construct_speed'),
                                        'recruit_all' => __('screens.overview.effect_recruit_all'),
                                        'combat_boost_att' => __('screens.overview.effect_combat_att'),
                                        'combat_boost_def' => __('screens.overview.effect_combat_def'),
                                        'combat_boost_cav' => __('screens.overview.effect_combat_cav'),
                                        'combat_boost_cat' => __('screens.overview.effect_combat_cat'),
                                        'noble_cost' => __('screens.overview.effect_noble_cost'),
                                        'farm_capacity' => __('screens.overview.effect_farm_capacity'),
                                        'merchant_capacity' => __('screens.overview.effect_merchant_capacity'),
                                        'support_speed' => __('screens.overview.effect_support_speed'),
                                        'combat_boost_def_archer' => __('screens.overview.effect_combat_def_archer'),
                                        'combat_boost_def_militia' => __('screens.overview.effect_combat_def_militia'),
                                    ];

                                    $iconFile = !empty($effect['item_icon']) ? $effect['item_icon'] : ($fallbackIcons[$effect['effect_type']] ?? '3001.webp');
                                    $iconSrc = 'graphic/new/inventory/' . $iconFile;

                                    // Known boost types always use translated name (ignores DB name which is in PT)
                                    $knownTypes = array_keys($fallbackNames);
                                    if (in_array($effect['effect_type'], $knownTypes)) {
                                        $effectName = $fallbackNames[$effect['effect_type']];
                                    } else {
                                        $effectName = !empty($effect['item_name']) ? $effect['item_name'] : __('screens.overview.active_effect');
                                    }

                                    $pct        = ($effect['effect_value'] > 0 && $effect['effect_value'] <= 1) ? round($effect['effect_value'] * 100) : 0;
                                    $effectBonus = $pct ? "+{$pct}%" : '';
                                    $tooltipTitle = $effectName . ($effectBonus ? " ({$effectBonus})" : '');
                                    $eff_tooltip_id = 'tt_effect_' . $village['id'] . '_' . $idx;
                                    $expiresText = '';
                                    if (!empty($effect['expires_at'])) {
                                        $expires = strtotime($effect['expires_at']);
                                        $secsLeft = $expires - time();
                                        if ($secsLeft <= 0) {
                                            $expiresText = '';
                                        } elseif (date('Y-m-d', $expires) === date('Y-m-d')) {
                                            $expiresText = __('screens.overview.expires_today_at') . " " . date('H:i:s', $expires);
                                        } elseif (date('Y-m-d', $expires) === date('Y-m-d', strtotime('+1 day'))) {
                                            $expiresText = __('screens.overview.expires_tomorrow_at') . " " . date('H:i:s', $expires);
                                        } else {
                                            // For multi-day items: show date instead of broken H:i:s countdown
                                            $expiresText = __('screens.overview.expires_in') . " " . date('d/m/Y H:i', $expires);
                                        }
                                    }

                                    if ($effectBonus) {
                                        $bulletText = "{$effectBonus} " . __('screens.overview.item_type') . ($expiresText ? " - {$expiresText}" : '');
                                    } else {
                                        $bulletText = $expiresText ?: __('screens.overview.permanent');
                                    }
                                    ?>
                                    <tr class="nowrap">
                                        <td width="30">
                                            <img src="<?= htmlspecialchars($iconSrc) ?>" width="20" height="20" alt="">
                                        </td>
                                        <td>
                                            <span id="<?= $eff_tooltip_id ?>_trigger">
                                                <?= __('items.item_' . $effect['item_id'] . '_name', htmlspecialchars($effectName)) ?><?= $effectBonus ? " ({$effectBonus})" : '' ?>
                                            </span>
                                            <div id="<?= $eff_tooltip_id ?>" style="display:none;">
                                                <img src="<?= htmlspecialchars($iconSrc) ?>" style="vertical-align: middle;" width="20" height="20" alt="">
                                                <strong><?= htmlspecialchars($tooltipTitle) ?></strong><br><br>
                                                <ul><li><?= htmlspecialchars($bulletText) ?></li></ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <div style="opacity: 1;" id="show_units" class="vis moveable widget">
                <h4 class="head">
                    <img style="float: right; cursor: pointer;"
                        onclick="return VillageOverview.toggleWidget( 'show_units', this );" src="graphic/icons/minus.png">
                    <?= __('screens.overview.units_in_village') ?>
                </h4>
                <div class="widget_content" style="display: block;">
                    <table class="vis" width="100%">
                        <tbody>
                            <?php foreach ($in_village_units as $dbname => $num): ?>
                                <tr>
                                    <td>
                                        <a href="#" class="unit_link"
                                            onclick="return UnitPopup.open(event, '<?= $dbname ?>')"><img
                                                src="/graphic/unit/<?= $dbname ?>.png">
                                            <b></a>
                                        <?= $num ?>
                                        </b>
                                        <?php if ($dbname === 'unit_paladin'): ?>
                                            <?= $pala_name ?>
                                        <?php else: ?>
                                            <?= $cl_units->get_name($dbname) ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div>
                        <a
                            href="game.php?village=<?= $village['id'] ?>&amp;screen=train&mode=train"><?= __('screens.overview.recruit') ?></a>
                    </div>
                </div>
            </div>


            <div id="inline_popup" class="hidden" style="width:700px;">
                <div id="inline_popup_menu">
                    <span id="inline_popup_title"></span>
                    <a id="inline_popup_close" href="javascript:inlinePopupClose()">X</a>
                </div>
                <div id="inline_popup_main" style="height: auto;">
                    <div id="inline_popup_content"></div>
                </div>
            </div>

            <div id="unit_popup_template" style="display: none">
                <div class="inner-border main content-border" style="border: none; font-weight: normal">
                    <table style="float: left;width:450px">
                        <tr>
                            <td>
                                <p class="unit_desc"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                        </tr>
                    </table>
                    <img style="margin-top: 60px; max-width: 200px; display: none" id="unit_image"
                        src="graphic/map/empty.png" alt="" />
                </div>
            </div>
            <div id="show_group" class="vis moveable widget">
                <h4 class="head">
                    <img style="float: right; cursor: pointer;"
                        onclick="return VillageOverview.toggleWidget( 'show_group', this );" src="graphic/icons/minus.png">
                    <?= __('screens.overview.group') ?: 'Grupo' ?>
                </h4>
                <div class="widget_content" style="padding: 5px;">
                    <table class="vis" width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <strong><?= __('screens.overview.current_group') ?></strong> 
                                    <span><?= $group_name ? htmlspecialchars($group_name) : '<i>'.__('screens.overview.no_group').'</i>' ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <form action="game.php?village=<?= $village['id'] ?>&amp;screen=overview&amp;action=change_group" method="post" style="margin: 5px 0;">
                                        <select name="group_id" onchange="this.form.submit();" style="width: 100%;">
                                            <option value="0"><?= __('screens.overview.no_group_remove') ?></option>
                                            <?php foreach ($all_groups as $g): ?>
                                                <option value="<?= $g['id'] ?>" <?= ($village['group_id'] ?? 0) == $g['id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($g['name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">
                                    <a href="game.php?village=<?= $village['id'] ?>&amp;screen=groups_bar"><?= __('screens.overview.manage_groups') ?></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>



            <br />
            <style>
                .green-bar {
                    height: 5px;
                    background-color: green;
                }

                .yellow-bar {
                    height: 5px;
                    background-color: yellow;
                }

                .orange-bar {
                    height: 5px;
                    background-color: orange;
                }

                .red-bar {
                    height: 5px;
                    background-color: red;
                }
            </style>

            <?php
            $loyalty = (int)round($village['agreement'] ?? 100);
            if ($loyalty < 100):
            ?>
            <div id="show_agreement" class="vis moveable widget">
                <h4 class="head">
                    <img style="float: right; cursor: pointer;"
                        onclick="return VillageOverview.toggleWidget( 'show_agreement', this );"
                        src="graphic/icons/minus.png"> <?= __('screens.overview.morale') ?>
                </h4>
                <div class="widget_content" style="">
                    <table class="vis" width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <div id="pop" style="padding: 5px;">
                                        <div style="color: <?= $color ?>; font-weight: bold; text-align: center; margin-bottom: 5px;">
                                            <?= $loyalty ?> / <span style="color: green;">100</span>
                                        </div>
                                        <div style="background-color: #eee; width: 100%; height: 5px; border: 1px solid #ccc; border-radius: 2px; overflow: hidden;">
                                            <div class="<?= $color ?>-bar" style="width: <?= $loyalty ?>%;"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>


<?php if (($village['bonus'] ?? 0) == 0 && $premium): ?>
    <div id="show_b" class="vis moveable widget">
        <h4 class="head">
            <img style="float: right; cursor: pointer;" onclick="return VillageOverview.toggleWidget( 'show_b', this );"
                src="graphic/icons/minus.png"> <?= __('screens.overview.redeem_bonus') ?>
        </h4>
        <div class="widget_content" style="">
            <table class="vis" width="100%">
                <tbody>
                    <tr>

                        <?= __('screens.overview.buy_bonus_text') ?>:<center><a
                                href="game.php?village=<?= $village['id'] ?>&screen=codigos"><?= __('screens.overview.codes') ?></a>
                        </center>
                        <?php if ($user['premium_p'] >= 50): ?>
                            <form action="game.php?village=<?= $village['id'] ?>&screen=overview&akcja=bonus" method="post">
                                <td><?= __('screens.overview.premium_points') ?>: <b><?= $ilosc_sz ?></b></td>
                        <tr>
                            <td><b><?= __('screens.overview.bonus_cost') ?></b></td>
                        <tr>
                            <th><?= __('screens.overview.choose_bonus') ?></th>
                        <tr>
                            <td><input type="radio" name="bonus" value="1" checked="checked" />
                                <?= __('screens.overview.bonus_1') ?>
                        <tr>
                            <td><input type="radio" name="bonus" value="2" /> <?= __('screens.overview.bonus_2') ?>
                        <tr>
                            <td><input type="radio" name="bonus" value="3" /> <?= __('screens.overview.bonus_3') ?>
                        <tr>
                            <td><input type="radio" name="bonus" value="4" /> <?= __('screens.overview.bonus_4') ?>
                        <tr>
                            <td><input type="radio" name="bonus" value="5" /> <?= __('screens.overview.bonus_5') ?>
                        <tr>
                            <td><input type="radio" name="bonus" value="6" /> <?= __('screens.overview.bonus_6') ?>
                        <tr>
                            <td><input type="radio" name="bonus" value="7" /> <?= __('screens.overview.bonus_7') ?>
                        <tr>
                            <td><input type="radio" name="bonus" value="8" /> <?= __('screens.overview.bonus_8') ?>
                        <tr>
                            <td><input type="radio" name="bonus" value="9" /> <?= __('screens.overview.bonus_9') ?>
                        <tr>
                            <td>
                                <center><input type="submit" class="btn btn-build"
                                        value="<?= __('screens.overview.buy_bonus') ?>" /> </center>
                                </form>
                            <?php endif; ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> <?php endif; ?>

</table>
<script>
    $(function () { if (document.location.hash == "#bonus_1_dodany") UI.SuccessMessage("<?= __('screens.overview.bonus_success') ?>", 3000); });
    $(function () { if (document.location.hash == "#bonus_2_dodany") UI.SuccessMessage("<?= __('screens.overview.bonus_success') ?>", 3000); });
    $(function () { if (document.location.hash == "#bonus_3_dodany") UI.SuccessMessage("<?= __('screens.overview.bonus_success') ?>", 3000); });
    $(function () { if (document.location.hash == "#bonus_4_dodany") UI.SuccessMessage("<?= __('screens.overview.bonus_success') ?>", 3000); });
    $(function () { if (document.location.hash == "#bonus_5_dodany") UI.SuccessMessage("<?= __('screens.overview.bonus_success') ?>", 3000); });
    $(function () { if (document.location.hash == "#bonus_6_dodany") UI.SuccessMessage("<?= __('screens.overview.bonus_success') ?>", 3000); });
    $(function () { if (document.location.hash == "#bonus_7_dodany") UI.SuccessMessage("<?= __('screens.overview.bonus_success') ?>", 3000); });
    $(function () { if (document.location.hash == "#bonus_8_dodany") UI.SuccessMessage("<?= __('screens.overview.bonus_success') ?>", 3000); });
    $(function () { if (document.location.hash == "#bonus_9_dodany") UI.SuccessMessage("<?= __('screens.overview.bonus_success') ?>", 3000); });
    
    $(document).ready(function() {
        if (typeof VillageOverview !== 'undefined') {
            VillageOverview.init();
        }

        // Bind rich tooltips for active effects / religion / flag
        $('[id$="_trigger"]').each(function() {
            var triggerId = $(this).attr('id');
            var contentId = triggerId.replace('_trigger', '');
            var $content  = $('#' + contentId);
            if ($content.length) {
                UI.ToolTip($(this), {
                    bodyHandler: function() {
                        return $content.html();
                    }
                });
            }
        });
    });
</script>

<?php
$active_features_overview = [];
$now_time = time();
foreach (['wood_production', 'clay_production', 'iron_production'] as $col) {
    $expires = $user[$col . '_expires'] ?? 0;
    if ($expires && !is_numeric($expires)) {
        $expires = strtotime($expires);
    }
    if ($expires > $now_time) {
        $active_features_overview[$col] = [
            'expires' => $expires,
            'expires_formatted' => date('d M Y, H:i', $expires),
            'auto_renew' => !empty($user[$col . '_auto_renew'])
        ];
    }
}
?>
<script type="text/javascript">
    window.overviewActiveFeatures = <?= json_encode($active_features_overview) ?>;
    window.userPremiumPoints = <?= (int) ($ilosc_sz ?? 0) ?>;

    function openProdBonusModal(feature) {
        const featureInfo = {
            'wood': {
                'id': 'wood_production',
                'name': 'madeira',
                'title': '+20% na produção de madeira',
                'img': '/graphic/new/premium/WoodProduction_large.webp',
                'desc': 'Produza mais 20% de madeira!'
            },
            'clay': {
                'id': 'clay_production',
                'name': 'argila',
                'title': '+20% na produção de argila',
                'img': '/graphic/new/premium/StoneProduction_large.webp',
                'desc': 'Produza mais 20% de argila!'
            },
            'iron': {
                'id': 'iron_production',
                'name': 'ferro',
                'title': '+20% na produção de ferro',
                'img': '/graphic/new/premium/IronProduction_large.webp',
                'desc': 'Produza mais 20% de ferro!'
            }
        };

        const info = featureInfo[feature];
        if (!info) return;

        const activeInfo = window.overviewActiveFeatures[info.id];
        const isActive = !!activeInfo;

        // Populate modal values
        document.getElementById('pbm-title').textContent = info.title;
        document.getElementById('pbm-img').src = info.img;
        document.getElementById('pbm-desc').textContent = info.desc;
        document.getElementById('pbm-feature-id').value = info.id;

        // Checkmark state
        document.getElementById('pbm-check').style.display = isActive ? 'block' : 'none';

        // Expiry display
        const expiryDiv = document.getElementById('pbm-expiry-info');
        if (isActive) {
            expiryDiv.style.display = 'block';
            document.getElementById('pbm-expiry-date').textContent = activeInfo.expires_formatted;
            document.getElementById('pbm-auto-renew-checkbox').checked = activeInfo.auto_renew;
        } else {
            expiryDiv.style.display = 'none';
        }

        // Action button text
        const actBtn = document.getElementById('pbm-btn-activate');
        actBtn.textContent = isActive ? 'PROLONGAR AGORA' : 'ATIVAR AGORA';

        // Hide gift section on start
        document.getElementById('pbm-gift-section').style.display = 'none';
        document.getElementById('pbm-gift-recipient').value = '';
        document.getElementById('pbm-gift-message').style.display = 'none';

        // Update cost display
        updatePbmCost();

        // Show modal overlay
        document.getElementById('prodBonusModalOverlay').style.display = 'flex';
    }

    function closeProdBonusModal() {
        document.getElementById('prodBonusModalOverlay').style.display = 'none';
    }

    function updatePbmCost() {
        const durationSelect = document.getElementById('pbm-duration-select');
        const duration = parseInt(durationSelect.value);
        const cost = duration === 90 ? 450 : 150;
        document.getElementById('pbm-cost-value').textContent = cost;
    }

    function togglePbmGiftSection() {
        const section = document.getElementById('pbm-gift-section');
        section.style.display = section.style.display === 'none' ? 'block' : 'none';
    }

    function submitPbmActivation() {
        const featureId = document.getElementById('pbm-feature-id').value;
        const duration = parseInt(document.getElementById('pbm-duration-select').value);
        const cost = duration === 90 ? 450 : 150;

        if (window.userPremiumPoints < cost) {
            alert("Pontos Premium insuficientes!");
            return;
        }

        const btn = document.getElementById('pbm-btn-activate');
        const originalText = btn.textContent;
        btn.disabled = true;
        btn.textContent = 'A processar...';

        const formData = new FormData();
        formData.append('action', 'activate');
        formData.append('feature', featureId);
        formData.append('duration', duration);

        fetch('game.php?screen=premium', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            btn.disabled = false;
            btn.textContent = originalText;
            if (data.success) {
                alert(data.message);
                window.location.reload();
            } else {
                alert(data.message || 'Erro ao ativar a funcionalidade.');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.textContent = originalText;
            alert('Erro ao ligar ao servidor.');
            console.error(err);
        });
    }

    function togglePbmAutoRenew(checked) {
        const featureId = document.getElementById('pbm-feature-id').value;
        const formData = new FormData();
        formData.append('action', 'toggle_auto_renew');
        formData.append('feature', featureId);
        formData.append('enabled', checked ? '1' : '0');

        fetch('game.php?screen=premium', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) {
                alert(data.message || 'Erro ao alterar renovação automática.');
            }
        })
        .catch(err => {
            alert('Erro ao ligar ao servidor.');
            console.error(err);
        });
    }

    function submitPbmGift() {
        const featureId = document.getElementById('pbm-feature-id').value;
        const duration = parseInt(document.getElementById('pbm-duration-select').value);
        const recipient = document.getElementById('pbm-gift-recipient').value.trim();
        const msgDiv = document.getElementById('pbm-gift-message');

        if (!recipient) {
            msgDiv.style.color = 'red';
            msgDiv.textContent = 'Por favor, insere o nome do destinatário.';
            msgDiv.style.display = 'block';
            return;
        }

        msgDiv.style.color = '#8B4513';
        msgDiv.textContent = 'A processar...';
        msgDiv.style.display = 'block';

        const formData = new FormData();
        formData.append('action', 'gift_feature');
        formData.append('feature', featureId);
        formData.append('duration', duration);
        formData.append('recipient', recipient);

        fetch('game.php?screen=premium', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                msgDiv.style.color = 'green';
                msgDiv.textContent = data.message;
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                msgDiv.style.color = 'red';
                msgDiv.textContent = data.message || 'Erro ao enviar presente.';
            }
        })
        .catch(err => {
            msgDiv.style.color = 'red';
            msgDiv.textContent = 'Erro ao ligar ao servidor.';
            console.error(err);
        });
    }
</script>

<style type="text/css">
    #prodBonusModalOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 10000;
        display: none;
        justify-content: center;
        align-items: center;
    }
    .prod-bonus-card {
        background: #F4E4BC;
        border: 3px solid #8B4513;
        border-radius: 10px;
        width: 380px;
        box-sizing: border-box;
        padding: 20px;
        position: relative;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        text-align: left;
    }
    .prod-bonus-header {
        background: #8B4513;
        color: white;
        padding: 10px;
        text-align: center;
        border-radius: 5px;
        font-weight: bold;
        font-size: 15px;
        margin-bottom: 15px;
        margin-top: 10px;
    }
    .prod-bonus-close {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #8B4513;
        color: white;
        border: none;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 15px;
        line-height: 26px;
        text-align: center;
        font-weight: bold;
    }
    .prod-bonus-check {
        position: absolute;
        top: 45px;
        right: 20px;
        font-size: 48px;
        color: green;
        line-height: 1;
        font-weight: bold;
    }
    .prod-bonus-img {
        text-align: center;
        margin: 20px 0;
    }
    .prod-bonus-img img {
        width: 100px;
        height: 100px;
    }
    .prod-bonus-desc {
        font-size: 14px;
        font-weight: bold;
        color: #3e2723;
        margin-bottom: 10px;
        text-align: center;
    }
    .prod-bonus-bullets {
        margin: 10px 0;
        padding-left: 20px;
        font-size: 13px;
        color: #3e2723;
    }
    .prod-bonus-controls {
        margin: 20px 0 15px 0;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 13px;
        color: #3e2723;
    }
    .prod-bonus-controls select {
        padding: 4px;
        border: 1px solid #8B4513;
        background: #F4E4BC;
        color: #3e2723;
        font-weight: bold;
    }
    .prod-bonus-btn-activate {
        display: block;
        width: 100%;
        padding: 10px;
        background: #228B22;
        color: white;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        font-size: 14px;
        margin-bottom: 10px;
        transition: 0.2s;
        text-align: center;
    }
    .prod-bonus-btn-activate:hover {
        background: #006400;
    }
    .prod-bonus-auto-renew {
        background: #E7F3FF;
        border: 1px solid #2196F3;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 4px;
        font-size: 12px;
        color: #0d47a1;
    }
    .prod-bonus-btn-gift {
        display: block;
        width: 100%;
        padding: 8px;
        background: #8B4513;
        color: white;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        font-size: 13px;
        text-align: center;
    }
    .prod-bonus-btn-gift:hover {
        background: #5d330c;
    }
</style>

<div id="prodBonusModalOverlay" onclick="if(event.target===this) closeProdBonusModal();">
    <div class="prod-bonus-card">
        <button type="button" class="prod-bonus-close" onclick="closeProdBonusModal()">✕</button>
        
        <div id="pbm-check" class="prod-bonus-check" style="display: none;">✓</div>

        <div class="prod-bonus-header" id="pbm-title">+20% na produção de madeira</div>
        
        <div class="prod-bonus-img">
            <img id="pbm-img" src="/graphic/new/premium/WoodProduction_large.webp" alt="Resource">
        </div>

        <div class="prod-bonus-desc" id="pbm-desc">Produza mais 20% de madeira!</div>

        <ul class="prod-bonus-bullets">
            <li>Em todas as aldeias</li>
        </ul>

        <div class="prod-bonus-controls">
            <img src="/graphic/new/premium/time.png" style="vertical-align: middle;" alt="Duration" />
            <select id="pbm-duration-select" onchange="updatePbmCost()">
                <option value="90">90 dias</option>
                <option value="30">30 dias</option>
            </select>
            <img src="/graphic/new/premium/coinbag_15x15.png" style="vertical-align: middle;" alt="Coins" />
            <strong><span id="pbm-cost-value">450</span> pontos</strong>
        </div>

        <input type="hidden" id="pbm-feature-id" value="">

        <button type="button" class="prod-bonus-btn-activate" id="pbm-btn-activate" onclick="submitPbmActivation()">ATIVAR AGORA</button>

        <!-- Auto-renew & Expiry section -->
        <div id="pbm-expiry-info" class="prod-bonus-auto-renew" style="display: none;">
            <label style="cursor: pointer; display: block; font-weight: bold; margin-bottom: 5px;">
                <input type="checkbox" id="pbm-auto-renew-checkbox" onchange="togglePbmAutoRenew(this.checked)">
                Prolongar automaticamente
            </label>
            <small>Expira a <span id="pbm-expiry-date"></span></small>
        </div>

        <!-- Comprar como Presente section -->
        <button type="button" class="prod-bonus-btn-gift" onclick="togglePbmGiftSection()">COMPRAR COMO PRESENTE</button>
        
        <div id="pbm-gift-section" style="display: none; margin-top: 15px; border-top: 1px solid #8B4513; padding-top: 15px;">
            <div style="font-weight: bold; margin-bottom: 5px; font-size: 12px; color: #8B4513;">Comprar como presente:</div>
            <div style="display: flex; gap: 8px;">
                <input type="text" id="pbm-gift-recipient" placeholder="Nome do jogador" style="background: rgba(0,0,0,0.1); border: 1px solid #8B4513; padding: 5px; flex-grow: 1; border-radius: 4px; outline: none; font-size: 13px;">
                <button type="button" onclick="submitPbmGift()" style="background: #8B4513; color: white; border: none; padding: 5px 12px; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 12px;">Enviar</button>
            </div>
            <div id="pbm-gift-message" style="margin-top: 5px; font-size: 11px; font-weight: bold; display: none;"></div>
        </div>
    </div>
</div>

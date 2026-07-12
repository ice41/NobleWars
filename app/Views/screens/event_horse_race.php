<?php
$e = $eventData;
$energy = $e['energy'];
$distance = $e['distance'];
$trophies = $e['trophies'];

// Helper for time
$timeStr = sprintf("%02d:%02d:%02d", floor($timeToNext/3600), floor(($timeToNext%3600)/60), $timeToNext%60);
?>
<link rel="stylesheet" type="text/css" href="graphic/events/horse_race/event_horse_race.css">



<table  class="w-100 mb-20">
    <tr>
        <td valign="top"  class="p-10" style="width: 100px;">
            <div  style="border: 2px solid #7d510f; width: 90px; height: 90px; background: #0b3d22 url(;"graphic/events/horse_race/event_logo.webp') no-repeat center; background-size: cover; box-shadow: inset 0 0 10px #000;"></div>
        </td>
        
        <td valign="top"  class="p-10">
            <h2  style="margin-top: 0; position: relative;"><?= __('screens.event_horse_race.title') ?> <span  class="bold" style="position: absolute; right: 0; font-size: 12px;"><a href="#">? <?= __('screens.event_horse_race.help') ?></a></span></h2>
            <p><?= __('screens.event_horse_race.description') ?></p>
            <p><b><?= __('screens.event_horse_race.event_ends', ['date' => htmlspecialchars($overall_end_date_str ?? '')]) ?></b></p>
            
            <div  class="mt-15" style="display: flex; flex-direction: row; gap: 10px;">
                <div class="bordered-box event-status"  style="flex: 1; width: auto; float: none; margin: 0;">
                    <div class="status-title"><?= __('screens.event_horse_race.energy_label') ?></div>
                    <div class="status-value">
                        <img src="graphic/events/horse_race/icon_energy.webp"  class="v-align-middle"> <span id="hr-energy"><?= $energy ?></span> / 10
                        <a href="#" onclick="openBuyEnergy(); return false;" title="<?= __('screens.event_horse_race.add_energy_title') ?>"><img src="graphic/events/horse_race/premium_plus.webp"  class="v-align-middle" style="height: 10px; margin-left: 2px;"></a>
                    </div>
                </div>

                <div class="bordered-box event-status"  style="flex: 1; width: auto; float: none; margin: 0;">
                    <div class="status-title"><?= __('screens.event_horse_race.trophy_label') ?></div>
                    <div class="status-value">
                        <img src="graphic/events/horse_race/icon_currency.webp"  class="v-align-middle"> <span id="hr-trophies"><?= $trophies ?></span>
                    </div>
                </div>
            </div>
        </td>
        
        <td valign="top"  class="p-10" style="width: 220px;">
            <div class="shop-box-right">
                <h4><?= __('screens.event_horse_race.event_shop') ?></h4>
                <div  style="padding: 15px;">
                    <img src="graphic/events/horse_race/shop-chest.webp"  style="width: 110px;" alt="">
                    <a href="#" onclick="openHorseShop(); return false;" class="btn btn-green mt-15 p-5"  style="display: block;"><?= __('screens.event_horse_race.visit_shop') ?></a>
                </div>
            </div>
        </td>
    </tr>
</table>

<div class="event-options">
    <div class="options-row">
        <!-- Option 1 -->
        <div class="event-option option-1">
            <div class="event-option-header">
                <!-- No chance -->
            </div>
            <div class="event-option-content"></div>
            <div class="event-option-reward">
                <img src="graphic/events/horse_race/icon_distance.webp" class="icon"> <span class="reward">50</span>
                <img src="graphic/events/horse_race/icon_currency.webp" class="icon"> <span class="reward">0</span>
            </div>
            <div class="event-option-footer">
                <button class="btn btn-default" onclick="doRace(1)"><?= __('screens.event_horse_race.cheer') ?></button>
            </div>
        </div>
        <!-- Option 2 -->
        <div class="event-option option-2">
            <div class="event-option-header">
                <div class="event-option-chance"><div class="icon-dice"></div>25%</div>
            </div>
            <div class="event-option-content"></div>
            <div class="event-option-reward">
                <img src="graphic/events/horse_race/icon_distance.webp" class="icon"> <span class="reward">400</span>
                <img src="graphic/events/horse_race/icon_currency.webp" class="icon"> <span class="reward">10</span>
            </div>
            <div class="event-option-footer">
                <button class="btn btn-default" onclick="doRace(2)" id="btn-race-2"><?= __('screens.event_horse_race.cheer') ?></button><br>
                <button class="btn btn-default mt-5" onclick="openDoubleChance(2)"  style="font-size:10px; padding: 3px;"><img src="graphic/new/premium/coinbag_15x15.png"  style="height:12px;"> <?= __('screens.event_horse_race.double_chance') ?></button>
            </div>
        </div>
        <!-- Option 3 -->
        <div class="event-option option-3">
            <div class="event-option-header">
                <div class="event-option-chance"><div class="icon-dice"></div>10%</div>
            </div>
            <div class="event-option-content"></div>
            <div class="event-option-reward">
                <img src="graphic/events/horse_race/icon_distance.webp" class="icon"> <span class="reward">800</span>
                <img src="graphic/events/horse_race/icon_currency.webp" class="icon"> <span class="reward">17</span>
            </div>
            <div class="event-option-footer">
                <button class="btn btn-default" onclick="doRace(3)" id="btn-race-3"><?= __('screens.event_horse_race.cheer') ?></button><br>
                <button class="btn btn-default mt-5" onclick="openDoubleChance(3)"  style="font-size:10px; padding: 3px;"><img src="graphic/new/premium/coinbag_15x15.png"  style="height:12px;"> <?= __('screens.event_horse_race.double_chance') ?></button>
            </div>
        </div>
        <!-- Option 4 -->
        <div class="event-option option-4">
            <div class="event-option-header">
                <div class="event-option-chance"><div class="icon-dice"></div>5%</div>
            </div>
            <div class="event-option-content"></div>
            <div class="event-option-reward">
                <img src="graphic/events/horse_race/icon_distance.webp" class="icon"> <span class="reward">2975</span>
                <img src="graphic/events/horse_race/icon_currency.webp" class="icon"> <span class="reward">25</span>
            </div>
            <div class="event-option-footer">
                <button class="btn btn-default" onclick="doRace(4)" id="btn-race-4"><?= __('screens.event_horse_race.cheer') ?></button><br>
                <button class="btn btn-default mt-5" onclick="openDoubleChance(4)"  style="font-size:10px; padding: 3px;"><img src="graphic/new/premium/coinbag_15x15.png"  style="height:12px;"> <?= __('screens.event_horse_race.double_chance') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="horse-race-event">
    <div class="event-horse-race-timer">
        <span class="label"><?= __('screens.event_horse_race.race_ends_in') ?></span>
        <span class="timer-content" id="race-countdown"><?= htmlspecialchars($end_date_str ?? '') ?></span>
    </div>

    <div class="event-horse-race-status">
        <div class="event-horse-race-group player-group">
            <div class="title"><?= $team == 1 ? __('screens.event_horse_race.team_red') : __('screens.event_horse_race.team_blue') ?></div>
        </div>
        <div class="event-horse-race-stadium">
            <div class="event-horse-race-laps">
                <div class="banner player-group">
                    <div class="content">
                        <p><?= __('screens.event_horse_race.distance') ?>:</p>
                        <p class="distance" id="hr-distance-lap"><?= $distance ?></p>
                        <p><?= __('screens.event_horse_race.laps') ?>:</p>
                        <p class="laps" id="hr-laps"><?= floor($distance / 100000) ?></p>
                    </div>
                </div>
                <div class="banner enemy-group">
                    <div class="content">
                        <p><?= __('screens.event_horse_race.distance') ?>:</p>
                        <p class="distance" id="hr-enemy-distance"><?= $enemyDistance ?></p>
                        <p><?= __('screens.event_horse_race.laps') ?>:</p>
                        <p class="laps" id="hr-enemy-laps"><?= floor($enemyDistance / 100000) ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="event-horse-race-group enemy-group">
            <div class="title"><?= $team == 1 ? __('screens.event_horse_race.team_blue') : __('screens.event_horse_race.team_red') ?></div>
        </div>
        <!-- Meeples as direct children of the status container for absolute centering -->
        <div class="horse-meeple" id="horse-meeple"  style="display:block;"></div>
        <div class="horse-meeple" id="horse-meeple-enemy"  style="display:block;"></div>
    </div>
</div>

<div  class="mt-20" style="display:flex; justify-content:space-between; gap:20px;">
    <div  style="width:50%;">
        <table class="vis w-100 text-center" >
            <tr><th colspan="4"  class="text-center"><img src="graphic/events/horse_race/icon_currency.webp"  style="height:16px; vertical-align:-3px;"> <?= __('screens.event_horse_race.top_mvp') ?></th></tr>
            <tr><th  class="text-center">#</th><th  class="text-center"><?= __('screens.event_horse_race.col_name') ?></th><th  class="text-center"><?= __('screens.event_horse_race.col_distance') ?></th><th  class="text-center"><?= __('screens.event_horse_race.col_reward') ?></th></tr>
                        <?php foreach($topPlayers as $i => $p): ?>
            <tr <?= $i % 2 == 1 ? 'class="row_a"' : '' ?>>
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($p['name']) ?></td>
                <td><?= $p['distance'] ?></td>
                <td><img src="graphic/events/horse_race/icon_currency.webp"  style="height:12px;"> <?= $p['trophies'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div  style="width:50%;">
        <table class="vis w-100 text-center" >
            <tr><th colspan="4"  class="text-center"><img src="graphic/events/horse_race/icon_currency.webp"  style="height:16px; vertical-align:-3px;"> <?= __('screens.event_horse_race.top_unlucky') ?></th></tr>
            <tr><th  class="text-center">#</th><th  class="text-center"><?= __('screens.event_horse_race.col_name') ?></th><th  class="text-center"><?= __('screens.event_horse_race.col_distance_lost') ?></th><th  class="text-center"><?= __('screens.event_horse_race.col_reward') ?></th></tr>
                        <?php foreach($bottomPlayers as $i => $p): ?>
            <tr <?= $i % 2 == 1 ? 'class="row_a"' : '' ?>>
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($p['name']) ?></td>
                <td><?= $p['lost_distance'] ?></td>
                <td><img src="graphic/events/horse_race/icon_currency.webp"  style="height:12px;"> <?= $p['trophies'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<!-- Shop Modal -->
<div id="horse-shop-modal"  style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background:#e3d5b8; border:2px solid #8c5f0d; padding:20px; z-index:1000; width:800px; max-height:80vh; overflow-y:auto;">
    <div  class="text-right mb-10">
        <button class="btn" onclick="$('#horse-shop-overlay, #horse-shop-modal').hide();"><?= __('screens.event_horse_race.close') ?></button>
    </div>
    <div id="horse-shop-content"><?= __('screens.event_horse_race.loading') ?></div>
</div>
<div id="horse-shop-overlay"  class="w-100" style="display:none; position:fixed; top:0; left:0; height:100%; background:rgba(0,0,0,0.7); z-index:999;" onclick="$('#horse-shop-overlay, #horse-shop-modal').hide();"></div>

<!-- Modal Dupla Oportunidade -->
<div id="double-chance-modal"  class="text-center" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); background:#e3d5b8; border:3px solid #7d510f; padding:25px; z-index:1001; width:380px; box-shadow: 0 5px 20px rgba(0,0,0,0.5);">
    <h3  style="margin-top:0; color:#5a3200;"><?= __('screens.event_horse_race.double_chance') ?></h3>
    <p><?= __('screens.event_horse_race.double_chance_confirm') ?></p>
    <div  style="margin: 15px 0;">
        <img src="graphic/new/premium/coinbag_15x15.png"  class="v-align-middle" style="height:20px;"> <strong>10 <?= __('screens.event_horse_race.premium_points') ?></strong>
    </div>
    <div  class="mt-15" style="display:flex; gap:10px; justify-content:center;">
        <button class="btn btn-green" id="btn-confirm-double" onclick="confirmDoubleChance()"><?= __('screens.event_horse_race.confirm') ?></button>
        <button class="btn" onclick="$('#double-chance-overlay,#double-chance-modal').hide();"><?= __('screens.event_horse_race.cancel') ?></button>
    </div>
</div>
<div id="double-chance-overlay"  class="w-100" style="display:none; position:fixed; top:0; left:0; height:100%; background:rgba(0,0,0,0.6); z-index:1000;" onclick="$('#double-chance-overlay,#double-chance-modal').hide();"></div>

<!-- Modal Comprar Palha Premium -->
<div id="buy-energy-modal"  class="text-center" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); background:#e3d5b8; border:3px solid #7d510f; padding:25px; z-index:1001; width:380px; box-shadow: 0 5px 20px rgba(0,0,0,0.5);">
    <h3  style="margin-top:0; color:#5a3200;"><?= __('screens.event_horse_race.add_energy') ?></h3>
    <p><?= __('screens.event_horse_race.add_energy_confirm') ?></p>
    <div  style="margin: 15px 0;">
        <img src="graphic/events/horse_race/icon_energy.webp"  class="v-align-middle" style="height:20px;"> <strong>+5 <?= __('screens.event_horse_race.energy_label') ?></strong>
        &nbsp;&nbsp;
        <img src="graphic/new/premium/coinbag_15x15.png"  class="v-align-middle" style="height:20px;"> <strong>5 <?= __('screens.event_horse_race.premium_points') ?></strong>
    </div>
    <div  class="mt-15" style="display:flex; gap:10px; justify-content:center;">
        <button class="btn btn-green" onclick="confirmBuyEnergy()"><?= __('screens.event_horse_race.confirm') ?></button>
        <button class="btn" onclick="$('#buy-energy-overlay,#buy-energy-modal').hide();"><?= __('screens.event_horse_race.cancel') ?></button>
    </div>
</div>
<div id="buy-energy-overlay"  class="w-100" style="display:none; position:fixed; top:0; left:0; height:100%; background:rgba(0,0,0,0.6); z-index:1000;" onclick="$('#buy-energy-overlay,#buy-energy-modal').hide();"></div>

<script>
var villageId      = <?= (int)($village['id'] ?? 0) ?>;
var playerDistance = <?= (int)($distance ?? 0) ?>;
var enemyDistance  = <?= (int)($enemyDistance ?? 0) ?>;
var endTimestamp   = <?= (int)($endTimestamp ?? 0) ?>;
var doubleChanceOpt = 0;
var msgFinished    = <?= json_encode(__('screens.event_horse_race.finished')) ?>;
var msgError       = <?= json_encode(__('screens.event_horse_race.error')) ?>;
var msgAddedEnergy = <?= json_encode(__('screens.event_horse_race.added_energy')) ?>;
var msgLoadingShop = <?= json_encode(__('screens.event_horse_race.loading_shop')) ?>;

// ─── Countdown timer ───────────────────────────────────────────────────────
(function raceCountdown() {
    var el = document.getElementById('race-countdown');
    if (!el || !endTimestamp) return;
    function tick() {
        var now  = Math.floor(Date.now() / 1000);
        var diff = endTimestamp - now;
        if (diff <= 0) { el.textContent = msgFinished; return; }
        var d = Math.floor(diff / 86400);
        var h = Math.floor((diff % 86400) / 3600);
        var m = Math.floor((diff % 3600)  / 60);
        var s = diff % 60;
        el.textContent = (d > 0 ? d + 'd ' : '') +
            String(h).padStart(2,'0') + ':' +
            String(m).padStart(2,'0') + ':' +
            String(s).padStart(2,'0');
        setTimeout(tick, 1000);
    }
    tick();
})();

// ─── Oval track waypoints ──────────────────────────────────────────────────
var trackPath = [
    { x: 220, y: 50 },  // 0
    { x: 260, y: 50 },  // 1
    { x: 300, y: 50 },  // 2
    { x: 380, y: 50 },  // 3
    { x: 440, y: 90 },  // 4
    { x: 465, y: 150 }, // 5
    { x: 440, y: 210 }, // 6
    { x: 380, y: 250 }, // 7
    { x: 300, y: 250 }, // 8
    { x: 210, y: 250 }, // 9
    { x: 120, y: 250 }, // 10
    { x:  60, y: 210 }, // 11
    { x:  35, y: 150 }, // 12
    { x:  60, y: 90 },  // 13
    { x: 120, y: 50 },  // 14
    { x: 180, y: 50 },  // 15
    { x: 220, y: 50 },  // 16
];

var segLengths = [];
var totalLength = 0;
for (var i = 0; i < trackPath.length - 1; i++) {
    var dx = trackPath[i+1].x - trackPath[i].x;
    var dy = trackPath[i+1].y - trackPath[i].y;
    var len = Math.sqrt(dx*dx + dy*dy);
    segLengths.push(len);
    totalLength += len;
}

var DIST_PER_LAP = 100000;

function getMeeplePos(dist) {
    var lapFrac  = (dist % DIST_PER_LAP) / DIST_PER_LAP;
    var target   = lapFrac * totalLength;
    var acc = 0;
    for (var i = 0; i < segLengths.length; i++) {
        if (acc + segLengths[i] >= target) {
            var t = (target - acc) / segLengths[i];
            return {
                x: trackPath[i].x + t * (trackPath[i+1].x - trackPath[i].x),
                y: trackPath[i].y + t * (trackPath[i+1].y - trackPath[i].y)
            };
        }
        acc += segLengths[i];
    }
    return trackPath[0];
}

var displayedPlayerDistance = playerDistance;
var displayedEnemyDistance = enemyDistance;
var playerAnimTimer = null;
var enemyAnimTimer = null;

function animateMeeple(isPlayer, startDist, endDist, duration) {
    var startTime = Date.now();
    var timer = setInterval(function() {
        var elapsed = Date.now() - startTime;
        var t = Math.min(elapsed / duration, 1);
        var easeT = t * (2 - t);
        var currentDist = startDist + (endDist - startDist) * easeT;
        var containerWidth = $('.event-horse-race-status').width() || 860;
        var trackWidth = 500;
        var leftOffset = (containerWidth - trackWidth) / 2;
        if (leftOffset < 0) leftOffset = 0;
        var pos = getMeeplePos(currentDist);
        if (isPlayer) {
            displayedPlayerDistance = currentDist;
            $('#horse-meeple').css({ left: (leftOffset + pos.x - 15) + 'px', top: (pos.y - 15) + 'px', bottom: 'auto' });
        } else {
            displayedEnemyDistance = currentDist;
            $('#horse-meeple-enemy').css({ left: (leftOffset + pos.x - 15) + 'px', top: (pos.y - 20) + 'px', bottom: 'auto' });
        }
        if (t >= 1) { clearInterval(timer); }
    }, 20);
    return timer;
}

function updateMeeples(pDist, eDist, animate) {
    if (playerAnimTimer) clearInterval(playerAnimTimer);
    if (enemyAnimTimer) clearInterval(enemyAnimTimer);
    if (animate) {
        playerAnimTimer = animateMeeple(true, displayedPlayerDistance, pDist, 1200);
        enemyAnimTimer = animateMeeple(false, displayedEnemyDistance, eDist, 1200);
    } else {
        displayedPlayerDistance = pDist;
        displayedEnemyDistance = eDist;
        var pPos = getMeeplePos(pDist);
        var ePos = getMeeplePos(eDist);
        var containerWidth = $('.event-horse-race-status').width() || 860;
        var trackWidth = 500;
        var leftOffset = (containerWidth - trackWidth) / 2;
        if (leftOffset < 0) leftOffset = 0;
        $('#horse-meeple').css({ left: (leftOffset + pPos.x - 15) + 'px', top: (pPos.y - 15) + 'px', bottom: 'auto' });
        $('#horse-meeple-enemy').css({ left: (leftOffset + ePos.x - 15) + 'px', top: (ePos.y - 20) + 'px', bottom: 'auto' });
    }
}

updateMeeples(playerDistance, enemyDistance, false);

$(window).on('resize', function() {
    updateMeeples(playerDistance, enemyDistance, false);
});

// ─── Aplaudir / Cheer ──────────────────────────────────────────────────────
function doRace(opt, isDouble) {
    isDouble = isDouble || false;
    $.post(
        '/game.php?village=' + villageId + '&screen=event_horse_race&ajax_action=race',
        { type: opt, double: isDouble ? 1 : 0 },
        function(res) {
            if (res.success) {
                $('#hr-energy').text(res.new_energy);
                $('#hr-distance-lap').text(res.new_distance);
                $('#hr-laps').text(Math.floor(res.new_distance / 100000));
                $('#hr-trophies').text(res.new_trophies);
                playerDistance = res.new_distance;
                updateMeeples(playerDistance, enemyDistance, true);
                if (res.message) UI.SuccessMessage(res.message);
            } else {
                UI.ErrorMessage(res.error || msgError);
            }
        },
        'json'
    );
}

// ─── Double Chance ─────────────────────────────────────────────────────────
function openDoubleChance(opt) {
    doubleChanceOpt = opt;
    $('#double-chance-overlay, #double-chance-modal').show();
}
function confirmDoubleChance() {
    $('#double-chance-overlay, #double-chance-modal').hide();
    $.post(
        '/game.php?village=' + villageId + '&screen=event_horse_race&ajax_action=race',
        { type: doubleChanceOpt, double: 1 },
        function(res) {
            if (res.success) {
                $('#hr-energy').text(res.new_energy);
                $('#hr-distance-lap').text(res.new_distance);
                $('#hr-laps').text(Math.floor(res.new_distance / 100000));
                $('#hr-trophies').text(res.new_trophies);
                playerDistance = res.new_distance;
                updateMeeples(playerDistance, enemyDistance, true);
                if (res.message) UI.SuccessMessage(res.message);
            } else {
                UI.ErrorMessage(res.error || msgError);
            }
        },
        'json'
    );
}

// ─── Buy Energy (premium) ──────────────────────────────────────────────────
function openBuyEnergy() {
    $('#buy-energy-overlay, #buy-energy-modal').show();
}
function confirmBuyEnergy() {
    $('#buy-energy-overlay, #buy-energy-modal').hide();
    $.post(
        '/game.php?village=' + villageId + '&screen=event_horse_race&ajax_action=buy_energy',
        {},
        function(res) {
            if (res.success) {
                $('#hr-energy').text(res.new_energy);
                UI.SuccessMessage(msgAddedEnergy);
            } else {
                UI.ErrorMessage(res.error || msgError);
            }
        },
        'json'
    );
}

// ─── Event Shop ────────────────────────────────────────────────────────────
function openHorseShop() {
    $('#horse-shop-overlay, #horse-shop-modal').show();
    $('#horse-shop-content').html(msgLoadingShop);
    $.get('/game.php?village=' + villageId + '&screen=event_horse_race_shop&ajax=shop_html', function(html) {
        $('#horse-shop-content').html(html);
    });
}
</script>

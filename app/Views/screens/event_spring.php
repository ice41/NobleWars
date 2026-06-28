<?php
/**
 * View for the "Spring Festival" event
 * Grid of 20 locked boxes - player opens one per day with their daily point
 */
?>
<style>
    .spring-event-wrapper {
        position: relative;
        font-family: Verdana, Arial, Helvetica, sans-serif;
        min-height: 700px;
        min-width: 1000px;
        padding: 0;
        overflow: hidden;
    }

    .spring-bg-base {
        position: absolute;
        inset: 0;
        background: url('/graphic/events/festival_de_primavera/background.webp') no-repeat center top;
        background-size: cover;
        z-index: 0;
    }

    .spring-bg-scenery {
        position: absolute;
        inset: 0;
        background: url('/graphic/events/festival_de_primavera/background_scenery.webp') no-repeat center bottom;
        background-size: 100% auto;
        z-index: 1;
        pointer-events: none;
    }

    .spring-content {
        position: relative;
        z-index: 2;
        width: 1000px;
        height: 860px;
        margin: 0 auto;
    }

    .spring-logo {
        position: absolute;
        top: 10px;
        left: 10px;
        width: 100px;
        height: 100px;
        z-index: 20;
    }

    .spring-cycle-time {
        position: absolute;
        top: 2px;
        right: 55px;
        color: #f5e1bc;
        font-size: 16px;
        font-weight: bold;
        z-index: 20;
    }

    .spring-event-help {
        position: absolute;
        top: 7px;
        right: 7px;
        width: 32px;
        height: 32px;
        z-index: 20;
    }

    .spring-header {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 700px;
        z-index: 5;
    }

    .spring-header img.banner {
        width: 100%;
        display: block;
    }

    .spring-header-title {
        position: absolute;
        top: 25px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 26px;
        font-weight: bold;
        color: #fff;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8), -1px -1px 0 #2d5a1b, 1px -1px 0 #2d5a1b, -1px 1px 0 #2d5a1b, 1px 1px 0 #2d5a1b;
        letter-spacing: 1px;
        pointer-events: none;
    }

    .spring-counters {
        position: absolute;
        bottom: 45px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        justify-content: center;
        gap: 8px;
        width: 70%;
        pointer-events: none;
    }

    .spring-counter {
        flex: 1;
        text-align: center;
        color: #5a3a0a;
        font-weight: bold;
        font-size: 12px;
        padding: 2px 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        white-space: nowrap;
        overflow: hidden;
        pointer-events: all;
    }

    .spring-counter img {
        height: 18px;
        flex-shrink: 0;
    }

    /* Background gifts panel - gift-container-bg: w518 h648 top164 left358 */
    .spring-grid-bg {
        width: 518px;
        height: 648px;
        position: absolute;
        top: 164px;
        left: 358px;
        z-index: 10;
        pointer-events: none;
    }

    .spring-grid-bg img {
        width: 100%;
        height: 100%;
    }

    /* Gift items grid - gift-container-gifts: w497 h616 top196 left370 */
    .spring-grid {
        width: 497px;
        height: 616px;
        position: absolute;
        top: 196px;
        left: 370px;
        z-index: 15;
        overflow: hidden;
    }

    /* Each slot - gift-item-container: w124 h123 p8 float:left */
    .spring-box {
        width: 124px;
        height: 123px;
        padding: 8px;
        float: left;
        position: relative;
        cursor: pointer;
        box-sizing: border-box;
    }

    .spring-box.no-points {
        cursor: not-allowed;
    }

    .spring-box.opened {
        cursor: default;
    }

    /* Door image - gift-event-door: absolute left:8 top:10, fills remaining area */
    .spring-box img.box-bg {
        position: absolute;
        left: 8px;
        top: 10px;
        width: 108px;
        height: 103px;
        object-fit: fill;
        transition: filter 0.15s;
    }

    .spring-box:hover:not(.opened):not(.no-points) img.box-bg {
        filter: brightness(1.15);
    }

    .spring-box.opened img.box-bg {
        opacity: 0.4;
    }

    /* Reward reveal overlay */
    .spring-box-reveal {
        position: absolute;
        left: 8px;
        top: 10px;
        width: 108px;
        height: 103px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        font-size: 10px;
        font-weight: bold;
        padding: 4px;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        box-sizing: border-box;
    }

    .spring-box-reveal img {
        height: 32px;
        margin-bottom: 3px;
    }

    /* Points bottom-right */
    .spring-bottom-bar {
        position: absolute;
        bottom: 10px;
        right: 13px;
        z-index: 20;
    }

    .spring-points-display {
        background: rgba(255, 240, 200, 0.92);
        border: 2px solid #c8a050;
        border-radius: 5px;
        padding: 6px 15px;
        font-weight: bold;
        font-size: 14px;
        color: #402a0a;
    }

    /* Messages over grid */
    .spring-msg-container {
        position: absolute;
        top: 164px;
        left: 370px;
        width: 497px;
        z-index: 30;
    }

    .spring-msg {
        margin-bottom: 10px;
        padding: 8px 12px;
        border-radius: 4px;
        font-weight: bold;
        font-size: 13px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
    }

    .spring-msg.success {
        background: #e0ffe0;
        border: 1px solid #27ae60;
        color: #1a7a40;
    }

    .spring-msg.error {
        background: #ffe0e0;
        border: 1px solid #c0392b;
        color: #922b21;
    }

    /* Reset button */
    .spring-reset-container {
        position: absolute;
        bottom: 8px;
        right: 8px;
        width: 240px;
        height: 115px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .spring-btn-reset {
        background: linear-gradient(to bottom, #c0392b, #922b21);
        border: 1px solid #7b241c;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
        transition: transform 0.1s;
    }

    .spring-btn-reset:hover {
        transform: scale(1.05);
    }

    /* Confirmation modal */
    #spring-confirm-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.65);
        z-index: 10000;
        align-items: center;
        justify-content: center;
    }

    #spring-confirm-modal {
        background: #f4e4bc;
        border: 4px solid #c8a050;
        border-radius: 8px;
        padding: 25px 30px;
        min-width: 320px;
        text-align: center;
        box-shadow: 0 5px 30px rgba(0, 0, 0, 0.5);
    }

    #spring-confirm-modal h3 {
        margin: 0 0 10px 0;
        color: #402a0a;
        font-size: 18px;
    }

    #spring-confirm-modal p {
        color: #5a3a10;
        margin-bottom: 20px;
    }

    .spring-modal-btns {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .spring-btn-confirm {
        background: linear-gradient(to bottom, #27ae60, #1e8449);
        border: 1px solid #145a32;
        color: white;
        padding: 8px 25px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
    }

    .spring-btn-cancel {
        background: linear-gradient(to bottom, #7f8c8d, #636e72);
        border: 1px solid #454d4f;
        color: white;
        padding: 8px 25px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }
</style>

<div class="spring-event-wrapper">
    <div class="spring-bg-base"></div>
    <div class="spring-bg-scenery"></div>
    <div class="spring-content">

        <!-- Logo top left -->
        <img class="spring-logo" src="/graphic/events/festival_de_primavera/logo.webp" alt="Logo">

        <!-- Timer top right -->
        <div class="spring-cycle-time" id="spring-countdown">
            00:00:00
        </div>

        <!-- Help top right -->
        <div class="spring-event-help">
            <a href="#"><img src="/graphic/events/festival_de_primavera/help.webp"
                    onerror="this.src='/graphic/icons/questionmark.png'" alt="?" style="width:32px; height:32px;"></a>
        </div>

        <!-- Header with counters overlaid on banner scroll slots -->
        <div class="spring-header">
            <img src="/graphic/events/festival_de_primavera/banner.webp" alt="<?= __('screens.event_spring.title') ?>" class="banner">

            <div class="spring-header-title">
                <?= __('screens.event_spring.title') ?>
            </div>

            <!-- Counters overlaid on scroll slots -->
            <div class="spring-counters">
                <div class="spring-counter">
                    <img src="/graphic/events/festival_de_primavera/item_4003.webp" alt="">
                    <?= $points ?> <?= $points != 1 ? __('screens.event_spring.points_plural') : __('screens.event_spring.point_singular') ?>
                </div>
                <div class="spring-counter">
                    <img src="/graphic/events/festival_de_primavera/item_4002.webp" alt="">
                    <?= count($opened_boxes) ?>/<?= $total_boxes ?>
                </div>
                <div class="spring-counter" style="position: relative; right: 13px;">
                    <img src="/graphic/events/festival_de_primavera/item_4004.webp" alt="">
                    <div
                        style="display: flex; flex-direction: column; align-items: center; line-height: 1.1; margin-top: 2px;">
                        <span><?= date('d.m.Y', strtotime($end_date_str)) ?></span>
                        <span><?= date('H:i', strtotime($end_date_str)) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="spring-msg-container">
            <?php if (isset($_GET['success'])): ?>
                <?php if ($_GET['success'] === 'box_opened' && $last_reward): ?>
                    <div class="spring-msg success">
                        🎁 <?= __('screens.event_spring.msg_box_opened', ['reward' => htmlspecialchars($last_reward['label'])]) ?>
                    </div>
                <?php elseif ($_GET['success'] === 'board_reset'): ?>
                    <div class="spring-msg success">
                        ✨ <?= __('screens.event_spring.msg_board_reset') ?>
                    </div>
                <?php elseif ($_GET['success'] === 'board_auto_reset'): ?>
                    <div class="spring-msg success">
                        ✨ <?= __('screens.event_spring.msg_board_auto_reset') ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="spring-msg error">
                    <?php
                    $errs = [
                        'no_points'     => __('screens.event_spring.err_no_points'),
                        'already_opened'=> __('screens.event_spring.err_already_opened'),
                        'no_premium'    => __('screens.event_spring.err_no_premium'),
                    ];
                    echo $errs[$_GET['error']] ?? __('screens.event_spring.err_generic');
                    ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Gift panel background image -->
        <div class="spring-grid-bg">
            <img src="/graphic/events/festival_de_primavera/background_gifts.webp" alt="">
        </div>

        <!-- Gift boxes grid -->
        <div class="spring-grid">
            <?php foreach (range(1, $total_boxes) as $boxId):
                $isOpened = in_array($boxId, $opened_boxes);
                $canOpen = !$isOpened && $points > 0;
                $boxClass = $isOpened ? 'opened' : ($points <= 0 ? 'no-points' : '');
                ?>
                <div class="spring-box <?= $boxClass ?>" id="spring-box-<?= $boxId ?>" <?php if ($canOpen): ?>onclick="confirmOpenBox(<?= $boxId ?>)" <?php endif; ?>>
                    <img class="box-bg" src="/graphic/events/festival_de_primavera/close.webp" alt="">
                    <?php if ($isOpened): ?>
                        <div class="spring-box-reveal">
                            <img src="/graphic/new/inventory/<?= $boxes[$boxId]['img'] ?>" alt="" style="width: 48px; height: 48px; margin-bottom: 5px;">
                            <?= htmlspecialchars($boxes[$boxId]['label']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <!-- Reset Button in empty space -->
            <div class="spring-reset-container">
                <form method="POST" action="game.php?village=<?= $village['id'] ?>&screen=event_spring">
                    <button type="submit" name="reset_board" class="spring-btn-reset">
                        <?= __('screens.event_spring.reset_btn') ?> <img src="/graphic/events/festival_de_primavera/coinbag_18x18.webp" alt="PP"
                            style="height:14px">)
                    </button>
                </form>
            </div>
        </div>

        <!-- Points display bottom-right -->
        <div class="spring-bottom-bar">
            <div class="spring-points-display" style="display: flex; flex-direction: column; align-items: center; gap: 4px; padding: 6px 12px;">
                <div>🌸 <?= $points ?> <?= $points != 1 ? __('screens.event_spring.points_available_plural') : __('screens.event_spring.point_available_singular') ?></div>
                <div style="font-size: 11px; font-weight: normal; color: #5a3a10; white-space: nowrap;"><?= __('screens.event_spring.next_point_in') ?>: <strong id="spring-point-timer">00:00</strong></div>
            </div>
        </div>

    </div><!-- end spring-content -->
</div>

<!-- Confirmation Modal -->
<div id="spring-confirm-overlay" onclick="closeSpringConfirm()">
    <div id="spring-confirm-modal" onclick="event.stopPropagation()">
        <h3>🌸 <?= __('screens.event_spring.modal_title') ?></h3>
        <p id="spring-confirm-text"><?= __('screens.event_spring.modal_text') ?></p>
        <form id="spring-open-form" method="POST" action="game.php?village=<?= $village['id'] ?>&screen=event_spring">
            <input type="hidden" name="open_box" id="spring-box-input" value="">
            <div class="spring-modal-btns">
                <button type="submit" class="spring-btn-confirm">✓ <?= __('screens.event_spring.btn_open') ?></button>
                <button type="button" class="spring-btn-cancel" onclick="closeSpringConfirm()">✗ <?= __('screens.event_spring.btn_cancel') ?></button>
            </div>
        </form>
    </div>
</div>

<script>
    function confirmOpenBox(boxId) {
        document.getElementById('spring-box-input').value = boxId;
        document.getElementById('spring-confirm-overlay').style.display = 'flex';
    }

    function closeSpringConfirm() {
        document.getElementById('spring-confirm-overlay').style.display = 'none';
    }

    // Countdown Timer Logic
    const endTime = <?= strtotime($end_date_str) * 1000 ?>;
    const countdownEl = document.getElementById('spring-countdown');

    function updateSpringCountdown() {
        const now = new Date().getTime();
        const diff = endTime - now;

        if (diff <= 0) {
            countdownEl.innerHTML = "00:00:00";
            return;
        }

        const h = Math.floor(diff / (1000 * 60 * 60));
        const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const s = Math.floor((diff % (1000 * 60)) / 1000);

        countdownEl.innerHTML =
            String(h).padStart(2, '0') + ':' +
            String(m).padStart(2, '0') + ':' +
            String(s).padStart(2, '0');
    }

    setInterval(updateSpringCountdown, 1000);
    updateSpringCountdown();

    // Next Point Countdown Logic
    let nextPointSec = <?= (int)$next_point_seconds ?>;
    const pointTimerEl = document.getElementById('spring-point-timer');

    function updatePointCountdown() {
        if (nextPointSec <= 0) {
            window.location.reload();
            return;
        }

        const m = Math.floor(nextPointSec / 60);
        const s = nextPointSec % 60;

        if (pointTimerEl) {
            pointTimerEl.innerHTML = String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
        }
        nextPointSec--;
    }

    if (pointTimerEl) {
        setInterval(updatePointCountdown, 1000);
        updatePointCountdown();
    }
</script>
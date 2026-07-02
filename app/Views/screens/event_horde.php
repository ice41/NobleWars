<?php
/**
 * View for the "Ataque da Horda" event
 * Includes the selection modal for units
 */
?>
<style>
    .event-horde-container {
        background-color: #f4e4bc;
        padding: 20px;
        border: 1px solid #7d510f;
        font-family: Verdana, Arial, Helvetica, sans-serif;
        color: #402a0a;
        min-height: 800px;
        position: relative;
    }

    .event-header-top {
        margin-bottom: 20px;
        overflow: hidden;
    }


    .shop-box-right {
        float: right;
        width: 180px;
        border: 2px solid #7d510f;
        background-color: #fcf6e4;
        border-radius: 10px;
        overflow: hidden;
        text-align: center;
        margin-left: 20px;
    }

    .shop-box-right h4 {
        background: linear-gradient(to bottom, #9d6c3c, #7d510f);
        color: white;
        margin: 0;
        padding: 8px;
        font-size: 14px;
    }

    .horde-battle-area {
        clear: both;
        position: relative;
        border: 4px solid transparent;
        border-image: url("graphic/events/ataque_horda/border.webp") 5 fill repeat;
        height: 600px;
        background: url("graphic/events/ataque_horda/background.webp") no-repeat center center;
        background-size: cover;
        margin-top: 20px;
        padding: 0;
    }

    .horde-slots-container-abs {
        position: absolute;
        bottom: 80px;
        left: 0;
        right: 0;
        padding: 0 10px;
    }

    .horde-slots-table {
        width: 100%;
        border-spacing: 10px;
        table-layout: fixed;
    }

    .horde-unit-slot {
        background-color: #f4e4bc;
        border: 1px solid #7d510f;
        padding: 8px;
        border-radius: 3px;
        text-align: center;
    }

    .slot-image-area {
        width: 100%;
        height: 140px;
        background: linear-gradient(to bottom, #c0a47d, #8d704d);
        border: 1px solid #000;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 5px 0;
        cursor: pointer;
    }

    .slot-image-area:hover {
        filter: brightness(1.1);
    }

    .slot-image-area img {
        max-width: 90%;
        max-height: 90%;
        opacity: 0.8;
    }

    .btn-espiar-horde {
        background: linear-gradient(to bottom, #7d510f, #402a0a);
        color: white;
        width: 100%;
        padding: 6px 0;
        border: 1px solid #000;
        border-radius: 4px;
        font-weight: bold;
        font-size: 12px;
        cursor: pointer;
        text-decoration: none;
        display: block;
    }

    /* Modal Styles */
    #horde-modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        z-index: 10000;
        align-items: center;
        justify-content: center;
    }

    #horde-modal {
        background: #f4e4bc;
        border: 4px solid transparent;
        border-image: url("graphic/events/ataque_horda/border.webp") 5 fill repeat;
        width: 700px;
        padding: 20px;
        position: relative;
        box-shadow: 0 5px 25px rgba(0,0,0,0.5);
    }

    #horde-modal h2 {
        margin: 0 0 20px 0;
        font-size: 22px;
        color: #402a0a;
    }

    .modal-close {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        font-weight: bold;
        font-size: 20px;
        background: #f4e4bc;
        border: 1px solid #7d510f;
        padding: 0 5px;
        border-radius: 3px;
    }

    .units-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
    }

    .unit-choice {
        background: linear-gradient(to bottom, #947a62, #6c4824);
        border: 1px solid #000;
        border-radius: 8px;
        padding: 10px;
        text-align: center;
        cursor: pointer;
        transition: transform 0.1s;
    }

    .unit-choice:hover {
        transform: scale(1.03);
        box-shadow: 0 0 10px #7d510f;
    }

    .unit-choice img {
        width: 100%;
        height: 100px;
        object-fit: contain;
        margin-bottom: 10px;
    }

    .unit-choice .unit-name {
        color: #fff;
        font-weight: bold;
        font-size: 13px;
    }

    .btn-green-horde {
        background: linear-gradient(to bottom, #2ecc71, #27ae60);
        border: 1px solid #1e8449;
        color: white;
        padding: 10px 60px;
        font-size: 18px;
        font-weight: bold;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
    }

    .result-red {
        background: rgba(192, 57, 43, 0.6) !important;
        border: 2px solid #c0392b !important;
    }
    .result-yellow {
        background: rgba(241, 196, 15, 0.6) !important;
        border: 2px solid #f1c40f !important;
    }
    .result-green {
        background: rgba(39, 174, 96, 0.6) !important;
        border: 2px solid #27ae60 !important;
    }

    .horde-unit-slot.locked {
        pointer-events: none;
    }
</style>

<div class="event-horde-container">
    <!-- Header Section -->
    <div class="event-header-top">
        <div class="shop-box-right">
            <h4><?= __('screens.event_horde.shop_title') ?></h4>
            <div style="padding: 15px;">
                <img src="graphic/events/ataque%20horda/shop-chest.webp" style="width: 110px;" alt="">
                <a href="#" onclick="openHordeShop(); return false;" class="btn" style="display: block; margin-top: 15px; padding: 5px;"><?= __('screens.event_horde.shop_visit') ?></a>
            </div>
        </div>

        <img src="graphic/events/ataque%20horda/event_logo@2x.webp" style="float: left; width: 120px; margin-right: 20px;" alt="">
        
        <div style="float: right;">
            <a href="#" style="font-weight: bold; text-decoration: none; color: black; display: flex; align-items: center;" onclick="return window.open('help.php', '<?= __('screens.event_horde.help') ?>', 'width=800,height=600');">
                <img src="graphic/icons/questionmark.png" alt="" style="margin-right: 5px;"> <?= __('screens.event_horde.help') ?>
            </a>
        </div>

        <h1 style="margin: 0; font-size: 26px; color: #402a0a; font-weight: bold;"><?= __('screens.event_horde.title') ?></h1>
        <p style="margin: 15px 0 10px 0; font-size: 14px;"><?= __('screens.event_horde.description') ?></p>
        <p style="margin: 0; font-size: 14px; font-weight: bold;"><?= __('screens.event_horde.event_ends', ['date' => $end_date_str]) ?></p>

        <?php if (isset($_GET['success'])): ?>
            <div class="vis_item success" style="margin-top: 10px; padding: 5px; border: 1px solid green; background: #e0ffe0; color: green;">
                <?php 
                    if ($_GET['success'] == 'attack_sent') echo __('screens.event_horde.success_attack_sent'); 
                    elseif ($_GET['success'] == 'event_solved') echo __('screens.event_horde.success_solved');
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="vis_item error" style="margin-top: 10px; padding: 5px; border: 1px solid red; background: #ffe0e0; color: red;">
                <?php 
                    if ($_GET['error'] == 'no_energy') echo __('screens.event_horde.error_no_energy'); 
                    elseif ($_GET['error'] == 'event_ended_shop_only') echo __('screens.event_horde.error_shop_only');
                ?>
            </div>
        <?php endif; ?>

        <div style="display: flex; flex-direction: row; gap: 10px; margin-top: 20px;">
            <div class="bordered-box event-status" style="flex: 1; float: none; margin: 0;">
                <div class="status-title"><?= __('screens.event_horde.attack_plans') ?></div>
                <div class="status-value">
                    <img src="graphic/events/ataque%20horda/icon_energy.webp" style="height: 16px; vertical-align: middle; margin-right: 3px;" alt="">
                    <?= $energy ?> / <?= $max_energy ?>
                    <?php if ($energy < $max_energy): ?>
                        <br><small style="font-size: 9px; color: #402a0a;"><?= __('screens.event_horde.next_in') ?>: <span id="energy-timer" data-seconds="<?= $next_energy_time ?>"><?= date('i:s', $next_energy_time) ?></span></small>
                    <?php endif; ?>
                </div>
            </div>
            <div class="bordered-box event-status" style="flex: 1; float: none; margin: 0;">
                <div class="status-title"><?= __('screens.event_horde.guidons_label') ?></div>
                <div class="status-value">
                    <img src="graphic/events/ataque%20horda/icon_currency.webp" style="height: 16px; vertical-align: middle; margin-right: 3px;" alt="">
                    <?= $guidons ?> <?= __('screens.event_horde.guidons') ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Battle Area -->
    <form action="game.php?village=<?= $village['id'] ?>&screen=event_horde&action=attack" method="POST">
        <div class="horde-battle-area">
            <div style="text-align: right; color: white; font-weight: bold; font-size: 18px; text-shadow: 2px 2px 3px black; padding: 20px;">
                <img src="graphic/events/ataque%20horda/icon_currency.webp" style="height: 24px; vertical-align: middle;" alt=""> <?= $guidons ?> <?= __('screens.event_horde.guidons') ?>
            </div>

            <div class="horde-slots-container-abs">
                <table class="horde-slots-table">
                    <tr>
                        <?php for ($i = 0; $i < 5; $i++): 
                            $is_locked = isset($locked_slots[$i]) && $locked_slots[$i] !== '0';
                            $locked_unit = $is_locked ? $locked_slots[$i] : null;
                            $last_unit = isset($last_attempt['guess'][$i]) ? $last_attempt['guess'][$i] : null;
                            $result_color = '';
                            if (isset($last_attempt['results'][$i])) {
                                if ($last_attempt['results'][$i] == 2) $result_color = 'result-green';
                                elseif ($last_attempt['results'][$i] == 1) $result_color = 'result-yellow';
                                else $result_color = 'result-red';
                            }
                            // Priority to locked unit display
                            $display_unit = $is_locked ? $locked_unit : ($last_unit ?: 'unknown');
                            $display_img = $display_unit == 'unknown' ? 'unit_unknown.png' : 'unit_' . $display_unit . '.webp';
                        ?>
                            <td class="horde-unit-slot <?= $is_locked ? 'locked result-green' : $result_color ?>" id="slot-<?= $i ?>">
                                <div style="font-weight: bold; font-size: 13px; margin-bottom: 5px; color: <?= !empty($result_color) || $is_locked ? 'white' : 'inherit' ?>;">
                                    <?= $is_locked ? __('screens.event_horde.slot_success') : ($display_unit == 'unknown' ? __('screens.event_horde.slot_select') : ucfirst($display_unit)) ?>
                                </div>
                                <div class="slot-image-area" onclick="<?= ($is_shop_only || $is_locked) ? 'return false;' : 'openHordeModal(' . $i . ')' ?>" style="<?= ($is_shop_only || $is_locked) ? 'cursor: default;' : '' ?>">
                                    <img src="graphic/events/ataque%20horda/<?= $display_img ?>" class="slot-unit-img" alt="" style="<?= $display_unit == 'unknown' ? 'opacity: 0.5;' : 'opacity: 1;' ?>">
                                </div>
                                <input type="hidden" name="units[<?= $i ?>]" id="input-slot-<?= $i ?>" value="<?= $display_unit != 'unknown' ? $display_unit : '' ?>">
                                
                                <a href="#" class="btn-espiar-horde" style="<?= ($is_shop_only || $is_locked) ? 'pointer-events: none; opacity: 0.5;' : '' ?>">
                                    <img src="/ds_graphic/unit/spy.png" style="height: 16px; vertical-align: middle; margin-right: 5px;" alt="">
                                    <?= __('screens.event_horde.spy') ?>
                                </a>
                            </td>
                        <?php endfor; ?>
                    </tr>
                </table>
            </div>

            <div style="position: absolute; bottom: 20px; width: 100%; text-align: center;">
                <?php if ($is_shop_only): ?>
                    <div style="background: rgba(0,0,0,0.7); color: white; padding: 10px; display: inline-block; border-radius: 5px; font-weight: bold;">
                        <?= __('screens.event_horde.event_ended_msg') ?>
                    </div>
                <?php else: ?>
                    <button type="submit" class="btn-green-horde"><?= __('screens.event_horde.send_attack') ?></button>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>

<!-- Unit Selection Modal -->
<div id="horde-modal-overlay" onclick="closeHordeModal()">
    <div id="horde-modal" onclick="event.stopPropagation()">
        <span class="modal-close" onclick="closeHordeModal()">×</span>
        <h2><?= __('screens.event_horde.modal_title') ?></h2>
        
        <div class="units-grid">
            <?php foreach ($event_units as $unit): ?>
                <div class="unit-choice" onclick="selectHordeUnit('<?= $unit['icon'] ?>', '<?= $unit['id'] ?>', '<?= $unit['name'] ?>')">
                    <img src="graphic/events/ataque%20horda/<?= $unit['icon'] ?>" alt="">
                    <div class="unit-name"><?= $unit['name'] ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    let activeSlot = null;

    function openHordeModal(slotIndex) {
        activeSlot = slotIndex;
        document.getElementById('horde-modal-overlay').style.display = 'flex';
    }

    function closeHordeModal() {
        document.getElementById('horde-modal-overlay').style.display = 'none';
    }

    function selectHordeUnit(icon, id, name) {
        if (activeSlot !== null) {
            const slot = document.getElementById('slot-' + activeSlot);
            const img = slot.querySelector('.slot-unit-img');
            const input = document.getElementById('input-slot-' + activeSlot);
            const title = slot.querySelector('div[style*="font-size: 13px"]');

            img.src = 'graphic/events/ataque_horda/' + icon;
            img.style.opacity = '1';
            input.value = id;
            if (title) title.textContent = name;
            
            closeHordeModal();
        }
    }

    // Energy Timer
    const timerEl = document.getElementById('energy-timer');
    if (timerEl) {
        let seconds = parseInt(timerEl.getAttribute('data-seconds'));
        const interval = setInterval(() => {
            seconds--;
            if (seconds <= 0) {
                clearInterval(interval);
                location.reload();
                return;
            }
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            timerEl.textContent = mins + ":" + (secs < 10 ? '0' : '') + secs;
        }, 1000);
    }
</script>

<!-- Shop Modal -->
<div id="horde-shop-modal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background:#e3d5b8; border:2px solid #8c5f0d; padding:20px; z-index:1000; width:800px; max-height:80vh; overflow-y:auto;">
    <div style="text-align:right; margin-bottom:10px;">
        <button class="btn" onclick="$('#horde-shop-overlay, #horde-shop-modal').hide();"><?= __('screens.event_horde.shop_close') ?></button>
    </div>
    <div id="horde-shop-content"><?= __('screens.event_horde.loading') ?></div>
</div>
<div id="horde-shop-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); z-index:999;" onclick="$('#horde-shop-overlay, #horde-shop-modal').hide();"></div>

<script>
function openHordeShop() {
    $('#horde-shop-overlay, #horde-shop-modal').show();
    $('#horde-shop-content').html(<?= json_encode(__('screens.event_horde.loading_shop')) ?>);
    $.get('/game.php?village=<?= $village['id'] ?? 0 ?>&screen=event_horde_shop&ajax=shop_html', function(html) {
        $('#horde-shop-content').html(html);
    });
}
</script>

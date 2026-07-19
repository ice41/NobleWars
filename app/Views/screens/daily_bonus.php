<?php
// Daily Bonus Modal View
?>
<style>
    /* Modal Overlay */
    .bonus-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Modal Container */
    .bonus-modal {
        background: #f4e4bc;
        border: 3px solid #7d510f;
        border-radius: 10px;
        padding: 20px;
        max-width: 700px;
        width: 90%;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
    }

    /* Header */
    .bonus-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .bonus-header h2 {
        color: #7d510f;
        margin: 0 0 10px 0;
    }

    .bonus-streak {
        background: #fff3d4;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
    }

    /* Chest Grid */
    .chest-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin: 20px 0;
    }

    /* Chest Item */
    .chest-item {
        background: #fff;
        border: 2px solid #c1a264;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        position: relative;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .chest-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .chest-item.locked {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .chest-item.claimed {
        background: #e8f5e9;
        border-color: #4caf50;
    }

    .chest-item.available {
        background: #fff9c4;
        border-color: #ffc107;
        animation: pulse 2s infinite;
    }

    .chest-item.golden {
        background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
        border-color: #ff8c00;
    }

    @keyframes pulse {

        0%,
        100% {
            box-shadow: 0 0 10px rgba(255, 193, 7, 0.5);
        }

        50% {
            box-shadow: 0 0 20px rgba(255, 193, 7, 0.8);
        }
    }

    /* Chest Image */
    .chest-image {
        width: 80px;
        height: 80px;
        margin: 0 auto 10px;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
    }

    .chest-day {
        font-size: 24px;
        font-weight: bold;
        color: #7d510f;
        margin-bottom: 5px;
    }

    .chest-description {
        font-size: 12px;
        color: #666;
        min-height: 30px;
    }

    /* Claim Button */
    .claim-button {
        background: #4caf50;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        margin-top: 10px;
    }

    .claim-button:hover {
        background: #45a049;
    }

    .claim-button:disabled {
        background: #ccc;
        cursor: not-allowed;
    }

    /* Close Button */
    .close-modal {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #d32f2f;
        color: white;
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 18px;
        line-height: 1;
    }

    .close-modal:hover {
        background: #c62828;
    }
</style>

<div class="bonus-modal-overlay" id="bonusModal">
    <div class="bonus-modal">
        <button class="close-modal" onclick="closeBonusModal()">×</button>

        <div class="bonus-header">
            <h2>🎁 <?= __('screens.profile.daily_login_bonus') ?></h2>
            <p><?= __('screens.profile.claim_daily_bonus_desc') ?></p>
 
            <div class="bonus-streak">
                <strong>🔥 <?= __('screens.profile.current_streak') ?></strong> <?= $current_streak ?> <?= __('screens.profile.days') ?>
                <?php if ($best_streak > 0): ?>
                    | <strong>📊 <?= __('screens.profile.best_streak') ?></strong> <?= $best_streak ?> <?= __('screens.profile.days') ?>
                <?php endif; ?>
            </div>
        </div>
 
        <div class="chest-grid">
            <?php foreach ($chests as $chest): ?>
                <div class="chest-item <?= $chest['state'] ?> <?= $chest['chest_type'] === 'golden' ? 'golden' : '' ?>"
                    data-day="<?= $chest['day'] ?>" data-state="<?= $chest['state'] ?>">
 
                    <div class="chest-day"><?= __('screens.profile.day') ?> <?= $chest['day'] ?></div>
 
                    <div class="chest-image">
                        <?php if ($chest['state'] === 'claimed'): ?>
                            <?php if (!empty($chest['reward_data']['icon'])): ?>
                                <img src="graphic/new/inventory/<?= htmlspecialchars($chest['reward_data']['icon']) ?>" alt="<?= htmlspecialchars($chest['reward_data']['name']) ?>" style="width: 50px; height: 50px; margin-top: 15px;">
                            <?php else: ?>
                                <img src="graphic/new/chest/chest_op.png" alt="<?= __('screens.profile.open_chest') ?>" style="width: 50px; height: 50px; margin-top: 15px;">
                            <?php endif; ?>
                        <?php elseif ($chest['chest_type'] === 'golden'): ?>
                            <img src="graphic/new/chest/chest_cl.png" alt="<?= __('screens.profile.golden_chest') ?>" style="width: 50px; height: 50px; margin-top: 15px; filter: hue-rotate(45deg) saturate(2);">
                        <?php else: ?>
                            <img src="graphic/new/chest/chest_cl.png" alt="<?= __('screens.profile.closed_chest') ?>" style="width: 50px; height: 50px; margin-top: 15px;">
                        <?php endif; ?>
                    </div>
 
                    <div class="chest-description">
                        <?= htmlspecialchars($chest['description']) ?>
                    </div>
 
                    <?php if ($chest['state'] === 'available'): ?>
                        <button class="claim-button" onclick="claimBonus(<?= $chest['day'] ?>)">
                            <?= __('screens.profile.claim') ?>
                        </button>
                    <?php elseif ($chest['state'] === 'claimed'): ?>
                        <div  class="text-green bold mt-10">✓ <?= __('screens.profile.bonus_claimed') ?></div>
                    <?php else: ?>
                        <div  class="mt-10" style="color: #999;">🔒 <?= __('screens.profile.locked') ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
 
        <?php if ($available_day === null): ?>
            <div  class="text-center" style="padding: 20px; background: #fff3d4; border-radius: 5px;">
                <?php if (count($claimed_days) >= 9): ?>
                    <strong>🎉 <?= __('screens.profile.congratulations') ?></strong><br>
                    <?= __('screens.profile.claimed_all_chests') ?><br>
                    <?= __('screens.profile.come_back_tomorrow_desc') ?>
                <?php else: ?>
                    <strong>⏰ <?= __('screens.profile.come_back_tomorrow') ?></strong><br>
                    <?= __('screens.profile.already_claimed_today') ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
 
<script>
    function closeBonusModal() {
        document.getElementById('bonusModal').style.display = 'none';
        // Redirect back to profile or previous page
        window.location.href = 'game.php?village=<?= $village['id'] ?>&screen=profile';
    }
 
    function claimBonus(day) {
        // Disable button
        event.target.disabled = true;
        event.target.textContent = '<?= __('screens.profile.claiming', 'Claiming...') ?>';
 
        // AJAX request to claim bonus
        fetch('game.php?village=<?= $village['id'] ?>&screen=daily_bonus&action=claim&h=<?= $hkey ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'day=' + day
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    alert('🎉 ' + ('<?= __('screens.profile.bonus_claimed_success') ?>') + '\n\n' + data.description);
 
                    // Reload page to update UI
                    location.reload();
                } else {
                    alert('❌ ' + data.error);
                    event.target.disabled = false;
                    event.target.textContent = '<?= __('screens.profile.claim') ?>';
                }
            })
            .catch(error => {
                alert('❌ ' + '<?= __('screens.profile.error_claiming_bonus') ?>');
                console.error('Error:', error);
                event.target.disabled = false;
                event.target.textContent = '<?= __('screens.profile.claim') ?>';
            });
    }

    // Auto-close on ESC key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeBonusModal();
        }
    });
</script>
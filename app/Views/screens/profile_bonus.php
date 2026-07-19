<?php
// Profile Bonus View - Daily Login Bonus (9 Days Cycle)
?>
<style>
    /* Bonus Container */
    .bonus-container {
        background: #f4e4bc;
        border: 2px solid #7d510f;
        border-radius: 8px;
        padding: 20px;
        margin: 20px 0;
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

    /* Chest Grid - 3 columns for 9 chests (3x3 layout) */
    .chest-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin: 20px 0;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    @media (max-width: 600px) {
        .chest-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Chest Item */
    .chest-item {
        background: #fff;
        border: 2px solid #c1a264;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        position: relative;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .chest-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
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
        cursor: pointer;
    }

    .chest-item.golden {
        background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
        border-color: #ff8c00;
    }

    @keyframes pulse {
        0%, 100% {
            box-shadow: 0 0 10px rgba(255, 193, 7, 0.5);
        }
        50% {
            box-shadow: 0 0 20px rgba(255, 193, 7, 0.8);
        }
    }

    /* Chest Image */
    .chest-image {
        width: 60px;
        height: 60px;
        margin: 0 auto 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chest-day {
        font-size: 16px;
        font-weight: bold;
        color: #7d510f;
        margin-bottom: 5px;
    }

    .chest-description {
        font-size: 11px;
        color: #666;
        min-height: 30px;
        line-height: 1.3;
    }

    /* Claim Button */
    .claim-button {
        background: #4caf50;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        font-weight: bold;
        margin-top: 8px;
    }

    .claim-button:hover {
        background: #45a049;
    }

    .claim-button:disabled {
        background: #ccc;
        cursor: not-allowed;
    }

    /* Status Messages */
    .bonus-status {
        text-align: center;
        padding: 15px;
        background: #fff3d4;
        border-radius: 5px;
        margin-top: 20px;
    }

    .status-icon {
        font-size: 12px;
        margin-top: 8px;
    }
</style>

<div class="bonus-container">
    <?php if (isset($_GET['success'])): ?>
        <div  class="mb-15 text-center" style="background: #d4edda; border: 2px solid #28a745; color: #155724; padding: 12px; border-radius: 5px;">
            <strong>✓</strong> <?= htmlspecialchars($_GET['success']) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div  class="mb-15 text-center" style="background: #f8d7da; border: 2px solid #dc3545; color: #721c24; padding: 12px; border-radius: 5px;">
            <strong>✗</strong> <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <div class="bonus-header">
        <h2>🎁 <?= __('screens.profile.daily_login_bonus') ?></h2>
        <p><?= __('screens.profile.claim_daily_bonus_desc') ?></p>

        <div class="bonus-streak">
            <strong>🔥 <?= __('screens.profile.current_streak') ?></strong> <?= $bonus_current_streak ?> <?= __('screens.profile.days') ?>
            <?php if ($bonus_best_streak > 0): ?>
                | <strong>📊 <?= __('screens.profile.best_streak') ?></strong> <?= $bonus_best_streak ?> <?= __('screens.profile.days') ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="chest-grid">
        <?php foreach ($bonus_chests as $chest): ?>
            <div class="chest-item <?= $chest['state'] ?> <?= $chest['chest_type'] === 'golden' ? 'golden' : '' ?>"
                data-day="<?= $chest['day'] ?>" data-state="<?= $chest['state'] ?>">

                <div class="chest-day"><?= __('screens.profile.day') ?> <?= $chest['day'] ?></div>

                <div class="chest-image">
                    <?php if ($chest['state'] === 'claimed'): ?>
                        <?php if (!empty($chest['reward_data']['icon'])): ?>
                            <img src="graphic/new/inventory/<?= htmlspecialchars($chest['reward_data']['icon']) ?>" alt="<?= htmlspecialchars($chest['reward_data']['name']) ?>" style="width: 45px; height: 45px;">
                        <?php else: ?>
                            <img src="graphic/new/chest/chest_op.png" alt="<?= __('screens.profile.open_chest') ?>" style="width: 45px; height: 45px;">
                        <?php endif; ?>
                    <?php elseif ($chest['chest_type'] === 'golden'): ?>
                        <img src="graphic/new/chest/chest_cl.png" alt="<?= __('screens.profile.golden_chest') ?>"
                            style="width: 45px; height: 45px; filter: hue-rotate(45deg) saturate(2);">
                    <?php else: ?>
                        <img src="graphic/new/chest/chest_cl.png" alt="<?= __('screens.profile.closed_chest') ?>"
                            style="width: 45px; height: 45px;">
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
                    <div class="status-icon text-green bold" >✓ <?= __('screens.profile.bonus_claimed') ?></div>
                <?php else: ?>
                    <div class="status-icon"  style="color: #999;">🔒 <?= __('screens.profile.locked') ?></div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($bonus_available_day === null): ?>
        <div class="bonus-status">
            <?php if (count($bonus_claimed_days) >= 9): ?>
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

<script>
    function claimBonus(day) {
        // Disable button
        event.target.disabled = true;
        event.target.textContent = '...';

        // AJAX request to claim bonus
        fetch('game.php?village=<?= $village['id'] ?>&screen=profile&mode=bonus&action=claim_bonus&h=<?= $hkey ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'day=' + day
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirect with success message
                    window.location.href = 'game.php?village=<?= $village['id'] ?>&screen=profile&mode=bonus&success=' + encodeURIComponent('<?= __('screens.profile.bonus_claimed_success') ?> ' + data.description);
                } else {
                    // Redirect with error message
                    window.location.href = 'game.php?village=<?= $village['id'] ?>&screen=profile&mode=bonus&error=' + encodeURIComponent(data.error);
                }
            })
            .catch(error => {
                // Redirect with error message
                window.location.href = 'game.php?village=<?= $village['id'] ?>&screen=profile&mode=bonus&error=' + encodeURIComponent('<?= __('screens.profile.error_claiming_bonus') ?>');
                console.error('Error:', error);
            });
    }
</script>
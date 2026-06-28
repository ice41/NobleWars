<?php
/**
 * Premium Screen View
 * Display premium features and purchase options
 */
?>

<!-- Include Name Cosmetics CSS -->
<link rel="stylesheet" href="/css/name_cosmetics.css">


<!-- Purchase Modal -->
<div id="purchaseModal"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999;">
    <div
        style="position: relative; width: 920px; margin: 50px auto; background: url('/graphic/premium/modal_bg.jpg'); border: 3px solid #8B4513; border-radius: 10px; padding: 20px;">
        <!-- Close Button -->
        <button onclick="closePurchaseModal()"
            style="position: absolute; top: 10px; right: 10px; background: #8B4513; color: white; border: none; width: 30px; height: 30px; border-radius: 50%; cursor: pointer; font-size: 18px;">✕</button>

        <h2 style="text-align: center; color: white; text-shadow: 2px 2px 4px #000;">
            <?= __('screens.premium.get_premium_points') ?>
        </h2>

        <!-- Premium Packages -->
        <div style="display: flex; justify-content: space-around; margin: 30px 0;">
            <!-- 200 Points -->
            <div
                style="background: linear-gradient(180deg, #8B0000 0%, #4B0000 100%); border: 3px solid #FFD700; border-radius: 10px; padding: 15px; width: 160px; text-align: center;">
                <div style="color: white; font-size: 48px; font-weight: bold; text-shadow: 2px 2px 4px #000;">200</div>
                <div style="color: #FFD700; font-weight: bold;"><?= __('screens.premium.premium_point') ?></div>
                <div style="margin: 20px 0;">
                    <img src="/graphic/new/premium/coinbag_15x15.png" alt="Coins" style="width: 100px; height: 100px;" />
                </div>
                <div style="background: #8B4513; color: white; padding: 8px; border-radius: 5px; font-weight: bold;">
                    3,99 €</div>
            </div>

            <!-- 600 Points -->
            <div
                style="background: linear-gradient(180deg, #006400 0%, #003200 100%); border: 3px solid #FFD700; border-radius: 10px; padding: 15px; width: 160px; text-align: center; position: relative;">
                <div
                    style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: green; color: white; padding: 3px 10px; border-radius: 5px; font-size: 12px;">
                    500 + 20%</div>
                <div style="color: white; font-size: 48px; font-weight: bold; text-shadow: 2px 2px 4px #000;">600</div>
                <div style="color: #FFD700; font-weight: bold;">Ponto Premium</div>
                <div style="margin: 20px 0;">
                    <img src="/graphic/new/premium/product_03.png" alt="Coins" style="width: 100px; height: 100px;" />
                </div>
                <div style="background: #8B4513; color: white; padding: 8px; border-radius: 5px; font-weight: bold;">
                    9,99 €</div>
            </div>

            <!-- 1500 Points - Most Popular -->
            <div
                style="background: linear-gradient(180deg, #006400 0%, #003200 100%); border: 3px solid #FFD700; border-radius: 10px; padding: 15px; width: 160px; text-align: center; position: relative;">
                <div
                    style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: green; color: white; padding: 3px 10px; border-radius: 5px; font-size: 12px;">
                    1000 + 50%</div>
                <div style="color: white; font-size: 48px; font-weight: bold; text-shadow: 2px 2px 4px #000;">1500</div>
                <div style="color: #FFD700; font-weight: bold;">Ponto Premium</div>
                <div style="margin: 20px 0;">
                    <img src="/graphic/new/premium/product_03.png" alt="Coins" style="width: 100px; height: 100px;" />
                </div>
                <div style="background: #00008B; color: white; padding: 8px; border-radius: 5px; font-weight: bold;">
                    <?= __('screens.premium.most_popular') ?>
                </div>
                <div
                    style="background: #8B4513; color: white; padding: 8px; border-radius: 5px; font-weight: bold; margin-top: 5px;">
                    19,99 €</div>
            </div>

            <!-- 5000 Points -->
            <div
                style="background: linear-gradient(180deg, #006400 0%, #003200 100%); border: 3px solid #FFD700; border-radius: 10px; padding: 15px; width: 160px; text-align: center; position: relative;">
                <div
                    style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: green; color: white; padding: 3px 10px; border-radius: 5px; font-size: 12px;">
                    2500 + 100%</div>
                <div style="color: white; font-size: 48px; font-weight: bold; text-shadow: 2px 2px 4px #000;">5000</div>
                <div style="color: #FFD700; font-weight: bold;">Ponto Premium</div>
                <div style="margin: 20px 0;">
                    <img src="/graphic/new/premium/product_04.png" alt="Coins" style="width: 100px; height: 100px;" />
                </div>
                <div style="background: #8B4513; color: white; padding: 8px; border-radius: 5px; font-weight: bold;">
                    49,99 €</div>
            </div>

            <!-- 8500 Points -->
            <div
                style="background: linear-gradient(180deg, #006400 0%, #003200 100%); border: 3px solid #FFD700; border-radius: 10px; padding: 15px; width: 160px; text-align: center; position: relative;">
                <div
                    style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: green; color: white; padding: 3px 10px; border-radius: 5px; font-size: 12px;">
                    4000 + 112%</div>
                <div style="color: white; font-size: 48px; font-weight: bold; text-shadow: 2px 2px 4px #000;">8500</div>
                <div style="color: #FFD700; font-weight: bold;">Ponto Premium</div>
                <div style="margin: 20px 0;">
                    <img src="/graphic/new/premium/product_05.png" alt="Coins" style="width: 100px; height: 100px;" />
                </div>
                <div style="background: #8B4513; color: white; padding: 8px; border-radius: 5px; font-weight: bold;">
                    79,99 €</div>
            </div>
        </div>

        <!-- Removed village scene image as it doesn't exist -->

        <!-- Payment Method -->
        <div style="background: rgba(139, 69, 19, 0.8); padding: 15px; border-radius: 5px;">
            <div style="color: white; margin-bottom: 10px;"><?= __('screens.premium.how_to_pay') ?></div>
            <div style="display: flex; align-items: center; gap: 20px;">
                <div style="background: white; padding: 10px; border-radius: 5px; flex: 1;">
                    <img src="/graphic/new/premium/paypal.png" alt="PayPal" style="height: 30px;" />
                    <select style="width: 100%; padding: 5px; margin-top: 5px;">
                        <option>PayPal</option>
                    </select>
                </div>
                <div>
                    <label style="color: white;">
                        <input type="checkbox" /> <?= __('screens.premium.save_account') ?>
                    </label>
                </div>
                <span
                    style="background: #FFD700; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; display: inline-block;">?</span>
            </div>
        </div>

        <!-- Footer Links -->
        <div style="text-align: center; margin-top: 20px; font-size: 11px;">
            <a href="game.php?village=<?= $village['id'] ?>&screen=support" style="color: #FFD700; margin: 0 10px;"><?= __('screens.premium.support_request') ?></a>
            <a href="game.php?village=<?= $village['id'] ?>&screen=terms" style="color: #FFD700; margin: 0 10px;"><?= __('screens.premium.general_terms') ?></a>
            <a href="game.php?village=<?= $village['id'] ?>&screen=privacy" style="color: #FFD700; margin: 0 10px;"><?= __('screens.premium.data_protection') ?></a>
            <a href="game.php?village=<?= $village['id'] ?>&screen=legal" style="color: #FFD700; margin: 0 10px;"><?= __('screens.premium.legal_info') ?></a>
            <div style="color: white; margin-top: 5px;"><?= __('screens.premium.prices_include_tax') ?></div>
        </div>
    </div>
</div>

<!-- Cosmetic Purchase Result Modal -->
<div id="cosmeticResultModal"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 10001;">
    <div
        style="position: relative; width: 450px; margin: 150px auto; background: #f4e4bc; border: 3px solid #8b4513; border-radius: 10px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.5);">
        <!-- Header -->
        <h3 id="resultModalTitle" style="text-align: center; margin-bottom: 20px; font-size: 22px;"></h3>

        <!-- Content -->
        <div id="resultModalContent" style="text-align: center; font-size: 16px; line-height: 1.6; color: #333;"></div>

        <!-- OK Button -->
        <div style="text-align: center; margin-top: 25px;">
            <button onclick="closeResultModal()"
                style="background: #27ae60; color: white; border: none; padding: 12px 40px; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold;">OK</button>
        </div>
    </div>
</div>

<script>
    // Global variables
    // window.currentUsername = <?= json_encode(isset($user["username"]) ? $user["username"] : "Guest") ?>;
    window.currentUsername = "TestUser"; // Temporary hardcoded value
</script>

<script>
    function openPurchaseModal() {
        document.getElementById('purchaseModal').style.display = 'block';
    }

    function closePurchaseModal() {
        document.getElementById('purchaseModal').style.display = 'none';
    }

    // Activate premium feature
    // Calculate cost based on feature and duration
    function calculateCost(feature, duration) {
        const pricing = {
            'account_manager': {
                3: 30,
                7: 60,
                14: 100,
                30: 200,
                90: 600
            },
            'farm_assistant': {
                30: 30,
                90: 90
            },
            'wood_production': {
                30: 150,
                90: 450
            },
            'clay_production': {
                30: 150,
                90: 450
            },
            'iron_production': {
                30: 150,
                90: 450
            }
        };

        return pricing[feature]?.[duration] || 0;
    }

    // Activate premium feature
    function activateFeature(feature, duration, cost) {
        // Recalculate cost to ensure it's correct
        const actualCost = calculateCost(feature, parseInt(duration));
        showActivationModal(feature, duration, actualCost);
    }

    // Feature activation modal functions
    let pendingActivation = null;

    function showActivationModal(feature, duration, cost) {
        const featureNames = {
            'account_manager': 'Gestor de conta',
            'farm_assistant': 'Assistente de Saque',
            'wood_production': '+20% produção de madeira',
            'clay_production': '+20% produção de argila',
            'iron_production': '+20% produção de ferro'
        };

        const featureName = featureNames[feature] || feature;

        document.getElementById('activationFeatureName').textContent = featureName;
        document.getElementById('activationDuration').textContent = duration;
        document.getElementById('activationCost').textContent = cost;

        pendingActivation = { feature, duration, cost };
        document.getElementById('activationModal').style.display = 'flex';
    }

    function closeActivationModal() {
        document.getElementById('activationModal').style.display = 'none';
        pendingActivation = null;
    }

    function confirmActivation() {
        console.log('confirmActivation called', pendingActivation);
        if (!pendingActivation) {
            console.error('No pending activation!');
            return;
        }

        const { feature, duration } = pendingActivation;
        console.log('Activating:', feature, 'for', duration, 'days');

        const formData = new FormData();
        formData.append('action', 'activate');
        formData.append('feature', feature);
        formData.append('duration', duration);

        console.log('Sending request...');
        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
            .then(response => {
                console.log('Response received:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    alert('✅ ' + data.message);
                    console.log('Reloading page...');
                    location.reload();
                } else {
                    alert('❌ ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erro ao ativar funcionalidade: ' + error.message);
            });

        closeActivationModal();
    }

    // Toggle auto-renewal for premium features
    function toggleAutoRenew(feature, enabled) {
        const formData = new FormData();
        formData.append('action', 'toggle_auto_renew');
        formData.append('feature', feature);
        formData.append('enabled', enabled ? '1' : '0');

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Auto-renewal updated:', data.message);
                } else {
                    alert('❌ Erro: ' + data.message);
                    // Revert checkbox state on error
                    document.getElementById('auto_renew_' + feature.replace('_', '')).checked = !enabled;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erro ao atualizar renovação automática');
                // Revert checkbox state on error
                document.getElementById('auto_renew_' + feature.replace('_', '')).checked = !enabled;
            });
    }
</script>

<!-- Premium Feature Activation Confirmation Modal -->
<div id="activationModal"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 10000; align-items: center; justify-content: center;">
    <div class="popup_box" style="width: 450px; background: #f4e4bc; border: 2px solid #8b4513;">
        <h3 style="text-align: center; margin-bottom: 20px; color: #8b4513;">
            <?= __('screens.premium.confirm_activation') ?>
        </h3>

        <div style="padding: 20px; text-align: center; background: #f4e4bc;">
            <p style="font-size: 16px; margin-bottom: 15px; color: #000;">
                <?= __('screens.premium.activate') ?> "<strong><span id="activationFeatureName"></span></strong>"
                <?= __('screens.premium.for') ?> <strong><span id="activationDuration"></span>
                    <?= __('screens.premium.days') ?></strong>?
            </p>

            <p style="font-size: 14px; color: #666; margin-bottom: 25px;">
                <?= __('screens.premium.cost') ?> <img src="/graphic/new/premium/coinbag_15x15.png"
                    style="vertical-align: middle;" /> <strong><span id="activationCost"></span>
                    <?= __('screens.premium.premium_points') ?></strong>
            </p>

            <div style="display: flex; gap: 10px; justify-content: center;">
                <button onclick="confirmActivation()" class="btn"
                    style="background: #5cb85c; color: white; padding: 8px 30px;">
                    OK
                </button>
                <button onclick="closeActivationModal()" class="btn"
                    style="background: #999; color: white; padding: 8px 30px;">
                    <?= __('screens.premium.cancel') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<h2><?= __('screens.premium.premium') ?></h2>

<div style="float: right; font-size: 18px; font-weight: bold;">
    <img src="/graphic/new/premium/coinbag_15x15.png" alt="Pontos" style="vertical-align: middle;" />
    <?= number_format($premium_points) ?> <?= __('screens.premium.points') ?>
</div>

<div style="clear: both;"></div>

<!-- Tabs -->
<table class="vis" width="100%">
    <tr>
        <?php foreach ($tabs as $tab_key => $tab_name): ?>
            <th <?= $tab === $tab_key ? 'class="selected"' : '' ?>>
                <?php if ($tab_key === 'buy'): ?>
                    <a href="#" onclick="openPremiumModal(); return false;">
                        <?= $tab_name ?>
                    </a>
                <?php else: ?>
                    <a href="game.php?village=<?= $village['id'] ?>&screen=premium&tab=<?= $tab_key ?>">
                        <?= $tab_name ?>
                    </a>
                <?php endif; ?>
            </th>
        <?php endforeach; ?>
    </tr>
</table>

<br />

<?php if ($tab === 'subscriptions'): ?>
    <!-- Premium Features Grid -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">

        <!-- Premium Account -->
        <div class="premium-card"
            style="border: 2px solid #8B4513; padding: 15px; background: #F4E4BC; border-radius: 8px;">
            <div
                style="background: #8B4513; color: white; padding: 8px; text-align: center; border-radius: 5px; margin-bottom: 10px;">
                <strong><?= __('screens.premium.premium_account') ?></strong>
            </div>

            <div style="text-align: center; margin: 20px 0;">
                <img src="/graphic/new/premium/Premium_large.webp" alt="Crown" style="width: 120px; height: 120px;" />
            </div>

            <div style="margin: 15px 0;">
                <strong><?= __('screens.premium.premium_account_desc') ?></strong>
            </div>

            <ul style="margin: 10px 0; padding-left: 20px;">
                <li><?= __('screens.premium.more_build_orders') ?></li>
                <li><?= __('screens.premium.map_improvements') ?></li>
                <li><?= __('screens.premium.village_overview') ?></li>
                <li><a class="nowrap" href=""><?= __('screens.premium.and_more') ?></a></li>
            </ul>
            <!--
            <div style="margin: 15px 0; text-align: center;">
                <img src="/graphic/new/premium/time.png" style="vertical-align: middle;" />
                <select name="duration_premium" style="width: 80px;">
                    <option value="30">30 dias</option>
                    <option value="90">90 dias</option>
                    <option value="180">180 dias</option>
                </select>
                <img src="/graphic/new/premium/coinbag_15x15.png" style="vertical-align: middle;" />
                <strong>200 pontos</strong>
            </div>

            <div style="text-align: center; margin: 10px 0;">
                <button class="btn" style="background: green; color: white; padding: 8px 20px;"
                    onclick="const duration = document.querySelector('select[name=duration_wood]').value; activateFeature('wood_production', duration, 150)">Ativar agora</button>
            </div>

            <div style="text-align: center; margin: 10px 0;">
                <button class="btn" style="background: #8B4513; color: white; padding: 5px 15px;">Comprar como
                    presente</button>
            </div>-->
        </div>

        <!-- Account Manager -->
        <div class="premium-card"
            style="border: 2px solid #8B4513; padding: 15px; background: #F4E4BC; border-radius: 8px; position: relative;">
            <?php if (!empty($active_features['account_manager'])): ?>
                <div style="position: absolute; top: 10px; right: 10px; font-size: 48px; color: green;">✓</div>
            <?php endif; ?>

            <div
                style="background: #8B4513; color: white; padding: 8px; text-align: center; border-radius: 5px; margin-bottom: 10px;">
                <strong><?= __('screens.premium.account_manager') ?></strong>
            </div>

            <div style="text-align: center; margin: 20px 0;">
                <img src="/graphic/new/premium/AccountManager_large.webp" alt="Account Manager"
                    style="width: 120px; height: 120px;" />
            </div>

            <div style="margin: 15px 0;">
                <strong><?= __('screens.premium.account_manager_desc') ?></strong>
            </div>

            <ul style="margin: 10px 0; padding-left: 20px;">
                <li><?= __('screens.premium.manage_buildings') ?></li>
                <li><?= __('screens.premium.manage_recruitment') ?></li>
                <li><?= __('screens.premium.includes_farm_assistant') ?></li>
                <li><a class="nowrap" href=""><?= __('screens.premium.and_more') ?></a></li>
            </ul>

            <div style="margin: 15px 0; text-align: center;">
                <img src="/graphic/new/premium/time.png" style="vertical-align: middle;" />
                <select name="duration_manager" style="width: 80px;">
                    <option value="90"><?= __('screens.premium.90_days') ?></option>
                    <option value="30"><?= __('screens.premium.30_days') ?></option>
                    <option value="14"><?= __('screens.premium.14_days') ?></option>
                    <option value="7"><?= __('screens.premium.7_days') ?></option>
                    <option value="3"><?= __('screens.premium.3_days') ?></option>
                </select>
                <img src="/graphic/new/premium/coinbag_15x15.png" style="vertical-align: middle;" />
                <strong id="cost_manager">200 pontos</strong>
            </div>

            <?php if (!empty($active_features['account_manager'])): ?>
                <div style="text-align: center; margin: 10px 0;">
                    <button class="btn" style="background: green; color: white; padding: 8px 20px;"
                        onclick="const duration = document.querySelector('select[name=duration_manager]').value; activateFeature('account_manager', duration, 200)"><?= __('screens.premium.extend_now') ?></button>
                </div>

                <div style="background: #E7F3FF; border: 1px solid #2196F3; padding: 10px; margin-top: 10px;">
                    <img src="/graphic/icons/questionmark.png" style="vertical-align: middle;" />
                    <input type="checkbox" id="auto_renew_accountmanager" <?= !empty($user['account_manager_auto_renew']) ? 'checked' : '' ?> onchange="toggleAutoRenew('account_manager', this.checked)" />
                    <?= __('screens.premium.auto_renew') ?>
                    <br />
                    <small><?= __('screens.premium.expires') ?>         <?php
                               if (isset($active_features['account_manager']['expires'])) {
                                   $expires = $active_features['account_manager']['expires'];
                                   if (!is_numeric($expires)) {
                                       $expires = strtotime($expires);
                                   }
                                   echo date('M d, H:i', $expires);
                               }
                               ?></small>
                </div>
            <?php else: ?>
                <div style="text-align: center; margin: 10px 0;">
                    <button class="btn" style="background: green; color: white; padding: 8px 20px;"
                        onclick="const duration = document.querySelector('select[name=duration_manager]').value; activateFeature('account_manager', duration, 200)"><?= __('screens.premium.activate_now') ?></button>
                </div>
            <?php endif; ?>

            <div style="text-align: center; margin: 10px 0;">
                <button class="btn"
                    style="background: #8B4513; color: white; padding: 5px 15px;"><?= __('screens.premium.buy_as_gift') ?></button>
            </div>

            <!-- <div style="background: #FFE4E1; border: 1px solid #FF6347; padding: 10px; margin-top: 10px; font-size: 12px;">
                <strong>Precisa de ter uma conta Premium e 5 aldeias para poder ativar o gestor de conta.</strong>
            </div>-->
        </div>

        <!-- Farm Assistant -->
        <div class="premium-card"
            style="border: 2px solid #8B4513; padding: 15px; background: #F4E4BC; border-radius: 8px; position: relative;">
            <?php if (!empty($active_features['farm_assistant'])): ?>
                <div style="position: absolute; top: 10px; right: 10px; font-size: 48px; color: green;">✓</div>
            <?php endif; ?>

            <div
                style="background: #8B4513; color: white; padding: 8px; text-align: center; border-radius: 5px; margin-bottom: 10px;">
                <strong><?= __('screens.premium.farm_assistant') ?></strong>
            </div>

            <div style="text-align: center; margin: 20px 0;">
                <img src="/graphic/new/premium/FarmAssistent_large.webp" alt="Farm Assistant"
                    style="width: 120px; height: 120px;" />
            </div>

            <div style="margin: 15px 0;">
                <strong><?= __('screens.premium.farm_assistant_desc') ?></strong>
            </div>

            <ul style="margin: 10px 0; padding-left: 20px;">
                <li><a class="nowrap" href=""><?= __('screens.premium.see_details') ?></a></li>
            </ul>

            <div style="margin: 15px 0; text-align: center;">
                <img src="/graphic/new/premium/time.png" style="vertical-align: middle;" />
                <select name="duration_farm" style="width: 80px;">
                    <option value="90"><?= __('screens.premium.90_days') ?></option>
                    <option value="30"><?= __('screens.premium.30_days') ?></option>
                    <option value="14"><?= __('screens.premium.14_days') ?></option>
                    <option value="7"><?= __('screens.premium.7_days') ?></option>
                    <option value="3"><?= __('screens.premium.3_days') ?></option>
                </select>
                <img src="/graphic/new/premium/coinbag_15x15.png" style="vertical-align: middle;" />
                <strong id="cost_farm">30 pontos</strong>
            </div>

            <?php if (!empty($active_features['farm_assistant'])): ?>
                <div style="text-align: center; margin: 10px 0;">
                    <button class="btn" style="background: green; color: white; padding: 8px 20px;"
                        onclick="const duration = document.querySelector('select[name=duration_farm]').value; activateFeature('farm_assistant', duration, 30)"><?= __('screens.premium.extend_now') ?></button>
                </div>

                <div style="background: #E7F3FF; border: 1px solid #2196F3; padding: 10px; margin-top: 10px;">
                    <img src="/graphic/icons/questionmark.png" style="vertical-align: middle;" />
                    <input type="checkbox" id="auto_renew_farm" <?= !empty($user['farm_assistant_auto_renew']) ? 'checked' : '' ?> onchange="toggleAutoRenew('farm_assistant', this.checked)" /> <?= __('screens.premium.auto_renew') ?>
                    <br />
                    <small><?= __('screens.premium.expires') ?>         <?php
                               if (isset($active_features['farm_assistant']['expires'])) {
                                   $expires = $active_features['farm_assistant']['expires'];
                                   // Convert to timestamp if it's a DATETIME string
                                   if (!is_numeric($expires)) {
                                       $expires = strtotime($expires);
                                   }
                                   echo date('M d, H:i', $expires);
                               }
                               ?></small>
                </div>
            <?php else: ?>
                <div style="text-align: center; margin: 10px 0;">
                    <button class="btn" style="background: green; color: white; padding: 8px 20px;"
                        onclick="const duration = document.querySelector('select[name=duration_farm]').value; activateFeature('farm_assistant', duration, 30)"><?= __('screens.premium.activate_now') ?></button>
                </div>
            <?php endif; ?>

            <div style="text-align: center; margin: 10px 0;">
                <button class="btn"
                    style="background: #8B4513; color: white; padding: 5px 15px;"><?= __('screens.premium.buy_as_gift') ?></button>
            </div>
        </div>

        <!-- Wood Production +20% -->
        <div class="premium-card"
            style="border: 2px solid #8B4513; padding: 15px; background: #F4E4BC; border-radius: 8px; position: relative;">
            <?php if (!empty($active_features['wood_production'])): ?>
                <div style="position: absolute; top: 10px; right: 10px; font-size: 48px; color: green;">✓</div>
            <?php endif; ?>

            <div
                style="background: #8B4513; color: white; padding: 8px; text-align: center; border-radius: 5px; margin-bottom: 10px;">
                <strong><?= __('screens.premium.wood_production_title') ?></strong>
            </div>

            <div style="text-align: center; margin: 20px 0;">
                <img src="/graphic/new/premium/WoodProduction_large.webp" alt="Wood" style="width: 80px; height: 80px;" />
            </div>

            <div style="margin: 15px 0;">
                <strong><?= __('screens.premium.wood_production_desc') ?></strong>
            </div>

            <ul style="margin: 10px 0; padding-left: 20px;">
                <li><?= __('screens.premium.in_all_villages') ?></li>
            </ul>

            <div style="margin: 15px 0; text-align: center;">
                <img src="/graphic/new/premium/time.png" style="vertical-align: middle;" />
                <select name="duration_wood" style="width: 80px;">
                    <option value="90"><?= __('screens.premium.90_days') ?></option>
                    <option value="30"><?= __('screens.premium.30_days') ?></option>
                </select>
                <img src="/graphic/new/premium/coinbag_15x15.png" style="vertical-align: middle;" />
                <strong>150 <?= __('screens.premium.points') ?></strong>
            </div>

            <?php if (!empty($active_features['wood_production'])): ?>
                <div style="text-align: center; margin: 10px 0;">
                    <button class="btn" style="background: green; color: white; padding: 8px 20px;"
                        onclick="const duration = document.querySelector('select[name=duration_wood]').value; activateFeature('wood_production', duration, 150)"><?= __('screens.premium.extend_now') ?></button>
                </div>
                <div style="background: #E7F3FF; border: 1px solid #2196F3; padding: 10px; margin-top: 10px;">
                    <input type="checkbox" id="auto_renew_woodproduction" <?= !empty($user['wood_production_auto_renew']) ? 'checked' : '' ?> onchange="toggleAutoRenew('wood_production', this.checked)" />
                    <?= __('screens.premium.auto_renew') ?>
                    <br />
                    <small><?= __('screens.premium.expires') ?>
                        <?php if (isset($active_features['wood_production']['expires'])) {
                            $expires = $active_features['wood_production']['expires'];
                            echo date('M d, H:i', is_numeric($expires) ? $expires : strtotime($expires));
                        } ?></small>
                </div>
            <?php else: ?>
                <div style="text-align: center; margin: 10px 0;">
                    <button class="btn" style="background: green; color: white; padding: 8px 20px;"
                        onclick="const duration = document.querySelector('select[name=duration_wood]').value; activateFeature('wood_production', duration, 150)"><?= __('screens.premium.activate_now') ?></button>
                </div>
            <?php endif; ?>

            <div style="text-align: center; margin: 10px 0;">
                <button class="btn"
                    style="background: #8B4513; color: white; padding: 5px 15px;"><?= __('screens.premium.buy_as_gift') ?></button>
            </div>
        </div>

        <!-- Clay Production +20% -->
        <div class="premium-card"
            style="border: 2px solid #8B4513; padding: 15px; background: #F4E4BC; border-radius: 8px; position: relative;">
            <?php if (!empty($active_features['clay_production'])): ?>
                <div style="position: absolute; top: 10px; right: 10px; font-size: 48px; color: green;">✓</div>
            <?php endif; ?>

            <div
                style="background: #8B4513; color: white; padding: 8px; text-align: center; border-radius: 5px; margin-bottom: 10px;">
                <strong><?= __('screens.premium.clay_production_title') ?></strong>
            </div>

            <div style="text-align: center; margin: 20px 0;">
                <img src="/graphic/new/premium/StoneProduction_large.webp" alt="Clay" style="width: 80px; height: 80px;" />
            </div>

            <div style="margin: 15px 0;">
                <strong><?= __('screens.premium.clay_production_desc') ?></strong>
            </div>

            <ul style="margin: 10px 0; padding-left: 20px;">
                <li><?= __('screens.premium.in_all_villages') ?></li>
            </ul>

            <div style="margin: 15px 0; text-align: center;">
                <img src="/graphic/new/premium/time.png" style="vertical-align: middle;" />
                <select name="duration_clay" style="width: 80px;">
                    <option value="90"><?= __('screens.premium.90_days') ?></option>
                    <option value="30"><?= __('screens.premium.30_days') ?></option>
                </select>
                <img src="/graphic/new/premium/coinbag_15x15.png" style="vertical-align: middle;" />
                <strong>150 <?= __('screens.premium.points') ?></strong>
            </div>

            <?php if (!empty($active_features['clay_production'])): ?>
                <div style="text-align: center; margin: 10px 0;">
                    <button class="btn" style="background: green; color: white; padding: 8px 20px;"
                        onclick="const duration = document.querySelector('select[name=duration_clay]').value; activateFeature('clay_production', duration, 150)"><?= __('screens.premium.extend_now') ?></button>
                </div>
                <div style="background: #E7F3FF; border: 1px solid #2196F3; padding: 10px; margin-top: 10px;">
                    <input type="checkbox" id="auto_renew_clayproduction" <?= !empty($user['clay_production_auto_renew']) ? 'checked' : '' ?> onchange="toggleAutoRenew('clay_production', this.checked)" />
                    <?= __('screens.premium.auto_renew') ?>
                    <br />
                    <small><?= __('screens.premium.expires') ?>
                        <?php if (isset($active_features['clay_production']['expires'])) {
                            $expires = $active_features['clay_production']['expires'];
                            echo date('M d, H:i', is_numeric($expires) ? $expires : strtotime($expires));
                        } ?></small>
                </div>
            <?php else: ?>
                <div style="text-align: center; margin: 10px 0;">
                    <button class="btn" style="background: green; color: white; padding: 8px 20px;"
                        onclick="const duration = document.querySelector('select[name=duration_clay]').value; activateFeature('clay_production', duration, 150)"><?= __('screens.premium.activate_now') ?></button>
                </div>
            <?php endif; ?>

            <div style="text-align: center; margin: 10px 0;">
                <button class="btn"
                    style="background: #8B4513; color: white; padding: 5px 15px;"><?= __('screens.premium.buy_as_gift') ?></button>
            </div>
        </div>

        <!-- Iron Production +20% -->
        <div class="premium-card"
            style="border: 2px solid #8B4513; padding: 15px; background: #F4E4BC; border-radius: 8px; position: relative;">
            <?php if (!empty($active_features['iron_production'])): ?>
                <div style="position: absolute; top: 10px; right: 10px; font-size: 48px; color: green;">✓</div>
            <?php endif; ?>

            <div
                style="background: #8B4513; color: white; padding: 8px; text-align: center; border-radius: 5px; margin-bottom: 10px;">
                <strong><?= __('screens.premium.iron_production_title') ?></strong>
            </div>

            <div style="text-align: center; margin: 20px 0;">
                <img src="/graphic/new/premium/IronProduction_large.webp" alt="Iron" style="width: 80px; height: 80px;" />
            </div>

            <div style="margin: 15px 0;">
                <strong><?= __('screens.premium.iron_production_desc') ?></strong>
            </div>

            <ul style="margin: 10px 0; padding-left: 20px;">
                <li><?= __('screens.premium.in_all_villages') ?></li>
            </ul>

            <div style="margin: 15px 0; text-align: center;">
                <img src="/graphic/new/premium/time.png" style="vertical-align: middle;" />
                <select name="duration_iron" style="width: 80px;">
                    <option value="90">90 dias</option>
                    <option value="30">30 dias</option>
                </select>
                <img src="/graphic/new/premium/coinbag_15x15.png" style="vertical-align: middle;" />
                <strong>150 <?= __('screens.premium.points') ?></strong>
            </div>

            <?php if (!empty($active_features['iron_production'])): ?>
                <div style="text-align: center; margin: 10px 0;">
                    <button class="btn" style="background: green; color: white; padding: 8px 20px;"
                        onclick="const duration = document.querySelector('select[name=duration_iron]').value; activateFeature('iron_production', duration, 150)"><?= __('screens.premium.extend_now') ?></button>
                </div>
                <div style="background: #E7F3FF; border: 1px solid #2196F3; padding: 10px; margin-top: 10px;">
                    <input type="checkbox" id="auto_renew_ironproduction" <?= !empty($user['iron_production_auto_renew']) ? 'checked' : '' ?> onchange="toggleAutoRenew('iron_production', this.checked)" />
                    <?= __('screens.premium.auto_renew') ?>
                    <br />
                    <small><?= __('screens.premium.expires') ?>
                        <?php if (isset($active_features['iron_production']['expires'])) {
                            $expires = $active_features['iron_production']['expires'];
                            echo date('M d, H:i', is_numeric($expires) ? $expires : strtotime($expires));
                        } ?></small>
                </div>
            <?php else: ?>
                <div style="text-align: center; margin: 10px 0;">
                    <button class="btn" style="background: green; color: white; padding: 8px 20px;"
                        onclick="const duration = document.querySelector('select[name=duration_iron]').value; activateFeature('iron_production', duration, 150)"><?= __('screens.premium.activate_now') ?></button>
                </div>
            <?php endif; ?>

            <div style="text-align: center; margin: 10px 0;">
                <button class="btn"
                    style="background: #8B4513; color: white; padding: 5px 15px;"><?= __('screens.premium.buy_as_gift') ?></button>
            </div>
        </div>

    </div>

<?php elseif ($tab === 'buy'): ?>
    <!-- Premium Purchase Content - Modern Design -->
    <style>
        .premium-buy-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .premium-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .premium-header h2 {
            font-size: 32px;
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .premium-header p {
            color: #7f8c8d;
            font-size: 16px;
        }

        .premium-packages {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(15%, 1fr));
            gap: 2px;
            margin-bottom: 40px;
        }

        .premium-package {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .premium-package:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            border-color: #3498db;
        }

        .premium-package.popular {
            border-color: #f39c12;
            background: linear-gradient(135deg, #fff 0%, #fff9e6 100%);
        }

        .premium-package.popular::before {
            content: "Mais Popular";
            position: absolute;
            top: 15px;
            right: -35px;
            background: #f39c12;
            color: white;
            padding: 5px 40px;
            transform: rotate(45deg);
            font-size: 12px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .package-bonus {
            background: #27ae60;
            color: #8B4513;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 15px;
        }

        .package-image {
            width: 120px;
            height: 120px;
            margin: 15px auto;
            display: block;
        }

        .package-points {
            font-size: 48px;
            font-weight: bold;
            color: #2c3e50;
            margin: 10px 0;
        }

        .package-label {
            color: #7f8c8d;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .package-price {
            background: #3498db;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 20px;
            font-weight: bold;
            margin-top: 15px;
        }

        .premium-package.popular .package-price {
            background: #f39c12;
        }

        .payment-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }

        .payment-section h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 20px;
        }

        .payment-method {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .payment-select {
            flex: 1;
            min-width: 250px;
        }

        .payment-select select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            background: white;
            cursor: pointer;
            transition: border-color 0.3s;
        }

        .payment-select select:focus {
            outline: none;
            border-color: #3498db;
        }

        .payment-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .payment-checkbox input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .help-button {
            background: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }

        .help-button:hover {
            background: #2980b9;
        }

        .footer-links {
            text-align: center;
            padding: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .footer-links a {
            color: #3498db;
            text-decoration: none;
            margin: 0 15px;
            font-size: 13px;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .footer-note {
            color: #95a5a6;
            font-size: 12px;
            margin-top: 10px;
        }
    </style>

    <!-- buy tab: auto-open modal + static footer links so navigation works -->
    <div style="text-align: center; padding: 30px;">
        <p style="font-size: 16px; margin-bottom: 20px;"><?= __('screens.premium.get_premium_points') ?></p>
        <button class="btn" style="background: #8B4513; color: white; font-size: 16px; padding: 12px 30px;" onclick="openPurchaseModal()">
            <?= __('screens.premium.get_premium_points') ?>
        </button>
    </div>

    <!-- Static footer links - outside the modal so navigation always works -->
    <div class="footer-links" style="margin-top: 30px;">
        <a href="game.php?village=<?= $village['id'] ?>&screen=support"><?= __('screens.premium.support_request') ?></a>
        |
        <a href="game.php?village=<?= $village['id'] ?>&screen=terms"><?= __('screens.premium.general_terms') ?></a>
        |
        <a href="game.php?village=<?= $village['id'] ?>&screen=privacy"><?= __('screens.premium.data_protection') ?></a>
        |
        <a href="game.php?village=<?= $village['id'] ?>&screen=legal"><?= __('screens.premium.legal_info') ?></a>
        <p class="footer-note"><?= __('screens.premium.prices_include_tax') ?></p>
    </div>

<?php elseif ($tab === 'cosmetics'): ?>
    <!-- Cosmetics Tab -->
    <div style='display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;'>
        <!-- Animated Scrolls (100 points) -->
        <div class='premium-card'
            style='border: 2px solid #8B4513; padding: 15px; background: #F4E4BC; border-radius: 8px;'>
            <div
                style='background: #8B4513; color: white; padding: 8px; text-align: center; border-radius: 5px; margin-bottom: 10px;'>
                <strong><?= __('screens.premium.animated_red') ?></strong>
            </div>
            <div style='text-align: center; margin: 20px 0;'>
                <img src='/graphic/new/premium/name/effect/name_effect_red.webp' alt='Red Scroll'
                    style='width: 100px; height: 100px;' />
            </div>
            <p><?= __('screens.premium.change_name_color') ?>     <?= __('screens.premium.red') ?>
                <?= __('screens.premium.animated') ?>
                <?= __('screens.premium.for_this_world') ?><br /><?= __('screens.premium.example') ?> <span
                    class="username-animated-red"><?= htmlspecialchars($user['username']) ?></span>
            </p>
            <div style='text-align: center; margin: 10px 0;'>
                <img src='/graphic/new/premium/coinbag_15x15.png' style='vertical-align: middle;' /> <strong>100
                    <?= __('screens.premium.points') ?></strong>
            </div>
            <div style='text-align: center;'>
                <button class='btn' style='background: red; color: white; padding: 8px 20px;'
                    onclick="buyCosmetic('animation', 'red', 'vermelho')"><?= __('screens.premium.acquire') ?></button>
            </div>
        </div>

        <div class='premium-card'
            style='border: 2px solid #8B4513; padding: 15px; background: #F4E4BC; border-radius: 8px;'>
            <div
                style='background: #8B4513; color: white; padding: 8px; text-align: center; border-radius: 5px; margin-bottom: 10px;'>
                <strong><?= __('screens.premium.animated_blue') ?></strong>
            </div>
            <div style='text-align: center; margin: 20px 0;'>
                <img src='/graphic/new/premium/name/effect/name_effect_blue.webp' alt='Blue Scroll'
                    style='width: 100px; height: 100px;' />
            </div>
            <p><?= __('screens.premium.change_name_color') ?>     <?= __('screens.premium.blue') ?>
                <?= __('screens.premium.animated') ?>
                <?= __('screens.premium.for_this_world') ?><br /><?= __('screens.premium.example') ?> <span
                    class="username-animated-blue"><?= htmlspecialchars($user['username']) ?></span>
            </p>
            <div style='text-align: center; margin: 10px 0;'>
                <img src='/graphic/new/premium/coinbag_15x15.png' style='vertical-align: middle;' /> <strong>100
                    <?= __('screens.premium.points') ?></strong>
            </div>
            <div style='text-align: center;'>
                <button class='btn' style='background: blue; color: white; padding: 8px 20px;'
                    onclick="buyCosmetic('animation', 'blue', 'azul')"><?= __('screens.premium.acquire') ?></button>
            </div>
        </div>

        <div class='premium-card'
            style='border: 2px solid #8B4513; padding: 15px; background: #F4E4BC; border-radius: 8px;'>
            <div
                style='background: #8B4513; color: white; padding: 8px; text-align: center; border-radius: 5px; margin-bottom: 10px;'>
                <strong><?= __('screens.premium.animated_pink') ?></strong>
            </div>
            <div style='text-align: center; margin: 20px 0;'>
                <img src='/graphic/new/premium/name/effect/name_effect_pink.webp' alt='Pink Scroll'
                    style='width: 100px; height: 100px;' />
            </div>
            <p><?= __('screens.premium.change_name_color') ?>     <?= __('screens.premium.pink') ?>
                <?= __('screens.premium.animated') ?>
                <?= __('screens.premium.for_this_world') ?><br /><?= __('screens.premium.example') ?> <span
                    class="username-animated-pink"><?= htmlspecialchars($user['username']) ?></span>
            </p>
            <div style='text-align: center; margin: 10px 0;'>
                <img src='/graphic/new/premium/coinbag_15x15.png' style='vertical-align: middle;' /> <strong>100
                    <?= __('screens.premium.points') ?></strong>
            </div>
            <div style='text-align: center;'>
                <button class='btn' style='background: pink; color: white; padding: 8px 20px;'
                    onclick="buyCosmetic('animation', 'pink', 'rosa')"><?= __('screens.premium.acquire') ?></button>
            </div>
        </div>

        <div class='premium-card'
            style='border: 2px solid #8B4513; padding: 15px; background: #F4E4BC; border-radius: 8px;'>
            <div
                style='background: #8B4513; color: white; padding: 8px; text-align: center; border-radius: 5px; margin-bottom: 10px;'>
                <strong><?= __('screens.premium.animated_yellow') ?></strong>
            </div>
            <div style='text-align: center; margin: 20px 0;'>
                <img src='/graphic/new/premium/name/effect/name_effect_yellow.webp' alt='Pink Scroll'
                    style='width: 100px; height: 100px;' />
            </div>
            <p><?= __('screens.premium.change_name_color') ?>     <?= __('screens.premium.yellow') ?>
                <?= __('screens.premium.animated') ?>
                <?= __('screens.premium.for_this_world') ?><br /><?= __('screens.premium.example') ?> <span
                    class="username-animated-yellow"><?= htmlspecialchars($user['username']) ?></span>
            </p>
            <div style='text-align: center; margin: 10px 0;'>
                <img src='/graphic/new/premium/coinbag_15x15.png' style='vertical-align: middle;' /> <strong>100
                    <?= __('screens.premium.points') ?></strong>
            </div>
            <div style='text-align: center;'>
                <button class='btn' style='background: yellow; color: white; padding: 8px 20px;'
                    onclick="buyCosmetic('animation', 'yellow', 'amarelo')"><?= __('screens.premium.acquire') ?></button>
            </div>
        </div>

        <div class='premium-card'
            style='border: 2px solid #8B4513; padding: 15px; background: #F4E4BC; border-radius: 8px;'>
            <div
                style='background: #8B4513; color: white; padding: 8px; text-align: center; border-radius: 5px; margin-bottom: 10px;'>
                <strong><?= __('screens.premium.animated_purple') ?></strong>
            </div>
            <div style='text-align: center; margin: 20px 0;'>
                <img src='/graphic/new/premium/name/effect/name_effect_roxo.webp' alt='Pink Scroll'
                    style='width: 100px; height: 100px;' />
            </div>
            <p><?= __('screens.premium.change_name_color') ?>     <?= __('screens.premium.purple') ?>
                <?= __('screens.premium.animated') ?>
                <?= __('screens.premium.for_this_world') ?><br /><?= __('screens.premium.example') ?> <span
                    class="username-animated-purple"><?= htmlspecialchars($user['username']) ?></span>
            </p>
            <div style='text-align: center; margin: 10px 0;'>
                <img src='/graphic/new/premium/coinbag_15x15.png' style='vertical-align: middle;' /> <strong>100
                    <?= __('screens.premium.points') ?></strong>
            </div>
            <div style='text-align: center;'>
                <button class='btn' style='background: purple; color: white; padding: 8px 20px;'
                    onclick="buyCosmetic('animation', 'purple', 'roxo')"><?= __('screens.premium.acquire') ?></button>
            </div>
        </div>

        <div class='premium-card'
            style='border: 2px solid #8B4513; padding: 15px; background: #F4E4BC; border-radius: 8px;'>
            <div
                style='background: #8B4513; color: white; padding: 8px; text-align: center; border-radius: 5px; margin-bottom: 10px;'>
                <strong><?= __('screens.premium.animated_orange') ?></strong>
            </div>
            <div style='text-align: center; margin: 20px 0;'>
                <img src='/graphic/new/premium/name/effect/name_effect_orange.webp' alt='Pink Scroll'
                    style='width: 100px; height: 100px;' />
            </div>
            <p><?= __('screens.premium.change_name_color') ?>     <?= __('screens.premium.orange') ?>
                <?= __('screens.premium.animated') ?>
                <?= __('screens.premium.for_this_world') ?><br /><?= __('screens.premium.example') ?> <span
                    class="username-animated-orange"><?= htmlspecialchars($user['username']) ?></span>
            </p>
            <div style='text-align: center; margin: 10px 0;'>
                <img src='/graphic/new/premium/coinbag_15x15.png' style='vertical-align: middle;' /> <strong>100
                    <?= __('screens.premium.points') ?></strong>
            </div>
            <div style='text-align: center;'>
                <button class='btn' style='background: orange; color: white; padding: 8px 20px;'
                    onclick="buyCosmetic('animation', 'orange', 'laranja')"><?= __('screens.premium.acquire') ?></button>
            </div>
        </div>
    </div>
    </div>
    <!-- Just color named-->
    </br>
    <div style='display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;'>
        <div class='premium-card'
            style='border: 2px solid #8B4513; padding: 25px; background: #F4E4BC; border-radius: 8px;'>
            <div
                style='background: #8B4513; color: white; padding: 8px; text-align: center; border-radius: 5px; margin-bottom: 10px;'>
                <strong><?= __('screens.premium.scroll_red') ?></strong>
            </div>
            <div style='text-align: center; margin: 20px 0;'>
                <img src='/graphic/new/premium/name/color/name_effect_red.webp' alt='Red Scroll'
                    style='width: 100px; height: 100px;' />
            </div>
            <p><?= __('screens.premium.change_name_color') ?>     <?= __('screens.premium.red') ?>
                <?= __('screens.premium.animated') ?>
                <?= __('screens.premium.for_this_world') ?><br /><?= __('screens.premium.example') ?> <span
                    class="username-color-red"><?= htmlspecialchars($user['username']) ?></span>
            </p>
            <div style='text-align: center; margin: 10px 0;'>
                <img src='/graphic/new/premium/coinbag_15x15.png' style='vertical-align: middle;' /> <strong>100
                    <?= __('screens.premium.points') ?></strong>
            </div>
            <div style='text-align: center;'>
                <button class='btn' style='background: green; color: white; padding: 8px 20px;'
                    onclick="buyCosmetic('color', 'red', 'vermelho')"><?= __('screens.premium.acquire') ?></button>
            </div>
        </div>

        <div class='premium-card'
            style='border: 2px solid #8B4513; padding: 15px; background: #F4E4BC; border-radius: 8px;'>
            <div
                style='background: #8B4513; color: white; padding: 8px; text-align: center; border-radius: 5px; margin-bottom: 10px;'>
                <strong><?= __('screens.premium.scroll_blue') ?></strong>
            </div>
            <div style='text-align: center; margin: 20px 0;'>
                <img src='/graphic/new/premium/name/color/name_effect_blue.webp' alt='Blue Scroll'
                    style='width: 100px; height: 100px;' />
            </div>
            <p><?= __('screens.premium.change_name_color') ?>     <?= __('screens.premium.blue') ?>
                <?= __('screens.premium.for_this_world') ?><br /><?= __('screens.premium.example') ?> <span
                    class="username-color-blue"><?= htmlspecialchars($user['username']) ?></span>
            </p>
            <div style='text-align: center; margin: 10px 0;'>
                <img src='/graphic/new/premium/coinbag_15x15.png' style='vertical-align: middle;' /> <strong>100
                    <?= __('screens.premium.points') ?></strong>
            </div>
            <div style='text-align: center;'>
                <button class='btn' style='background: green; color: white; padding: 8px 20px;'
                    onclick="buyCosmetic('color', 'blue', 'azul')"><?= __('screens.premium.acquire') ?></button>
            </div>
        </div>

        <div class='premium-card'
            style='border: 2px solid #8B4513; padding: 15px; background: #F4E4BC; border-radius: 8px;'>
            <div
                style='background: #8B4513; color: white; padding: 8px; text-align: center; border-radius: 5px; margin-bottom: 10px;'>
                <strong><?= __('screens.premium.scroll_pink') ?></strong>
            </div>
            <div style='text-align: center; margin: 20px 0;'>
                <img src='/graphic/new/premium/name/color/name_effect_pink.webp' alt='Pink Scroll'
                    style='width: 100px; height: 100px;' />
            </div>
            <p><?= __('screens.premium.change_name_color') ?>     <?= __('screens.premium.pink') ?>
                <?= __('screens.premium.animated') ?>
                <?= __('screens.premium.for_this_world') ?><br /><?= __('screens.premium.example') ?> <span
                    class="username-color-pink"><?= htmlspecialchars($user['username']) ?></span>
            </p>
            <div style='text-align: center; margin: 10px 0;'>
                <img src='/graphic/new/premium/coinbag_15x15.png' style='vertical-align: middle;' /> <strong>100
                    <?= __('screens.premium.points') ?></strong>
            </div>
            <div style='text-align: center;'>
                <button class='btn' style='background: green; color: white; padding: 8px 20px;'
                    onclick="buyCosmetic('color', 'pink', 'rosa')"><?= __('screens.premium.acquire') ?></button>
            </div>
        </div>

        <div class='premium-card'
            style='border: 2px solid #8B4513; padding: 15px; background: #F4E4BC; border-radius: 8px;'>
            <div
                style='background: #8B4513; color: white; padding: 8px; text-align: center; border-radius: 5px; margin-bottom: 10px;'>
                <strong><?= __('screens.premium.scroll_yellow') ?></strong>
            </div>
            <div style='text-align: center; margin: 20px 0;'>
                <img src='/graphic/new/premium/name/color/name_effect_yellow.webp' alt='Pink Scroll'
                    style='width: 100px; height: 100px;' />
            </div>
            <p><?= __('screens.premium.change_name_color') ?>     <?= __('screens.premium.yellow') ?>
                <?= __('screens.premium.for_this_world') ?><br /><?= __('screens.premium.example') ?> <span
                    class="username-color-yellow"><?= htmlspecialchars($user['username']) ?></span>
            </p>
            <div style='text-align: center; margin: 10px 0;'>
                <img src='/graphic/new/premium/coinbag_15x15.png' style='vertical-align: middle;' /> <strong>100
                    <?= __('screens.premium.points') ?></strong>
            </div>
            <div style='text-align: center;'>
                <button class='btn' style='background: green; color: white; padding: 8px 20px;'
                    onclick="buyCosmetic('color', 'yellow', 'amarelo')"><?= __('screens.premium.acquire') ?></button>
            </div>
        </div>

        <div class='premium-card'
            style='border: 2px solid #8B4513; padding: 15px; background: #F4E4BC; border-radius: 8px;'>
            <div
                style='background: #8B4513; color: white; padding: 8px; text-align: center; border-radius: 5px; margin-bottom: 10px;'>
                <strong><?= __('screens.premium.scroll_purple') ?></strong>
            </div>
            <div style='text-align: center; margin: 20px 0;'>
                <img src='/graphic/new/premium/name/color/name_effect_pink.webp' alt='Pink Scroll'
                    style='width: 100px; height: 100px;' />
            </div>
            <p><?= __('screens.premium.change_name_color') ?> roxo
                <?= __('screens.premium.for_this_world') ?><br /><?= __('screens.premium.example') ?> <span
                    class="username-color-purple"><?= htmlspecialchars($user['username']) ?></span>
            </p>
            <div style='text-align: center; margin: 10px 0;'>
                <img src='/graphic/new/premium/coinbag_15x15.png' style='vertical-align: middle;' /> <strong>100
                    <?= __('screens.premium.points') ?></strong>
            </div>
            <div style='text-align: center;'>
                <button class='btn' style='background: green; color: white; padding: 8px 20px;'
                    onclick="buyCosmetic('color', 'purple', 'roxo')"><?= __('screens.premium.acquire') ?></button>
            </div>
        </div>

        <div class='premium-card'
            style='border: 2px solid #8B4513; padding: 15px; background: #F4E4BC; border-radius: 8px;'>
            <div
                style='background: #8B4513; color: white; padding: 8px; text-align: center; border-radius: 5px; margin-bottom: 10px;'>
                <strong><?= __('screens.premium.scroll_orange') ?></strong>
            </div>
            <div style='text-align: center; margin: 20px 0;'>
                <img src='/graphic/new/premium/name/color/name_effect_orange.webp' alt='Pink Scroll'
                    style='width: 100px; height: 100px;' />
            </div>
            <p><?= __('screens.premium.change_name_color') ?> laranja
                <?= __('screens.premium.for_this_world') ?><br /><?= __('screens.premium.example') ?> <span
                    class="username-color-orange"><?= htmlspecialchars($user['username']) ?></span>
            </p>
            <div style='text-align: center; margin: 10px 0;'>
                <img src='/graphic/new/premium/coinbag_15x15.png' style='vertical-align: middle;' /> <strong>100
                    <?= __('screens.premium.points') ?></strong>
            </div>
            <div style='text-align: center;'>
                <button class='btn' style='background: green; color: white; padding: 8px 20px;'
                    onclick="buyCosmetic('color', 'orange', 'laranja')"><?= __('screens.premium.acquire') ?></button>
            </div>
        </div>
    </div>

    <!-- Village Skins Section -->
    <h3
        style="margin-top: 40px; margin-bottom: 20px; color: #8B4513; border-bottom: 2px solid #8B4513; padding-bottom: 10px;">
        <?= __('screens.premium.village_appearance') ?>
    </h3>
    <p style="margin-bottom: 20px; color: #666;">
        <?= __('screens.premium.customize_village') ?>
    </p>

    <div
        style='display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-bottom: 30px;'>
        <?php
        $village_skins = [
            ['color' => 'blue', 'name' => __('screens.premium.color_blue'), 'bg' => '#4169E1', 'cost' => 150],
            ['color' => 'red', 'name' => __('screens.premium.color_red'), 'bg' => '#DC143C', 'cost' => 150],
            ['color' => 'turquoise', 'name' => __('screens.premium.color_turquoise'), 'bg' => '#40E0D0', 'cost' => 150],
            ['color' => 'yellow', 'name' => __('screens.premium.color_yellow'), 'bg' => '#FFD700', 'cost' => 150],
            ['color' => 'orange', 'name' => __('screens.premium.color_orange'), 'bg' => '#FF8C00', 'cost' => 150],
            ['color' => 'pink', 'name' => __('screens.premium.color_pink'), 'bg' => '#FF69B4', 'cost' => 150],
            ['color' => 'civilian', 'name' => __('screens.premium.color_civilian'), 'bg' => '#8B7355', 'cost' => 200, 'special' => true],
            ['color' => 'forest', 'name' => __('screens.premium.color_forest'), 'bg' => '#228B22', 'cost' => 200, 'special' => true],
            ['color' => 'mine', 'name' => __('screens.premium.color_mine'), 'bg' => '#696969', 'cost' => 200, 'special' => true]
        ];

        foreach ($village_skins as $skin):
            ?>
            <div class='premium-card'
                style='border: 2px solid #8B4513; padding: 15px; background: #F4E4BC; border-radius: 8px;'>
                <div
                    style='background: <?= $skin['bg'] ?>; color: white; padding: 8px; text-align: center; border-radius: 5px; margin-bottom: 10px;'>
                    <strong><?= $skin['name'] ?><?= isset($skin['special']) ? ' ⭐' : '' ?></strong>
                </div>

                <!-- Preview images -->
                <div style='text-align: center; margin: 15px 0; background: #2C1810; padding: 15px; border-radius: 5px;'>
                    <div style='margin-bottom: 10px;'>
                        <small
                            style='color: #F4E4BC; display: block; margin-bottom: 5px;'><?= __('screens.premium.day_levels') ?></small>
                        <?php
                        $prefix = isset($skin['special']) ? '' : 'banner_';
                        $skinName = $skin['color'];
                        ?>
                        <div style='display: flex; justify-content: center; gap: 5px;'>
                            <img src='/graphic/map/design/<?= $prefix . $skinName ?>_v1.png' alt='v1'
                                style='width: 30px; height: 30px;' onerror="this.src='/graphic/map/v1.png'">
                            <img src='/graphic/map/design/<?= $prefix . $skinName ?>_v2.png' alt='v2'
                                style='width: 30px; height: 30px;' onerror="this.src='/graphic/map/v2.png'">
                            <img src='/graphic/map/design/<?= $prefix . $skinName ?>_v3.png' alt='v3'
                                style='width: 30px; height: 30px;' onerror="this.src='/graphic/map/v3.png'">
                        </div>
                    </div>
                    <div>
                        <small
                            style='color: #F4E4BC; display: block; margin-bottom: 5px;'><?= __('screens.premium.night_levels') ?></small>
                        <div style='display: flex; justify-content: center; gap: 5px;'>
                            <img src='/graphic/map_dark/design/n_<?= $prefix . $skinName ?>_v1.png' alt='v1'
                                style='width: 30px; height: 30px;' onerror="this.src='/graphic/map_dark/v1.png'">
                            <img src='/graphic/map_dark/design/n_<?= $prefix . $skinName ?>_v2.png' alt='v2'
                                style='width: 30px; height: 30px;' onerror="this.src='/graphic/map_dark/v2.png'">
                            <img src='/graphic/map_dark/design/n_<?= $prefix . $skinName ?>_v3.png' alt='v3'
                                style='width: 30px; height: 30px;' onerror="this.src='/graphic/map_dark/v3.png'">
                        </div>
                    </div>
                </div>

                <p style='font-size: 13px; color: #666; margin: 10px 0;'>
                    <?php if (isset($skin['special'])): ?>
                        <strong><?= __('screens.premium.special_skin') ?></strong><br>
                    <?php endif; ?>
                    <?= __('screens.premium.village_will_appear') ?>
                </p>

                <div style='text-align: center; margin: 10px 0;'>
                    <img src='/graphic/new/premium/coinbag_15x15.png' style='vertical-align: middle;' />
                    <strong><?= $skin['cost'] ?>         <?= __('screens.premium.points') ?></strong>
                </div>

                <div style='text-align: center;'>
                    <button class='btn'
                        style='background: <?= $skin['bg'] ?>; color: white; padding: 8px 20px; border: none; border-radius: 4px; cursor: pointer;'
                        onclick="buyVillageSkin('<?= $skin['color'] ?>', '<?= $skin['name'] ?>', <?= $skin['cost'] ?>)"><?= __('screens.premium.acquire') ?></button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


<?php elseif ($tab === 'transfer'): ?>
    <!-- Transfer Tab -->
    <div class="info-box" style="background: #FFF3CD; border: 1px solid #8a5613; color: #644c05; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
        <strong>Tenha em atenção que os Pontos Premium só podem ser transferidos para outras contas no Noblewars.</strong>
    </div>

    <table class='vis' width='100%'>
        <tr>
            <th colspan='2'>
                <img src='/graphic/new/premium/coinbag_15x15.png' style='vertical-align: middle;' />
                Pontos premium transferíveis: 0
            </th>
        </tr>
        <tr>
            <td width='150'>Destinatário:</td>
            <td><input type='text' name='recipient' style='width: 200px;' /></td>
        </tr>
        <tr>
            <td>Pontos Premium:</td>
            <td>
                <input type='number' name='points' min='1' style='width: 100px;' />
                <a href='#'> O que são pontos transferíveis?</a>
            </td>
        </tr>
        <tr>
            <td colspan='2' style='text-align: center; padding: 10px;'>
                <button class='btn'>Avançar</button>
            </td>
        </tr>
    </table>

<?php elseif ($tab === 'points_history'): ?>
    <!-- Points History Tab -->
    <table class='vis' width='100%'>
        <tr>
            <th>Data</th>
            <th>Mundo</th>
            <th>Transação</th>
            <th>Movimento</th>
            <th>Saldo</th>
            <th>Descrição</th>
        </tr>
        <?php if (empty($points_history)): ?>
            <tr>
                <td colspan='6' style='text-align: center; padding: 20px; color: #999;'>
                    Nenhuma transação registada.
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($points_history as $transaction): ?>
                <tr>
                    <td><?= date('d.m.Y H:i', strtotime($transaction['created_at'])) ?></td>
                    <td>Mundo 1</td>
                    <td>
                        <?php
                        $type_labels = [
                            'purchase' => '💰 Compra',
                            'spend' => '🛒 Gasto',
                            'transfer_out' => '📤 Transferência enviada',
                            'transfer_in' => '📥 Transferência recebida',
                            'admin' => '⚙️ Ajuste admin'
                        ];
                        echo $type_labels[$transaction['transaction_type']] ?? $transaction['transaction_type'];
                        ?>
                    </td>
                    <td style='color: <?= $transaction['amount'] > 0 ? 'green' : 'red' ?>; font-weight: bold;'>
                        <?= $transaction['amount'] > 0 ? '+' : '' ?>             <?= $transaction['amount'] ?>
                    </td>
                    <td><?= $transaction['balance_after'] ?></td>
                    <td style='font-size: 12px;'><?= htmlspecialchars($transaction['description']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

<?php elseif ($tab === 'features_history'): ?>
    <!-- Features History Tab -->
    <table class='vis' width='100%'>
        <tr>
            <th>Data</th>
            <th>Mundo</th>
            <th>Funcionalidade</th>
            <th>Duração</th>
            <th>Pontos gastos</th>
            <th>Estado</th>
        </tr>
        <?php if (empty($features_history)): ?>
            <tr>
                <td colspan='6' style='text-align: center; padding: 20px; color: #999;'>
                    Nenhuma funcionalidade ativada.
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($features_history as $feature): ?>
                <tr>
                    <td><?= date('d.m.Y H:i', strtotime($feature['created_at'])) ?></td>
                    <td>Mundo 1</td>
                    <td><?= htmlspecialchars($feature['feature_name']) ?></td>
                    <td><?= $feature['duration_days'] ?> dias</td>
                    <td><?= $feature['points_spent'] ?> pontos</td>
                    <td>
                        <?php
                        $now = time();
                        $expires = strtotime($feature['expires_at']);
                        if ($expires > $now) {
                            $days_left = ceil(($expires - $now) / 86400);
                            echo "<span style='color: green;'>✓ Ativo ($days_left dias)</span>";
                        } else {
                            echo "<span style='color: #999;'>⏱ Expirado</span>";
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

<?php endif; ?>

<script>
    function buyCosmetic(type, value, colorName) {
        showConfirmModal(type, value, colorName);
    }

    function buyVillageSkin(color, colorName, cost) {
        if (!confirm(`Comprar skin de aldeia "${colorName}" por ${cost} pontos premium?\n\nA tua aldeia aparecerá com esta cor no mapa para todos os jogadores.`)) {
            return;
        }

        const formData = new FormData();
        formData.append('action', 'buy_cosmetic');
        formData.append('type', 'village_skin');
        formData.append('value', color);

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
            .then(response => {
                return response.text(); // Get text first to see what's returned
            })
            .then(text => {
                console.log('Response:', text); // Debug: show response
                const data = JSON.parse(text); // Try to parse JSON
                if (data.success) {
                    alert('✅ ' + data.message);
                    location.reload();
                } else {
                    alert('❌ ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erro ao processar compra: ' + error);
            });
    }

    function showConfirmModal(type, value, colorName) {
        const modal = document.getElementById('cosmeticConfirmModal');
        const preview = document.getElementById('cosmeticPreview');
        const description = document.getElementById('cosmeticDescription');
        const warning = document.getElementById('cosmeticWarning');

        // Set preview with actual effect
        const className = type === 'animation' ? 'username-animated-' + value : 'username-color-' + value;
        preview.className = className;
        preview.textContent = window.currentUsername || 'Username';

        // Set description
        const typeText = type === 'animation' ? 'animado' : 'estático';
        description.textContent = `Cosmético: Nome ${typeText} ${colorName}`;

        // For now, always show warning (TODO: check if user has cosmetic)
        const hasExisting = false;

        if (hasExisting) {
            warning.style.display = 'block';
            warning.innerHTML = '<strong>⚠️ Atenção:</strong> Já tens um cosmético deste tipo ativo. Esta compra irá substituir o anterior.';
        } else {
            warning.style.display = 'none';
        }

        // Store purchase data
        modal.dataset.type = type;
        modal.dataset.value = value;

        modal.style.display = 'block';
    }

    function closeConfirmModal() {
        document.getElementById('cosmeticConfirmModal').style.display = 'none';
    }

    function confirmPurchase() {
        const modal = document.getElementById('cosmeticConfirmModal');
        const type = modal.dataset.type;
        const value = modal.dataset.value;

        executePurchase(type, value);
    }

    function executePurchase(type, value) {
        const formData = new FormData();
        formData.append('action', 'buy_cosmetic');
        formData.append('type', type);
        formData.append('value', value);

        // Get current URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const village = urlParams.get('village');
        const screen = urlParams.get('screen');
        const tab = urlParams.get('tab');
        const h = urlParams.get('h');

        // Build URL with parameters
        let url = '/game.php?village=' + village + '&screen=' + screen;
        if (tab) url += '&tab=' + tab;
        if (h) url += '&h=' + h;
        url += '&action=buy_cosmetic';

        fetch(url, {
            method: 'POST',
            body: formData
        })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                return response.text();
            })
            .then(text => {
                console.log('Response text:', text);
                try {
                    const data = JSON.parse(text);
                    if (data.success) {
                        closeConfirmModal();
                        showSuccessModal(data.message, data.new_balance);
                    } else {
                        closeConfirmModal();
                        showErrorModal(data.message);
                    }
                } catch (e) {
                    closeConfirmModal();
                    showErrorModal('Erro ao processar resposta: ' + e.message);
                }
            })
            .catch(error => {
                closeConfirmModal();
                showErrorModal('Erro ao processar compra: ' + error);
            });
    }

    function showSuccessModal(message, newBalance) {
        const modal = document.getElementById('cosmeticResultModal');
        const title = document.getElementById('resultModalTitle');
        const content = document.getElementById('resultModalContent');

        title.textContent = 'Compra Realizada!';
        title.style.color = '#27ae60';
        content.innerHTML = '<p style="margin: 10px 0;">' + message + '</p>' +
            '<p style="margin: 10px 0;"><strong>Novo saldo: ' + newBalance + ' pontos premium</strong></p>';

        modal.style.display = 'block';
    }

    function showErrorModal(message) {
        const modal = document.getElementById('cosmeticResultModal');
        const title = document.getElementById('resultModalTitle');
        const content = document.getElementById('resultModalContent');

        title.textContent = 'Erro';
        title.style.color = '#e74c3c';
        content.innerHTML = '<p style="margin: 10px 0;">' + message + '</p>';

        modal.style.display = 'block';
    }

    function closeResultModal() {
        document.getElementById('cosmeticResultModal').style.display = 'none';
        location.reload();
    }
</script>

<!-- Cosmetic Purchase Confirmation Modal -->
<div id="cosmeticConfirmModal"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 10000;">
    <div
        style="position: relative; width: 500px; margin: 100px auto; background: #f4e4bc; border: 3px solid #8b4513; border-radius: 10px; padding: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.5);">
        <!-- Close Button -->
        <button onclick="closeConfirmModal()"
            style="position: absolute; top: 10px; right: 10px; background: #8b4513; color: white; border: none; width: 30px; height: 30px; border-radius: 50%; cursor: pointer; font-size: 18px; font-weight: bold;">✕</button>

        <!-- Header -->
        <h3 style="text-align: center; color: #8b4513; margin-bottom: 20px; font-size: 20px;">Confirmar Compra</h3>

        <!-- Preview -->
        <div
            style="background: white; border: 2px solid #8b4513; border-radius: 8px; padding: 20px; margin: 20px 0; text-align: center;">
            <div style="margin-bottom: 10px; color: #666; font-size: 14px;">Pré-visualização:</div>
            <div id="cosmeticPreview" style="font-size: 24px; font-weight: bold; margin: 10px 0;"></div>
        </div>

        <!-- Description -->
        <div style="text-align: center; margin: 15px 0;">
            <p id="cosmeticDescription" style="color: #333; font-size: 16px; margin: 10px 0;"></p>

            <!-- Warning for replacement -->
            <div id="cosmeticWarning"
                style="display: none; background: #fff3cd; border: 2px solid #ffc107; border-radius: 5px; padding: 10px; margin: 15px 0; color: #856404; font-size: 14px;">
            </div>

            <p style="color: #666; font-size: 14px;">
                <img src="/graphic/new/premium/coinbag_15x15.png" style="vertical-align: middle;" />
                <strong>Custo: 100 pontos premium</strong>
            </p>
        </div>

        <!-- Buttons -->
        <div style="display: flex; gap: 10px; justify-content: center; margin-top: 20px;">
            <button onclick="closeConfirmModal()"
                style="background: #999; color: white; border: none; padding: 10px 30px; border-radius: 5px; cursor: pointer; font-size: 14px; font-weight: bold;">Cancelar</button>
            <button onclick="confirmPurchase()"
                style="background: #27ae60; color: white; border: none; padding: 10px 30px; border-radius: 5px; cursor: pointer; font-size: 14px; font-weight: bold;">Confirmar
                Compra</button>
        </div>
    </div>
</div>

<!-- Modal de Compra Premium -->
<div id="premiumPurchaseModal" class="premium-modal" style="display: none;">
    <div class="modal-overlay" onclick="closePremiumModal()"></div>
    <div class="modal-content-premium">
        <button class="modal-close-premium" onclick="closePremiumModal()">×</button>

        <div class="modal-header-premium">
            <img src="/graphic/new/premium/gold_coins.png" alt="Premium"
                style="width: 60px; height: 60px; margin-right: 15px;">
            <h2><?= __('screens.premium.modal_title') ?></h2>
        </div>

        <div class="modal-body-premium">
            <!-- Pacotes Premium -->
            <div class="modal-packages-premium">
                <?php
                $modal_packages = [
                    ['base' => 200, 'bonus' => 0, 'total' => 200, 'price' => '3,99', 'popular' => false, 'image' => 'product_01.png'],
                    ['base' => 500, 'bonus' => 20, 'total' => 600, 'price' => '9,99', 'popular' => false, 'image' => 'product_02.png'],
                    ['base' => 1000, 'bonus' => 50, 'total' => 1500, 'price' => '19,99', 'popular' => true, 'image' => 'product_03.png'],
                    ['base' => 2500, 'bonus' => 100, 'total' => 5000, 'price' => '49,99', 'popular' => false, 'image' => 'product_04.png'],
                    ['base' => 4000, 'bonus' => 112, 'total' => 8500, 'price' => '79,99', 'popular' => false, 'image' => 'product_05.png']
                ];

                foreach ($modal_packages as $pkg):
                    ?>
                    <div class="modal-package-premium <?= $pkg['popular'] ? 'popular' : '' ?>">
                        <?php if ($pkg['bonus'] > 0): ?>
                            <div class="modal-package-bonus-premium"><?= $pkg['base'] ?> + <?= $pkg['bonus'] ?>%</div>
                        <?php endif; ?>

                        <div class="modal-package-points-premium"><?= number_format($pkg['total'], 0, ',', '.') ?></div>
                        <div class="modal-package-label-premium"><?= __('screens.premium.gold_bags') ?></div>

                        <div class="modal-package-image-premium">
                            <img src="/graphic/new/premium/<?= $pkg['image'] ?>" alt="Moedas">
                        </div>

                        <?php if ($pkg['popular']): ?>
                            <div class="modal-package-badge-premium"><?= __('screens.premium.most_popular') ?></div>
                        <?php endif; ?>

                        <div class="modal-package-price-premium"><?= $pkg['price'] ?> €</div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Layout em 2 colunas: Decoração (60%) + Payment (40%) -->
            <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 20px; margin-bottom: 25px;">
                <!-- Imagem decorativa -->
                <div class="modal-decoration-premium">
                    <img src="/graphic/index/bg-noble2.jpg" alt="Decoração">
                </div>

                <!-- Método de Pagamento -->
                <div class="modal-payment-premium">
                    <!-- Inline Notification Warning Container -->
                    <div id="premium-warning-message" style="display:none; color: #ffaa00; font-weight: bold; margin-bottom: 12px; background: rgba(44, 24, 16, 0.95); padding: 10px 15px; border-radius: 5px; border: 1px solid #ffaa00; text-align: left; font-size: 12px; line-height: 1.5; box-sizing: border-box;">
                        ⚠️ <span id="premium-warning-text"></span>
                    </div>

                    <label><?= __('screens.premium.how_to_pay') ?></label>
                    <div class="payment-row-premium">
                        <div class="payment-select-premium">
                            <img id="paymentMethodIcon" src="/graphic/new/premium/paypal.png" alt="PayPal"
                                style="width: 20px; margin-right: 5px;" onerror="this.style.display='none'">
                            <select id="paymentMethod" onchange="changePaymentMethod(this.value)" style="background: transparent; border: none; color: #F4E4BC; font-weight: bold; cursor: pointer; outline: none; font-size: 13px; width: 100%;">
                                <option value="paypal" style="background: #2C1810; color: #F4E4BC;">PayPal</option>
                                <option value="mbway" style="background: #2C1810; color: #F4E4BC;">MB WAY</option>
                            </select>
                        </div>
                        <button class="payment-dropdown-premium" style="font-size: 13px; padding: 12px 15px; width: auto; min-width: 140px; white-space: nowrap;">Pagar com PayPal</button>
                    </div>

                    <div class="payment-save-premium">
                        <label>
                            <input type="checkbox" id="saveAccount">
                            <span><?= __('screens.premium.save_account') ?></span>
                        </label>
                        <button type="button" class="payment-help-premium"
                            title="Guardar informações de pagamento para compras futuras"
                            onclick="showSavePaymentHelp(event)">?</button>
                    </div>

                    <!-- PayPal Buttons appear here after clicking ▼ -->
                    <div id="paypal-button-container" style="display:none; margin-top: 15px;"></div>

                    <!-- MB WAY Input/Wait Form appear here after selecting MB WAY and clicking checkout -->
                    <div id="mbway-container" style="display:none; margin-top: 15px; background: rgba(44, 24, 16, 0.95); padding: 15px; border-radius: 6px; border: 1.5px solid #FF69B4; text-align: left; font-size: 13px; line-height: 1.6; max-width: 100%; box-sizing: border-box;">
                        <!-- Step 1: Input phone number -->
                        <div id="mbway-step-input">
                            <div style="font-weight: bold; color: #FF69B4; font-size: 14px; margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                                <img src="/graphic/new/premium/mbway.png" style="width: 20px; height: auto;" alt="MB WAY">
                                Pagar com MB WAY
                            </div>
                            <p style="margin: 0 0 10px 0; color: #F4E4BC;">Insere o teu número de telemóvel associado ao MB WAY para iniciar o pagamento:</p>
                            <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 10px;">
                                <span style="color: #F4E4BC; font-weight: bold;">+351</span>
                                <input type="text" id="mbway-phone" maxlength="9" placeholder="9xxxxxxxx" style="background: rgba(0,0,0,0.3); border: 1px solid #8B4513; padding: 8px; color: #F4E4BC; font-size: 14px; border-radius: 4px; width: 120px; font-family: monospace; outline: none; text-align: center;">
                                <button type="button" onclick="startMbwayPayment()" class="payment-dropdown-premium" style="background: #FF69B4; color: #fff; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 13px; transition: 0.3s; margin: 0; display: inline-block;">Pagar</button>
                            </div>
                            <div id="mbway-input-error" style="color: #ff4d4d; font-weight: bold; display: none; margin-top: 5px;"></div>
                        </div>

                        <!-- Step 2: Waiting screen -->
                        <div id="mbway-step-waiting" style="display: none; text-align: center; padding: 10px 0;">
                            <div style="font-weight: bold; color: #FF69B4; font-size: 14px; margin-bottom: 10px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <img src="/graphic/new/premium/mbway.png" style="width: 20px; height: auto;" alt="MB WAY">
                                A aguardar MB WAY...
                            </div>
                            <div style="margin: 15px 0;">
                                <!-- Elegant Loader -->
                                <div class="mbway-spinner" style="width: 30px; height: 30px; border: 3px solid rgba(255,105,180,0.1); border-left-color: #FF69B4; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto;"></div>
                            </div>
                            <p style="margin: 10px 0; color: #F4E4BC; font-size: 13px;">
                                Enviámos uma notificação para o telemóvel <strong id="mbway-waiting-phone" style="color: #FF69B4;">9xxxxxxxx</strong>.<br>
                                Abre a aplicação MB WAY e autoriza o pagamento de <strong id="mbway-waiting-amount" style="color: #FF69B4;">0.00 €</strong>.
                            </p>
                            <div style="margin-top: 20px; display: flex; justify-content: center; gap: 10px;">
                                <button type="button" onclick="cancelMbwayPayment()" class="payment-dropdown-premium" style="background: #B22222; color: #fff; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 13px; transition: 0.3s; margin: 0; display: inline-block;">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Links legais -->
        <div class="modal-footer-premium">
            <a href="game.php?village=<?= $village['id'] ?>&screen=support"><?= __('screens.premium.support_request') ?></a>
            <span>|</span>
            <a href="game.php?village=<?= $village['id'] ?>&screen=terms"><?= __('screens.premium.general_terms') ?></a>
            <span>|</span>
            <a href="game.php?village=<?= $village['id'] ?>&screen=privacy"><?= __('screens.premium.data_protection') ?></a>
            <span>|</span>
            <a href="game.php?village=<?= $village['id'] ?>&screen=legal"><?= __('screens.premium.legal_info') ?></a>
            <p class="footer-note-premium"><?= __('screens.premium.prices_include_tax') ?></p>
        </div>
    </div>
</div>
</div>

<style>
    .premium-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10000;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding-top: 40px;
        box-sizing: border-box;
    }

    .modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.85);
    }

    .modal-content-premium {
        position: relative;
        width: 95%;
        max-width: 1020px;
        max-height: 82vh !important;
        overflow-y: auto !important;
        background: linear-gradient(135deg, #4A1810 0%, #2C1810 100%);
        border: 4px solid #8B4513;
        border-radius: 12px;
        box-shadow: 0 10px 50px rgba(0, 0, 0, 0.7);
    }

    .modal-close-premium {
        position: absolute;
        top: 10px;
        right: 15px;
        background: rgba(0, 0, 0, 0.5);
        border: 2px solid #8B4513;
        font-size: 32px;
        color: #F4E4BC;
        cursor: pointer;
        z-index: 1;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s;
    }

    .modal-close-premium:hover {
        background: rgba(255, 0, 0, 0.3);
        transform: rotate(90deg);
        border-color: #ff0000;
    }

    .modal-header-premium {
        padding: 12px 25px;
        background: linear-gradient(to bottom, rgba(139, 69, 19, 0.4), transparent);
        border-bottom: 3px solid #8B4513;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-header-premium h2 {
        margin: 0;
        color: #F4E4BC;
        font-size: 26px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    }

    .modal-body-premium {
        padding: 20px 30px;
    }

    .modal-packages-premium {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 12px;
        margin-bottom: 15px;
    }

    .modal-package-premium {
        background: linear-gradient(135deg, #8B0000 0%, #4A0000 100%);
        border: 3px solid #DAA520;
        border-radius: 8px;
        padding: 8px 5px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        position: relative;
    }

    .modal-package-premium:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(218, 165, 32, 0.5);
        border-color: #FFD700;
    }

    .modal-package-premium.popular {
        background: linear-gradient(135deg, #2D5016 0%, #1A3010 100%);
    }

    .modal-package-bonus-premium {
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-50%);
        background: #27ae60;
        color: white;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: bold;
        white-space: nowrap;
    }

    .modal-package-points-premium {
        font-size: 24px;
        font-weight: bold;
        color: white;
        margin: 5px 0;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .modal-package-label-premium {
        font-size: 11px;
        color: #F4E4BC;
        margin-bottom: 5px;
    }

    .modal-package-image-premium {
        margin: 5px 0;
        min-height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-package-image-premium img {
        max-width: 45px;
        height: auto;
    }

    .modal-package-badge-premium {
        background: #2563eb;
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: bold;
        margin: 5px 0;
    }

    .modal-package-price-premium {
        font-size: 16px;
        font-weight: bold;
        color: #DAA520;
        background: rgba(0, 0, 0, 0.4);
        padding: 5px 8px;
        border-radius: 4px;
        margin-top: 5px;
    }

    .modal-decoration-premium {
        margin: 0;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid #8B4513;
    }

    .modal-decoration-premium img {
        width: 100%;
        height: 110px;
        object-fit: cover;
    }

    .modal-payment-premium {
        background: rgba(139, 69, 19, 0.3);
        padding: 20px;
        border-radius: 8px;
        border: 2px solid #8B4513;
    }

    .modal-payment-premium label {
        display: block;
        margin-bottom: 12px;
        font-weight: bold;
        color: #F4E4BC;
        font-size: 14px;
    }

    .payment-row-premium {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }

    .payment-select-premium {
        flex: 1;
        display: flex;
        align-items: center;
        background: #2C1810;
        border: 2px solid #8B4513;
        border-radius: 4px;
        padding: 0 15px;
    }

    .payment-select-premium select {
        flex: 1;
        padding: 12px 10px;
        border: none;
        background: transparent;
        color: #F4E4BC;
        font-size: 14px;
        cursor: pointer;
    }

    .payment-dropdown-premium {
        padding: 12px 20px;
        background: #DAA520;
        border: none;
        border-radius: 4px;
        color: #2C1810;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.3s;
    }

    .payment-dropdown-premium:hover {
        background: #FFD700;
    }

    .payment-save-premium {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .payment-save-premium label {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        margin: 0;
    }

    .payment-save-premium input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .payment-save-premium span {
        color: #F4E4BC;
        font-weight: normal;
    }

    .payment-help-premium {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #DAA520;
        border: none;
        color: #2C1810;
        font-weight: bold;
        cursor: help;
        transition: all 0.3s;
    }

    .payment-help-premium:hover {
        background: #FFD700;
        transform: scale(1.1);
    }

    .modal-footer-premium {
        margin-top: 10px;
        padding-top: 15px;
        border-top: 2px solid #8B4513;
        text-align: center;
    }

    .modal-footer-premium a {
        color: #DAA520;
        text-decoration: none;
        font-size: 12px;
        transition: color 0.3s;
    }

    .modal-footer-premium a:hover {
        color: #FFD700;
        text-decoration: underline;
    }

    .modal-footer-premium span {
        color: #666;
        margin: 0 8px;
    }

    .footer-note-premium {
        margin-top: 12px;
        font-size: 11px;
        color: #999;
    }

    @media (max-width: 1024px) {
        .modal-packages-premium {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .modal-packages-premium {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<!-- PayPal JS SDK — loaded dynamically with Client ID from server config -->
<script>
window.paypalConfigured = false;
(function() {
    fetch('game.php?village=<?= $village['id'] ?>&screen=paypal&action=config&t=' + new Date().getTime())
        .then(r => r.json())
        .then(cfg => {
            if (!cfg.client_id || cfg.client_id.startsWith('COLOCA')) {
                console.warn('PayPal: credenciais não configuradas em app/Config/paypal.php');
                window.paypalConfigured = false;
                return;
            }
            window.paypalConfigured = true;
            const script = document.createElement('script');
            script.src = 'https://www.paypal.com/sdk/js?client-id=' + encodeURIComponent(cfg.client_id) + '&currency=EUR';
            document.head.appendChild(script);
        })
        .catch(() => {
            console.warn('PayPal SDK: falha ao obter client_id');
            window.paypalConfigured = false;
        });
})();
</script>

<script>
    let selectedPackage = null;

    function openPremiumModal() {
        document.getElementById('premiumPurchaseModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        selectedPackage = null; // Reset selection
        updatePackageSelection();
        clearPremiumWarning();
    }

    function closePremiumModal() {
        document.getElementById('premiumPurchaseModal').style.display = 'none';
        document.body.style.overflow = 'auto';
        if (typeof resetMbwayUI === 'function') {
            resetMbwayUI();
        }
        clearPremiumWarning();
    }

    function selectPackage(index) {
        selectedPackage = index;
        updatePackageSelection();
        clearPremiumWarning();
    }

    function updatePackageSelection() {
        const packages = document.querySelectorAll('.modal-package-premium');
        packages.forEach((pkg, index) => {
            if (index === selectedPackage) {
                pkg.style.borderColor = '#FFD700';
                pkg.style.boxShadow = '0 0 20px rgba(255, 215, 0, 0.6)';
                pkg.style.transform = 'scale(1.05)';
            } else {
                pkg.style.borderColor = '#DAA520';
                pkg.style.boxShadow = 'none';
                pkg.style.transform = 'scale(1)';
            }
        });
    }

    function processPurchase() {
        clearPremiumWarning();

        if (selectedPackage === null) {
            showPremiumWarning('Por favor, seleciona um pacote primeiro!');
            return;
        }

        const method = document.getElementById('paymentMethod').value;
        if (method === 'paypal') {
            const paypalContainer = document.getElementById('paypal-button-container');
            paypalContainer.style.display = 'block';
            document.getElementById('mbway-container').style.display = 'none';

            // Clear previous render if any
            paypalContainer.innerHTML = '';

            if (!window.paypalConfigured) {
                paypalContainer.innerHTML = `
                    <div style="color: #ff4d4d; font-weight: bold; margin-top: 10px; background: rgba(44, 24, 16, 0.95); padding: 15px; border-radius: 6px; border: 1.5px solid #ff4d4d; text-align: left; font-size: 13px; line-height: 1.6; max-width: 100%; box-sizing: border-box;">
                        ⚠️ <strong style="color: #ff4d4d; font-size: 14px;">Erro de Configuração do PayPal:</strong><br>
                        O SDK do PayPal não pôde ser carregado. Isto deve-se ao facto de as credenciais no ficheiro 
                        <code style="background: rgba(255,255,255,0.15); padding: 2px 5px; border-radius: 3px; font-family: monospace; color: #fff;">app/Config/paypal.php</code> 
                        ainda conterem os valores padrão de exemplo (como <code style="background: rgba(255,255,255,0.15); padding: 2px 5px; border-radius: 3px; font-family: monospace; color: #fff;">COLOCA_AQUI_...</code>).<br><br>
                        <strong>Como resolver:</strong>
                        <ol style="margin-top: 5px; padding-left: 20px; color: #F4E4BC;">
                            <li>Abre o ficheiro <code style="background: rgba(255,255,255,0.15); padding: 2px 5px; border-radius: 3px; font-family: monospace; color: #fff;">app/Config/paypal.php</code> no teu editor.</li>
                            <li>Substitui os valores do <code style="background: rgba(255,255,255,0.15); padding: 2px 5px; border-radius: 3px; font-family: monospace; color: #fff;">sandbox_client_id</code> e <code style="background: rgba(255,255,255,0.15); padding: 2px 5px; border-radius: 3px; font-family: monospace; color: #fff;">sandbox_client_secret</code> pelas tuas credenciais do Sandbox.</li>
                            <li><strong>Garante que guardas o ficheiro</strong> após a edição.</li>
                            <li>Atualiza a página (F5) e tenta novamente.</li>
                        </ol>
                    </div>`;
                return;
            }

            if (typeof paypal === 'undefined') {
                paypalContainer.innerHTML = `
                    <div style="color: #ffaa00; font-weight: bold; margin-top: 10px; background: rgba(44, 24, 16, 0.95); padding: 15px; border-radius: 6px; border: 1.5px solid #ffaa00; text-align: left; font-size: 13px; line-height: 1.6; max-width: 100%; box-sizing: border-box;">
                        ⏳ <strong style="color: #ffaa00; font-size: 14px;">A carregar o PayPal...</strong><br>
                        O script de pagamento está a ser descarregado dos servidores seguros do PayPal. 
                        Por favor, aguarda uns segundos e clica novamente em "Pagar com PayPal".<br><br>
                        <small style="color: #aaa;">Se este aviso persistir por mais de 10 segundos, verifica a consola de desenvolvimento (F12) e a tua ligação à Internet.</small>
                    </div>`;
                return;
            }

            // Hide the checkout button and show PayPal buttons
            document.querySelector('.payment-dropdown-premium').style.display = 'none';

            paypal.Buttons({
                style: {
                    layout: 'vertical',
                    color:  'gold',
                    shape:  'rect',
                    label:  'pay'
                },

                // Step 1: Create order on server
                createOrder: function() {
                    return fetch('game.php?village=<?= $village['id'] ?>&screen=paypal', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `action=create_order&package=${selectedPackage}`
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.error) throw new Error(data.error);
                        return data.id;
                    });
                },

                // Step 2: Capture after user approves on PayPal
                onApprove: function(data) {
                    return fetch('game.php?village=<?= $village['id'] ?>&screen=paypal', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `action=capture_order&order_id=${data.orderID}`
                    })
                    .then(r => r.json())
                    .then(result => {
                        if (result.success) {
                            closePremiumModal();
                            alert('✅ ' + result.message);
                            window.location.reload();
                        } else {
                            alert('❌ Erro: ' + (result.error || 'Pagamento não confirmado.'));
                        }
                    });
                },

                onCancel: function() {
                    // Restore button
                    document.querySelector('.payment-dropdown-premium').style.display = 'inline-block';
                    paypalContainer.style.display = 'none';
                },

                onError: function(err) {
                    console.error('PayPal error:', err);
                    alert('Erro no PayPal. Por favor, tenta novamente.');
                    document.querySelector('.payment-dropdown-premium').style.display = 'inline-block';
                    paypalContainer.style.display = 'none';
                }
            }).render('#paypal-button-container');
        } else if (method === 'mbway') {
            document.getElementById('paypal-button-container').style.display = 'none';
            document.querySelector('.payment-dropdown-premium').style.display = 'none';

            const mbwayContainer = document.getElementById('mbway-container');
            mbwayContainer.style.display = 'block';

            // Reset to step 1
            document.getElementById('mbway-step-input').style.display = 'block';
            document.getElementById('mbway-step-waiting').style.display = 'none';
            document.getElementById('mbway-phone').value = '';
            document.getElementById('mbway-input-error').style.display = 'none';
        }
    }

    let currentMbwayOrderId = null;

    function changePaymentMethod(method) {
        const paypalBtn = document.querySelector('.payment-dropdown-premium');
        const paypalContainer = document.getElementById('paypal-button-container');
        const mbwayContainer = document.getElementById('mbway-container');
        const methodIcon = document.getElementById('paymentMethodIcon');

        // Reset containers
        paypalContainer.style.display = 'none';
        mbwayContainer.style.display = 'none';

        if (method === 'paypal') {
            methodIcon.src = '/graphic/new/premium/paypal.png';
            paypalBtn.style.display = 'inline-block';
            paypalBtn.textContent = 'Pagar com PayPal';
        } else if (method === 'mbway') {
            methodIcon.src = '/graphic/new/premium/mbway.png';
            paypalBtn.style.display = 'inline-block';
            paypalBtn.textContent = 'Pagar com MB WAY';
        }
    }

    function startMbwayPayment() {
        const phone = document.getElementById('mbway-phone').value.trim();
        const errorDiv = document.getElementById('mbway-input-error');
        errorDiv.style.display = 'none';

        if (!/^9[0-9]{8}$/.test(phone)) {
            errorDiv.textContent = '⚠️ Número de telemóvel inválido. Deve ter 9 dígitos e começar por 9.';
            errorDiv.style.display = 'block';
            return;
        }

        // Show loading state
        const payBtn = document.querySelector('#mbway-step-input button');
        const originalText = payBtn.textContent;
        payBtn.disabled = true;
        payBtn.textContent = 'A processar...';

        fetch('game.php?village=<?= $village['id'] ?>&screen=paypal', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=create_mbway_order&package=${selectedPackage}&phone=${phone}`
        })
        .then(r => r.json())
        .then(data => {
            payBtn.disabled = false;
            payBtn.textContent = originalText;

            if (data.error) {
                errorDiv.textContent = '⚠️ ' + data.error;
                errorDiv.style.display = 'block';
                return;
            }

            currentMbwayOrderId = data.id;

            // Transition to Step 2: Waiting screen
            document.getElementById('mbway-step-input').style.display = 'none';
            document.getElementById('mbway-step-waiting').style.display = 'block';
            document.getElementById('mbway-waiting-phone').textContent = data.phone;
            document.getElementById('mbway-waiting-amount').textContent = data.amount + ' €';
        })
        .catch(err => {
            payBtn.disabled = false;
            payBtn.textContent = originalText;
            errorDiv.textContent = '⚠️ Erro ao comunicar com o servidor. Tenta novamente.';
            errorDiv.style.display = 'block';
            console.error('MB WAY error:', err);
        });
    }



    function cancelMbwayPayment() {
        if (!currentMbwayOrderId) {
            resetMbwayUI();
            return;
        }

        fetch('game.php?village=<?= $village['id'] ?>&screen=paypal', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=cancel_mbway_order&order_id=${currentMbwayOrderId}`
        })
        .then(() => {
            resetMbwayUI();
        })
        .catch(() => {
            resetMbwayUI();
        });
    }

    function showPremiumWarning(msg) {
        const warningDiv = document.getElementById('premium-warning-message');
        const warningText = document.getElementById('premium-warning-text');
        if (warningDiv && warningText) {
            warningText.textContent = msg;
            warningDiv.style.display = 'block';
            warningDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    function clearPremiumWarning() {
        const warningDiv = document.getElementById('premium-warning-message');
        if (warningDiv) {
            warningDiv.style.display = 'none';
        }
    }

    function showSavePaymentHelp(event) {
        if (event) event.preventDefault();
        const msg = "Esta opção permite guardar os seus dados de faturação no navegador para compras futuras, agilizando o checkout na próxima vez.";
        if (typeof UI !== 'undefined' && typeof UI.InfoMessage === 'function') {
            UI.InfoMessage(msg, 5000);
        } else {
            alert(msg);
        }
    }

    function resetMbwayUI() {
        currentMbwayOrderId = null;
        document.getElementById('mbway-container').style.display = 'none';
        document.querySelector('.payment-dropdown-premium').style.display = 'inline-block';
    }

        // Add click event to dropdown button
        const dropdownBtn = document.querySelector('.payment-dropdown-premium');
        if (dropdownBtn) {
            dropdownBtn.addEventListener('click', function () {
                processPurchase();
            });
        }

    // Close modal when clicking outside
    document.getElementById('purchaseModal')?.addEventListener('click', function (e) {
        if (e.target === this) {
            closePurchaseModal();
        }
    });

    // Update cost display when duration changes
    function updateCostDisplay(selectName, feature, costElementId) {
        const select = document.querySelector(`select[name="${selectName}"]`);
        const costElement = document.getElementById(costElementId);

        if (select && costElement) {
            select.addEventListener('change', function () {
                const duration = parseInt(this.value);
                const cost = calculateCost(feature, duration);
                costElement.textContent = cost + ' pontos';
            });
        }
    }

    // Initialize cost displays for all features
    document.addEventListener('DOMContentLoaded', function () {
        updateCostDisplay('duration_manager', 'account_manager', 'cost_manager');
        updateCostDisplay('duration_farm', 'farm_assistant', 'cost_farm');
        updateCostDisplay('duration_wood', 'wood_production', 'cost_wood');
        updateCostDisplay('duration_clay', 'clay_production', 'cost_clay');
        updateCostDisplay('duration_iron', 'iron_production', 'cost_iron');
    });
    // Adicionar evento de clique aos pacotes e botões
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closePremiumModal();
        }
    });

    // Adicionar evento de clique aos pacotes e botões
    document.addEventListener('DOMContentLoaded', function () {
        // Add click event to packages
        const packages = document.querySelectorAll('.modal-package-premium');
        packages.forEach((pkg, index) => {
            pkg.addEventListener('click', function () {
                selectPackage(index);
            });
            pkg.style.cursor = 'pointer';
        });

        // Add click event to dropdown button
        const dropdownBtn = document.querySelector('.payment-dropdown-premium');
        if (dropdownBtn) {
            dropdownBtn.addEventListener('click', function () {
                processPurchase();
            });
        }

        // Encontrar todos os botões de compra existentes e adicionar o evento
        const buyButtons = document.querySelectorAll('.premium-package button, .premium-package');
        buyButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                if (e.target.tagName === 'BUTTON' || e.target.classList.contains('premium-package')) {
                    openPremiumModal();
                }
            });
        });
    });
</script>
</content>
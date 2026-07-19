<?php
// Layout helpers
$is_own_profile = ($user['id'] == $village['userid']);
?>

<!-- Include Name Cosmetics CSS -->
<link rel="stylesheet" href="/css/name_cosmetics.css">

<h2><?= __('screens.profile.profile') ?></h2>

<?php if (!empty($success)): ?>
    <div class="success"
        style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<!-- Tabs Navigation Container -->
<table class="content-border" width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td>
            <table class="main" width="100%" align="center">
                <tr>
                    <td id="content_value">
                        <!-- Navigation Tabs -->
                        <table class="vis submenu-vis" width="100%">
                            <tr>
                                <?php foreach ($tabs as $key => $label): ?>
                                    <?php
                                    $is_active = ($key === $current_tab);
                                    $bg_color = $is_active ? '#e5c389' : '#f4e4bc';
                                    $label_display = ($key === 'profile') ? \App\Helpers\CosmeticHelper::formatUsername($user['username'], $user['id']) : htmlspecialchars($label);
                                    ?>
                                    <td align="center"
                                        style="background-color: <?= $bg_color ?>; padding: 4px 10px; border: 1px solid #7d510f;">
                                        <a href="game.php?village=<?= $village['id'] ?>&screen=profile&mode=<?= $key ?>"
                                            style="text-decoration: none; font-weight: bold; color: #5d2f09;">
                                            <?= $label_display ?>
                                        </a>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        </table>

                        <?php if ($current_tab === 'profile'): ?>
                            <div
                                style="background-color: #fceec4; padding: 10px; border: 1px solid #c1a264; margin-top: 5px;">

                                <div style="margin-bottom: 10px;">
                                    <div style="float: right;">
                                        <a href="#" onclick="$('#edit_profile_form').toggle(); return false;"
                                            class="btn"><?= __('screens.profile.edit_profile') ?></a>
                                    </div>
                                    <h3 style="margin: 0; color: #5d2f09;">
                                        <?= \App\Helpers\CosmeticHelper::formatUsername($user['username'], $user['id']) ?>
                                    </h3>
                                    <div style="clear: both;"></div>
                                </div>

                                <!-- Main Content Table -->
                                <table width="100%">
                                    <tr>
                                        <!-- Left Column -->
                                        <td valign="top" width="45%">
                                            <div
                                                style="background-color: #f0e6c2; padding: 5px; border: 1px solid #7d510f; margin-bottom: 10px;">
                                                <table width="100%">
                                                    <tr>
                                                        <td width="120" valign="top">
                                                            <!-- Avatar + Coat of Arms (Brasão) -->
                                                            <div
                                                                style="background-color: #5d4037; border: 2px solid #3e2723; width: 100%; height: 120px; display: flex; align-items: center; justify-content: center;">
                                                                <?php if (isset($user['avatar']) && $user['avatar'] > 0): ?>
                                                                    <img src="graphic/player/profile/<?= $user['avatar'] ?>.webp"
                                                                        style="width: 100%; height: 100%; object-fit: cover;">
                                                                <?php else: ?>
                                                                    <img src="graphic/player/profile/default.webp"
                                                                        style="width: 100%; height: 100%; object-fit: cover;">
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                        <td valign="top" style="padding-left: 10px;">
                                                            <table width="100%" cellspacing="0">
                                                                <tr>
                                                                    <td><strong><?= __('screens.profile.points') ?></strong>
                                                                    </td>
                                                                    <td align="right"><?= number_format($user['points']) ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong><?= __('screens.profile.rank') ?></strong>
                                                                    </td>
                                                                    <td align="right"><?= $user['rang'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong><?= __('screens.profile.tribe') ?></strong>
                                                                    </td>
                                                                    <td align="right">
                                                                        <?php if ($user['ally'] > 0): ?>
                                                                            <a
                                                                                href="game.php?village=<?= $village['id'] ?>&screen=ally&mode=profile&id=<?= $user['ally'] ?>"><?= __('screens.profile.view') ?></a>
                                                                        <?php else: ?>
                                                                            -
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>
                                                                <!-- <tr>
                                                                        <td colspan="2"
                                                                            style="border-top: 1px dotted #8c5f0d; margin-top: 5px; padding-top: 5px;">
                                                                            <img src="graphic/icons/external_link.png">
                                                                            <a href="#" style="font-size: 10px;">Arquivo de
                                                                                jogador (ligação externa)</a>
                                                                        </td>
                                                                    </tr> -->
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>

                                            <table class="vis" width="100%">
                                                <tr>
                                                    <th style="background-color: #c1a264;">
                                                        <?= __('screens.profile.villages') ?>
                                                        (<?= count($villages_list) ?>)
                                                    </th>
                                                    <th style="background-color: #c1a264;">
                                                        <?= __('screens.profile.coordinates') ?>
                                                    </th>
                                                    <th style="background-color: #c1a264;">
                                                        <?= __('screens.profile.village_points') ?>
                                                    </th>
                                                </tr>
                                                <?php foreach ($villages_list as $v): ?>
                                                    <tr>
                                                        <td style="background-color: #f8f4e0;">
                                                            <a
                                                                href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $v['id'] ?>">
                                                                <?= htmlspecialchars($v['name']) ?>
                                                            </a>
                                                        </td>
                                                        <td style="background-color: #f8f4e0;"><?= $v['x'] ?>|<?= $v['y'] ?>
                                                        </td>
                                                        <td style="background-color: #f8f4e0;">
                                                            <?= number_format($v['points']) ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </table>
                                        </td>

                                        <!-- Right Column (Awards etc) -->
                                        <td valign="top" width="55%" style="padding-left: 10px;">




                                            <!-- Hidden Edit Profile Form (Right Column Only) -->
                                            <div id="edit_profile_form"
                                                style="display: none; margin-bottom: 15px; border: 2px solid #8c5f0d; padding: 0; background: #f4e4bc;">

                                                <form
                                                    action="game.php?village=<?= $village['id'] ?>&screen=profile&h=<?= $hkey ?>"
                                                    method="post" enctype="multipart/form-data">

                                                    <!-- Brasão Section -->
                                                    <div
                                                        style="background: #c1a264; padding: 8px; font-weight: bold; color: #000;">
                                                        <?= __('screens.profile.coat_of_arms') ?>
                                                    </div>
                                                    <div style="padding: 10px;">
                                                        <!-- Current Avatar Display -->
                                                        <div style="margin-bottom: 10px;">
                                                            <strong><?= __('screens.profile.current_coat_of_arms') ?></strong>
                                                            <div style="margin-top: 5px;">
                                                                <?php if (isset($user['avatar']) && $user['avatar'] > 0): ?>
                                                                    <img src="graphic/player/profile/<?= $user['avatar'] ?>.webp"
                                                                        style="width: 120px; height: 120px; border: 2px solid #8c5f0d;">
                                                                <?php else: ?>
                                                                    <img src="graphic/player/profile/default.webp"
                                                                        style="width: 120px; height: 120px; border: 2px solid #8c5f0d;">
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>

                                                        <!-- Premium Upload Notice -->
                                                        <!--<div
                                                            style="background: #fff5da; border: 1px solid #d4af37; padding: 8px; margin-bottom: 10px;">
                                                            <img src="graphic/new/premium/Premium_large.webp"
                                                                style="vertical-align: middle; margin-right: 5px; width: 20px; height: 20px;">
                                                            <span style="color: #8c5f0d; font-weight: bold;">Carregar imagem
                                                                própria requer Conta
                                                                Premium</span>
                                                        </div>-->

                                                        <!-- Avatar Selection Gallery -->
                                                        <strong><?= __('screens.profile.or_choose_avatar') ?></strong>
                                                        <div
                                                            style="margin-top: 10px; max-height: 350px; overflow-y: auto; border: 1px solid #8c5f0d; padding: 5px; background: #f0e6c2;">
                                                            <div
                                                                style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 5px;">
                                                                <?php for ($i = 1; $i <= 31; $i++): ?>
                                                                    <label style="cursor: pointer; display: block;">
                                                                        <input type="radio" name="avatar" value="<?= $i ?>"
                                                                            <?= (isset($user['avatar']) && $user['avatar'] == $i) ? 'checked' : '' ?> style="display: none;">
                                                                        <img src="graphic/player/profile/<?= $i ?>.webp"
                                                                            class="avatar-option"
                                                                            style="width: 80px; height: 80px; border: 3px solid #8c5f0d; display: block; transition: border-color 0.2s;"
                                                                            onclick="this.previousElementSibling.checked = true; document.querySelectorAll('.avatar-option').forEach(img => img.style.borderColor = '#8c5f0d'); this.style.borderColor = '#d4af37';">
                                                                    </label>
                                                                <?php endfor; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Extended Profile Fields -->
                                                    <div
                                                        style="background: #c1a264; padding: 8px; font-weight: bold; color: #000;">
                                                        <?= __('screens.profile.personal_data') ?>
                                                    </div>
                                                    <div style="padding: 10px;">
                                                        <table width="100%">
                                                            <tr>
                                                                <td width="120"><?= __('screens.profile.birth_date') ?></td>
                                                                <td>
                                                                    <input type="text" name="b_day" size="2" maxlength="2"
                                                                        value="<?= isset($user['b_day']) && $user['b_day'] > 0 ? $user['b_day'] : '' ?>">
                                                                    <select name="b_month">
                                                                        <option value="0"><?= __('screens.profile.month') ?>
                                                                        </option>
                                                                        <?php
                                                                        $months = [1 => __('screens.profile.january'), 2 => __('screens.profile.february'), 3 => __('screens.profile.march'), 4 => __('screens.profile.april'), 5 => __('screens.profile.may'), 6 => __('screens.profile.june'), 7 => __('screens.profile.july'), 8 => __('screens.profile.august'), 9 => __('screens.profile.september'), 10 => __('screens.profile.october'), 11 => __('screens.profile.november'), 12 => __('screens.profile.december')];
                                                                        foreach ($months as $num => $name): ?>
                                                                            <option value="<?= $num ?>"
                                                                                <?= (isset($user['b_month']) && $user['b_month'] == $num) ? 'selected' : '' ?>>
                                                                                <?= $name ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    <input type="text" name="b_year" size="4" maxlength="4"
                                                                        value="<?= isset($user['b_year']) && $user['b_year'] > 0 ? $user['b_year'] : '' ?>">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><?= __('screens.profile.gender') ?></td>
                                                                <td>
                                                                    <label><input type="radio" name="sex" value="f"
                                                                            <?= (isset($user['sex']) && $user['sex'] == 'f') ? 'checked' : '' ?>>
                                                                        <?= __('screens.profile.female') ?></label>
                                                                    <label><input type="radio" name="sex" value="m"
                                                                            <?= (!isset($user['sex']) || $user['sex'] == 'm') ? 'checked' : '' ?>>
                                                                        <?= __('screens.profile.male') ?></label>
                                                                    <label><input type="radio" name="sex" value="n"
                                                                            <?= (isset($user['sex']) && $user['sex'] == 'n') ? 'checked' : '' ?>>
                                                                        <?= __('screens.profile.not_specified') ?></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><?= __('screens.profile.location') ?></td>
                                                                <td>
                                                                    <input type="text" name="ort"
                                                                        value="<?= htmlspecialchars($user['ort'] ?? '') ?>"
                                                                        style="width: 200px;">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                    <!-- Texto Pessoal Section -->
                                                    <div
                                                        style="background: #c1a264; padding: 8px; font-weight: bold; color: #000;">
                                                        <?= __('screens.profile.personal_text') ?>
                                                    </div>
                                                    <div style="padding: 10px;">
                                                        <!-- BBCode Toolbar -->
                                                        <?php 
                                                        $textareaId = 'personal_text';
                                                        $prefix = 'prof_';
                                                        include __DIR__ . '/../components/bbcode_toolbar.php'; 
                                                        ?>

                                                        <!-- Textarea -->
                                                        <textarea id="personal_text" name="personal_text" rows="10"
                                                            style="width: 100%; border: 1px solid #8c5f0d; background-color: #fffdf0; font-family: monospace; padding: 5px;"><?= htmlspecialchars($user['personal_text'] ?? '') ?></textarea>

                                                        <!-- Buttons -->
                                                        <div style="margin-top: 10px;">
                                                            <input type="submit" name="save_profile"
                                                                value="<?= __('screens.profile.save') ?>" class="btn"
                                                                style="padding: 4px 12px;">
                                                            <input type="button"
                                                                value="<?= __('screens.profile.preview') ?>" class="btn"
                                                                style="padding: 4px 12px; margin-left: 5px;"
                                                                onclick="alert('<?= __('screens.profile.preview_coming_soon') ?>')">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>


                                            <!-- Metas de crescimento (Regular) -->
                                            <?php if (($config['awards'] ?? true) && !empty($awards_regular)): ?>
                                                <div class="award-group">
                                                    <div class="award-group-head"><?= __('screens.profile.medals_acquired') ?>
                                                    </div>
                                                    <div class="award-group-content">
                                                        <?php
                                                        $has_shown_awards = false;
                                                        foreach ($awards_regular as $index => $award):
                                                            // Only show unlocked awards in the summary tab
                                                            if ($award['level'] <= 0)
                                                                continue;
                                                            $has_shown_awards = true;
                                                            ?>
                                                            <div class="award-box clearfix">
                                                                <div class="award <?= htmlspecialchars($award['class'] ?? '') ?>">
                                                                    <img src="graphic/awards/<?= htmlspecialchars($award['image']) ?>.png"
                                                                        title="" alt="">
                                                                </div>
                                                                <div class="award-desc">
                                                                    <strong><?= htmlspecialchars($award['name']) ?>
                                                                        (<?= htmlspecialchars($award['level_label']) ?> -
                                                                        <?= __('screens.common.level') ?>
                                                                        <?= htmlspecialchars($award['level']) ?>)</strong>
                                                                    <p><?= $award['description'] ?></p>
                                                                </div>
                                                            </div>
                                                            <?php if ($index < count($awards_regular) - 1): ?>
                                                                <hr>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>

                                                        <?php if (!$has_shown_awards): ?>
                                                            <div style="padding: 10px; font-style: italic;">
                                                                <?= __('screens.profile.no_medals_yet') ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="award-group-foot">&nbsp;</div>
                                                </div>
                                                <br>
                                            <?php endif; ?>

                                            <!-- Medalhas Diárias -->
                                            <?php if (($config['awards'] ?? true) && !empty($awards_daily)): ?>
                                                <div class="award-group">
                                                    <div class="award-group-head"><?= __('screens.profile.daily_medals') ?>
                                                    </div>
                                                    <div class="award-group-content">
                                                        <?php foreach ($awards_daily as $index => $award): ?>
                                                            <div class="award-box clearfix">
                                                                <div class="award <?= htmlspecialchars($award['class'] ?? '') ?>">
                                                                    <img src="graphic/awards/<?= htmlspecialchars($award['image']) ?>.png"
                                                                        title="" alt="">
                                                                </div>
                                                                <div class="award-desc">
                                                                    <strong><?= htmlspecialchars($award['count']) ?>x
                                                                        <?= htmlspecialchars($award['name']) ?></strong>
                                                                    <p><?= $award['description'] ?></p>
                                                                </div>
                                                            </div>
                                                            <?php if ($index < count($awards_daily) - 1): ?>
                                                                <hr>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <div class="award-group-foot">&nbsp;</div>
                                                </div>
                                                <br>
                                            <?php endif; ?>

                                            <!-- Metas noutros mundos -->
                                            <?php if (!empty($awards_other_worlds)): ?>
                                                <div class="award-group">
                                                    <div class="award-group-head">
                                                        <?= __('screens.profile.goals_other_worlds') ?>
                                                    </div>
                                                    <div class="award-group-content" style="padding: 10px;">
                                                        <?php foreach ($awards_other_worlds as $world_data): ?>
                                                            <div style="margin-bottom: 5px;">
                                                                <strong><?= __('screens.profile.world') ?>
                                                                    <?= htmlspecialchars($world_data['world']) ?></strong>
                                                            </div>
                                                            <div><?= $world_data['icons_html'] ?></div>
                                                            <div style="margin-bottom: 10px;"></div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <div class="award-group-foot">&nbsp;</div>
                                                </div>
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                </table>

                                <script>
                                                                                                   functi                                                                                                                                                 on inser                                                                                            tBBCode(tag) {
                                        const textarea = document.getElementById('personal_text');
                                        const start = textarea.selectionStart;
                                        const end = textarea.selectionEnd;
                                        const text = textarea.value;
                                        const selectedText = text.substring(start, end);

                                        let before, after;

                                        switch (tag) {
                                            case 'url':
                                                before = '[url=]';
                                                after = '[/url]';
                                                break;
                                            case 'img':
                                                before = '[img]';
                                                after = '[/img]';
                                                break;
                                            case 'player':
                                                before = '[player]';
                                                after = '[/player]';
                                                break;
                                            case 'tribe':
                                                before = '[ally]';
                                                after = '[/ally]';
                                                break;
                                            case 'size':
                                                before = '[size=12]';
                                                after = '[/size]';
                                                break;
                                            case 'color':
                                                before = '[color=#000000]';
                                                after = '[/color]';
                                                break;
                                            default:
                                                before = '[' + tag + ']';
                                                after = '[/' + tag + ']';
                                        }

                                        textarea.value = text.substring(0, start) + before + selectedText + after + text.substring(end);
                                        textarea.focus();
                                        textarea.selectionStart = start + before.length;
                                        textarea.selectionEnd = start + before.length + selectedText.length;
                                    }

                                    // Highlight selected avatar on page load
                                    document.addEventListener('DOMContentLoaded', function () {
                                        const selectedAvatar = document.querySelector('input[name="avatar"]:checked');
                                        if (selectedAvatar) {
                                            const img = selectedAvatar.nextElementSibling;
                                            if (img) img.style.borderColor = '#d4af37';
                                        }
                                    });
                                </script>

                            </div>
                        <?php elseif ($current_tab === 'inventory'): ?>
                            <?php require __DIR__ . '/inventory.php'; ?>

                        <?php elseif ($current_tab === 'stats'): ?>
                            <script src="js/chart.umd.min.js"></script>

                            <style>
                                .stats-grid {
                                    display: grid;
                                    grid-template-columns: repeat(3, 1fr);
                                    gap: 10px;
                                    margin: 10px 0;
                                }

                                .stat-chart-box {
                                    background: #fff5da;
                                    border: 1px solid #7d510f;
                                    border-radius: 4px;
                                    overflow: hidden;
                                }

                                .stat-chart-header {
                                    background: #e3c485;
                                    padding: 6px 10px;
                                    font-weight: bold;
                                    color: #2b1d0c !important;
                                    border-bottom: 1px solid #7d510f;
                                    display: flex;
                                    align-items: center;
                                    gap: 5px;
                                }

                                .stat-chart-content {
                                    background: #fff5da;
                                    position: relative;
                                    height: 250px;
                                    box-sizing: border-box;
                                }

                                .chart-canvas {
                                    width: 100% !important;
                                    height: 100% !important;
                                }
                            </style>

                            <?php if (!empty($stats['charts']['points']['data'])): ?>
                                <div class="stats-grid">
                                    <!-- Pontos do jogador -->
                                    <div class="stat-chart-box">
                                        <div class="stat-chart-header">
                                            <img src="graphic/overview/main.png" width="16" height="16">
                                            <?= __('screens.profile.player_points') ?>
                                        </div>
                                        <div class="stat-chart-content">
                                            <div style="position: absolute; top: 10px; left: 10px; right: 10px; bottom: 10px;">
                                                <canvas id="pointsChart" class="chart-canvas"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Aldeias do jogador -->
                                    <div class="stat-chart-box">
                                        <div class="stat-chart-header">
                                            <img src="graphic/buildings/place.png" width="16" height="16">
                                            <?= __('screens.profile.player_villages') ?>
                                        </div>
                                        <div class="stat-chart-content">
                                            <div style="position: absolute; top: 10px; left: 10px; right: 10px; bottom: 10px;">
                                                <canvas id="villagesChart" class="chart-canvas"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Classificação do jogador -->
                                    <div class="stat-chart-box">
                                        <div class="stat-chart-header">
                                            <img src="graphic/overview/main.png" width="16" height="16">
                                            <?= __('screens.profile.player_ranking') ?>
                                        </div>
                                        <div class="stat-chart-content">
                                            <div style="position: absolute; top: 10px; left: 10px; right: 10px; bottom: 10px;">
                                                <canvas id="rankChart" class="chart-canvas"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pontos da tribo -->
                                    <div class="stat-chart-box">
                                        <div class="stat-chart-header">
                                            <img src="graphic/overview/main.png" width="16" height="16">
                                            <?= __('screens.profile.tribe_points') ?>
                                        </div>
                                        <div class="stat-chart-content">
                                            <div style="position: absolute; top: 10px; left: 10px; right: 10px; bottom: 10px;">
                                                <?php if ($stats['charts']['tribe_points']): ?>
                                                    <canvas id="tribePointsChart" class="chart-canvas"></canvas>
                                                <?php else: ?>
                                                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #999;">
                                                        <div style="text-align: center;">
                                                            <div style="font-size: 32px; margin-bottom: 10px;">📊</div>
                                                            <div><?= ($user['ally'] > 0) ? __('screens.profile.waiting_for_data') : __('screens.profile.no_tribe') ?></div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Aldeias saqueadas -->
                                    <div class="stat-chart-box">
                                        <div class="stat-chart-header">
                                            <img src="graphic/buildings/place.png" width="16" height="16">
                                            <?= __('screens.profile.looted_villages') ?>
                                        </div>
                                        <div class="stat-chart-content">
                                            <div style="position: absolute; top: 10px; left: 10px; right: 10px; bottom: 10px;">
                                                <canvas id="villagesLootedChart" class="chart-canvas"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Recursos pilhados -->
                                    <div class="stat-chart-box">
                                        <div class="stat-chart-header">
                                            <img src="graphic/res.png" width="16" height="16">
                                            <?= __('screens.profile.looted_resources') ?>
                                        </div>
                                        <div class="stat-chart-content">
                                            <div style="position: absolute; top: 10px; left: 10px; right: 10px; bottom: 10px;">
                                                <canvas id="resourcesLootedChart" class="chart-canvas"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Unidades derrotadas -->
                                    <div class="stat-chart-box">
                                        <div class="stat-chart-header">
                                            <img src="graphic/unit/unit_spear.png" width="16" height="16">
                                            <?= __('screens.profile.defeated_units') ?>
                                        </div>
                                        <div class="stat-chart-content">
                                            <div style="position: absolute; top: 10px; left: 10px; right: 10px; bottom: 10px;">
                                                <canvas id="combatChart" class="chart-canvas"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Unidades ganhas / perdidas -->
                                    <div class="stat-chart-box">
                                        <div class="stat-chart-header">
                                            <img src="graphic/unit/unit_spear.png" width="16" height="16">
                                            <?= __('screens.profile.units_won_lost') ?>
                                        </div>
                                        <div class="stat-chart-content">
                                            <div style="position: absolute; top: 10px; left: 10px; right: 10px; bottom: 10px;">
                                                <canvas id="unitsWonLostChart" class="chart-canvas"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Recursos gastos -->
                                    <div class="stat-chart-box">
                                        <div class="stat-chart-header">
                                            <img src="graphic/res.png" width="16" height="16">
                                            <?= __('screens.profile.resources_spent') ?>
                                        </div>
                                        <div class="stat-chart-content">
                                            <div style="position: absolute; top: 10px; left: 10px; right: 10px; bottom: 10px;">
                                                <canvas id="resourcesChart" class="chart-canvas"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    // Chart.js default config
                                    Chart.defaults.font.size = 10;
                                    Chart.defaults.color = '#603000';

                                    const chartOptions = {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: {
                                            legend: { display: false },
                                            tooltip: {
                                                backgroundColor: 'rgba(60, 30, 0, 0.95)',
                                                titleColor: '#fff',
                                                bodyColor: '#fff5da',
                                                borderColor: '#7d510f',
                                                borderWidth: 1,
                                                padding: 8,
                                                titleFont: { size: 11 },
                                                bodyFont: { size: 10 }
                                            }
                                        },
                                        scales: {
                                            x: {
                                                grid: {
                                                    color: '#e6d5b0',
                                                    drawTicks: false
                                                },
                                                ticks: {
                                                    color: '#603000',
                                                    font: { size: 9 },
                                                    maxRotation: 0,
                                                    minRotation: 0
                                                }
                                            },
                                            y: {
                                                beginAtZero: false,
                                                grid: {
                                                    color: '#e6d5b0',
                                                    drawTicks: false
                                                },
                                                ticks: {
                                                    color: '#603000',
                                                    font: { size: 9 },
                                                    precision: 0,
                                                    callback: function (value) {
                                                        if (value >= 1000) return (value / 1000) + 'k';
                                                        return value;
                                                    }
                                                }
                                            }
                                        }
                                    };

                                    // Simple point charts
                                    const pointCharts = ['points', 'villages', 'rank', 'tribePoints', 'villagesLooted', 'resourcesLooted'];
                                    pointCharts.forEach(type => {
                                        const ctx = document.getElementById(type + 'Chart');
                                        if (!ctx) return;

                                        const data = <?= json_encode($stats['charts']) ?>[
                                            type === 'tribePoints' ? 'tribe_points' :
                                                type === 'villagesLooted' ? 'villages_looted' :
                                                    type === 'resourcesLooted' ? 'resources_looted' :
                                                        type
                                        ];

                                        if (!data || !data.labels || data.labels.length === 0) {
                                            const container = ctx.parentElement;
                                            container.innerHTML = '<div style="display:flex; align-items:center; justify-content:center; height:100%; color:#999; font-size:10px;"><?= __("screens.profile.waiting_for_data") ?></div>';
                                            return;
                                        }

                                        new Chart(ctx, {
                                            type: 'line',
                                            data: {
                                                labels: data.labels,
                                                datasets: [{
                                                    data: data.data,
                                                    borderColor: '#2b8a3e',
                                                    backgroundColor: 'rgba(43, 138, 62, 0.08)',
                                                    borderWidth: 2.5,
                                                    pointBackgroundColor: '#2b8a3e',
                                                    pointBorderColor: '#fff',
                                                    pointRadius: 4,
                                                    pointHoverRadius: 6,
                                                    pointHoverBackgroundColor: '#2b8a3e',
                                                    pointHoverBorderColor: '#fff',
                                                    fill: true,
                                                    tension: 0.15
                                                }]
                                            },
                                            options: {
                                                ...chartOptions,
                                                scales: {
                                                    ...chartOptions.scales,
                                                    y: {
                                                        ...chartOptions.scales.y,
                                                        reverse: (type === 'rank'),
                                                        beginAtZero: (type !== 'rank' && type !== 'points')
                                                    }
                                                }
                                            }
                                        });
                                    });

                                    // Detailed charts
                                    const detailedCharts = ['combat', 'resources', 'unitsWonLost'];
                                    detailedCharts.forEach(type => {
                                        const ctx = document.getElementById(type + 'Chart');
                                        if (!ctx) return;

                                        const data = <?= json_encode($stats['charts']) ?>[
                                            type === 'unitsWonLost' ? 'units_won_lost' : type
                                        ];
                                        if (!data.datasets || data.datasets.length === 0 || !data.labels || data.labels.length === 0) {
                                            const container = ctx.parentElement;
                                            container.innerHTML = '<div style="display:flex; align-items:center; justify-content:center; height:100%; color:#999; font-size:10px;"><?= __("screens.profile.waiting_for_data") ?></div>';
                                            return;
                                        }

                                        new Chart(ctx, {
                                            type: 'bar',
                                            data: {
                                                labels: data.labels,
                                                datasets: data.datasets.map(ds => ({
                                                    ...ds,
                                                    borderWidth: 1.5
                                                }))
                                            },
                                            options: {
                                                ...chartOptions,
                                                plugins: {
                                                    ...chartOptions.plugins,
                                                    legend: { 
                                                        display: true, 
                                                        position: 'bottom', 
                                                        labels: { 
                                                            boxWidth: 10, 
                                                            color: '#603000',
                                                            font: { size: 9, weight: 'bold' } 
                                                        } 
                                                    }
                                                },
                                                scales: {
                                                    ...chartOptions.scales,
                                                    x: { ...chartOptions.scales.x, stacked: true },
                                                    y: { ...chartOptions.scales.y, stacked: true }
                                                }
                                            }
                                        });
                                    });
                                </script>
                            <?php else: ?>
                                <div style="text-align: center; padding: 60px 20px; color: #999;">
                                    <div style="font-size: 64px; margin-bottom: 20px;">📊</div>
                                    <h3><?= __('screens.profile.stats_no_data') ?></h3>
                                    <p><?= __('screens.profile.stats_no_data_desc') ?></p>
                                </div>
                            <?php endif; ?>

                        <?php elseif ($current_tab === 'friends'): ?>
                            <?php require __DIR__ . '/friends.php'; ?>

                        <?php elseif ($current_tab === 'bonus'): ?>
                            <?php require __DIR__ . '/profile_bonus.php'; ?>

                        <?php elseif ($current_tab === 'mentor'): ?>
                            <h3><?= __('screens.profile.mentor_title') ?></h3>
                            <div class="info-box">
                                <?= __('screens.profile.mentorship') ?>
                                (<?= __('screens.profile.coming_soon_placeholder') ?>)
                            </div>

                        <?php elseif ($current_tab === 'block'): ?>
                            <h3><?= __('screens.profile.block_title') ?></h3>
                            <p class="description"><?= __('screens.profile.block_description') ?></p>
                            <?php if (empty($blocked)): ?>
                                <div class="info-box"><?= __('screens.profile.no_blocked_players') ?></div>
                            <?php else: ?>
                                <table class="vis" style="width:100%">
                                    <tr>
                                        <th><?= __('screens.profile.name') ?></th>
                                        <th><?= __('screens.profile.actions') ?></th>
                                    </tr>
                                    <?php foreach ($blocked as $buser): ?>
                                        <tr>
                                            <td><?php echo $buser['username']; ?></td>
                                            <td><a href="#"><?= __('screens.profile.unblock') ?></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            <?php endif; ?>

                        <?php elseif ($current_tab === 'awards'): ?>
                            <!-- Awards Detail Tab -->
                            <div
                                style="background-color: #fceec4; padding: 10px; border: 1px solid #c1a264; margin-top: 5px;">

                                <!-- Daily Awards Section -->
                                <?php if (!empty($awards_daily)): ?>
                                    <div class="award-group">
                                        <div class="award-group-head"><?= __('screens.profile.daily_goals') ?></div>
                                        <div class="award-group-content">
                                            <?php foreach ($awards_daily as $index => $award): ?>
                                                <div class="award-box clearfix" style="position: relative; min-height: 80px;">
                                                    <div class="award level4" style="float: left; margin-right: 10px;">
                                                        <img src="graphic/awards/<?= htmlspecialchars($award['image']) ?>.png"
                                                            title="" alt="">
                                                    </div>
                                                    <div class="award-desc" style="overflow: hidden;">
                                                        <strong><?= htmlspecialchars($award['count']) ?>x
                                                            <?= htmlspecialchars($award['name']) ?></strong>
                                                        <p style="margin: 5px 0;"><?= $award['description'] ?></p>
                                                        <div style="color: #7b5212; font-size: 10px;">
                                                            <?= __('screens.profile.coming_soon_placeholder') ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if ($index < count($awards_daily) - 1): ?>
                                                    <hr style="margin: 10px 0; border: 0; border-top: 1px dotted #8c5f0d;">
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="award-group-foot">&nbsp;</div>
                                    </div>
                                    <br>
                                <?php endif; ?>

                                <!-- Regular Awards Section with Progress -->
                                <div class="award-group">
                                    <div class="award-group-head"><?= __('screens.profile.growth_goals') ?></div>
                                    <div class="award-group-content">
                                        <?php if (empty($awards_regular)): ?>
                                            <div style="padding: 10px;"><?= __('screens.profile.no_growth_awards') ?></div>
                                        <?php else: ?>
                                            <?php foreach ($awards_regular as $index => $award): ?>
                                                <div class="award-box clearfix" style="padding: 5px 0;">
                                                    <!-- Icon -->
                                                    <div class="award <?= htmlspecialchars($award['class'] ?? '') ?>"
                                                        style="float: left; margin-right: 15px;">
                                                        <img src="graphic/awards/<?= htmlspecialchars($award['image']) ?>.png"
                                                            title="" alt="">
                                                    </div>

                                                    <!-- Info & Progress -->
                                                    <div class="award-desc" style="overflow: hidden;">
                                                        <strong><?= htmlspecialchars($award['name']) ?>
                                                            (<?= htmlspecialchars($award['level_label']) ?> -
                                                            <?= __('screens.common.level') ?>
                                                            <?= htmlspecialchars($award['level']) ?>)</strong>
                                                        <p style="margin: 5px 0;"><?= $award['description'] ?></p>

                                                        <?php if (!$award['is_maxed'] && $award['next_value'] > 0): ?>
                                                            <div
                                                                style="margin-top: 5px; background-color: #f7eed3; border: 1px solid #7d510f; padding: 5px;">
                                                                <div style="font-size: 10px; color: #5d2f09; margin-bottom: 2px;">
                                                                    <?= __('screens.common.next_level') ?>:
                                                                    <?= $award['next_desc'] ?? __('screens.profile.keep_playing') ?>
                                                                </div>

                                                                <!-- Progress Bar Container -->
                                                                <div
                                                                    style="width: 100%; background-color: #ded1ad; height: 12px; border: 1px solid #7d510f; position: relative;">
                                                                    <!-- Progress Bar Fill -->
                                                                    <div
                                                                        style="width: <?= $award['progress_percent'] ?>%; background-color: #5d2f09; height: 100%; max-width: 100%;">
                                                                    </div>
                                                                    <!-- Text Overlay -->
                                                                    <div
                                                                        style="position: absolute; top: -1px; width: 100%; text-align: center; color: #fff; font-size: 9px; font-weight: bold; text-shadow: 1px 1px 1px #000;">
                                                                        <?= format_number($award['current_value']) ?> /
                                                                        <?= format_number($award['next_value']) ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php elseif ($award['is_maxed']): ?>
                                                            <div style="margin-top: 5px; color: #155724; font-weight: bold;">
                                                                <?= __('screens.profile.completed') ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <?php if ($index < count($awards_regular) - 1): ?>
                                                    <hr style="margin: 10px 0; border: 0; border-top: 1px dotted #8c5f0d;">
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="award-group-foot">&nbsp;</div>
                                </div>

                                <!-- Awards from Other Active Worlds -->
                                <?php if (!empty($awards_active_worlds) && ($user['show_active_worlds'] ?? 0)): ?>
                                    <div class="award-group">
                                        <div class="award-group-head"><?= __('screens.profile.goals_other_worlds') ?></div>
                                        <div class="award-group-content">
                                            <?php foreach ($awards_active_worlds as $world_data): ?>
                                                <div
                                                    style="margin-bottom: 15px; padding: 10px; background-color: #f7eed3; border: 1px solid #7d510f;">
                                                    <div style="margin-bottom: 8px;">
                                                        <strong
                                                            style="color: #5d2f09;"><?= htmlspecialchars($world_data['world_name']) ?></strong>
                                                        <span
                                                            style="font-size: 10px; color: #666; margin-left: 10px;"><?= __('screens.profile.player_label') ?>
                                                            <?= htmlspecialchars($world_data['player_name']) ?></span>
                                                    </div>
                                                    <?php if (!empty($world_data['awards'])): ?>
                                                        <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                                            <?php foreach ($world_data['awards'] as $award): ?>
                                                                <?php if ($award['level'] > 0): ?>
                                                                    <div class="award <?= htmlspecialchars($award['class'] ?? '') ?>"
                                                                        title="<?= htmlspecialchars($award['name']) ?> - <?= __('screens.common.level') ?> <?= $award['level'] ?>">
                                                                        <img src="graphic/awards/<?= htmlspecialchars($award['image']) ?>.png"
                                                                            alt="">
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <div style="font-style: italic; color: #666; font-size: 11px;">
                                                            <?= __('screens.profile.no_medal_in_world') ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="award-group-foot">&nbsp;</div>
                                    </div>
                                    <br>
                                <?php endif; ?>

                                <!-- Awards from Closed Worlds -->
                                <?php if (!empty($awards_closed_worlds) && ($user['show_closed_worlds'] ?? 0)): ?>
                                    <div class="award-group">
                                        <div class="award-group-head"><?= __('screens.profile.goals_closed_worlds') ?></div>
                                        <div class="award-group-content">
                                            <?php foreach ($awards_closed_worlds as $world_data): ?>
                                                <div
                                                    style="margin-bottom: 15px; padding: 10px; background-color: #f7eed3; border: 1px solid #7d510f;">
                                                    <div style="margin-bottom: 8px;">
                                                        <strong
                                                            style="color: #5d2f09;"><?= htmlspecialchars($world_data['world_name']) ?></strong>
                                                        <span
                                                            style="font-size: 10px; color: #666; margin-left: 10px;"><?= __('screens.profile.player_label') ?>
                                                            <?= htmlspecialchars($world_data['player_name']) ?></span>
                                                        <?php if (!empty($world_data['final_rank'])): ?>
                                                            <span
                                                                style="font-size: 10px; color: #666; margin-left: 10px;"><?= __('screens.profile.final_rank_label') ?>
                                                                #<?= number_format($world_data['final_rank']) ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php if (!empty($world_data['awards'])): ?>
                                                        <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                                            <?php foreach ($world_data['awards'] as $award): ?>
                                                                <?php if ($award['level'] > 0): ?>
                                                                    <div class="award <?= htmlspecialchars($award['class'] ?? '') ?>"
                                                                        title="<?= htmlspecialchars($award['name']) ?> - <?= __('screens.common.level') ?> <?= $award['level'] ?>">
                                                                        <img src="graphic/awards/<?= htmlspecialchars($award['image']) ?>.png"
                                                                            alt="">
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <div style="font-style: italic; color: #666; font-size: 11px;">
                                                            <?= __('screens.profile.no_medal_in_world') ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="award-group-foot">&nbsp;</div>
                                    </div>
                                    <br>
                                <?php endif; ?>

                                <br>

                                <!-- Public Settings Filter --><?php if ($current_tab === 'awards'): ?>
                                    <form method="POST"
                                        action="game.php?village=<?= $village['id'] ?>&screen=profile&mode=awards&h=<?= $hkey ?>">
                                        <div
                                            style="background-color: #f0e6c2; border: 1px solid #7d510f; padding: 10px; margin-top: 10px;">
                                            <strong><?= __('screens.profile.public_settings') ?></strong>
                                            <div style="margin-top: 5px;">
                                                <label>
                                                    <input type="checkbox" name="hide_own_awards" <?= $user['hide_own_awards'] ? 'checked' : '' ?>>
                                                    <?= __('screens.profile.hide_own_awards_label') ?>
                                                </label>
                                            </div>
                                            <div style="margin-top: 5px;">
                                                <label>
                                                    <input type="checkbox" name="show_active_worlds"
                                                        <?= ($user['show_active_worlds'] ?? 0) ? 'checked' : '' ?>>
                                                    <?= __('screens.profile.show_active_worlds_label') ?>
                                                </label>
                                            </div>
                                            <div style="margin-top: 5px;">
                                                <label>
                                                    <input type="checkbox" name="show_closed_worlds"
                                                        <?= ($user['show_closed_worlds'] ?? 0) ? 'checked' : '' ?>>
                                                    <?= __('screens.profile.show_closed_worlds_label') ?>
                                                </label>
                                            </div>
                                            <div style="margin-top: 10px;">
                                                <button type="submit" name="save_privacy" class="btn"
                                                    style="padding: 4px 10px;"><?= __('screens.profile.save_privacy') ?></button>
                                            </div>
                                        </div>
                                    </form>
                                <?php endif; ?>

                            </div>
                        <?php else: ?>
                            <!-- Other Tabs Placeholder -->
                            <div
                                style="background-color: #fceec4; padding: 50px; border: 1px solid #c1a264; margin-top: 5px; text-align: center;">
                                <h3 style="color: #8c5f0d;"><?= __('screens.profile.tab_label') ?> '<?= htmlspecialchars($tabs[$current_tab]) ?>'</h3>
                                <p style="color: #5d2f09;"><?= __('screens.profile.coming_soon_placeholder') ?></p>
                                <img src="graphic/unit/unit_snob.png" style="opacity: 0.7; margin-top: 20px;">
                            </div>
                        <?php endif; ?>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
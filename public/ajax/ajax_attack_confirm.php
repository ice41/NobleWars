<?php
/**
 * AJAX endpoint to generate attack confirmation modal
 * Returns HTML for confirmation screen with catapult selector
 */

session_start();

require_once __DIR__ . '/../../app/bootstrap_ajax.php';

// Configuration (ficheiros locais da public/)
require_once(__DIR__ . '/../configs/config.php');
require_once(__DIR__ . '/../modelo/lib/world_constants.php');
require_once(__DIR__ . '/../modelo/lib/config.php');

// Language support
\CoreFetcher::load('Helpers/language_helper.php');

// Initialize locale from session / cookie (same priority as GameController)
try {
    $globalDb = \App\Core\Database::getInstance(\App\Core\Database::getGlobalDbName());

    // Try world-specific cookie (session_1) then legacy generic cookie
    $worldParam = $_POST['world'] ?? $_GET['world'] ?? '1';
    $worldNum = preg_replace('/[^0-9]/', '', $worldParam ?: '1') ?: '1';
    $sessionSid = $_COOKIE['session_' . $worldNum] ?? $_COOKIE['session'] ?? '';

    if (!empty($sessionSid)) {
        // A tabela sessions vive na base do MUNDO (o login e o SessionModel inserem lá)
        $worldDbName = get_world_db_name($worldNum);
        $worldDb = \App\Core\Database::getInstance($worldDbName);
        $sessionData = $worldDb->fetch("SELECT userid FROM sessions WHERE sid = ?", [$sessionSid]);
        if ($sessionData) {
            $userData = $globalDb->fetch("SELECT language FROM conta WHERE id = ?", [$sessionData['userid']]);
            if ($userData && !empty($userData['language'])) {
                set_locale($userData['language']);
            } else {
                init_locale();
            }
        } else {
            init_locale();
        }
    } else {
        init_locale();
    }
} catch (\Exception $e) {
    init_locale();
}


// Get parameters
$type       = $_POST['type']         ?? 'attack';
$targetId   = (int)($_POST['targetId'] ?? 0);
$targetName = $_POST['targetName']   ?? '';
$targetPlayer = $_POST['targetPlayer'] ?? '';
$duration   = $_POST['duration']     ?? '';
$arrival    = $_POST['arrival']      ?? '';
$units      = json_decode($_POST['units'] ?? '{}', true);
$villageUnits = json_decode($_POST['villageUnits'] ?? '{}', true);
if (isset($_GET['world'])) {
    $server = (int) $_GET['world'];
    $_SESSION['world'] = $server;
} else {
    $server = isset($_SESSION['world']) ? (int) $_SESSION['world'] : 1;
}
session_write_close();
$worldDb = get_world_db_name($server);

// Check if session cookie exists and is valid
$cookieName = 'session_' . $server;
if (!isset($_COOKIE[$cookieName])) {
    header('Location: index.php');
    exit;
}

$sid = $_COOKIE[$cookieName];
$sessionModel = new \App\Models\SessionModel($worldDb);
$session = $sessionModel->checkSession($sid);

if (!$session) {
    header('Location: index.php');
    exit;
}

// Only allow POST requests (prevent direct GET access in browser)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: game.php?screen=overview');
    exit;
}

// Initialize BuildsLibrary
$cl_builds = new \App\Models\BuildsLibrary($worldDb);

// Action label
$actionText = $type === 'attack'
    ? __('screens.map.action_attack')
    : __('screens.map.action_support');

$targetNameClean = explode(' (', $targetName)[0];

$titleKey = $type === 'attack' ? 'screens.map.confirm_attack_title' : 'screens.map.confirm_support_title';
$confirmTitle = __($titleKey);

if ($confirmTitle === $titleKey) {
    // Fallback if missing translation
    $confirmTitle = str_replace('{type}', $actionText, __('screens.map.confirm_title')) . ' a ' . $targetNameClean;
} else {
    $confirmTitle = str_replace('{target}', $targetNameClean, $confirmTitle);
}

$hasCatapults = isset($units['catapult']) && $units['catapult'] > 0;

// All unit keys in display order
$allUnits = ['spear','sword','axe','archer','spy','light','cav_archer','heavy','ram','catapult','paladin','snob'];
?>

<div style="padding: 12px 16px;">
    <h3 style="margin: 0 0 12px 0; text-align: center;">
        <?= htmlspecialchars($confirmTitle) ?>
    </h3>


    <table class="vis" width="100%" style="margin-bottom: 10px;">
        <tr>
            <th colspan="2" style="text-align: left;"><?= __('screens.place.order') ?: 'Order' ?></th>
        </tr>
        <tr>
            <td style="width: 40%; padding: 3px 6px;"><strong><?= __('screens.map.destination') ?>:</strong></td>
            <td style="padding: 3px 6px;">
                <a href="game.php?screen=info_village&id=<?= $targetId ?>"><?= htmlspecialchars($targetName) ?></a>
            </td>
        </tr>
        <?php if ($targetPlayer !== ''): ?>
        <?php 
            // Try to find the player ID for the link
            $targetPlayerId = 0;
            if ($targetId > 0) {
                $db = \App\Core\Database::getInstance($worldDb, get_world_db_host(get_active_world()), get_world_db_user(get_active_world()), get_world_db_pass(get_active_world()));
                $villageData = $db->fetch("SELECT userid FROM villages WHERE id = ?", [$targetId]);
                if ($villageData) {
                    $targetPlayerId = (int)$villageData['userid'];
                }
            }
        ?>
        <tr>
            <td style="padding: 3px 6px;"><strong><?= __('screens.map.player') ?>:</strong></td>
            <td style="padding: 3px 6px;">
                <?php if ($targetPlayerId > 0): ?>
                    <a href="game.php?screen=info_player&id=<?= $targetPlayerId ?>"><?= htmlspecialchars($targetPlayer) ?></a>
                <?php else: ?>
                    <?= htmlspecialchars($targetPlayer) ?>
                <?php endif; ?>
            </td>
        </tr>
        <?php endif; ?>
        <?php if ($duration !== ''): ?>
        <tr>
            <td style="padding: 3px 6px;"><strong><?= __('screens.map.duration') ?>:</strong></td>
            <td style="padding: 3px 6px;"><?= htmlspecialchars($duration) ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($arrival !== ''): ?>
        <tr>
            <td style="padding: 3px 6px;"><strong><?= __('screens.map.arrival') ?></strong></td>
            <td style="padding: 3px 6px;"><?= htmlspecialchars($arrival) ?></td>
        </tr>
        <?php endif; ?>
    </table>

    <div id="single_attack_ui">
        <div style="margin-bottom: 15px;">
            <a href="#" id="add_attack_btn" onclick="initMultiAttack(); return false;" style="font-weight: bold; text-decoration: none; color: #804000;">
                <img src="graphic/icons/plus.png" alt="+" style="vertical-align: -2px;"> Adicionar novo ataque
            </a>
        </div>

        <table class="vis" width="100%" style="text-align: center;">
            <tbody>
                <tr>
                    <?php foreach ($allUnits as $u): ?>
                    <th style="text-align:center">
                        <img src="graphic/unit/unit_<?= $u ?>.png" style="width: 18px; height: 18px;" title="<?= $u ?>">
                    </th>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <?php foreach ($allUnits as $u): ?>
                    <?php $u_val = (int)($units[$u] ?? 0); ?>
                    <td style="text-align:center" <?= $u_val === 0 ? 'class="hidden"' : '' ?>>
                        <?= $u_val ?>
                    </td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Hidden multi-attack UI -->
    <div id="multi_attack_ui" style="display: none; margin-top: 15px;">
        <div style="border: 1px solid #7d510f; background: #f4e4bc; padding: 5px; margin-bottom: 10px; font-size: 11px;">
            <img src="graphic/new/questionmark.webp" alt="Info" style="float: left; margin-right: 5px; width: 16px; height: 16px;">
            Enviar vários ataques de uma só vez de uma única aldeia é útil para situações específicas, tal como enviar vários nobres para reduzir a lealdade numa rápida sucessão.
            Na maioria dos casos, é sempre melhor enviar todas as suas tropas num único ataque para causar o maior dano.
        </div>
        
        <table class="vis" width="100%" id="multi_attack_table">
            <thead>
                <tr>
                    <th width="120">Unidades</th>
                    <?php foreach ($allUnits as $u): ?>
                    <th style="text-align:center"><img src="graphic/unit/unit_<?= $u ?>.png"></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody id="multi_attack_rows">
                <tr id="row_village_units" style="font-weight: bold; background: #f4e4bc;">
                    <td>Unidades na aldeia</td>
                    <?php foreach ($allUnits as $u): ?>
                    <td style="text-align:center" class="village_unit_count" data-unit="<?= $u ?>"><?= (int)($villageUnits[$u] ?? 0) ?></td>
                    <?php endforeach; ?>
                </tr>
                <tr id="row_attack_1" class="attack_row" data-row="1">
                    <td style="font-weight: bold;">Atacar #1</td>
                    <?php foreach ($allUnits as $u): ?>
                    <td style="text-align:center" class="attack_val" data-unit="<?= $u ?>">
                        <input type="text" size="3" name="multi_unit_<?= $u ?>_1" value="<?= (int)($units[$u] ?? 0) ?>" onkeyup="updateMultiAttackTotals()" style="width: 30px; text-align: center;">
                    </td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
            <tfoot>
                <tr id="row_attack_add" style="background: #f4e4bc;">
                    <td>
                        <a href="#" id="add_another_attack_btn" onclick="addMultiAttackRow(); return false;" style="font-weight: bold; text-decoration: none; color: #804000;">
                            <img src="graphic/icons/plus.png" alt="+" style="vertical-align: -2px;"> Atacar #<span id="next_attack_num">2</span>
                        </a>
                    </td>
                    <td colspan="<?= count($allUnits) ?>"></td>
                </tr>
                <tr style="font-weight: bold; background: #e3d5b3;">
                    <td>Total</td>
                    <?php foreach ($allUnits as $u): ?>
                    <td style="text-align:center" class="total_val" data-unit="<?= $u ?>"><?= (int)($units[$u] ?? 0) ?></td>
                    <?php endforeach; ?>
                </tr>
            </tfoot>
        </table>
    </div>

    <?php if ($hasCatapults && $type === 'attack'): ?>
        <table class="vis" width="100%" style="margin: 10px 0;">
            <tr>
                <th><?= __('screens.map.catapult_target') ?></th>
                <td>
                    <select name="building" id="modal_building_select" size="1">
                        <?php 
                        $selectedBuilding = $_POST['building'] ?? '';
                        foreach ($cl_builds->get_array("dbname") as $dbname): 
                        ?>
                            <option value="<?= $dbname ?>" <?= ($selectedBuilding === $dbname) ? 'selected' : '' ?>>
                                <?= $cl_builds->get_name($dbname) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table>
    <?php endif; ?>

    <div style="text-align: left; margin-top: 12px;">
        <button class="btn btn-attack" onclick="confirmCommand('<?= $type ?>')">
            <span><?= __('screens.map.confirm_btn') ?></span>
        </button>
        <button class="btn btn-cancel" onclick="cancelConfirmation()" style="margin-left: 10px;">
            <span><?= __('screens.map.cancel_btn') ?></span>
        </button>
    </div>
</div>
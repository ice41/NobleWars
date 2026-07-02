<?php
/**
 * Popup Unit - Shows detailed unit information
 * Migrated from popup_unit.php
 */

session_start();

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use App\Models\UnitsLibrary;
use App\Models\BuildsLibrary;

// Load language helper and helper functions
require_once __DIR__ . '/../app/Helpers/helpers.php';
require_once __DIR__ . '/../app/Helpers/language_helper.php';

// Detetar mundo ativo e verificar sessão
$server = get_active_world();
$worldDb = get_world_db_name($server);

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

// Get unit parameter
$unit = $_GET['unit'] ?? '';
session_write_close();

// Initialize libraries
$config = ['speed' => 1, 'movement_speed' => 1];
$cl_units = new UnitsLibrary($worldDb, $config);
$cl_builds = new BuildsLibrary($worldDb);

// Validate unit exists, redirect to game overview if empty or invalid
if (empty($unit) || !in_array($unit, $cl_units->get_array('dbname'))) {
    header('Location: game.php?screen=overview');
    exit;
}

// Ensure locale is initialized correctly if session is lost
if (empty(current_locale())) {
    init_locale();
}

// Output HTML
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title><?= $cl_units->get_name($unit) ?></title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

    <link rel="stylesheet" type="text/css" href="css/game_new.css" />

</head>

<body id="ds_body" class="header">
    <table style="margin:auto; margin-top: 15px; width: 100%;padding:5px;">
        <tr>
            <td>
                <table class="content-border" id="content_value"
                    style="border-collapse: collapse; width: 100%; padding: 10px;">
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <img src="graphic/unit_big/<?= $cl_units->get_graphicName($unit) ?>.png"
                                            alt="<?= $cl_units->get_name($unit) ?>" />
                                    </td>
                                    <td>
                                        <h2><?= $cl_units->get_name($unit) ?></h2>
                                        <p><?= $cl_units->get_description($unit) ?></p>
                                    </td>
                                </tr>
                            </table>

                            <table class="vis">
                                <tr>
                                    <th width="150"><?= __('units.popup.costs') ?></th>
                                    <th><?= __('units.popup.pop') ?></th>
                                    <th><?= __('units.popup.speed') ?></th>
                                    <th><?= __('units.popup.loot') ?></th>
                                </tr>

                                <tr class="center">
                                    <td>
                                        <img src="graphic/icons/wood.png" title="<?= __('buildings.wood.name') ?>"
                                            alt="" /><?= $cl_units->get_woodprice($unit) ?>
                                        <img src="graphic/icons/stone.png" title="<?= __('buildings.stone.name') ?>"
                                            alt="" /><?= $cl_units->get_stoneprice($unit) ?>
                                        <img src="graphic/icons/iron.png" title="<?= __('buildings.iron.name') ?>"
                                            alt="" /><?= $cl_units->get_ironprice($unit) ?>
                                    </td>
                                    <td>
                                        <img src="graphic/icons/face.png" title="<?= __('units.popup.pop') ?>" alt="" />
                                        <?= $cl_units->get_bhprice($unit) ?>
                                    </td>
                                    <td>
                                        <?= __('units.popup.minutes_per_field', ['minutes' => ($cl_units->get_speed($unit) / 60)]) ?>
                                    </td>
                                    <td>
                                        <?= $cl_units->get_booty($unit) ?>
                                    </td>
                                </tr>
                            </table>

                            <br />

                            <table class="vis">
                                <tr>
                                    <td><?= __('units.popup.att') ?></td>
                                    <td>
                                        <img src="graphic/unit/att.png" alt="<?= __('units.popup.att') ?>" />
                                        <?= $cl_units->get_att($unit, 1) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?= __('units.popup.def') ?></td>
                                    <td>
                                        <img src="graphic/unit/def.png" alt="<?= __('units.popup.def') ?>" />
                                        <?= $cl_units->get_def($unit, 1) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?= __('units.popup.def_cav') ?></td>
                                    <td>
                                        <img src="graphic/unit/def_cav.png" alt="<?= __('units.popup.def_cav') ?>" />
                                        <?= $cl_units->get_defCav($unit, 1) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?= __('units.popup.def_archer') ?></td>
                                    <td><img src="graphic/unit/def_archer.png"
                                            alt="<?= __('units.popup.def_archer') ?>" />
                                        <?= $cl_units->get_defArcher($unit, 1) ?></td>
                                </tr>
                            </table>

                            <br />

                            <table class="vis">
                                <tr>
                                    <th colspan="<?= $cl_units->get_countNeeded($unit) ?>"><?= __('units.popup.requirements') ?></th>
                                </tr>

                                <tr>
                                    <?php if (count($cl_units->get_needed($unit)) > 0): ?>
                                        <?php foreach ($cl_units->get_needed($unit) as $n_unit => $n_stage): ?>
                                            <td>
                                                <a
                                                    href="popup_building.php?building=<?= $n_unit ?>"><?= $cl_builds->get_name($n_unit) ?></a>
                                                (<?= __('units.popup.level') ?> <?= $n_stage ?>)
                                            </td>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <td><?= __('units.popup.no_requirements') ?></td>
                                    <?php endif; ?>
                                </tr>
                            </table>
                            <br />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
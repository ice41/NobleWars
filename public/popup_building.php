<?php
/**
 * Popup Building - Shows detailed building information
 * Migrated from popup_building.php
 */

require_once __DIR__ . '/../app/bootstrap_public.php';

use App\Models\BuildsLibrary;

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

// Initialize language system
init_locale();

// Get building parameter
$building = $_GET['building'] ?? '';
session_write_close();

// Initialize library
$cl_builds = new BuildsLibrary($worldDb);

// Validate building exists, redirect to game overview if empty or invalid
if (empty($building) || !in_array($building, $cl_builds->get_array('dbname'))) {
    header('Location: game.php?screen=overview');
    exit;
}

// Output HTML
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title><?= $cl_builds->get_name($building) ?></title>
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
                                    <td valign="top">
                                        <img src="graphic/big_buildings/<?= $building ?>1.png"
                                            alt="<?= $cl_builds->get_name($building) ?>" />
                                    </td>
                                    <td valign="top">
                                        <h2><?= $cl_builds->get_name($building) ?></h2>
                                        <p><?= $cl_builds->get_description_bydbname($building) ?></p>
                                    </td>
                                </tr>
                            </table>
                            <br>

                            <table class="vis">
                                <tr>
                                    <th>
                                        <?= __('buildings.popup.max_level') ?>
                                    </th>
                                    <td>
                                        <?= $cl_builds->get_maxstage($building) ?>
                                    </td>
                                </tr>
                            </table>
                            <br>

                            <?php if (count($cl_builds->get_needed_by_dbname($building)) > 0): ?>
                                <table class="vis">
                                    <tr>
                                        <th colspan="3"><?= __('buildings.popup.requirements') ?></th>
                                    </tr>
                                    <tr>
                                        <?php foreach ($cl_builds->get_needed_by_dbname($building) as $n_building => $n_stage): ?>
                                            <td><a
                                                    href="popup_building.php?building=<?= $n_building ?>"><?= $cl_builds->get_name($n_building) ?></a>
                                                (<?= __('buildings.popup.level') ?> <?= $n_stage ?>)</td>
                                        <?php endforeach; ?>
                                    </tr>
                                </table>
                                <br>
                            <?php endif; ?>


                            <table class="vis">
                                <tr>
                                    <th><?= __('buildings.popup.level') ?></th>
                                    <th width="220"><?= __('buildings.popup.costs') ?></th>
                                    <th width="140"><?= __('buildings.popup.pop_and_total') ?></th>
                                </tr>
                                <?php for ($level = 1; $level <= $cl_builds->get_maxstage($building); $level++): ?>
                                    <tr>
                                        <td>
                                            <?= $level ?>
                                        </td>
                                        <td>
                                            <img src="graphic/icons/wood.png" title="<?= __('buildings.wood.name') ?>"
                                                alt="" /><?= $cl_builds->get_wood($building, $level) ?>
                                            <img src="graphic/icons/stone.png" title="<?= __('buildings.stone.name') ?>"
                                                alt="" /><?= $cl_builds->get_stone($building, $level) ?>
                                            <img src="graphic/icons/iron.png" title="<?= __('buildings.iron.name') ?>"
                                                alt="" /><?= $cl_builds->get_iron($building, $level) ?>
                                        </td>
                                        <td>
                                            <img src="graphic/icons/face.png" title="<?= __('units.popup.pop') ?>" alt="" />
                                            <?= $cl_builds->get_bh($building, $level) ?> /
                                            <?= $cl_builds->get_bh_total($building, $level) ?>
                                        </td>
                                    </tr>
                                <?php endfor; ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
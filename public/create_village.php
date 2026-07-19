<?php
/*****************************************/
/*   CREATE_VILLAGE.PHP - MODERNIZADO   */
/*   Seleção de direção da aldeia       */
/*   Fidelidade Visual: 100%            */
/*****************************************/

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR);

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

// Configuração
require_once('configs/config.php');

use App\Core\Database;
use App\Models\SessionModel;
use App\Models\AuthModel;

// Incluir helpers para funções de subdomínio
require_once(__DIR__ . '/../app/Helpers/helpers.php');

// Load translation helpers and initialize locale
require_once(__DIR__ . '/../app/Helpers/language_helper.php');
init_locale();

// Programmatic fallback translations injection to guarantee success if translation files aren't uploaded/present on production server
try {
    $langManager = \App\Core\LanguageManager::getInstance();
    $currentLocale = $langManager->getLocale();

    $fallbackData = [
        'title' => 'Estabelecer uma nova aldeia',
        'heading' => 'Estabelecer uma nova aldeia',
        'ennobled_by' => 'A sua aldeia foi conquistada por {name}',
        'restart_info' => 'Alguns cidadãos conseguiram escapar e podem agora construir uma nova aldeia.',
        'question' => 'Em que direção gostaria que a sua nova aldeia fosse colocada?',
        'random' => 'Aleatório (Recomendado)',
        'north_east' => 'Nordeste',
        'north_west' => 'Noroeste',
        'south_east' => 'Sudeste',
        'south_west' => 'Sudoeste',
        'submit' => 'Confirmar',
        'barbarian_village' => 'Aldeia bárbara',
        'village_of' => 'Aldeia de {name}',
    ];

    if (str_starts_with($currentLocale, 'en')) {
        $fallbackData = [
            'title' => 'Establish a new village',
            'heading' => 'Establish a new village',
            'ennobled_by' => 'Your village has been conquered by {name}',
            'restart_info' => 'A few citizens could escape and can now build a new village.',
            'question' => 'In which direction would you like your new village to be placed?',
            'random' => 'Random (Recommended)',
            'north_east' => 'North East',
            'north_west' => 'North West',
            'south_east' => 'South East',
            'south_west' => 'South West',
            'submit' => 'Confirm',
            'barbarian_village' => 'Barbarian village',
            'village_of' => 'Village of {name}',
        ];
    } elseif (str_starts_with($currentLocale, 'pl')) {
        $fallbackData = [
            'title' => 'Załóż nową wioskę',
            'heading' => 'Załóż nową wioskę',
            'ennobled_by' => 'Twoja wioska została przejęta przez {name}',
            'restart_info' => 'Kilku mieszkańców zdołało uciec i może teraz wybudować nową wioskę.',
            'question' => 'W jakim kierunku chcesz umieścić swoją nową wioskę?',
            'random' => 'Losowo (Zalecane)',
            'north_east' => 'Północny wschód',
            'north_west' => 'Północny zachód',
            'south_east' => 'Południowy wschód',
            'south_west' => 'Południowy zachód',
            'submit' => 'Potwierdź',
            'barbarian_village' => 'Wioska barbarzyńska',
            'village_of' => 'Wioska gracza {name}',
        ];
    } elseif (str_starts_with($currentLocale, 'es')) {
        $fallbackData = [
            'title' => 'Establecer un nuevo pueblo',
            'heading' => 'Establecer un nuevo pueblo',
            'ennobled_by' => 'Tu pueblo ha sido conquistado por {name}',
            'restart_info' => 'Algunos ciudadanos pudieron escapar y ahora pueden construir un nuevo pueblo.',
            'question' => '¿En qué dirección te gustaría que se colocara tu nuevo pueblo?',
            'random' => 'Aleatorio (Recomendado)',
            'north_east' => 'Nordeste',
            'north_west' => 'Noroeste',
            'south_east' => 'Sudeste',
            'south_west' => 'Sudoeste',
            'submit' => 'Confirmar',
            'barbarian_village' => 'Pueblo bárbaro',
            'village_of' => 'Pueblo de {name}',
        ];
    } elseif (str_starts_with($currentLocale, 'fr')) {
        $fallbackData = [
            'title' => 'Établir un nouveau village',
            'heading' => 'Établir un nouveau village',
            'ennobled_by' => 'Votre village a été conquis par {name}',
            'restart_info' => 'Quelques citoyens ont pu s\'échapper et peuvent maintenant construire un nouveau village.',
            'question' => 'Dans quelle direction souhaitez-vous que votre nouveau village soit placé ?',
            'random' => 'Aléatoire (Recommandé)',
            'north_east' => 'Nord-Est',
            'north_west' => 'Nord-Ouest',
            'south_east' => 'Sud-Est',
            'south_west' => 'Sud-Ouest',
            'submit' => 'Confirmer',
            'barbarian_village' => 'Village barbare',
            'village_of' => 'Village de {name}',
        ];
    }

    $langManager->setTranslations($currentLocale, 'create_village', $fallbackData);
} catch (\Exception $e) {
    // Silently fall back to standard helper lookup if injection fails
}

try {
    // Detetar mundo ativo (subdomínio em produção, ?world= em local)
    $server = get_active_world();
    $worldDb = get_world_db_name($server);

    // Check session
    $cookieName = 'session_' . $server;
    if (!isset($_COOKIE[$cookieName])) {
        header('Location: index.php');
        exit;
    }

$sessionModel = new SessionModel($worldDb);
$authModel = new AuthModel();

$sid = $_COOKIE[$cookieName];
$session = $sessionModel->checkSession($sid);

if (!$session) {
    header('Location: index.php');
    exit;
}

$userId = $session['userid'];
$user = $authModel->getUserById($userId);

if (!$user) {
    header('Location: index.php');
    exit;
}

    // Garantir que a tabela `creation_of_settlement` existe.
    $db = Database::getInstance($worldDb, get_world_db_host(get_active_world()), get_world_db_user(get_active_world()), get_world_db_pass(get_active_world()));

    // Redirecionar se o jogador já tiver aldeias neste mundo
    try {
        $worldUser = $db->query("SELECT villages FROM users WHERE id = " . (int)$userId)->fetch(\PDO::FETCH_ASSOC);
        if ($worldUser && (int)$worldUser['villages'] > 0) {
            header('Location: ' . get_world_url($server, 'game.php?screen=overview'));
            exit;
        }
    } catch (\Exception $e) {
        // Prosseguir caso a tabela users ainda não esteja pronta ou ocorra erro
    }

    try {
        $db->query("CREATE TABLE IF NOT EXISTS `twozenie_osady` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `okrag` int(11) NOT NULL DEFAULT '1',
          `osad_na_okragu` int(11) NOT NULL DEFAULT '0',
          `suma_wiosek` int(11) NOT NULL DEFAULT '0',
          PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
    } catch (\Exception $e) {
        // Silently ignore if CREATE permission is denied or if table already exists
    }

    try {
        // Initialize if empty
        $check = $db->query("SELECT COUNT(*) FROM twozenie_osady")->fetchColumn();
        if ($check == 0) {
            $db->query("INSERT INTO twozenie_osady (okrag, osad_na_okragu, suma_wiosek) VALUES (1, 0, 0)");
        }
    } catch (\Exception $e) {
        // Silently ignore if table does not exist or has issues
    }

// Helper functions ported from original functions.php

function przydziel_osadzie_kontynent($x, $y)
{
    $x_k = floor($x / 100);
    $y_k = floor($y / 100);
    return $y_k . $x_k;
}

function getrandomxyforcircle($db, $radius, $direction)
{
    if ($radius > 703) {
        $radius = 703;
    }

    /*
    Directions:
    NE (Nord-East) -> OW (Original: OW?) -> 270-360 deg
    NW (Nord-West) -> OZ (Original: OZ?) -> 180-270 deg
    SE (South-East) -> PW (Original: PW?) -> 0-90 deg
    SW (South-West) -> PZ (Original: PZ?) -> 90-180 deg
    R -> Random
    */

    $directions = ['NE', 'NW', 'SE', 'SW', 'R'];
    if (!in_array($direction, $directions)) {
        $direction = 'R';
    }

    $c = 1;
    for ($i = 1; $i <= $c; $i++) {
        if ($direction == 'SE') { // PW
            $los = mt_rand(0, 90000);
        } elseif ($direction == 'SW') { // PZ
            $los = mt_rand(90001, 180000);
        } elseif ($direction == 'NW') { // OZ
            $los = mt_rand(180001, 270000);
        } elseif ($direction == 'NE') { // OW
            $los = mt_rand(270001, 360000);
        } else { // R
            $los = mt_rand(0, 360000);
        }

        $los /= 1000;
        // 550|500 center offset? Original: 550, 500. Let's stick to 500|500 for true center if map is 1000x1000
        // But original used 550|500. Let's use 500|500 to be safe and centered.
        $x = round(cos($los * M_PI / 180) * $radius) + 500;
        $y = round(sin($los * M_PI / 180) * $radius) + 500;

        $x += mt_rand(-6, 6);
        $y += mt_rand(-6, 6);

        if ($x > 999 || $y > 999 || $x < 0 || $y < 0) {
            if ($c < 4000) {
                $c += 1;
                $db->query("UPDATE `twozenie_osady` SET `osad_na_okragu` = `osad_na_okragu` + 1");
            }
        } else {
            $cnt = $db->query("SELECT COUNT(id) FROM `villages` WHERE `x` = '$x' AND `y` = '$y'")->fetchColumn();
            if ($cnt > 0) {
                if ($c < 4500) {
                    $c += 1;
                }
            } else {
                // Check for 'decoration' (bushes/obstacles)
                $cntdecoration = $db->query("SELECT COUNT(*) FROM `decoration` WHERE `x` = '$x' AND `y` = '$y'")->fetchColumn();

                if ($cntdecoration > 0) {
                    if ($c < 4500) {
                        $c += 1;
                    }
                } else {
                    $db->query("UPDATE `twozenie_osady` SET `osad_na_okragu` = `osad_na_okragu` + 1");
                    return [$x, $y];
                }
            }
        }
    }
    return null;
}

function create_villages($db, $player_id, $count, $direction, $username_override = null, $forceX = null, $forceY = null)
{
    $player_id = (int) $gracz;
    $count = (int) $count;
    if ($count < 1)
        $count = 1;
    if ($count > 15000)
        $count = 15000;

    if ($player_id == -1) {
        $nazwa = __('create_village.barbarian_village');
    } else {
        $nazwa = __('create_village.village_of', ['name' => $username_override]);
    }

    $data = time();
    $do_tylu = 0;

    for ($i = 1; $i <= $count; $i++) {
        $create_vg = $db->query("SELECT * FROM `twozenie_osady`")->fetch(\PDO::FETCH_ASSOC);

        // If circle is full (heuristic: villages > radius * 1.75), expand radius
        if ($create_vg['osad_na_okragu'] > ($create_vg['okrag'] * 1.75) && $create_vg['okrag'] < 705) {
            $db->query("UPDATE `twozenie_osady` SET `osad_na_okragu` = 0");
            $db->query("UPDATE `twozenie_osady` SET `okrag` = `okrag` + 1");
            // Re-fetch
            $create_vg = $db->query("SELECT * FROM `twozenie_osady`")->fetch(\PDO::FETCH_ASSOC);
        }

        if ($create_vg['okrag'] < 705) {
            $coords = null;
            if ($forceX !== null && $forceY !== null) {
                $exists = $db->query("SELECT id FROM villages WHERE x = " . (int)$forceX . " AND y = " . (int)$forceY)->fetchColumn();
                if (!$exists) {
                    $coords = [(int)$forceX, (int)$forceY];
                }
            }
            if ($coords === null) {
                $coords = getrandomxyforcircle($db, $create_vg['okrag'], $direction);
            }

            if ($coords && isset($coords[0]) && isset($coords[1])) {
                $continent = (int) przydziel_osadzie_kontynent($coords[0], $coords[1]);

                // Bonus village logic (simplified)
                $bonus = 0;
                if ($player_id == -1 && mt_rand(0, 5) == 3) {
                    $bonus = mt_rand(1, 9);
                }

                $db->query(
                    "INSERT INTO villages (x, y, name, continent, userid, create_time, last_prod_aktu, bonus, points, r_wood, r_stone, r_iron,
                                          main, barracks, stable, garage, church, snob, smith, place, statue, market, wood, stone, iron, farm, storage, hide, wall) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, 26, 1000, 1000, 1000,
                             1, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 1, 1, 0, 0)",
                    [$coords[0], $coords[1], $nazwa, $continent, $player_id, $data, $data, $bonus]
                );

                $lastid = $db->lastInsertId();
                // Initialize unit_place
                $db->query("INSERT INTO unit_place (villages_from_id, villages_to_id) VALUES (?, ?)", [$lastid, $lastid]);

            } else {
                $do_tylu++;
            }
        }
    }

    $count -= $do_tylu;

    if ($player_id != -1) {
        // Update user stats
        $db->query("UPDATE `users` SET `villages` = `villages` + $count WHERE `id` = $gracz");
        // Points update skipped for now, usually handled by build events
    }

    $db->query("UPDATE `twozenie_osady` SET `suma_wiosek` = `suma_wiosek` + $count");
}

// Check if they registered via an invite with a pending coordinate, and if so, auto-create the village directly without showing the selection screen
if (isset($_SESSION['invite_code'])) {
    try {
        $inviteModel = new \App\Models\InviteModel($worldDb);
        $inviteRow = $inviteModel->getInviteByCode($_SESSION['invite_code']);
        if ($inviteRow && $inviteRow['status'] === 'pending') {
            if ($inviteRow['x'] !== null && $inviteRow['y'] !== null) {
                if (!isset($_POST['direction'])) {
                    $_POST['direction'] = 'R';
                    $_GET['action'] = 'create';
                }
            }
        }
    } catch (\Exception $e) {
        error_log("Failed to auto-process invite in create_village: " . $e->getMessage());
    }
}

// Process direction selection
if (isset($_GET['action']) && $_GET['action'] == 'create' && isset($_POST['direction'])) {
    $direction = $_POST['direction']; // OW, OZ, PW, PZ, R

    $forceX = null;
    $forceY = null;
    if (isset($_SESSION['invite_code'])) {
        try {
            $inviteModel = new \App\Models\InviteModel($worldDb);
            $inviteRow = $inviteModel->getInviteByCode($_SESSION['invite_code']);
            if ($inviteRow && $inviteRow['status'] === 'pending') {
                if ($inviteRow['x'] !== null && $inviteRow['y'] !== null) {
                    $forceX = (int)$inviteRow['x'];
                    $forceY = (int)$inviteRow['y'];
                }
            }
        } catch (\Exception $e) {
            error_log("Failed to load invite coords in create_village: " . $e->getMessage());
        }
    }

    // Map direction to internal function codes
    $spawn_dir = 'R';
    if ($direction == 'OZ')
        $spawn_dir = 'NW';
    if ($direction == 'OW')
        $spawn_dir = 'NE';
    if ($direction == 'PZ')
        $spawn_dir = 'SW';
    if ($direction == 'PW')
        $spawn_dir = 'SE';

    // Ensure user exists in world database (lan_X.users)
    // This is critical for Ranking and Game Header to work correctly
    $checkUser = $db->query("SELECT count(id) FROM users WHERE id = $userId")->fetchColumn();
    if ($checkUser == 0) {
        // Insert user into world DB
        // Using explicit ID to match global ID (conta.id)
        // Default values for new player

        // FIX: Use 'nazwa' column from global user data (AuthModel)
        $username_esc = $user['nazwa'];

        // SECURITY FIX: Check admin status from index_tw.conta
        // Only set admin=1 if user is actually admin in global database
        $adminStatus = 0;
        $globalConn = @mysqli_connect($conf['db_host'], $conf['db_user'], $conf['db_pass'], (\App\Core\Database::getGlobalDbName()));
        if ($globalConn) {
            mysqli_query($globalConn, "SET SESSION sql_mode = ''");
            $result = mysqli_query($globalConn, "SELECT admin FROM conta WHERE id = $userId");
            if ($result && $row = mysqli_fetch_assoc($result)) {
                $adminStatus = (int) $row['admin'];
            }
            mysqli_close($globalConn);
        }

        // Given existing code uses query() with vars, I'll match style but be careful. 
        // Better to use prepare/execute.

        $now = time();
        $stmt = $db->prepare("INSERT INTO users (id, tw_id, username, points, villages, ally, rang, admin, start_gaming, last_activity) VALUES (?, ?, ?, 0, 0, -1, 0, ?, ?, ?)");
        $stmt->execute([$userId, $userId, $username_esc, $adminStatus, $now, $now]);

        // REFERRAL INTEGRATION: Accept friend invite if active in session
        if (isset($_SESSION['invite_code'])) {
            try {
                $inviteModel = new \App\Models\InviteModel($worldDb);
                $inviteModel->acceptInvite($_SESSION['invite_code'], $userId);
                unset($_SESSION['invite_code']);
            } catch (\Exception $e) {
                error_log("Failed to process friend invite referral: " . $e->getMessage());
            }
        }

        // AUTOMATION: Try to assign a mentor to the new player
        try {
            $mentorsModel = new \App\Models\MentorsModel($worldDb);
            $mentorsModel->assignMentor($userId);
        } catch (\Exception $e) {
            // Silently fail if mentorship system has issues, so player can still enter world
            error_log("Failed to assign mentor: " . $e->getMessage());
        }
    }

    // Create Player Village
    // FIX: Pass username explicitly (using 'nazwa')
    create_villages($db, $userId, 1, $spawn_dir, $user['nazwa'], $forceX, $forceY);

    // Create Barbarian Villages (2 per player)
    create_villages($db, -1, 2, 'R');

    // Update user's serwery_gry list
    $mainConn = @mysqli_connect($conf['db_host'], $conf['db_user'], $conf['db_pass'], $conf['db_name']);
    if ($mainConn) {
        mysqli_query($mainConn, "SET SESSION sql_mode = ''");
        $current_worlds = $user['serwery_gry'];
        $worlds_array = explode(';', $current_worlds);
        if (!in_array($server, $worlds_array)) {
            if (!empty($current_worlds)) {
                $new_worlds = $current_worlds . ';' . $server;
            } else {
                $new_worlds = $server;
            }
            $new_worlds_esc = mysqli_real_escape_string($mainConn, $new_worlds);
            mysqli_query($mainConn, "UPDATE conta SET serwery_gry = '$new_worlds_esc' WHERE id = $userId");
        }
        mysqli_close($mainConn);
    }

    // Redirecionar para o jogo (subdomínio em produção, ?world= em local)
    header('Location: ' . get_world_url($server, 'game.php?screen=overview'));
    exit;
}
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title><?= __('create_village.title') ?></title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <?php
    // Dynamic theme CSS — mirrors the logic in app/Views/game.php
    $cv_theme = !empty($user['theme']) ? $user['theme'] : ($conf['ingame_theme'] ?? 'classic');
    $cv_assetVer = function($p) { $abs = __DIR__ . '/' . $p; return $p . '?v=' . (file_exists($abs) ? filemtime($abs) : '1'); };
    if (in_array($cv_theme, ['modern', 'obsidian', 'viking', 'nexon'])) {
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Inter:wght@300;400;600;700&family=MedievalSharp&family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <?php } ?>
    <link rel="stylesheet" type="text/css" href="<?= $cv_assetVer('css/game_new.css') ?>" />
    <?php if ($cv_theme !== 'classic') {
        $cv_themeFile = 'css/game_' . $cv_theme . '.css';
        if (file_exists(__DIR__ . '/' . $cv_themeFile)) { ?>
    <link rel="stylesheet" type="text/css" href="<?= $cv_assetVer($cv_themeFile) ?>" />
    <?php } } ?>
    <script type="text/javascript" src="<?= $cv_assetVer('js/game_combined.js') ?>"></script>
</head>

<body id="ds_body" class="header scrollableMenu theme-<?= htmlspecialchars($cv_theme) ?>">
    <div class="top_bar">
        <div class="bg_left"> </div>
        <div class="bg_right"> </div>
    </div>
    <div class="top_shadow"> </div>
    <div class="top_background"> </div>

    <table id="main_layout" cellspacing="0" align="center">
        <tr style="height: 48px;">
            <td class="topbar left"></td>
            <td class="topbar center">
                <!-- Simple Header if needed, or empty for this standalone page -->
            </td>
            <td class="topbar right"> </td>
        </tr>
        <tr class="shadedBG">
            <td class="bg_left" id="SkyScraperAdCellLeft">
                <div class="bg_left"> </div>
            </td>
            <td class="maincell" style="width: 790px;">
                <div style="position:relative; padding: 10px 0;">

                    <div class="cv-card">

                        <h3 class="cv-title"><?= __('create_village.heading') ?></h3>
                        <hr class="cv-divider">

                        <?php if (!empty($user['ennobled_by'])): ?>
                            <div class="cv-info">
                                <?= __('create_village.ennobled_by', ['name' => htmlspecialchars($user['ennobled_by'])]) ?><br>
                                <?= __('create_village.restart_info') ?>
                            </div>
                        <?php endif; ?>

                        <p class="cv-subtitle"><?= __('create_village.question') ?></p>

                        <form action="<?= htmlspecialchars(get_world_url($server, 'create_village.php?action=create')) ?>" method="post">
                            <div class="cv-layout">

                                <div class="cv-options">
                                    <div class="cv-option">
                                        <input type="radio" name="direction" value="R" id="dir_r" checked="checked" />
                                        <label for="dir_r"><?= __('create_village.random') ?></label>
                                    </div>
                                    <div class="cv-option">
                                        <input type="radio" name="direction" value="OW" id="dir_ow" />
                                        <label for="dir_ow"><?= __('create_village.north_east') ?></label>
                                    </div>
                                    <div class="cv-option">
                                        <input type="radio" name="direction" value="OZ" id="dir_oz" />
                                        <label for="dir_oz"><?= __('create_village.north_west') ?></label>
                                    </div>
                                    <div class="cv-option">
                                        <input type="radio" name="direction" value="PW" id="dir_pw" />
                                        <label for="dir_pw"><?= __('create_village.south_east') ?></label>
                                    </div>
                                    <div class="cv-option">
                                        <input type="radio" name="direction" value="PZ" id="dir_pz" />
                                        <label for="dir_pz"><?= __('create_village.south_west') ?></label>
                                    </div>
                                </div>

                                <div class="cv-compass">
                                    <img src="graphic/new/compass3.png" alt="Compass" width="180" style="display:block;" />
                                </div>

                            </div>

                            <input type="submit" value="<?= __('create_village.submit') ?>" class="cv-btn" />
                        </form>

                    </div><!-- /cv-card -->

                </div>
            </td>
            <td class="bg_right" id="SkyScraperAdCell">
                <div class="bg_right"> </div>
            </td>
        </tr>
        <tr class="newStyleOnly">
            <td class="bg_bottomleft">&nbsp;</td>
            <td class="bg_bottomcenter">&nbsp;</td>
            <td class="bg_bottomright">&nbsp;</td>
        </tr>
    </table>
</body>

</html>
<?php
} catch (\Exception $e) {
    die("Erro Crítico no Engine: " . $e->getMessage() . "<br>Linha: " . $e->getLine() . "<br>Ficheiro: " . $e->getFile() . "<br><pre>" . $e->getTraceAsString() . "</pre>");
}
?>
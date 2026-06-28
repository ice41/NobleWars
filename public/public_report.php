<?php
/**
 * Public Report Viewer
 * Displays published reports with privacy filters applied
 */

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0)
        return;
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file))
        require $file;
});

// Load translation helpers and initialize locale
require_once(__DIR__ . '/../app/Helpers/language_helper.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
init_locale();

// Get hash from URL
$hash = $_GET['hash'] ?? '';

if (empty($hash) || !preg_match('/^[a-f0-9]{32}$/i', $hash)) {
    die(__('screens.reports.public.hash_invalid'));
}

// Load configuration
require_once(__DIR__ . '/modelo/lib/config.php');
require_once(__DIR__ . '/../app/Config/database.php');
require_once(__DIR__ . '/../app/Core/Database.php');

// Populate global $conf from $config (legacy bridge)
global $conf;
$conf['db_host'] = $config['db_host'];
$conf['db_user'] = $config['db_user'];
$conf['db_pass'] = $config['db_pw'] ?? '';
$conf['db_name'] = $config['db_name'];

// Get database instance
$db = App\Core\Database::getInstance();

// Fetch public report
$stmt = $db->query("SELECT * FROM public_reports WHERE hash = ?", [$hash]);
$public_report = $stmt ? $stmt->fetch() : null;

if (!$public_report) {
    die(__('screens.reports.public.not_found'));
}

// Fetch actual report
$stmt = $db->query("SELECT * FROM reports WHERE id = ?", [$public_report['report_id']]);
$report = $stmt ? $stmt->fetch() : null;

if (!$report) {
    die(__('screens.reports.public.original_not_found'));
}

// Increment view count
$db->query("UPDATE public_reports SET view_count = view_count + 1 WHERE id = ?", [$public_report['id']]);

// Get publisher info
$stmt = $db->query("SELECT username FROM users WHERE id = ?", [$public_report['user_id']]);
$publisher = $stmt ? $stmt->fetch() : null;

// Apply privacy filters
if (!$public_report['show_all']) {
    $hidden_text = __('screens.reports.public.hidden');
    if (!$public_report['show_own_village']) {
        $report['from_villagename'] = $hidden_text;
        $report['from_x'] = '?';
        $report['from_y'] = '?';
    }

    if (!$public_report['show_own_units']) {
        $report['a_units'] = '0;0;0;0;0;0;0;0;0;0;0;0';
    }

    if (!$public_report['show_casualties']) {
        $report['b_units'] = '0;0;0;0;0;0;0;0;0;0;0;0';
    }

    if (!$public_report['show_enemy_village']) {
        $report['to_villagename'] = $hidden_text;
        $report['to_x'] = '?';
        $report['to_y'] = '?';
    }

    if (!$public_report['show_enemy_units']) {
        $report['c_units'] = '0;0;0;0;0;0;0;0;0;0;0;0';
    }

    if (!$public_report['show_enemy_casualties']) {
        $report['d_units'] = '0;0;0;0;0;0;0;0;0;0;0;0';
    }

    if (!$public_report['show_loot']) {
        $report['hives'] = '0;0;0;0;0';
    }

    if (!$public_report['show_buildings']) {
        $report['budynki'] = '';
        $report['sorowce_poz'] = '';
    }
}

// Fetch village information if missing
if (empty($report['from_villagename']) && !empty($report['from_village'])) {
    $stmt = $db->query("SELECT name, x, y FROM villages WHERE id = ?", [$report['from_village']]);
    $from_village = $stmt ? $stmt->fetch() : null;
    if ($from_village) {
        $report['from_villagename'] = $from_village['name'];
        $report['from_x'] = $from_village['x'];
        $report['from_y'] = $from_village['y'];
    }
}

if (empty($report['to_villagename']) && !empty($report['to_village'])) {
    $stmt = $db->query("SELECT name, x, y FROM villages WHERE id = ?", [$report['to_village']]);
    $to_village = $stmt ? $stmt->fetch() : null;
    if ($to_village) {
        $report['to_villagename'] = $to_village['name'];
        $report['to_x'] = $to_village['x'];
        $report['to_y'] = $to_village['y'];
    }
}

// Parse report data for display
$report['a_units'] = explode(';', $report['a_units'] ?? '');
$report['b_units'] = explode(';', $report['b_units'] ?? '');
$report['c_units'] = explode(';', $report['c_units'] ?? '');
$report['d_units'] = explode(';', $report['d_units'] ?? '');
$report['e_units'] = explode(';', $report['e_units'] ?? '');
$report['hives'] = explode(';', $report['hives'] ?? '');
$report['budynki'] = $report['budynki'] ? explode(';', $report['budynki']) : [];
$report['sorowce_poz'] = $report['sorowce_poz'] ? explode(';', $report['sorowce_poz']) : [];
$report['f_units'] = $report['f_units'] ? explode(';', $report['f_units']) : [];

// Set up required variables for the view
$village = ['id' => 0]; // Dummy village for public view
$user = ['id' => 0]; // Dummy user
$is_public_view = true; // Flag to hide publish button

// Manually define units array
$units = [
    'unit_spear' => __('units.spear.name'),
    'unit_sword' => __('units.sword.name'),
    'unit_axe' => __('units.axe.name'),
    'unit_archer' => __('units.archer.name'),
    'unit_spy' => __('units.spy.name'),
    'unit_light' => __('units.light.name'),
    'unit_cav_archer' => __('units.marcher.name'),
    'unit_heavy' => __('units.heavy.name'),
    'unit_ram' => __('units.ram.name'),
    'unit_catapult' => __('units.catapult.name'),
    'unit_paladin' => __('units.knight.name'),
    'unit_snob' => __('units.snob.name')
];

// Manually define buildings array
// ORDER MUST MATCH cl_builds->get_array("dbname") in the original engine (church is excluded)
$buildings = [
    'main'    => __('buildings.main.name'),
    'barracks'=> __('buildings.barracks.name'),
    'stable'  => __('buildings.stable.name'),
    'garage'  => __('buildings.garage.name'),
    'snob'    => __('buildings.snob.name'),
    'smith'   => __('buildings.smith.name'),
    'place'   => __('buildings.place.name'),
    'statue'  => __('buildings.statue.name'),
    'market'  => __('buildings.market.name'),
    'wood'    => __('buildings.wood.name'),
    'stone'   => __('buildings.stone.name'),
    'iron'    => __('buildings.iron.name'),
    'farm'    => __('buildings.farm.name'),
    'storage' => __('buildings.storage.name'),
    'hide'    => __('buildings.hide.name'),
    'wall'    => __('buildings.wall.name'),
];

// Set visibility flags
$see_def_units = ($public_report['show_all'] || $public_report['show_enemy_units']) ? 1 : 0;
$def_out_units_see = !empty($report['f_units']) && array_sum($report['f_units']) > 0;
$def_out_res_see = !empty($report['sorowce_poz']) && array_sum($report['sorowce_poz']) > 0;
$has_buildings = !empty($report['budynki']) && array_sum($report['budynki']) > 0;

// Set default values for missing fields
$report['from_villagename'] = $report['from_villagename'] ?? __('screens.reports.public.unknown_village');
$report['from_x'] = $report['from_x'] ?? '?';
$report['from_y'] = $report['from_y'] ?? '?';
$report['to_villagename'] = $report['to_villagename'] ?? __('screens.reports.public.unknown_village');
$report['to_x'] = $report['to_x'] ?? '?';
$report['to_y'] = $report['to_y'] ?? '?';
$report['wins'] = $report['wins'] ?? 'att';
$report['luck'] = $report['luck'] ?? 0;
$report['moral'] = $report['moral'] ?? 100;

// Ram and catapult damage fields
$report['ram'] = $report['ram'] ?? '';
$report['catapult'] = $report['catapult'] ?? '';
$report['budynek'] = $report['budynek'] ?? '';
$report['agreement'] = $report['agreement'] ?? '';

// Include the attack report view
?>
<!DOCTYPE html>
<html>

<head>
    <title><?= __('screens.reports.public.title') ?></title>
    <link rel="stylesheet" href="/graphic/game_new.css">
    <style>
        body {
            font-family: Verdana, Arial, sans-serif;
            font-size: 11px;
            background-color: #f4e4bc;
            padding: 20px;
        }

        .public-header {
            background: #f4e4bc;
            padding: 15px;
            margin-bottom: 20px;
            border: 2px solid #7d510f;
            text-align: center;
        }

        .public-header h2 {
            margin: 0 0 10px 0;
            color: #7d510f;
        }

        .public-header p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="public-header">
        <h2><?= __('screens.reports.public.heading') ?></h2>
        <p><b><?= __('screens.reports.public.published_by') ?></b> <?= htmlspecialchars($publisher['username'] ?? __('screens.reports.public.unknown_user')) ?></p>
        <p><b><?= __('screens.reports.public.published_at') ?></b> <?= date('d.m.Y H:i:s', $public_report['published_at']) ?></p>
        <p><b><?= __('screens.reports.public.views') ?></b> <?= $public_report['view_count'] ?></p>
    </div>

    <?php
    // Include the attack report template
    include(__DIR__ . '/../app/Views/screens/reports/attack.php');
    ?>

    <br>
    <p style="text-align: center;">
        <a href="/" class="btn"><?= __('screens.reports.public.back_to_game') ?></a>
    </p>
</body>

</html>
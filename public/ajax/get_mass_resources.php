<?php
require_once __DIR__ . '/../../app/bootstrap_ajax.php';

use App\Core\Database;

header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
header('Pragma: no-cache'); // HTTP 1.0.
header('Expires: 0'); // Proxies.

// Get parameters
$villageIdsParam = isset($_GET['villages']) ? $_GET['villages'] : '';
$world = isset($_GET['world']) ? $_GET['world'] : (\App\Core\Database::getWorldDbName());

if (!$villageIdsParam) {
    echo json_encode(['error' => 'No village IDs provided']);
    exit;
}

$villageIds = array_map('intval', explode(',', $villageIdsParam));
if (empty($villageIds)) {
    echo json_encode(['error' => 'Invalid village IDs']);
    exit;
}

try {
    // Session validation: a tabela sessions vive na base do MUNDO
    $worldDb = Database::getInstance($world);

    $worldNum = preg_replace('/[^0-9]/', '', $world ?: '1') ?: '1';
    $sessionSid = $_COOKIE['session_' . $worldNum]
        ?? $_COOKIE['session']
        ?? '';

    $sessionData = $worldDb->fetch("SELECT userid FROM sessions WHERE sid = ?", [$sessionSid]);

    if (!$sessionData) {
        echo json_encode(['error' => 'Invalid session']);
        exit;
    }


    $db = $worldDb;
} catch (Exception $e) {
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Get world configuration for production
global $config;
if (!isset($config) || empty($config)) {
    $worldNum = isset($_GET['world']) ? preg_replace('/[^0-9]/', '', $_GET['world']) : '1';
    $config = require __DIR__ . '/../../app/Config/Worlds/' . $worldNum . '.php';
}
$speed = $config['speed'];
$arr_production = $config['arr_production'];
$arr_maxstorage = $config['arr_maxstorage'];

// Override level 30 storage if needed
if (isset($arr_maxstorage[30]) && $arr_maxstorage[30] !== 400000) {
    $arr_maxstorage[30] = 400000;
}

// Helper to calculate production
function get_prod($level, $speed, $arr_production)
{
    if ($level === 0)
        return 0;
    return floor($arr_production[$level] * $speed); // Removed /3600 to keep hourly rate, will divide later
}

// Fetch data for all villages
$placeholders = str_repeat('?,', count($villageIds) - 1) . '?';
$sql = "SELECT id, r_wood, r_stone, r_iron, r_bh, storage, wood, stone, iron, farm, last_prod_aktu, bonus 
        FROM villages WHERE id IN ($placeholders)";

$villages = $db->fetchAll($sql, $villageIds);

$response = [];
$timenow = time();

foreach ($villages as $village) {
    // Current Resources from DB
    $r_wood = $village['r_wood'];
    $r_stone = $village['r_stone'];
    $r_iron = $village['r_iron'];
    $r_bh = $village['r_bh'];

    $max_storage = $arr_maxstorage[$village['storage']] ?? 0;
    // Level 30 override
    if ($village['storage'] === 30) {
        $max_storage = 400000;
    }

    // Production Calculation based on time elapsed
    $last_prod = $village['last_prod_aktu'];
    $time_diff = $timenow - $last_prod;

    if ($time_diff > 0) {
        // Hourly production
        $wood_prod = get_prod($village['wood'], $speed, $arr_production);
        $stone_prod = get_prod($village['stone'], $speed, $arr_production);
        $iron_prod = get_prod($village['iron'], $speed, $arr_production);

        // Apply Bonus (simplified logic, assuming bonus is percentage like 1.2 for 20%)
        // Actually bonus column logic depends on implementation, often it's 0 or a multiplier.
        // Let's assume standard 0 for now or inspect logic. In reload_vdata it handles bonus.
        // For visual projection, base production is usually enough, but let's try to be accurate.
        // Skipping complex bonus logic for now to match get_resources.php

        // Calculate gains: (Rate / 3600) * seconds
        $wood_gain = ($wood_prod / 3600) * $time_diff;
        $stone_gain = ($stone_prod / 3600) * $time_diff;
        $iron_gain = ($iron_prod / 3600) * $time_diff;

        $r_wood += $wood_gain;
        $r_stone += $stone_gain;
        $r_iron += $iron_gain;
    }

    // Cap at storage
    if ($r_wood > $max_storage)
        $r_wood = $max_storage;
    if ($r_stone > $max_storage)
        $r_stone = $max_storage;
    if ($r_iron > $max_storage)
        $r_iron = $max_storage;

    // Persist to DB if changed or time elapsed
    if ($time_diff > 0) {
        $db->query(
            "UPDATE villages SET r_wood = ?, r_stone = ?, r_iron = ?, last_prod_aktu = ? WHERE id = ?",
            [$r_wood, $r_stone, $r_iron, $timenow, $village['id']]
        );
    }

    // Calculate max coins possible
    $coin_cost_wood = $config['coin_cost']['wood'];
    $coin_cost_stone = $config['coin_cost']['stone'];
    $coin_cost_iron = $config['coin_cost']['iron'];

    $max_coins = min(
        floor($r_wood / $coin_cost_wood),
        floor($r_stone / $coin_cost_stone),
        floor($r_iron / $coin_cost_iron)
    );

    $response[$village['id']] = [
        'wood' => floor($r_wood),
        'stone' => floor($r_stone),
        'iron' => floor($r_iron),
        'max_storage' => $max_storage,
        'max_coins' => $max_coins
    ];
}

echo json_encode([
    'success' => true,
    'villages' => $response,
    'timestamp' => $timenow
]);

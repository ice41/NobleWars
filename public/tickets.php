<?php
// Suppress deprecation warnings and notices - show only real errors
error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR);
ini_set('display_errors', '0');

// Force the screen to be support
$_GET['screen'] = 'support';

// Include the standard game bootstrap and routing
require_once __DIR__ . '/game.php';

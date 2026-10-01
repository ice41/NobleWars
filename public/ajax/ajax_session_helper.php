<?php
/**
 * Centralized session validation helper for AJAX endpoints.
 * Resolves the "Invalid session" issue by checking both
 * world-specific cookies (e.g., session_1) and the legacy generic cookie (session).
 */

/**
 * Validate the session for a given world database.
 * Returns the session row (with 'userid') or null if invalid.
 *
 * @param  \App\Core\Database $worldDb  World DB instance
 * @param  string             $world    World identifier (e.g. "lan_1")
 * @return array|null
 */
function validate_ajax_session(\App\Core\Database $worldDb, string $world): ?array
{
    // Extract numeric world number (e.g. "lan_1" → "1")
    $worldNum = preg_replace('/[^0-9]/', '', $world ?: '1') ?: '1';

    // Try world-specific cookie first, then legacy generic cookie
    $sid = $_COOKIE['session_' . $worldNum]
        ?? $_COOKIE['session']
        ?? '';

    if (empty($sid)) {
        return null;
    }

    return $worldDb->fetch("SELECT userid FROM sessions WHERE sid = ?", [$sid]) ?: null;
}

/**
 * Validate session against the world 'sessions' table (unified approach).
 * The sessions table lives in the world DB, not the global DB.
 *
 * @param  \App\Core\Database $worldDb  World DB instance
 * @param  string             $world    World identifier (for cookie name)
 * @return array|null
 */
function validate_global_ajax_session(\App\Core\Database $worldDb, string $world = ''): ?array
{
    $worldNum = preg_replace('/[^0-9]/', '', $world ?: '1') ?: '1';

    $sid = $_COOKIE['session_' . $worldNum]
        ?? $_COOKIE['session']
        ?? '';

    if (empty($sid)) {
        return null;
    }

    // A tabela sessions vive na base do MUNDO
    return $worldDb->fetch("SELECT userid FROM sessions WHERE sid = ?", [$sid]) ?: null;
}

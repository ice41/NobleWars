<?php
/**
 * Database credentials — stored in app/ (outside public webroot)
 * This file is NOT accessible directly via HTTP.
 *
 * Used by: public/configs/config.php → require this file → populates $conf[]
 */

$conf['db_host'] = 'localhost';
$conf['db_user'] = 'root';
$conf['db_pass'] = ''; // Leave empty for XAMPP/WAMP default
$conf['db_prefix'] = ''; // Prefixo para bases de dados dos mundos (ex: 'iceptds')
$conf['db_name'] = 'index_tw';

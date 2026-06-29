<?php
/**
 * Database credentials — stored in app/ (outside public webroot)
 * This file is NOT accessible directly via HTTP.
 *
 * Used by: public/configs/config.php → require this file → populates $conf[]
 */

$conf['db_host'] = 'localhost'; // deve colocar o host do banco de dados, geralmente localhost
$conf['db_user'] = 'root'; // deve colocar o usuário do banco de dados, geralmente root
$conf['db_pass'] = ''; // deve colocar a senha do banco de dados, geralmente vazio
$conf['db_name'] = 'index_tw'; // deve colocar o nome do banco de dados, geralmente index_tw

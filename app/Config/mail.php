<?php
/**
 * SMTP Mailer credentials — stored safely in app/ (outside public webroot)
 * This file is NOT accessible directly via HTTP.
 */

$conf['smtp_host'] = 'ssl0.ovh.net'; // IP local ou servidor SMTP externo (ex: ssl0.ovh.net)
$conf['smtp_port'] = 465;          // Porta SMTP (25, 465 para SSL, 587 para TLS/STARTTLS)
$conf['smtp_secure'] = 'ssl';        // '', 'ssl' ou 'tls'
$conf['smtp_verify'] = false;     // Verificar certificado SSL/TLS (definir como false se tiver problemas com certificados SSL locais/CA em falta)
$conf['smtp_user'] = 'postmaster@nped.pt';          // Utilizador/Email SMTP (se requerer autenticação)
$conf['smtp_pass'] = 'Voropi4141!..';          // Senha do SMTP (se requerer autenticação)
$conf['from_email'] = 'postmaster@nped.pt';
$conf['from_name'] = 'NoReply - NobleWars';

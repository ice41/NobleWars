<?php
/**
 * EQUIPA CLÁSSICA - Noblewars
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= __('public.team.title') ?> - Noblewars</title>
    <link rel="shortcut icon" href="graphic/icons/nwfavicon.ico" type="image/x-icon" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />
</head>
<body>
    <div id="index_body">
        <div id="main">
            <div id="header">
                <h1><a href="index.php" style="background:url(graphic/index/bg-noble2.jpg) no-repeat 100% 0;"><p style="position: absolute; top: -300px">Noblewars</p></a></h1>
                <div class="navigation">
                    <div class="navigation-holder">
                        <div class="navigation-wrapper">
                            <div id="navigation_span">
                                <?php foreach ($linki as $link => $value) { echo '<a href="' . $link . '">' . $value . '</a> - '; } ?>
                                <span style="float: right; margin-right: 10px;">
                                    <?php include __DIR__ . '/components/language_selector_public.php'; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="paladin"><img src="graphic/index/bg-ice41.png" alt="" /></span>
            </div>

            <div id="content">
                <div class="container-block-full">
                    <div class="container-top-full"></div>
                    <div class="container">
                        <div class="info-block register">
                            <h2 class="register"><?= __('public.team.heading') ?></h2>
                            <br /><br />
                            <h3 style="font-weight: bold;"><?= __('public.team.support_note') ?></h3>

                            <div style="margin-top: 50px;">
                                <h2><?= __('public.team.management_title') ?></h2>
                                <br /><br />
                                <table class="vis">
                                    <tr>
                                        <th width="300"><?= __('public.team.table.name') ?></th>
                                        <th width="250"><?= __('public.team.table.role') ?></th>
                                    </tr>
                                    <tr><td>Admin</td><td><?= __('public.team.roles.admin_role') ?></td></tr>
                                    <tr><td>Moderador</td><td><?= __('public.team.roles.moderator_role') ?></td></tr>
                                    <tr><td><a href="ice41.pt">Ice41</a></td><td><?= __('public.team.roles.tech_dev') ?></td></tr>
                                </table>
                                <br />
                                <p style="margin-top: 20px; color: #666;"><?= __('public.team.footer_note') ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="container-bottom-full"></div>
                </div>
            </div>
            <div class="closure">
                &copy; <?= date('Y') ?> · by ice41 - NobleWars
                <div style="margin-top: 8px; font-size: 12px;">
                    <a href="privacy.php" style="color: #7d510f; font-weight: bold; text-decoration: none;">Política de Privacidade</a>
                </div>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/components/cookie_banner.php'; ?>
</body>
</html>

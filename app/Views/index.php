<?php if (empty($p_l)): ?>
    <!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml">

    <head>
        <title><?= __('public.index.title') ?></title>
        <meta id="og_title" property="og:title" content="Tribos" />
        <meta id="og_type" property="og:type" content="game" />
        <meta id="og_url" property="og:url" content="https://ice41.pt" />
        <meta id="og_image" property="og:image" content="http://www.die-staemme.degraphic/reports/support_arrives.jpg" />
        <meta id="og_site_name" property="og:site_name" content="Tribos" />
        <meta id="fb_app_id" property="fb:app_id" content="110344252415324" />
        <link rel="shortcut icon" href="graphic/icons/nwfavicon.ico" type="image/x-icon" />
        <meta id="og_description" property="og:description" content="tribos jogo online" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="description" content="<?= __('public.index.meta_description') ?>" />
        <meta name="keywords"
            content="Jogo online, Jogos online, Jogo de navegador, jogos de navegador, jogos, wiki, jogos pl, estatísticas, Multijogador, grátis, grátis, grátis, estratégia, Idade Média, fórum" />
        <link rel="stylesheet" type="text/css" href="css/index.css" />
        <script type="text/javascript" src="js/index.js"></script>
        <script type="text/javascript">
            //<![CDATA[
            var mobile = false;
            //]]>
        </script>
    </head>

    <body>
        <!-- ULTRA SIMPLE LANGUAGE SELECTOR - GUARANTEED VISIBLE -->
        <div
            style="position: fixed; top: 0; right: 0; z-index: 99999; background: #fff; padding: 10px; border: 3px solid red; box-shadow: 0 0 10px rgba(0,0,0,0.5);">
            <strong style="color: red;">IDIOMA:</strong>
            <select onchange="window.location.href='?lang='+this.value"
                style="padding: 5px; font-size: 14px; border: 2px solid #000;">
                <option value="pt_PT" <?= (current_locale() == 'pt_PT') ? 'selected' : '' ?>>🇵🇹 PT</option>
                <option value="en_US" <?= (current_locale() == 'en_US') ? 'selected' : '' ?>>🇬🇧 EN</option>
                <option value="es_ES" <?= (current_locale() == 'es_ES') ? 'selected' : '' ?>>🇪🇸 ES</option>
                <option value="fr_FR" <?= (current_locale() == 'fr_FR') ? 'selected' : '' ?>>🇫🇷 FR</option>
            </select>
        </div>

        <div id="pbar">
            <!-- Portal Bar content omitted for brevity as it seems external/static, keeping structure -->
            <div class="pb-outer pb-outer-pl">
                <div class="pb-inner">
                    <div class="pb-cntnt">
                        <div class="pb-home">
                            <a href="https://ice41.pt" target="_blank" title="ice41"><span>ice41</span></a>
                        </div>

                        <!-- Language Selector -->
                        <div style="float: right; margin-right: 15px; position: relative;">
                            <select onchange="window.location.href='?lang='+this.value"
                                style="background: #fff; border: 1px solid #999; padding: 2px 5px; font-size: 11px; cursor: pointer;">
                                <option value="pt_PT" <?= (current_locale() == 'pt_PT') ? 'selected' : '' ?>>🇵🇹 Português (PT)
                                </option>
                                <option value="en_US" <?= (current_locale() == 'en_US') ? 'selected' : '' ?>>🇬🇧 English
                                </option>
                                <option value="es_ES" <?= (current_locale() == 'es_ES') ? 'selected' : '' ?>>🇪🇸 Español
                                </option>
                                <option value="fr_FR" <?= (current_locale() == 'fr_FR') ? 'selected' : '' ?>>🇫🇷 Français
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pb-tab"></div>
        </div>

        <div id="index_body">
            <div id="main">
                <!-- Language Selector - Visible Position -->
                <div
                    style="text-align: right; padding: 10px 20px; background: rgba(139, 108, 66, 0.3); border-bottom: 2px solid #8b6c42;">
                    <label style="color: #3b260e; font-weight: bold; margin-right: 10px;">Idioma:</label>
                    <select onchange="window.location.href='?lang='+this.value"
                        style="background: #f4e4bc; border: 2px solid #8b6c42; padding: 5px 10px; font-size: 12px; cursor: pointer; border-radius: 3px;">
                        <option value="pt_PT" <?= (current_locale() == 'pt_PT') ? 'selected' : '' ?>>🇵🇹 Português (PT)
                        </option>
                        <option value="en_US" <?= (current_locale() == 'en_US') ? 'selected' : '' ?>>🇬🇧 English
                        </option>
                        <option value="es_ES" <?= (current_locale() == 'es_ES') ? 'selected' : '' ?>>🇪🇸 Español
                        </option>
                        <option value="fr_FR" <?= (current_locale() == 'fr_FR') ? 'selected' : '' ?>>🇫🇷 Français
                        </option>
                    </select>
                </div>

                <div id="header">
                    <h1>
                        <a href="index.php" style="background:url(graphic/index/bg-noble2.jpg) no-repeat 100% 0;">
                            <p style="position: absolute; top: -300px"><?= __('public.index.game_title') ?></p>
                        </a>
                    </h1>
                    <div class="navigation">
                        <div class="navigation-holder">
                            <div class="navigation-wrapper">
                                <div id="navigation_span">
                                    <?php
                                    $lcount = count($linki);
                                    $i = 0;
                                    foreach ($linki as $link => $value):
                                        $i++;
                                        ?>
                                        <a href="<?= $link ?>"><?= $value ?></a>
                                        <?php if ($lcount != $i)
                                            echo " - "; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="paladin"><img src="graphic/index/bg-ice41.png" alt="" /></span>
                </div>
                <div id="content">
                    <div class="container-block">
                        <div class="container-top"></div>
                        <div class="container">
                            <div class="info-block">
                                <h2><?= __('public.index.heading') ?></h2>
                                <p><?= __('public.index.description') ?></p>
                                <a class="btn-kostenlos-anmelden"
                                    href="register.php"><?= __('public.index.register_now') ?></a>
                                <strong><?= __('public.index.screenshots') ?></strong>
                                <ul class="screenshots clearfix">
                                    <li><a href="#" onclick="Index.toggle_screenshot(1); return false;"><img
                                                src="graphic/index/tribalwars-map.png?46271"
                                                alt="<?= __('public.index.screenshot_map') ?>" /></a></li>
                                    <li><a href="#" onclick="Index.toggle_screenshot(2); return false;"><img
                                                src="graphic/index/tribalwars-rally-point.png?a01a1"
                                                alt="<?= __('public.index.screenshot_rally') ?>" /></a></li>
                                    <li class="last"><a href="#" onclick="Index.toggle_screenshot(3); return false;"><img
                                                src="graphic/index/tribalwars-paladin.png?def25"
                                                alt="<?= __('public.index.screenshot_paladin') ?>" /></a></li>
                                </ul>
                                <div>
                                    <br><b><?= str_replace('{count}', $players, __('public.index.registered_accounts')) ?></b>
                                </div>
                                <div class="clear"></div>
                            </div>

                            <div class="login-block">
                                <h2 style="text-align:left;margin-bottom:15px;"><?= __('public.index.login') ?></h2>

                                <?php if (isset($error)): ?>
                                    <p class="error" style="color: #b40000"><?= $error ?></p>
                                <?php endif; ?>

                                <form action="index.php?action=login" method="post" id="login_form"
                                    onsubmit="return Index.login_submit();">
                                    <div>
                                        <label for="user">
                                            <strong><?= __('public.index.username') ?></strong>
                                            <span>
                                                <input id="user" name="user" class="text" type="text" value=""
                                                    onkeydown="if((e=window.event||event) && e.keyCode == 13 && $('#user').val() && $('#password').val()) $('#login_form').submit()" />
                                            </span>
                                        </label>
                                        <label for="password">
                                            <strong><?= __('public.index.password') ?></strong>
                                            <span>
                                                <input name="clear" type="hidden" value="true" />
                                                <input id="password" name="password" class="text" type="password"
                                                    onkeydown="if((e=window.event||event) && e.keyCode == 13 && $('#user').val() && $('#password').val()) $('#login_form').submit()" />
                                            </span>
                                        </label>

                                        <input type="submit" id="login_submit_button" style="display: none" />

                                        <label for="cookie" class="remember_me" style="text-align: right;">
                                            <input id="cookie" type="checkbox" name="cookie" value="true" />
                                            <?= __('public.index.remember_me') ?>
                                        </label>

                                        <div id="login-buttons">
                                            <div id="js_login_button">
                                                <a href="#" onclick="$('#login_submit_button').click()"
                                                    class="login_button">
                                                    <span class="button_left"></span>
                                                    <span class="button_middle"><?= __('public.index.enter') ?></span>
                                                    <span class="button_right"></span>
                                                </a>
                                            </div>
                                        </div>
                                        <br style="clear:both;" />
                                    </div>
                                </form>
                                <div style="position: absolute; bottom: 10px">
                                    <a href="lost_pw.php"><?= __('public.index.recover_password') ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="container-bottom"></div>
                    </div>
                </div><!-- content -->

                <?php if (count($news) > 0): ?>
                    <?php $bbParser = new \App\Helpers\BBCodeParser(); ?>
                    <div id="footer">
                        <div class="footer-header"></div>
                        <div class="footer-holder">
                            <?php foreach ($news as $id => $ogloszenie): ?>
                                <div>
                                    <span
                                        class="<?= ($ogloszenie['typ'] != 0) ? 'global-' : '' ?>news"><?= $ogloszenie['nazwa'] ?></span>
                                    <strong><?= $ogloszenie['data'] ?></strong>
                                    <p><?= $bbParser->parse($ogloszenie['text']) ?></p>
                                </div>
                                <?php if (count($news) != $ogloszenie['counter']): ?>
                                    <div class="news-separator"></div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <div class="footer-bottom"></div>
                    </div><!-- footer -->
                <?php endif; ?>

                <div class="closure">
                    <?= __('public.index.footer') ?>
                    <br>
                    &copy; 2009 - 2024
                    <a target="_blank" href="https://www.ice41.pt">ice41</a> &middot;
                    <div id="screenshot" style="display:none" onclick="Index.hide_screenshot();">
                        <div id="screenshot_image"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php else: ?>
    <?php if (!empty($error)): ?>
        {"error":"<?= $error ?>"}
    <?php else: ?>
        {"res":"<form action=\"/index.php?action=zaloguj\" method=\"post\" class=\"server-form\" id=\"server_select_list\">
            \n\n\t\t\n\t<input name=\"user\" type=\"hidden\" value=\"<?= $user_info['id'] ?>\"><input name=\"password\"
                type=\"hidden\" value=\"<?= $user_info['haslo'] ?>\">\n\n\t\t\n\t<div id=\"active_server\">\n\t\t\t\t\t<p
                    class=\"pseudo-heading\">Em que mundo quer entrar?<\ /p>\n\t\t\t\t\t\t\t<div class=\"clearfix\"><?php foreach ($serwery as $serw): ?>\n\t\t\t\t\t\t<a href=\"#\" onclick=\"return
                                    Index.submit_login('serwer=<?= $serw ?>');\">\n\t\t\t\t<span
                            class=\"world_button_<?= (!in_array($serw, $user_info['serwery_gry'])) ? 'in' : '' ?>active\">Mundo <?= $serw ?><\ /span>\n\t\t\t<\ /a><?php endforeach; ?>\n\t\t\t\t\t\t<\
                                        /div>\n\t\t\n\t\t\n\t\t\t\t\t<p class=\"pseudo-heading\" id=\"show_all_server\">
                                            \n\t\t\t\t<?php if ($user_info['admin'] == 0): ?><a
                                                href=\"admin.php\">Entrar como admin<\ /a><?php endif; ?>\n\t\t\t<\ /p>
                                                        \n\t\t <\ /div>\n\n \t<div id=\"inactive_server_list\"
                                                                class=\"clearfix\" style=\"display:none;\">
                                                                \n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t
                                                                <\ /div>\n\t\n\t\n<\ /form>\n\n"}
                                                                        <?php endif; ?>
                                                                        <?php endif; ?>
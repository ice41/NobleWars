<?php
/**
 * PRIVACIDADE CLÁSSICA - Noblewars
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= __('privacy.title') ?> - Noblewars</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="shortcut icon" href="graphic/icons/nwfavicon.ico" />
    <style>
        .privacy-container { max-width: 900px; margin: 20px auto; font-family: Verdana, Arial, sans-serif; }
        .privacy-header { background: linear-gradient(to bottom, #f4e4bc, #d4c4a0); border: 2px solid #8b6c42; padding: 15px 20px; margin-bottom: 20px; border-radius: 5px; text-align: center; }
        .privacy-section { background: #f8f4e8; border: 2px solid #8b6c42; border-radius: 5px; margin-bottom: 15px; overflow: hidden; }
        .privacy-section h2 { background: linear-gradient(to bottom, #d4c4a0, #b4a480); padding: 12px 15px; border-bottom: 2px solid #8b6c42; margin: 0; font-size: 16px; color: #3b260e; }
        .privacy-content { padding: 15px 20px; color: #3b260e; line-height: 1.7; font-size: 13px; }
        .privacy-content ul { padding-left: 20px; margin: 10px 0; }
        .privacy-content li { margin-bottom: 6px; }
        .privacy-content a { color: #7d510f; font-weight: bold; }
        .privacy-footer { text-align: center; margin: 20px; }
        .email-placeholder { font-weight: bold; color: #7d510f; }
        .main-footer-links { text-align: center; margin: 10px 0; font-size: 12px; }
        .main-footer-links a { color: #7d510f; text-decoration: none; margin: 0 8px; }
        .main-footer-links a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div id="index_body">
        <div id="main">
            <div id="header">
                <h1><a href="index.php" style="background:url(graphic/index/bg-noble2.jpg) no-repeat 100% 0;"><p style="position: absolute; top: -300px">NobleWars</p></a></h1>
                <div class="navigation">
                    <div class="navigation-holder">
                        <div class="navigation-wrapper">
                            <div id="navigation_span">
                                <?php
                                $i = 0;
                                $lcount = count($linki);
                                foreach ($linki as $link => $value) {
                                    $i++;
                                    echo '<a href="' . $link . '">' . $value . '</a>';
                                    if ($lcount != $i) echo ' - ';
                                }
                                ?>
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
                        <div class="privacy-container">
                            <div class="privacy-header">
                                <h1>📜 <?= __('privacy.title') ?></h1>
                                <p><?= __('privacy.last_updated') ?> <?= date('Y-m-d') ?></p>
                            </div>

                            <?php foreach (['intro', 'controller', 'collect', 'legal_basis', 'use', 'share', 'international', 'storage', 'retention', 'cookies', 'cookie_table', 'rights', 'exercise_rights', 'automated', 'minors', 'third_parties', 'account_deletion', 'breach', 'security', 'changes', 'contact'] as $section): ?>
                                <div class="privacy-section">
                                    <h2><?= __('privacy.sections.' . $section . '.title') ?></h2>
                                    <div class="privacy-content">
                                        <?= __('privacy.sections.' . $section . '.content') ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="privacy-footer">
                            <a href="index.php" style="color:#3b260e; font-weight:bold;">← <?= __('privacy.back_home') ?></a>
                        </div>
                    </div>
                    <div class="container-bottom-full"></div>
                </div>
            </div>

            <div class="closure">
                &copy; <?= date('Y') ?> <?= __('privacy.footer_copyright') ?>
                <div class="main-footer-links">
                    <a href="privacy.php"><?= __('privacy.title') ?></a>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/components/cookie_banner.php'; ?>

    <script>
        (function() {
            var u = 'geral';
            var d = 'ice41.pt';
            document.querySelectorAll('.email-placeholder').forEach(function(el) {
                var a = document.createElement('a');
                a.href = 'mailto:' + u + '@' + d;
                a.textContent = u + '@' + d;
                a.style.color = '#7d510f';
                a.style.fontWeight = 'bold';
                el.innerHTML = '';
                el.appendChild(a);
            });
        })();
    </script>
</body>
</html>

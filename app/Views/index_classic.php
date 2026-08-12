<?php
/**
 * TEMA CLÁSSICO - Noblewars
 * Design original fiel ao jogo.
 */
?>
<!DOCTYPE html>
<html>

<head>
    <title>Noblewars</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="shortcut icon" href="graphic/icons/nwfavicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=MedievalSharp&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=MedievalSharp&display=swap" rel="stylesheet"></noscript>
    <style>
        /* Estilo Medieval Puro CSS */
        .login-block {
            float: right !important;
            position: relative !important;
            top: auto !important;
            right: 10px !important;
            margin: -290px 0 0 0 !important;
            background-color: #f4e4bc;
            background-image:
                radial-gradient(circle at center, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0) 70%),
                url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.1'/%3E%3C/svg%3E");
            border: 1px solid #c2b280;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2), inset 0 0 30px rgba(160, 82, 45, 0.15), inset 0 0 5px rgba(160, 82, 45, 0.3);
            padding: 20px 25px !important;
            width: 249px !important;
            height: auto !important;
            min-height: 350px;
            color: #3e2723;
            font-family: 'MedievalSharp', cursive;
            z-index: 10;
            display: block !important;
        }

        .login-block h2 {
            color: #2d1b10 !important;
            font-family: 'MedievalSharp', cursive;
            font-size: 36px !important;
            border-bottom: 2px solid #8c5f0d;
            padding-bottom: 5px;
            margin: 0 auto 20px auto !important;
            text-align: center !important;
            text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.5);
            width: 100%;
        }

        .medieval-button {
            display: block; width: 100%; height: 46px; line-height: 46px;
            background: linear-gradient(to bottom, #8b5a2b 0%, #6d4c41 50%, #5d4037 100%);
            border: 2px solid #3e2723; border-radius: 4px;
            color: #f5f5dc !important; font-family: 'MedievalSharp', cursive; font-size: 22px;
            text-align: center; text-decoration: none !important; text-shadow: 1px 1px 2px #000;
            cursor: pointer; position: relative;
        }

        .medieval-button:hover {
            background: linear-gradient(to bottom, #a16b35 0%, #7e584a 50%, #6d4c41 100%);
            color: #fff !important; transform: translateY(-1px);
        }

        .theme-switcher {
            position: fixed; bottom: 20px; right: 20px; z-index: 1000;
            background: rgba(0,0,0,0.7); color: white; padding: 10px 15px;
            border-radius: 30px; cursor: pointer; font-family: sans-serif;
            font-size: 12px; border: 1px solid #c2b280;
            transition: all 0.3s;
        }

        .theme-switcher:hover { background: #8b5a2b; }
        
        .medieval-input {
            background: #f4e4bc; border: 2px solid #7d510f; border-radius: 4px;
            padding: 8px; font-family: 'MedievalSharp', cursive; color: #5d4037;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2); outline: none; cursor: pointer;
        }
    </style>
</head>

<body>
    <div id="index_body">
        <div id="main">
            <div id="header">
                <h1>
                    <a href="index.php" style="background:url(graphic/index/bg-noble2.jpg) no-repeat 100% 0;">
                        <p style="position: absolute; top: -300px">NobleWars - O jogo de browser</p>
                    </a>
                </h1>
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
                <div class="container-block">
                    <div class="container-top"></div>
                    <div class="container">
                        <div class="info-block">
                            <h2><?= __('public.index.heading') ?></h2>
                            <p><?= __('public.index.description') ?></p>
                            <a class="medieval-button" href="register.php"><?= __('public.index.register_now') ?></a>
                            <strong style="margin-top: 50px;"><?= __('public.index.screenshots') ?></strong>
                            <ul class="screenshots clearfix">
                                <li><a href="#"><img src="graphic/index/tribalwars-map.png" alt="Mapa" width="120" height="90" loading="lazy" decoding="async" /></a></li>
                                <li><a href="#"><img src="graphic/index/tribalwars-rally-point.png" alt="Praça" width="120" height="90" loading="lazy" decoding="async" /></a></li>
                                <li class="last"><a href="#"><img src="graphic/index/tribalwars-paladin.png" alt="Paladino" width="120" height="90" loading="lazy" decoding="async" /></a></li>
                            </ul>
                            <div style="margin-top: 80px;">
                                <br><b><?= __('public.index.registered_accounts', ['count' => $players]) ?></b>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    
                    <div class="login-block">
                        <h2><?= __('public.index.login') ?></h2>

                        <?php if ($can_log): ?>
                            <form action="index.php?action=login" method="post" id="login_form">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                                <div>
                                    <label for="user">
                                        <strong><?= __('public.index.username') ?></strong>
                                        <input id="user" name="user" class="medieval-input" type="text" style="width:100%; box-sizing:border-box;" />
                                    </label>
                                    <label for="password" style="margin-top:10px; display:block;">
                                        <strong><?= __('public.index.password') ?></strong>
                                        <input id="password" name="password" class="medieval-input" type="password" style="width:100%; box-sizing:border-box;" />
                                    </label>
                                </div>
                                <a href="#" onclick="document.getElementById('login_form').submit(); return false;" class="medieval-button"><?= __('public.index.enter') ?></a>
                                <div style="text-align: center; margin-top: 15px;">
                                    <a href="password_recovery.php" style="color: #7d510f; text-decoration: none; font-size: 14px;">
                                        <?= __('public.index.recover_password') ?>
                                    </a>
                                </div>
                            </form>
                            <?php if (!empty($error)): ?>
                                <div class="error-msg"><?= htmlspecialchars($error) ?></div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div id="world_selection">
                                <p class="pseudo-heading"><?= __('public.index.select_world') ?></p>
                                <div class="clearfix" style="margin-top:15px; width:100%; max-height:160px; overflow-y:auto; padding-right:5px;">
                                    <?php if (!empty($user_worlds)): ?>
                                        <?php foreach ($user_worlds as $world): ?>
                                            <div style="margin-bottom:10px;">
                                                <a href="<?= htmlspecialchars(get_world_url($world, 'index.php?action=select_world&csrf_token=' . ($_SESSION['csrf_token'] ?? ''))) ?>" class="medieval-button">
                                                    <?= __('public.index.world') ?>: <?= htmlspecialchars($world) ?>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                    <?php
                                    $active_worlds_clean = array_map('strval', $active_worlds);
                                    $user_worlds_clean = array_map('strval', $user_worlds);
                                    $available_worlds = array_diff($active_worlds_clean, $user_worlds_clean);
                                    if (!empty($available_worlds)):
                                    ?>
                                        <p style="font-size: 14px; margin-bottom: 5px; margin-top: 15px; color: #5d4037; text-align: left; font-family: 'MedievalSharp', cursive;"><strong>Novos Mundos:</strong></p>
                                        <?php foreach ($available_worlds as $world): ?>
                                            <div style="margin-bottom:10px;">
                                                <a href="<?= htmlspecialchars(get_world_url($world, 'index.php?action=select_world&csrf_token=' . ($_SESSION['csrf_token'] ?? ''))) ?>" class="medieval-button" style="background: linear-gradient(to bottom, #4a6b35 0%, #3e582a 50%, #2d4017 100%);">
                                                    Jogar: <?= htmlspecialchars($world) ?>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <a href="index.php?action=logout&csrf_token=<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>" class="logout-link">← <?= __('public.index.enter_as_admin') ?></a>
                            </div>
                        <?php endif; ?>
                        <div class="clear"></div>
                    </div>
                    <div class="container-bottom"></div>
                </div>
            </div>

            <?php if (count($news) > 0): ?>
                <div id="footer">
                    <div class="footer-header"></div>
                    <div class="footer-holder">
                        <div>
                            <?php foreach ($news as $og): ?>
                                <div class="news-separator"></div>
                                <strong><?= htmlspecialchars($og['nazwa']) ?></strong>
                                <div class="-bottom" style="width: 80%">
                                    <p><?= $og['data'] ?></p>
                                    <p><?= $og['text'] ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="footer-bottom"></div>
                </div>
            <?php endif; ?>

            <div class="closure">
                &copy; <?= date('Y') ?> by Ice41 - Nobles Wars
                <div style="margin-top: 8px; font-size: 12px;">
                    <a href="privacy.php" style="color: #7d510f; font-weight: bold; text-decoration: none;">Política de Privacidade</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tema controlado pelo administrador -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var loginForm = document.getElementById('login_form');
            if (loginForm) {
                loginForm.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') { loginForm.submit(); }
                });
            }
        });
    </script>
    <?php include __DIR__ . '/components/cookie_banner.php'; ?>
</body>
</html>

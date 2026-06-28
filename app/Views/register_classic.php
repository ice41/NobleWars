<?php
/**
 * REGISTO CLÁSSICO - Noblewars
 */
?>
<!DOCTYPE html>
<html>

<head>
    <title><?= __('public.register.page_title') ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="shortcut icon" href="graphic/icons/nwfavicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&display=swap" rel="stylesheet">
    <style>
        .register-block {
            position: relative; margin: 20px auto; max-width: 500px;
            background-color: #f4e4bc;
            background-image: radial-gradient(circle at center, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0) 70%),
                url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.1'/%3E%3C/svg%3E");
            border: 1px solid #c2b280; border-radius: 5px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2), inset 0 0 30px rgba(160, 82, 45, 0.15), inset 0 0 5px rgba(160, 82, 45, 0.3);
            padding: 30px 40px; color: #3e2723; font-family: 'MedievalSharp', cursive;
        }

        .register-block h2 { color: #2d1b10; font-size: 36px; border-bottom: 2px solid #8c5f0d; padding-bottom: 5px; margin-bottom: 20px; text-align: center; text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.5); }
        .register-block h3.error { color: #c62828; background: rgba(255, 205, 210, 0.3); padding: 10px; border-radius: 4px; border: 1px solid #c62828; }
        .register-block input[type="text"], .register-block input[type="password"], .register-block input[type="email"] {
            background: #e6d5ac; border: 2px solid #5d4037; border-radius: 4px; padding: 10px 12px; color: #2d1b10; width: 100%; font-size: 16px; font-family: 'MedievalSharp', cursive; box-sizing: border-box; margin-bottom: 15px;
        }

        .medieval-button {
            display: block; width: 100%; height: 50px; line-height: 50px;
            background: linear-gradient(to bottom, #8b5a2b 0%, #6d4c41 50%, #5d4037 100%);
            border: 2px solid #3e2723; border-radius: 4px; color: #f5f5dc; font-family: 'MedievalSharp', cursive; font-size: 22px; text-align: center; text-decoration: none; text-shadow: 1px 1px 2px #000; cursor: pointer; position: relative;
        }
        .medieval-button:hover { background: linear-gradient(to bottom, #a16b35 0%, #7e584a 50%, #6d4c41 100%); color: #fff; transform: translateY(-1px); }

        .theme-switcher {
            position: fixed; bottom: 20px; right: 20px; z-index: 1000;
            background: rgba(0,0,0,0.7); color: white; padding: 10px 15px;
            border-radius: 30px; cursor: pointer; font-family: sans-serif;
            font-size: 12px; border: 1px solid #c2b280;
        }
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
                        <?php if ($mode == 'rejestracja'): ?>
                            <div class="register-block">
                                <h2><?= __('public.register.title') ?></h2>
                                <p style="text-align: center;"><?= __('public.register.already_registered') ?> <a href="index.php"><?= __('public.register.here') ?></a>!</p>
                                <?php if ($error): ?><h3 class="error"><?= $error ?></h3><?php endif; ?>
                                <form action="register.php?mode=rejestracja&action=create" method="post">
                                    <label><?= __('public.register.username') ?>:</label>
                                    <input name="name" type="text" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required />
                                    <label><?= __('public.register.password') ?>:</label>
                                    <input name="password" type="password" required />
                                    <label><?= __('public.register.confirm_password') ?>:</label>
                                    <input name="password_confirm" type="password" required />
                                    <label><?= __('public.register.email') ?>:</label>
                                    <input name="email" type="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required />
                                    <div style="margin: 15px 0;">
                                        <input id="agb" value="1" name="agb" type="checkbox" required />
                                        <label for="agb"><?= __('public.register.accept_rules') ?> <a href="rules.php"><?= __('public.register.rules') ?></a>.</label>
                                    </div>
                                    <button class="medieval-button" type="submit"><?= __('public.register.register_button') ?></button>
                                </form>
                            </div>
                        <?php endif; ?>

                        <?php if ($success): ?>
                            <div class="register-block">
                                <h2><?= __('public.register.success.heading') ?></h2>
                                <p><?= __('public.register.success.message') ?></p>
                                <p><strong><?= __('public.register.success.username_label') ?></strong> <?= htmlspecialchars($new_username) ?></p>
                                <p><strong><?= __('public.register.success.activation_code_label') ?></strong> <code><?= $activation_code ?></code></p>
                                <a class="medieval-button" href="ativar.php?user=<?= urlencode($new_username) ?>&kod=<?= urlencode($activation_code) ?>"><?= __('public.register.success.activate_button') ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="container-bottom-full"></div>
                </div>
            </div>
            <div class="closure">&copy; <?= date('Y') ?> by ice41 - NobleWars</div>
        </div>
    </div>
    <!-- Tema controlado pelo administrador -->
</body>
</html>

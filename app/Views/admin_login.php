<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('admin.login.title') ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Verdana, Arial, sans-serif;
            background: url('graphic/background/bg-admin-ice41.jpg') repeat;
            background-color: #1a1410;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #3b260e;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .login-box {
            background: url('graphic/background/bg-admin-ice41.jpg') repeat;
            background-color: #2b1d12;
            border: 3px solid #8b6c42;
            border-radius: 8px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.7);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #4a331c, #2b1d12);
            padding: 30px 20px;
            text-align: center;
            border-bottom: 2px solid #8b6c42;
        }

        .login-header h1 {
            color: #e8d0a9;
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px #000;
            margin-bottom: 5px;
        }

        .login-header .subtitle {
            color: #cbb286;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .login-body {
            padding: 40px 30px;
            background: rgba(240, 230, 210, 0.95);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: #3b260e;
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #8b6c42;
            font-size: 16px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 2px solid #8b6c42;
            background: #fdfaf5;
            border-radius: 4px;
            font-size: 14px;
            color: #3b260e;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #d4af37;
            box-shadow: 0 0 8px rgba(212, 175, 55, 0.3);
        }

        .error-message {
            background: #f2dede;
            border: 1px solid #a94442;
            border-left: 4px solid #a94442;
            color: #a94442;
            padding: 12px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .error-message i {
            margin-right: 8px;
        }

        .login-button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to bottom, #8b2323, #6e1c1c);
            color: white;
            border: 2px solid #4a0d0d;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        .login-button:hover {
            background: linear-gradient(to bottom, #a02828, #8b2323);
            box-shadow: 0 0 15px rgba(139, 35, 35, 0.6);
            transform: translateY(-2px);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .login-footer {
            padding: 20px;
            text-align: center;
            background: rgba(43, 29, 18, 0.5);
            border-top: 1px solid #8b6c42;
        }

        .login-footer a {
            color: #cbb286;
            text-decoration: none;
            font-size: 12px;
            transition: color 0.3s ease;
        }

        .login-footer a:hover {
            color: #e8d0a9;
        }

        .shield-icon {
            font-size: 48px;
            color: #d4af37;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px #000;
        }

        /* Language Selector Overlay */
        .lang-selector { position: relative; display: inline-block; font-family: Arial, Tahoma, sans-serif; font-size: 11px; z-index: 1000; text-align: left; }
        .lang-current { background-color: #fff8e2; border: 1px solid #cbb286; padding: 4px 8px; cursor: pointer; display: flex; align-items: center; gap: 5px; border-radius: 2px; color: #4f3b14; font-weight: bold; transition: background 0.2s;}
        .lang-current:hover { background-color: #f4e4bc; }
        .lang-dropdown { display: none; position: absolute; left: 0; background-color: #fff8e2; border: 1px solid #cbb286; min-width: 140px; box-shadow: 0 4px 8px rgba(0,0,0,0.3); }
        .lang-item { padding: 5px 8px; display: flex; align-items: center; gap: 6px; text-decoration: none; color: #005470; border-bottom: 1px solid #e1d5b8; }
        .lang-item:last-child { border-bottom: none; }
        .lang-item:hover, .lang-item.active { background-color: #f4e4bc; }
        .lang-check { margin-left: auto; color: #217a21; font-weight: bold; font-size: 13px;}
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
				<img src="graphic/index/noblewars.png" alt="" />
                <h1><?= __('admin.login.panel_title') ?></h1>
                <div class="subtitle"><?= __('admin.login.restricted_access') ?></div>
            </div>

            <div class="login-body">
                <?php if (isset($error)): ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="admin.php?action=login">
                    <div class="form-group">
                        <label for="username">
                            <i class="fas fa-user"></i> <?= __('admin.login.username') ?>
                        </label>
                        <div class="input-wrapper">
                            <i class="fas fa-user"></i>
                            <input type="text" id="username" name="username" required autofocus
                                placeholder="<?= __('admin.login.username_placeholder') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i> <?= __('admin.login.password') ?>
                        </label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="password" name="password" required placeholder="<?= __('admin.login.password') ?>">
                        </div>
                    </div>

                    <button type="submit" class="login-button">
                        <i class="fas fa-sign-in-alt"></i> <?= __('admin.login.login_button') ?>
                    </button>
                </form>
            </div>

            <div class="login-footer">
                <a href="index.php">
                    <i class="fas fa-arrow-left"></i> <?= __('admin.login.back_to_game') ?>
                </a>

                <div style="margin-top: 15px; display: flex; justify-content: center;">
                    <div class="lang-selector">
                        <?php 
                        $currentLocale = current_locale();
                        $localeName = locale_name($currentLocale);
                        $flagCode = strtolower($currentLocale === 'en_US' ? 'gb' : substr($currentLocale, 0, 2));
                        ?>
                        <div class="lang-current" onclick="document.getElementById('login-lang-drop').style.display = document.getElementById('login-lang-drop').style.display === 'block' ? 'none' : 'block'">
                            <img src="graphic/new/country/<?= $flagCode ?>.png" style="height: 11px;"> 
                            <?= $localeName ?> <span style="font-size: 8px;">&#9650;</span>
                        </div>
                        <div class="lang-dropdown" id="login-lang-drop" style="bottom: 100%; margin-bottom: 2px;">
                            <?php foreach (available_locales() as $loc): 
                                $locName = locale_name($loc);
                                $fc = strtolower($loc === 'en_US' ? 'gb' : substr($loc, 0, 2));
                            ?>
                                <a href="admin.php?action=login&lang=<?= $loc ?>" class="lang-item <?= $currentLocale === $loc ? 'active' : '' ?>">
                                    <img src="graphic/new/country/<?= $fc ?>.png" style="height: 11px;">
                                    <?= $locName ?>
                                    <?php if($currentLocale === $loc): ?>
                                        <span class="lang-check">&#10003;</span>
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

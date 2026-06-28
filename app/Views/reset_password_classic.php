<?php
/**
 * REDEFINIR SENHA - CLASSIC THEME
 */
?>
<!DOCTYPE html>
<html>

<head>
    <title><?= __('public.reset_password.page_title') ?> - Noblewars</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="shortcut icon" href="graphic/icons/nwfavicon.ico" />
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&display=swap" rel="stylesheet">
    <style>
        body {
            background: #f4e4bc;
            font-family: 'MedievalSharp', cursive;
        }

        .reset-container {
            max-width: 500px;
            margin: 100px auto;
            background: #f9f3e3;
            border: 2px solid #7d510f;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h1 {
            color: #2d1b10;
            text-align: center;
            border-bottom: 2px solid #8c5f0d;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: #2d1b10;
            margin-bottom: 5px;
            font-size: 18px;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 2px solid #5d4037;
            border-radius: 4px;
            background: #e6d5ac;
            color: #2d1b10;
            font-size: 16px;
            font-family: 'MedievalSharp', cursive;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            background: linear-gradient(to bottom, #8b5a2b 0%, #6d4c41 50%, #5d4037 100%);
            border: 2px solid #3e2723;
            border-radius: 4px;
            color: #f5f5dc;
            font-family: 'MedievalSharp', cursive;
            font-size: 20px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            margin-bottom: 15px;
        }

        .btn:hover {
            background: linear-gradient(to bottom, #a16b35 0%, #7e584a 50%, #6d4c41 100%);
        }

        .message {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .back-link {
            display: block;
            text-align: center;
            color: #7d510f;
            text-decoration: none;
            margin-top: 15px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="reset-container">
        <h1><?= __('public.reset_password.heading') ?></h1>

        <?php if (!empty($message)): ?>
            <div class="message"><?= $message ?></div>
            <a href="index.php" class="btn"><?= __('public.reset_password.go_to_login') ?></a>
        <?php elseif (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
            <a href="password_recovery.php" class="back-link"><?= __('public.reset_password.request_new_link') ?></a>
        <?php elseif ($valid_token): ?>
            <div class="info">
                <?= __('public.reset_password.info_text') ?>
            </div>

            <form method="post">
                <label for="password"><?= __('public.reset_password.new_password_label') ?></label>
                <input type="password" id="password" name="password" required minlength="6"
                    placeholder="<?= __('public.reset_password.placeholder_min_6') ?>">

                <label for="confirm_password"><?= __('public.reset_password.confirm_password_label') ?></label>
                <input type="password" id="confirm_password" name="confirm_password" required minlength="6"
                    placeholder="<?= __('public.reset_password.placeholder_confirm') ?>">

                <button type="submit" class="btn"><?= __('public.reset_password.submit_button') ?></button>
            </form>
        <?php else: ?>
            <div class="error"><?= __('public.reset_password.invalid_link') ?></div>
            <a href="password_recovery.php" class="back-link"><?= __('public.reset_password.request_new_link') ?></a>
        <?php endif; ?>

        <a href="index.php" class="back-link"><?= __('public.reset_password.back_to_login') ?></a>
    </div>
</body>

</html>

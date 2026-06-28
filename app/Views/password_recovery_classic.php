<?php
/**
 * RECUPERAÇÃO DE SENHA - CLASSIC THEME
 */
?>
<!DOCTYPE html>
<html>

<head>
    <title><?= __('public.password_recovery.page_title') ?> - Noblewars</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="shortcut icon" href="graphic/icons/nwfavicon.ico" />
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&display=swap" rel="stylesheet">
    <style>
        body {
            background: #f4e4bc;
            font-family: 'MedievalSharp', cursive;
        }

        .recovery-container {
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

        input[type="email"] {
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
    </style>
</head>

<body>
    <div class="recovery-container">
        <h1><?= __('public.password_recovery.heading') ?></h1>

        <?php if (!empty($message)): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <label for="email"><?= __('public.password_recovery.email_label') ?></label>
            <input type="email" id="email" name="email" required placeholder="<?= __('public.password_recovery.email_placeholder') ?>">

            <button type="submit" class="btn"><?= __('public.password_recovery.submit_button') ?></button>
        </form>

        <a href="index.php" class="back-link"><?= __('public.password_recovery.back_to_login') ?></a>
    </div>
</body>

</html>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Em Manutenção — Noble Wars</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;800&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            font-family: 'Cormorant Garamond', serif;
            background: 
                radial-gradient(ellipse at top, rgba(139, 90, 43, 0.15), transparent 60%),
                radial-gradient(ellipse at bottom, rgba(60, 30, 10, 0.3), transparent 60%),
                linear-gradient(135deg, #2a1810 0%, #3d2817 50%, #1a0f08 100%);
            color: #e8d9b0;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            overflow-x: hidden;
            position: relative;
        }

        /* Textura de pergaminho/stone */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: 
                repeating-linear-gradient(45deg, transparent, transparent 2px, rgba(0,0,0,0.03) 2px, rgba(0,0,0,0.03) 4px);
            pointer-events: none;
            z-index: 0;
        }

        .scroll-container {
            position: relative;
            max-width: 640px;
            width: 100%;
            background: 
                linear-gradient(to bottom, 
                    rgba(245, 230, 195, 0.98) 0%, 
                    rgba(235, 215, 170, 0.98) 50%,
                    rgba(220, 195, 145, 0.98) 100%);
            padding: 60px 50px;
            border: 2px solid #8b5a2b;
            border-radius: 4px;
            box-shadow: 
                0 0 0 1px #5c3a1e,
                0 0 0 6px rgba(139, 90, 43, 0.3),
                0 25px 60px rgba(0, 0, 0, 0.6),
                inset 0 0 80px rgba(139, 90, 43, 0.15);
            color: #3d2817;
            text-align: center;
            z-index: 1;
            animation: fadeIn 1s ease-out;
        }

        /* Ornamentos nos cantos */
        .scroll-container::before,
        .scroll-container::after {
            content: '❦';
            position: absolute;
            font-size: 28px;
            color: #8b5a2b;
            opacity: 0.7;
        }
        .scroll-container::before { top: 15px; left: 20px; }
        .scroll-container::after { bottom: 15px; right: 20px; }

        .corner-tl, .corner-tr, .corner-bl, .corner-br {
            position: absolute;
            width: 40px;
            height: 40px;
            border: 2px solid #8b5a2b;
        }
        .corner-tl { top: 8px; left: 8px; border-right: none; border-bottom: none; }
        .corner-tr { top: 8px; right: 8px; border-left: none; border-bottom: none; }
        .corner-bl { bottom: 8px; left: 8px; border-right: none; border-top: none; }
        .corner-br { bottom: 8px; right: 8px; border-left: none; border-top: none; }

        .logo-img {
            width: 180px;
            max-width: 60%;
            margin: 0 auto 25px;
            display: block;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
            animation: glow 3s ease-in-out infinite;
        }

        h1 {
            font-family: 'Cinzel', serif;
            font-weight: 800;
            font-size: 2.2rem;
            color: #5c3a1e;
            letter-spacing: 3px;
            margin-bottom: 10px;
            text-transform: uppercase;
            text-shadow: 1px 1px 0 rgba(245, 230, 195, 0.8);
        }

        .subtitle {
            font-family: 'Cinzel', serif;
            font-size: 0.95rem;
            letter-spacing: 4px;
            color: #8b5a2b;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .divider {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px 0;
            color: #8b5a2b;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, #8b5a2b, transparent);
            max-width: 100px;
        }

        .divider span {
            padding: 0 15px;
            font-size: 20px;
        }

        .message {
            font-size: 1.35rem;
            line-height: 1.6;
            color: #3d2817;
            margin-bottom: 20px;
            font-style: italic;
        }

        .message strong {
            font-style: normal;
            color: #8b5a2b;
            font-weight: 600;
        }

        .status-box {
            margin: 30px auto;
            padding: 25px 20px;
            background: rgba(139, 90, 43, 0.08);
            border-top: 1px solid rgba(139, 90, 43, 0.3);
            border-bottom: 1px solid rgba(139, 90, 43, 0.3);
        }

        .status-label {
            font-family: 'Cinzel', serif;
            font-size: 0.9rem;
            letter-spacing: 2px;
            color: #5c3a1e;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 10px 25px;
            background: rgba(139, 90, 43, 0.1);
            border: 1px solid #8b5a2b;
            border-radius: 2px;
        }

        .pulse-dot {
            width: 12px;
            height: 12px;
            background: #b8860b;
            border-radius: 50%;
            box-shadow: 0 0 0 0 rgba(184, 134, 11, 0.7);
            animation: pulse 2s infinite;
        }

        .status-text {
            font-family: 'Cinzel', serif;
            font-size: 1.1rem;
            font-weight: 600;
            color: #5c3a1e;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .info-list {
            list-style: none;
            margin: 25px auto;
            max-width: 420px;
            text-align: left;
        }

        .info-list li {
            padding: 10px 0;
            font-size: 1.15rem;
            color: #3d2817;
            border-bottom: 1px dashed rgba(139, 90, 43, 0.3);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .info-list li:last-child {
            border-bottom: none;
        }

        .info-list li::before {
            content: '⚜';
            color: #8b5a2b;
            font-size: 1.1rem;
        }

        .footer-text {
            margin-top: 25px;
            font-size: 0.95rem;
            color: #6b4423;
            font-style: italic;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes glow {
            0%, 100% { filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3)); }
            50% { filter: drop-shadow(0 4px 15px rgba(184, 134, 11, 0.5)); }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(184, 134, 11, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(184, 134, 11, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(184, 134, 11, 0);
            }
        }

        @media (max-width: 600px) {
            .scroll-container {
                padding: 50px 25px;
            }
            h1 {
                font-size: 1.6rem;
                letter-spacing: 2px;
            }
            .message {
                font-size: 1.15rem;
            }
            .status-text {
                font-size: 0.95rem;
            }
            .info-list li {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="scroll-container">
        <div class="corner-tl"></div>
        <div class="corner-tr"></div>
        <div class="corner-bl"></div>
        <div class="corner-br"></div>

        <img src="graphic/index/noblewars.png" alt="Noble Wars" class="logo-img">

        <div class="subtitle">⚜ Edicto Real ⚜</div>
        <h1>Em Manutenção</h1>

        <div class="divider"><span>❖</span></div>

        <p class="message">
            Os nossos <strong>ferreiros e engenheiros</strong> estão a trabalhar<br>
            para melhorar o reino. O acesso encontra-se<br>
            <strong>temporariamente suspenso</strong>.
        </p>

        <div class="status-box">
            <div class="status-label">Estado do Reino</div>
            <div class="status-indicator">
                <div class="pulse-dot"></div>
                <div class="status-text">Manutenção em Curso</div>
            </div>
        </div>

        <ul class="info-list">
            <li>As terras estão a ser restauradas</li>
            <li>Novas fortificações estão a ser erguidas</li>
            <li>Regressaremos em breve, nobre viajante</li>
        </ul>

        <p class="footer-text">
            — Agradecemos a vossa paciência e lealdade —
        </p>
    </div>
</body>
</html>

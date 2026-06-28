<style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap');

    /* ========== CONTAINER PRINCIPAL ========== */
    .help-wrapper {
        position: relative;
        margin: 20px auto;
        max-width: 1100px;
    }

    .help-container {
        position: relative;
        z-index: 2;
        padding: 50px 45px;
        font-family: 'Crimson Text', serif;
        color: #3e2f1c;
    }

    /* ========== PARTÍCULAS DOURADAS ========== */
    .particles {
        position: absolute;
        inset: 0;
        z-index: 1;
        pointer-events: none;
    }

    .particle {
        position: absolute;
        border-radius: 50%;
        animation: floatUp linear infinite;
        opacity: 0;
    }

    .particle:nth-child(odd) {
        background: radial-gradient(circle, #f9e076 0%, #c1a264 70%, transparent 100%);
        box-shadow: 0 0 8px #c1a264, 0 0 15px #8b6914;
    }

    .particle:nth-child(even) {
        background: radial-gradient(circle, #ffffff 0%, #e8d5a3 70%, transparent 100%);
        box-shadow: 0 0 6px #e8d5a3;
    }

    @keyframes floatUp {
        0% { transform: translateY(0) scale(1); opacity: 0; }
        10% { opacity: 0.7; }
        90% { opacity: 0.05; }
        100% { transform: translateY(-100vh) scale(0.2); opacity: 0; }
    }

    /* ========== CABEÇALHO ========== */
    .help-header {
        text-align: center;
        margin-bottom: 50px;
        position: relative;
    }

    .help-header h1 {
        font-family: 'Cinzel Decorative', serif;
        font-size: 3em;
        font-weight: 900;
        background: linear-gradient(180deg, #5a3e1b 0%, #8b6914 60%, #4a3518 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        filter: drop-shadow(0 2px 4px rgba(80, 40, 5, 0.3));
        margin: 0 0 6px;
        letter-spacing: 3px;
        animation: titleShine 4s ease-in-out infinite alternate;
    }

    @keyframes titleShine {
        0% { filter: drop-shadow(0 2px 4px rgba(80, 40, 5, 0.3)) brightness(1); }
        100% { filter: drop-shadow(0 2px 8px rgba(139, 105, 20, 0.6)) brightness(1.1); }
    }

    .help-header .subtitle {
        font-size: 1.15em;
        color: #6b5a3e;
        font-style: italic;
        margin: 0;
        letter-spacing: 0.5px;
    }

    .ornament {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 25px;
        margin-top: 20px;
    }

    .ornament-line {
        height: 2px;
        width: 90px;
        background: linear-gradient(90deg, transparent, #c1a264, transparent);
        position: relative;
    }

    .ornament-line::after {
        content: "◆";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #c1a264;
        font-size: 0.5em;
        background: #fdf8ed;
        padding: 0 8px;
    }

    .ornament-icon {
        font-size: 2em;
        color: #8b6914;
        filter: drop-shadow(0 0 6px #c1a264);
        animation: pulseOrnament 3s ease-in-out infinite;
    }

    @keyframes pulseOrnament {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.15); }
    }

    /* ========== GRELHA DE CARDS ========== */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        perspective: 1200px;
    }

    /* ========== CARD ========== */
    .help-card {
        background: linear-gradient(160deg, #fdf8ed 0%, #f4ead4 50%, #efe0c1 100%);
        border-radius: 16px;
        padding: 35px 25px 30px;
        border: 2px solid #c1a264;
        box-shadow: 
            0 8px 20px rgba(80, 50, 10, 0.15),
            inset 0 1px 0 rgba(255, 255, 240, 0.8);
        text-align: center;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        position: relative;
        transform-style: preserve-3d;
        animation: cardEntry 0.8s ease forwards;
        opacity: 0;
    }

    .help-card:nth-child(1) { animation-delay: 0.1s; }
    .help-card:nth-child(2) { animation-delay: 0.25s; }
    .help-card:nth-child(3) { animation-delay: 0.4s; }

    @keyframes cardEntry {
        from {
            opacity: 0;
            transform: translateY(30px) rotateX(5deg);
        }
        to {
            opacity: 1;
            transform: translateY(0) rotateX(0);
        }
    }

    /* Cantos decorativos */
    .help-card::before,
    .help-card::after {
        content: "❧";
        position: absolute;
        color: #c1a264;
        font-size: 1.2em;
        opacity: 0;
        transition: all 0.5s ease;
        z-index: 3;
    }

    .help-card::before {
        top: 12px;
        left: 18px;
        transform: rotate(-45deg);
    }

    .help-card::after {
        bottom: 12px;
        right: 18px;
        transform: rotate(135deg);
    }

    .help-card:hover::before,
    .help-card:hover::after {
        opacity: 1;
    }

    /* Efeito de brilho ao passar o rato */
    .help-card:hover {
        transform: translateY(-10px) scale(1.03);
        box-shadow: 
            0 20px 40px rgba(80, 50, 10, 0.3),
            inset 0 1px 0 rgba(255, 255, 240, 0.9),
            0 0 0 3px rgba(193, 162, 100, 0.4);
        border-color: #8b6914;
        background: linear-gradient(160deg, #ffffff 0%, #f7efda 50%, #f0e2c8 100%);
    }

    /* Ícone */
    .icon-circle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 90px;
        height: 90px;
        background: radial-gradient(circle at 35% 35%, #fdf8ed 0%, #e7d6af 60%, #c1a264 100%);
        border-radius: 50%;
        margin-bottom: 22px;
        font-size: 2.8em;
        border: 3px solid #c1a264;
        box-shadow: 
            0 6px 15px rgba(139, 105, 20, 0.3),
            inset 0 2px 8px rgba(255, 255, 220, 0.9);
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        position: relative;
        z-index: 2;
    }

    .help-card:hover .icon-circle {
        transform: scale(1.1) translateY(-4px) rotate(5deg);
        box-shadow: 
            0 15px 30px rgba(139, 105, 20, 0.5),
            inset 0 3px 10px rgba(255, 255, 220, 1);
        border-color: #8b6914;
    }

    /* Título */
    .help-card h3 {
        margin: 0 0 12px;
        font-family: 'Cinzel Decorative', serif;
        font-weight: 700;
        position: relative;
        z-index: 2;
    }

    .help-card h3 a {
        color: #4a3518;
        text-decoration: none;
        font-size: 1.3em;
        transition: all 0.3s;
        position: relative;
        display: inline-block;
    }

    .help-card h3 a::after {
        content: "";
        position: absolute;
        bottom: -3px;
        left: 50%;
        width: 0;
        height: 2px;
        background: #8b6914;
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }

    .help-card h3 a:hover::after {
        width: 100%;
    }

    .help-card h3 a:hover {
        color: #8b6914;
    }

    /* Descrição */
    .help-card p {
        color: #5a4a32;
        font-size: 1em;
        line-height: 1.7;
        position: relative;
        z-index: 2;
    }

    /* Seta */
    .arrow-hint {
        display: inline-block;
        margin-top: 18px;
        font-size: 1.3em;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.4s ease;
        color: #8b6914;
    }

    .help-card:hover .arrow-hint {
        opacity: 1;
        transform: translateY(0);
    }

    /* ========== RESPONSIVO ========== */
    @media (max-width: 700px) {
        .help-container {
            padding: 30px 20px;
        }
        .help-header h1 {
            font-size: 2em;
            letter-spacing: 1px;
        }
        .help-card {
            padding: 25px 18px;
        }
        .icon-circle {
            width: 70px;
            height: 70px;
            font-size: 2.2em;
        }
    }
</style>

<div class="help-wrapper">
    <!-- Partículas douradas -->
    <div class="particles" aria-hidden="true">
        <div class="particle" style="left: 8%; width: 5px; height: 5px; animation-duration: 9s; animation-delay: 0s;"></div>
        <div class="particle" style="left: 22%; width: 4px; height: 4px; animation-duration: 11s; animation-delay: 1s;"></div>
        <div class="particle" style="left: 35%; width: 6px; height: 6px; animation-duration: 8s; animation-delay: 0.5s;"></div>
        <div class="particle" style="left: 48%; width: 3px; height: 3px; animation-duration: 13s; animation-delay: 2s;"></div>
        <div class="particle" style="left: 60%; width: 5px; height: 5px; animation-duration: 10s; animation-delay: 1.5s;"></div>
        <div class="particle" style="left: 75%; width: 7px; height: 7px; animation-duration: 7s; animation-delay: 0.8s;"></div>
        <div class="particle" style="left: 88%; width: 4px; height: 4px; animation-duration: 12s; animation-delay: 3s;"></div>
        <div class="particle" style="left: 95%; width: 5px; height: 5px; animation-duration: 9.5s; animation-delay: 0.3s;"></div>
    </div>

    <div class="help-container">
        <div class="help-header">
            <h1><?= __('help.main.title') ?></h1>
            <p class="subtitle"><?= __('help.main.welcome') ?></p>
            <div class="ornament">
                <div class="ornament-line"></div>
                <div class="ornament-icon">⬥</div>
                <div class="ornament-line"></div>
            </div>
        </div>

        <div class="cards-grid">
            <div class="help-card">
                <div class="icon-circle"><i class="fas fa-dungeon"></i></div>
                <h3><a href="help.php?mode=buildings"><?= __('help.main.buildings_title') ?></a></h3>
                <p><?= __('help.main.buildings_desc') ?></p>
                <span class="arrow-hint">↗</span>
            </div>

            <div class="help-card">
                <div class="icon-circle"><i class="fas fa-chess-knight"></i></div>
                <h3><a href="help.php?mode=units"><?= __('help.main.units_title') ?></a></h3>
                <p><?= __('help.main.units_desc') ?></p>
                <span class="arrow-hint">↗</span>
            </div>

            <div class="help-card">
                <div class="icon-circle"><i class="fas fa-code"></i></div>
                <h3><a href="help.php?mode=bb_codes"><?= __('help.main.bb_codes_title') ?></a></h3>
                <p><?= __('help.main.bb_codes_desc') ?></p>
                <span class="arrow-hint">↗</span>
            </div>
        </div>
    </div>
</div>
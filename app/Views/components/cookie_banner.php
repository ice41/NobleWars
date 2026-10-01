<?php
/**
 * Cookie Consent - NobleWars Public Pages
 * Cartão flutuante moderno medieval no canto inferior direito.
 */
?>
<style>
    .nw-cookie-card {
        position: fixed;
        bottom: 22px;
        right: 22px;
        width: 360px;
        max-width: calc(100% - 44px);
        z-index: 99999;
        display: none;
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.4s ease, transform 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        font-family: 'MedievalSharp', 'Cinzel', Georgia, serif;
    }

    .nw-cookie-card.visible {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .nw-cookie-card.dismiss {
        opacity: 0;
        transform: translateY(20px);
        pointer-events: none;
    }

    .nw-cookie-inner {
        background:
            radial-gradient(circle at 30% 20%, rgba(255, 248, 225, 0.35) 0%, rgba(255, 248, 225, 0) 60%),
            url("data:image/svg+xml,%3Csvg width='220' height='220' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.08'/%3E%3C/svg%3E"),
            linear-gradient(145deg, #fdf6e3 0%, #f4e4bc 50%, #e8d5aa 100%);
        border: 3px solid #c2b280;
        border-radius: 16px;
        box-shadow:
            0 0 0 1px rgba(62, 39, 35, 0.3) inset,
            0 0 0 4px rgba(194, 178, 128, 0.25),
            0 15px 40px rgba(0, 0, 0, 0.45);
        color: #3e2723;
        padding: 24px;
        position: relative;
        overflow: hidden;
    }

    .nw-cookie-inner::before,
    .nw-cookie-inner::after {
        content: "❖";
        position: absolute;
        color: #c2b280;
        font-size: 18px;
        z-index: 2;
    }

    .nw-cookie-inner::before { top: 10px; left: 14px; }
    .nw-cookie-inner::after { top: 10px; right: 14px; }

    .nw-cookie-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .nw-cookie-icon {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: radial-gradient(circle at 35% 35%, #fdf8ed 0%, #e7d6af 60%, #c2b280 100%);
        border: 2px solid #c2b280;
        box-shadow: 0 4px 10px rgba(139, 105, 20, 0.35), inset 0 1px 4px rgba(255, 255, 220, 0.9);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #8b6914;
        flex-shrink: 0;
    }

    .nw-cookie-title {
        font-family: 'MedievalSharp', 'Cinzel', Georgia, serif;
        font-size: 18px;
        color: #5d4037;
        margin: 0;
        text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.4);
    }

    .nw-cookie-text {
        font-family: 'Outfit', Verdana, sans-serif;
        font-size: 13px;
        line-height: 1.6;
        color: #4a3520;
        margin: 0 0 16px 0;
        padding-left: 58px;
    }

    .nw-cookie-text a {
        color: #8b6914;
        font-weight: bold;
        text-decoration: underline;
    }

    .nw-cookie-text a:hover {
        color: #5d4037;
    }

    .nw-cookie-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        padding-left: 58px;
    }

    .nw-cookie-btn {
        border: 2px solid #3e2723;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-family: 'MedievalSharp', 'Cinzel', Georgia, serif;
        font-size: 13px;
        font-weight: bold;
        transition: all 0.2s ease;
        text-align: center;
    }

    .nw-cookie-btn.accept {
        background: linear-gradient(to bottom, #8b5a2b, #6d4c41);
        color: #f5f5dc;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.3);
    }

    .nw-cookie-btn.accept:hover {
        background: linear-gradient(to bottom, #a16b35, #7e584a);
        transform: translateY(-1px);
    }

    .nw-cookie-btn.reject {
        background: transparent;
        color: #5d4037;
        border-color: #8b6914;
    }

    .nw-cookie-btn.reject:hover {
        background: rgba(194, 178, 128, 0.15);
        color: #3e2723;
    }

    @media (max-width: 480px) {
        .nw-cookie-card {
            bottom: 12px;
            right: 12px;
            width: auto;
            left: 12px;
        }

        .nw-cookie-inner {
            padding: 18px;
        }

        .nw-cookie-text,
        .nw-cookie-actions {
            padding-left: 0;
        }

        .nw-cookie-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .nw-cookie-btn {
            width: 100%;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .nw-cookie-card,
        .nw-cookie-btn {
            transition: none !important;
        }
    }
</style>

<div id="nw-cookie-banner" class="nw-cookie-card" role="dialog" aria-live="polite" aria-label="Consentimento de Cookies">
    <div class="nw-cookie-inner">
        <div class="nw-cookie-header">
            <div class="nw-cookie-icon" aria-hidden="true">🍪</div>
            <h2 class="nw-cookie-title">Cookies</h2>
        </div>

        <p class="nw-cookie-text">
            Utilizamos cookies essenciais e, com o seu consentimento, analíticos.
            <a href="privacy.php">Saber mais</a>.
        </p>

        <div class="nw-cookie-actions">
            <button class="nw-cookie-btn reject" id="nw-cookie-reject" type="button">Apenas essenciais</button>
            <button class="nw-cookie-btn accept" id="nw-cookie-accept" type="button">Aceitar</button>
        </div>
    </div>
</div>

<script>
    (function () {
        'use strict';

        var STORAGE_KEY = 'nw_cookie_consent_v1';

        function getConsent() {
            try {
                return localStorage.getItem(STORAGE_KEY);
            } catch (e) {
                return null;
            }
        }

        function setConsent(value) {
            try {
                localStorage.setItem(STORAGE_KEY, value);
            } catch (e) {
                try { sessionStorage.setItem(STORAGE_KEY, value); } catch (e2) {}
            }
        }

        function hideCookieBanner() {
            var banner = document.getElementById('nw-cookie-banner');
            if (!banner) {
                return;
            }
            banner.classList.add('dismiss');
            setTimeout(function () {
                banner.classList.remove('visible', 'dismiss');
            }, 400);
        }

        function initCookieBanner() {
            if (getConsent() !== null) {
                return;
            }

            var banner = document.getElementById('nw-cookie-banner');
            var acceptBtn = document.getElementById('nw-cookie-accept');
            var rejectBtn = document.getElementById('nw-cookie-reject');

            if (!banner || !acceptBtn || !rejectBtn) {
                return;
            }

            banner.classList.add('visible');

            acceptBtn.addEventListener('click', function () {
                setConsent('accepted');
                hideCookieBanner();
            });

            rejectBtn.addEventListener('click', function () {
                setConsent('essential');
                hideCookieBanner();
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initCookieBanner);
        } else {
            initCookieBanner();
        }
    })();
</script>

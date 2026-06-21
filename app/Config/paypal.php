<?php
/**
 * PayPal Configuration
 *
 * INSTRUÇÕES:
 * 1. Acede a https://developer.paypal.com e inicia sessão com a tua conta PayPal
 * 2. Vai a "Apps & Credentials" → "Create App"
 * 3. Em modo SANDBOX (testes): copia o Client ID e Secret do sandbox
 * 4. Em modo LIVE (produção real): muda PAYPAL_MODE para 'live' e usa as credenciais live
 *
 * IMPORTANTE: Nunca partilhes este ficheiro. Adiciona-o ao .gitignore se usares Git.
 */

return [
    // -------------------------------------------------------------------------
    // MODO: 'sandbox' para testes | 'live' para pagamentos reais
    // -------------------------------------------------------------------------
    'mode' => 'sandbox',

    // -------------------------------------------------------------------------
    // CREDENCIAIS SANDBOX (para testes - não cobram dinheiro real)
    // -------------------------------------------------------------------------
    'sandbox_client_id'     => '',
    'sandbox_client_secret' => '',

    // -------------------------------------------------------------------------
    // CREDENCIAIS LIVE (pagamentos reais - só ativar quando estiver pronto)
    // -------------------------------------------------------------------------
    'live_client_id'     => '',
    'live_client_secret' => '',

    // -------------------------------------------------------------------------
    // MOEDA (ex: EUR, USD, BRL)
    // -------------------------------------------------------------------------
    'currency' => 'EUR',

    // -------------------------------------------------------------------------
    // URLs de retorno após pagamento
    // (são geridas automaticamente pelo SDK, podes deixar assim)
    // -------------------------------------------------------------------------
    'return_url' => '/game.php?screen=paypal&action=success',
    'cancel_url' => '/game.php?screen=paypal&action=cancel',
];

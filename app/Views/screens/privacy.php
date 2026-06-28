<?php
/**
 * Proteção de Dados / Política de Privacidade
 */
?>
<h2><?= __('screens.premium.data_protection') ?></h2>

<div class="content-box" style="background: #F4E4BC; border: 1px solid #8B4513; padding: 20px; line-height: 1.8;">

    <h3>1. Responsável pelo Tratamento</h3>
    <p>O responsável pelo tratamento dos seus dados pessoais é o Operador deste servidor de jogo. Para questões relacionadas com privacidade, contacte-nos através da secção de <a href="game.php?village=<?= $village['id'] ?>&screen=support">Suporte</a>.</p>

    <h3>2. Dados Recolhidos</h3>
    <p>Recolhemos apenas os dados estritamente necessários para o funcionamento do jogo:</p>
    <ul style="padding-left: 20px;">
        <li><strong>Dados de registo:</strong> nome de utilizador, endereço de e-mail, palavra-passe (encriptada)</li>
        <li><strong>Dados de jogo:</strong> atividade no jogo, pontuações, aldeias, alianças</li>
        <li><strong>Dados técnicos:</strong> endereço IP, tipo de navegador, data e hora de acesso (para fins de segurança)</li>
        <li><strong>Dados de pagamento:</strong> processados exclusivamente através do fornecedor de pagamentos (não armazenamos dados bancários)</li>
    </ul>

    <h3>3. Finalidade do Tratamento</h3>
    <p>Os seus dados são utilizados para:</p>
    <ul style="padding-left: 20px;">
        <li>Prestação e manutenção do serviço de jogo</li>
        <li>Gestão da sua conta e autenticação</li>
        <li>Prevenção de fraudes e comportamentos abusivos</li>
        <li>Comunicações relacionadas com o serviço (e-mails de sistema)</li>
        <li>Processamento de compras de pontos premium</li>
    </ul>

    <h3>4. Partilha de Dados</h3>
    <p>Não vendemos nem partilhamos os seus dados pessoais com terceiros para fins comerciais. Podemos partilhar dados com fornecedores de serviços essenciais (alojamento, processamento de pagamentos) sob contratos de confidencialidade.</p>

    <h3>5. Retenção de Dados</h3>
    <p>Os seus dados são conservados enquanto a sua conta estiver ativa. Após eliminação da conta, os dados são removidos no prazo de 30 dias, exceto os dados exigidos por lei.</p>

    <h3>6. Os Seus Direitos</h3>
    <p>Tem o direito de:</p>
    <ul style="padding-left: 20px;">
        <li>Aceder aos seus dados pessoais</li>
        <li>Corrigir dados incorretos</li>
        <li>Solicitar a eliminação da sua conta e dados</li>
        <li>Opor-se ao tratamento dos seus dados</li>
    </ul>
    <p>Para exercer estes direitos, contacte-nos através da secção de <a href="game.php?village=<?= $village['id'] ?>&screen=support">Suporte</a>.</p>

    <h3>7. Cookies</h3>
    <p>Utilizamos cookies essenciais para o funcionamento do jogo (sessão de utilizador). Não são utilizados cookies de rastreamento ou publicidade.</p>

    <p style="margin-top: 20px; font-size: 12px; color: #666;">Última atualização: Março de 2026 | Em conformidade com o RGPD (Regulamento Geral sobre a Proteção de Dados)</p>
</div>

<p style="margin-top: 15px;">
    <a href="game.php?village=<?= $village['id'] ?>&screen=premium" class="btn">← Voltar ao Premium</a>
</p>

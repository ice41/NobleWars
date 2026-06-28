<?php
/**
 * HTML Email Template for Password Recovery
 *
 * @param string $username
 * @param string $resetLink
 * @return string
 */
return function(string $username, string $resetLink, string $logoUrl = ''): string {
    if (empty($logoUrl)) {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
        $logoUrl = $protocol . ($_SERVER['HTTP_HOST'] ?? '127.0.0.1:8000') . "/graphic/index/noblewars.png";
    }

    return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperação de Senha - NobleWars</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4e4bc; font-family: 'Georgia', 'Times New Roman', Times, serif; color: #2d1b10; -webkit-font-smoothing: antialiased;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4e4bc; padding: 20px 0;">
        <tr>
            <td align="center">
                <!-- Main Card -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #f9f3e3; border: 3px double #7d510f; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); overflow: hidden;">
                    <!-- Header Banner -->
                    <tr>
                        <td align="center" style="background: linear-gradient(to bottom, #4a2f13 0%, #2d1b10 100%); padding: 20px; border-bottom: 3px double #7d510f;">
                            <img src="{$logoUrl}" alt="NobleWars" style="display: block; max-width: 180px; height: auto; border: 0;" />
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <h2 style="margin-top: 0; font-family: 'Georgia', serif; font-size: 20px; color: #7d510f; border-bottom: 1px solid #dcd1b4; padding-bottom: 10px;">Recuperação de Senha</h2>
                            
                            <p style="font-size: 16px; line-height: 1.6; margin: 20px 0;">Olá <strong>{$username}</strong>,</p>
                            
                            <p style="font-size: 16px; line-height: 1.6; margin: 20px 0;">Recebeu esta mensagem porque foi efetuado um pedido de recuperação de senha para a sua conta de jogo no NobleWars.</p>
                            
                            <p style="font-size: 16px; line-height: 1.6; margin: 20px 0;">Para redefinir a sua senha e voltar ao campo de batalha, clique no botão abaixo (este link é válido por apenas 1 hora):</p>
                            
                            <!-- Button Container -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{$resetLink}" target="_blank" style="display: inline-block; padding: 14px 30px; background: linear-gradient(to bottom, #8b5a2b 0%, #6d4c41 100%); border: 2px solid #3e2723; border-radius: 4px; color: #f5f5dc; font-family: 'Georgia', serif; font-size: 18px; font-weight: bold; text-decoration: none; text-shadow: 1px 1px 2px rgba(0,0,0,0.5); box-shadow: 0 4px 6px rgba(0,0,0,0.15); transition: background 0.2s;">
                                            Redefinir Senha
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="font-size: 14px; line-height: 1.6; color: #6d4c41; background-color: #f1ebd8; border-left: 4px solid #8b5a2b; padding: 10px 15px; margin: 25px 0; border-radius: 0 4px 4px 0; box-sizing: border-box;">
                                Se tiver problemas com o botão acima, copie e cole o seguinte link no seu navegador:<br>
                                <a href="{$resetLink}" target="_blank" style="color: #8b5a2b; word-break: break-all; text-decoration: underline;">{$resetLink}</a>
                            </p>
                            
                            <p style="font-size: 14px; line-height: 1.6; color: #5c5346; margin: 20px 0 0 0;">
                                Se não solicitou a redefinição de senha, por favor ignore este e-mail. A sua conta permanece totalmente segura.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #f1ebd8; padding: 25px 20px; border-top: 1px solid #dcd1b4; font-size: 12px; color: #7d7260;">
                            <p style="margin: 0 0 5px 0; font-weight: bold; color: #5d4037;">A Equipa NobleWars</p>
                            <p style="margin: 0;">&copy; 2026 NobleWars. Todos os direitos reservados.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
HTML;
};

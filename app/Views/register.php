<?php if (isset($ajax) && $ajax): ?>
    {"status":"ERROR","errors":["nickname_too_short"]}
<?php else: ?>
    <!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <title>Noblewars by ice41</title>
        <link rel="shortcut icon" href="/graphic/icons/nwfavicon.ico" type="image/x-icon" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="description"
            content="NobleWars é um jogo online para browser. Cada jogador possui uma pequena aldeia que deve liderar rumo ao poder e à glória." />
        <link rel="stylesheet" type="text/css" href="css/index.css" />
        <script type="text/javascript" src="js/index.js?1349701368"></script>
    </head>

    <body>
        <div id="index_body">
            <div id="main">
                <div id="header">
                    <h1><a href="index.php" style="background:url(graphic/index/bg-noble2.jpg) no-repeat 100% 0;"></a></h1>
                    <div class="navigation">
                        <div class="navigation-holder">
                            <div class="navigation-wrapper">
                                <div id="navigation_span">
                                    <?php
                                    $lcount = count($linki);
                                    $i = 0;
                                    foreach ($linki as $link => $value):
                                        $i++;
                                        ?>
                                        <a href="<?= $link ?>"><?= $value ?></a>
                                        <?php if ($lcount != $i)
                                            echo "-"; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="paladin"><img src="graphic/index/bg-paladin-new.png" alt="" /></span>
                </div>
                <div id="content">
                    <div id="screenshot" style="visibility:hidden" onclick="hide_screenshot();">
                        <div id="screenshot_image"></div>
                    </div>
                    <div class="container-block-full">
                        <div class="container-top-full"></div>
                        <div class="container">
                            <?php if ($mode == 'rejestracja'): ?>
                                <div class="info-block register" style="margin-left:10px">
                                    <script type="text/javascript">
                                        //<![CDATA[
                                        Register.messages = {
                                            nickname_too_short: 'O Nick deve conter pelo menos quatro caracteres!',
                                            nickname_too_long: 'O Nick pode conter at vinte e quatro caracteres!',
                                            nickname_bad_char: 'Nome imprprio',
                                            nickname_blocked: 'Nome imprprio',
                                            nickname_conflict: 'Nome do jogador j est em uso!',
                                            nickname_unknown: 'Ocorreu um erro desconhecido, tente mais tarde.'
                                        };

                                        $(document).ready(function () {
                                            Register.checkName($('#name').val());
                                        });
                                        GAPageTracking.track({ page_identifier: "reg_form", page_type: "game" });
                                        //]]>
                                    </script>
                                    <h3>Cada jogador apenas pode ter 1 conta para o mundo!</h3>

                                    <p>Se posivelmente se registou algum dia. Entre na sua conta <a href="./">aqui</a> !</p>

                                    <?php if (!empty($error)): ?>
                                        <h3 class="error"><?= $error ?></h3>
                                    <?php endif; ?>
                                    <br />

                                    <form id="register_form" action="index.php?action=create_account" method="post">

                                        <label for="name">O nome de ulilizador:</label><br />
                                        <input id="name" autocomplete="off" autofocus="autofocus" name="name" type="text"
                                            value="" onchange="Register.checkName(this.value)" />
                                        <span id="name_error" class="error"></span><br />

                                        <div id="name-suggestions"
                                            style="display: none; padding: 8px;  margin-top: 8px; border: 1px solid #654; width: 30em; margin-bottom: 8px;">
                                            <h3 class="error">Sugestao de nome:</h3>
                                            <ul id="name-suggestion-list">
                                            </ul>
                                        </div>

                                        <br />
                                        <label for="password">Senha:</label><br />
                                        <input id="password" name="password" type="password" value="" maxlength="100"
                                            onchange="Register.checkInputEqual('name', this.value);Register.checkInput('password', this.value)" />
                                        <span id="password_error" class="error"></span> <span id="password_errors"
                                            class="error"></span> <span id="password_info" class="info"></span><br />
                                        <br />

                                        <label for="password_confirm">Confirmar Senha:</label><br />
                                        <input id="password_confirm" name="password_confirm" type="password" value=""
                                            maxlength="100" onchange="Register.checkInputEqual('password', this.value)" /> <span
                                            id="password_confirm_error" class="error"></span>
                                        <br />

                                        <label for="email">E-Mail:</label><br />
                                        <span class="small">(Use um email real pois vai precisar de confirmar a sua
                                            conta)</span><br />


                                        <input id="email" name="email" type="text" value="" size="40" maxlength="150" /> <input
                                            type="hidden" name="email_hash" value="" />
                                        <div id="email_error" class="error" style="margin-bottom: 10px;"></div><br />

                                        <div>
                                            <table width="100%">

                                                <tr>
                                                    <td valign="top" width="20px"><input id="agb" value="1" name="agb"
                                                            type="checkbox" /></td>
                                                    <td>
                                                        Veja as regras antes de aceitar <a href="rules.php">Regras</a>.
                                                    </td>
                                                </tr>
                                            </table>
                                        </div><br />

                                        <input class="button_middle" id="register_button" type="submit" value="Registar" />
                                    </form>
                                </div>
                            <?php endif; ?>

                            <?php if ($mode == 'powodzenie' && $pokaz): ?>
                                <div class="info-block register" style="margin-left:10px">
                                    <h3>Seu Registo no site <a href="index.php?log=<?= $username ?>"></a> executado com sucesso!
                                        <?php if ($wa): ?>
                                            Seu código de ativação é: <strong><?= $kod ?></strong> Agora pode usá-lo para
                                            ativar sua conta! A ativação da conta pode ser encontrada nesta página:<a
                                                href="ativar.php">Activar</a>
                                        <?php endif; ?>
                                    </h3><br>
                                    <p>
                                        <?php if ($p_admin == 'false'): ?>
                                        <h3 class="error">Observação! O site ainda não tem um proprietário! Pode ativar sua
                                            conta + adicionar um administrador em <a
                                                href="wlasciciel.php?gracz=<?= $username ?>">esta pgina: First administrador</a>
                                        </h3>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="container-bottom-full"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php endif; ?>
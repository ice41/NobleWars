<a name="readme-top"></a>
<div align="center">

  
![PHP](https://img.shields.io/badge/php_8.3.0-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![CSS](https://img.shields.io/badge/css-%23663399.svg?style=for-the-badge&logo=css&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![MariaDB](https://img.shields.io/badge/MariaDB_8.2.13-003545?style=for-the-badge&logo=mariadb&logoColor=white)

![Debian](https://img.shields.io/badge/Debian-A81D33?style=for-the-badge&logo=debian&logoColor=white)
![Windows](https://img.shields.io/badge/Windows_11-0078D6?style=for-the-badge&logo=windows&logoColor=white)

<br />

<a href="http://noblewars.ice41.pt"> ![WEB](https://img.shields.io/badge/Open-Alpha-brightgreen?style=for-the-badge) </a>

</div>

<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/ice41/NobleWars">
    <img src="https://i.imgur.com/igZUzFt.png" alt="Nped" width="250" height="250">
  </a>
  <br>
<img src="https://img.shields.io/github/downloads/ice41/NobleWars/total" alt=""/>
<img src="https://img.shields.io/github/languages/count/ice41/NobleWars" alt=""/>
<img src="https://img.shields.io/github/languages/top/ice41/NobleWars?color=yellow" alt=""/>
<img src="https://img.shields.io/bitbucket/issues/ice41/NobleWars" alt=""/>
<img src="https://img.shields.io/github/forks/ice41/NobleWars?style=social" alt=""/>
<img src="https://img.shields.io/github/stars/ice41/NobleWars?style=social" alt=""/>
<h3 align="center">Noblewars</h3>

  <p align="center">
    <a href="https://github.com/ice41/NobleWars/blob/main/README-EN.md">Readme in English</a>
    <br />
    <br />
    <a href="https://github.com/ice41/NobleWars"><strong>Explore the docs »</strong></a>
    <br />
    <br />
    <a href="https://github.com/ice41/Tribalwars">Old Versions Tribalwars</a>
    ·
    <a href="https://github.com/ice41/NobleWars/issues">Report Bug</a>
    ·
    <a href="https://github.com/ice41/NobleWars/issues">Request Feature</a>
  </p>
</div>

<!-- ABOUT THE PROJECT -->
## Sobre o projeto

# Noblewars
- **Aqui pode encontrar mais informações sobre um motor novo inspirado no tradicional Tribalwars**
- **Este motor encontra-se em desenvolvimento activo**.
- **Ice41 é o criador e mentor deste motor**.
- **Este repositório é open-source, mas com os ficheiros principais encriptados. Este é o resultado de um ano de trabalho dedicado. Quem desejar acesso total e completo aos ficheiros para fins comerciais ou de desenvolvimento, pode adquirir a licença correspondente, contribuindo assim para o suporte do desenvolvedor e para futuros projetos semelhantes. Agradecemos a compreensão.**

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- USAGE EXAMPLES -->
## Utilidade / Como Executar

Para colocar o motor a funcionar localmente ou num servidor de alojamento, deves seguir os seguintes requisitos e passos:

### Requisitos do Sistema
- **PHP**: Versão `8.3.0` ou superior (com as extensões `mysqli`, `openssl`, `mbstring` e `zlib` ativas no ficheiro `php.ini`).
- **Base de Dados**: Servidor MySQL / MariaDB (ex: MariaDB `8.2.13` ou superior) em execução.
- **Servidor Web**: Apache (com suporte a ficheiros `.htaccess` e módulo mod_rewrite), Nginx ou o próprio servidor de desenvolvimento embutido do PHP.

### Como Rodar Localmente

#### Opção 1: Usando o servidor embutido do PHP (Recomendado para testes)

1. Certifica-te que tens o PHP instalado no teu sistema e que está acessível via linha de comandos.
2. Navega até à pasta do projeto.
3. Executa o comando:
   ```bash
   php -S localhost:8000 -t public
   ```
4. O servidor estará disponível em `http://localhost:8000`.

#### Opção 2: Usando o ficheiro batch (Windows)

Se estiveres no Windows e tiveres o PHP instalado, podes usar o ficheiro `iniciar php.bat` incluído no projeto:

1. Abre o ficheiro `iniciar php.bat` e verifica se o caminho para a pasta `public` está correto.
2. Faz duplo clique no ficheiro `.bat` para iniciar o servidor.
3. O servidor estará disponível em `http://localhost:8000`.

**Nota:** O ficheiro `.bat` contém um comando semelhante a este:
```batch
php -S localhost:8000 -t "caminho\para\o\projeto\public"
```

#### Opção 3: Usando XAMPP, WampServer, Laragon ou Docker

1. Coloca a pasta do projeto no teu diretório do servidor web (ex: `htdocs` ou `www`).
2. Configura o **Document Root** do teu servidor web para apontar diretamente para a pasta `public/`.
3. Inicia o Apache e o MySQL/MariaDB através do painel de controlo do teu servidor.

### Configuração da Base de Dados

**Antes de iniciar o jogo, certifica-te que tens um servidor MySQL/MariaDB em execução!**

1. **Base de Dados Geral**: Cria a base de dados MySQL geral e importa as tabelas correspondentes.
2. **Mundos**: Cria as bases de dados para os mundos ativos (ex: `lan_mundo1`).
3. **Configuração**: Edita as definições do servidor e da base de dados nos ficheiros:
   - `public/configs/config.php` (definições de domínio, cookies e temas).
   - `app/Config/database.php` (credenciais da base de dados MySQL geral e de mundos).
   - `app/Config/mail.php` (configurações do servidor SMTP de email).

### Sobre a Proteção do Código
- Os ficheiros lógicos centrais do motor (PHP e JS/CSS customizados) encontram-se **protegidos contra cópia direta e engenharia reversa**.
- Qualquer tentativa de modificar ou violar os ficheiros protegidos fará com que o sistema acione a autodefesa e interrompa a execução.
- Podes testar, configurar e traduzir livremente o jogo através das pastas desprotegidas (`app/Languages` e `app/configs`).
- Para obter a versão com código-fonte aberto para fins comerciais ou livre acesso de desenvolvimento, deves contactar a equipa e adquirir a respetiva licença.

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- ROADMAP -->
## Roadmap

Um resumo do desenvolvimento do motor.

🛡️ **Fase 8: Proteção Avançada e Melhorias (Alpha 1.7 - 1.8.5)**
- **Proteção do Código:** Implementada uma camada de segurança para os ficheiros principais do motor, garantindo a integridade do sistema.
- **Novo Sistema de Troféus:** Adicionado um sistema de conquistas e troféus que recompensa os jogadores por marcos importantes no jogo.
- **Melhorias no Mapa:** O mapa foi otimizado, corrigindo problemas de carregamento e melhorando a precisão das informações exibidas.
- **Nova Interface de Defesas:** A gestão de defesas nas aldeias foi redesenhada para ser mais intuitiva e rápida.
- **Correções e Ajustes:** Resolvidos vários bugs no sistema de mensagens, no fórum e nas notificações em tempo real. A lógica de batalha foi refinada para maior precisão.

🌟 **Fase 7: Atualizações Recentes (Alpha 1.6)**<br>
Melhorias no Mapa: Correções críticas e otimizações para a vista do mapa.<br>
Expansão de Idiomas: Adicionadas várias novas traduções em toda a interface.<br>
Correções no Sistema: Resolvidos problemas nos sistemas de mensagens, fórum da tribo e várias páginas da interface.<br>

⚔️ **Fase 6: Mecânicas Principais (Alpha 1.5)**<br>
Sistema de Bandeiras: Implementação total e restauração da mecânica de bandeiras.<br>
Partilha de Comandos: Adicionado suporte para os jogadores partilharem informações de comandos.<br>
Atualizações Automáticas: Os recursos agora são atualizados dinamicamente sem necessidade de recarregar a página.<br>
Controlo: Novas opções para bandeiras, paladinos e inventário numa base por mundo.<br>

🛡️ **Fase 5: Fiabilidade e Segurança (Alpha 1.4)**<br>
Sistema Wiki: Integrado um sistema interno de ajuda/wiki.<br>
Lógica Melhorada: Cálculos de pontos de construção aprimorados e exibição de velocidade das unidades.<br>
Segurança: Reforçado o painel de administração contra potenciais vulnerabilidades.<br>

⛪ **Fase 4: Expansão da Jogabilidade (Alpha 1.2)**<br>
Mecânica de Paladinos: Introduzido o sistema de itens para paladinos.<br>
Igreja e Monges: Revisão completa e implementação do sistema da Igreja.<br>
Equilíbrio Económico: Ajustes à lógica do mercado e novos tipos de bandeiras para mundos.<br>

🏗️ **Fase 3: Transição do Motor (Alpha 1.0)**<br>
Base 8.3 Polaca: Estabelecida a estrutura principal com base no motor polaco 8.3 refinado.<br>
Design Tribawars: Realinhado o design estrutural e visual para autenticidade.<br>
Lógica Fundamental: Implementada a lógica primária das páginas e o fluxo do jogo.<br>

💼 **Fase 2: Desenvolvimento de Funcionalidades (Alpha 0.4 - 0.8)**<br>
Ferramentas Utilitárias: Construídos o Assistente de Saques, Gestor de Contas e integrações Premium.<br>
Sistemas Principais: Implementados sistemas de classificação, relatórios e lógica básica de combate.<br>
Social: Desenvolvidos os sistemas de mensagens e relatórios comunitários.<br>

🌱 **Fase 1: Início (Alpha 0.0 - 0.3)**<br>
Modernização: Removidos componentes legados como Smarty e manipuladores antigos de tarefas agendadas.<br>
Lógica Inicial: Lógica básica de tropas, edifícios e evolução do mundo estabelecida.<br>
Planeamento: Definição do âmbito original do projeto e mapeamento de funcionalidades.<br>


<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- CONTRIBUTING -->
## Sobre
- Todo o motor foi escrito apenas em PHP sem crons e sem Smarty para um melhor desenvolvimento.
- Todas as funcionalidades e funções foram rescritas do 0 para melhor implentação.
- Se gostas do meu trabalho ajuda a nossa comunidade NPED a crescer.  [Discord](https://discord.gg/CxTTt5F6Gj).

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<details align="center">
  <summary><b>Github Stats 📈</b></summary>
  
![Anurag's GitHub stats](https://github-readme-stats.vercel.app/api?username=ice41&show_icons=true&theme=dark)


<a href="https://git.io/streak-stats"><img src="https://streak-stats.demolab.com?user=ice41&theme=dark&hide_border=true&locale=pt_BR&date_format=j%20M%5B%20Y%5D" alt="GitHub Streak" /></a>

</details>
<p align="center">
  <a href="https://discord.com/users/261642084463804416/"><img src="https://discord.c99.nl/widget/theme-1/261642084463804416.png" /></a><br>
</p>




<h3 align="center"> Contactos NPED </h3>
<div id="nped" align="center">
  <a href="https://discord.gg/CxTTt5F6Gj"><img src="https://discord.com/api/guilds/1074111566217220176/widget.png?style=banner4"></a>
<br>
</div>

  <div align="center">
    <table border="-10" style="border-collapse: collapse; border: none;">
      <tr>
        <td><a href="https://www.facebook.com/nped.pt.official/"><img src="https://i.imgur.com/jrIFEX1.png" height="30" width="30" alt="facebook NPED" title="Facebook NPED"></a></td>
        <td><a href="https://www.instagram.com/nped.pt/"><img src="https://i.imgur.com/aNF8H7x.png" height="30" width="30" alt="Instagram NPED" title="Instagram NPED"></a></td>
        <td><a href="#"><img src="https://i.imgur.com/MPYqzXV.png" height="30" width="30" alt="X NPED" title="X NPED"></a></td>
        <td><a href="https://discord.gg/CxTTt5F6Gj"><img src="https://i.imgur.com/tn4xcXv.png" height="30" width="30" alt="Discord Nped" title="Discord Nped"></a></td>
        <td><a href="https://github.com/npedpt"><img src="https://i.imgur.com/tc6JSoR.png" height="30" width="30" alt="Github Nped" title="Github Nped"></a></td>
        <td><a href="https://whatsapp.com/channel/0029VaKsOhhKLaHjpiVDHY3q"><img src="https://i.imgur.com/Qx9VA8Y.png" height="30" width="30" alt="Whatsapp Group NPED" title="Whatsapp Group NPED"></a></td>
        <td><a href="#"><img src="https://i.imgur.com/l8vUn0y.png" height="30" width="30" alt="Youtube" title="Youtube NPED"></a></td>
        <td><a href="https://nped.pt"><img src="https://i.imgur.com/7AbqJU4.png" height="30" width="30" alt="WebPage NPED" title="WebPage NPED"></a></td>
        <td><a href="https://steamcommunity.com/groups/Nped"><img src="https://i.imgur.com/ztzOF0u.png" height="30" width="30" alt="Steam Group NPED" title="Steam Group NPED"></a></td>
      </tr>
    </table>
  </div>

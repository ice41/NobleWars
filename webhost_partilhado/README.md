<!-- ABOUT THE PROJECT -->
## Organização das pastas
Para rodar em web host partilhado é preciso algumas alterações.<br />
Qual a pasta raiz do teu host?<br />
www /  public_html<br />

Vamos ter em conta que a tua pasta é  public_html<br />
EX:<br />
&nbsp;📁public_html<br />
&nbsp;&nbsp;└📁new_engine<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└📁App<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└📁public<br />
&nbsp;📄.htaccess<br />
&nbsp;📄index.php<br />
<br /><br />
O 📄index.php e o 📄.htaccess vai te direcionar para a pasta public<br />
<br /><br />
E se tiver um site na minha raiz?<br />
Para isso basta alterar o 📄index.php e o 📄.htaccess para o diretório pretendido<br />
Ex:<br />
&nbsp;📁public_html<br />
&nbsp;&nbsp;&nbsp;└📁game<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└📁new_engine<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└📁App<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└📁public<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;📄.htaccess<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;📄index.php<br />



# Domínio 🌐
- **Tem de alterar o DNS**
- **O nosso motor faz a gestão do subdominio**

Deve apontar o subdominio *.seudominio.pt para a pasta onde se encontra<br />
Como exemplos a cima está na pasta game deve apontar o dominio para www/game ou public_html/game<br />
<br /><br />
- **O que o motor vai fazer com o *.seudominio.pt ?**
<br /><br />
O motor com base no nome do Mundo vai gerir o subdominio<br />
ex:
O seu mundo tem o nome em app/config/world/mundo1.php<br />
<br />
o motor vai vai aplicar isso ao seu dominio quando entra no mundo mundo1.seudominio.pt


<!-- USAGE EXAMPLES -->
### Utilidades



<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- ROADMAP -->

<!-- ABOUT THE PROJECT -->
## Folder Organization
To run on a shared web host, some changes are needed.<br />
What is your host's root folder?<br />
www /  public_html<br />

Let's assume your folder is  public_html<br />
EX:<br />
&nbsp;📁public_html<br />
&nbsp;&nbsp;└📁new_engine<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└📁App<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└📁public<br />
&nbsp;📄.htaccess<br />
&nbsp;📄index.php<br />
<br /><br />
The 📄index.php and 📄.htaccess will redirect you to the public folder<br />
<br /><br />
What if I have a site in my root?<br />
For that, you just need to change the 📄index.php and 📄.htaccess to the desired directory<br />
Ex:<br />
&nbsp;📁public_html<br />
&nbsp;&nbsp;&nbsp;└📁game<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└📁new_engine<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└📁App<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└📁public<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;📄.htaccess<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;📄index.php<br />



# Domain 🌐
- **You must change the DNS**
- **Our engine handles the subdomain management**

You must point the subdomain *.yourdomain.com to the folder where it is located<br />
As in the examples above, if it's in the game folder, you must point the domain to www/game or public_html/game<br />
<br /><br />
- **What will the engine do with *.yourdomain.com ?**
<br /><br />
The engine, based on the World's name, will manage the subdomain<br />
ex:
Your world has the name in app/config/world/world1.php<br />
<br />
the engine will apply this to your domain when you enter the world world1.yourdomain.com


<!-- USAGE EXAMPLES -->
### Utilities



<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- ROADMAP -->
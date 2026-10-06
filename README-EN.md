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
## About the project

# Noblewars
- **Here you can find more information about a new engine inspired by the traditional Tribalwars**
- **This engine is under active development**.
- **Ice41 is the creator and mentor of this engine**.
- **This repository is open-source, but with the main files encrypted. This is the result of a year of dedicated work. Those who wish full and complete access to the files for commercial or development purposes can purchase the corresponding license, thus contributing to the developer's support and to future similar projects. We appreciate your understanding.**
  <br />
  <img src="https://i.imgur.com/Rr6WEbm.jpeg" alt="preview">
  <img src="https://i.imgur.com/n7fz4Qs.png" alt="preview">
<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- USAGE EXAMPLES -->
## Utility / How to Run

To run the engine locally or on a hosting server, you must follow the following requirements and steps:

### System Requirements
- **PHP**: Version `8.3.0` or higher (with the `mysqli`, `openssl`, `mbstring` and `zlib` extensions active in the `php.ini` file).
- **Database**: MySQL / MariaDB server (e.g., MariaDB `8.2.13` or higher) running.
- **Web Server**: Apache (with support for `.htaccess` files and the mod_rewrite module), Nginx or PHP's own built-in development server.

### How to Run Locally

#### Option 1: Using PHP's built-in server (Recommended for testing)

1. Make sure you have PHP installed on your system and that it is accessible via the command line.
2. Navigate to the project folder.
3. Run the command:
   ```bash
   php -S localhost:8000 -t public
   ```
4. The server will be available at `http://localhost:8000`.

#### Option 2: Using the batch file (Windows)

If you are on Windows and have PHP installed, you can use the `iniciar php.bat` file included in the project:

1. Open the `iniciar php.bat` file and check if the path to the `public` folder is correct.
2. Double-click the `.bat` file to start the server.
3. The server will be available at `http://localhost:8000`.

**Note:** The `.bat` file contains a command similar to this:
```batch
php -S localhost:8000 -t "path\to\project\public"
```

#### Option 3: Using XAMPP, WampServer, Laragon or Docker

1. Place the project folder in your web server directory (e.g., `htdocs` or `www`).
2. Configure your web server's **Document Root** to point directly to the `public/` folder.
3. Start Apache and MySQL/MariaDB through your server's control panel.
4. You can see the explanation.  <a href="https://github.com/ice41/NobleWars/blob/main/webhost_partilhado/README.md">aqui</a>

Ex:<br />
&nbsp;📁public_html<br />
&nbsp;&nbsp;&nbsp;└📁game<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└📁new_engine<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└📁App<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└📁public<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;📄.htaccess<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;📄index.php<br />
### Database Setup

**Before starting the game, make sure you have a MySQL/MariaDB server running!**

1. **General Database**: Create the main MySQL database and import the corresponding tables.
2. **Worlds**: Create the databases for active worlds (e.g., `lan_mundo1`).
3. **Configuration**: Edit the server and database settings in the files:
   - `public/configs/config.php` (domain, cookie and theme settings).
   - `app/Config/database.php` (general and world MySQL database credentials).
   - `app/Config/mail.php` (SMTP email server settings).

### About Code Protection
- The core logic files of the engine (PHP and custom JS/CSS) are **protected against direct copying and reverse engineering**.
- Any attempt to modify or violate the protected files will cause the system to trigger self-defense and abort execution.
- You can freely test, configure and translate the game through the unprotected folders (`app/Languages` and `app/configs`).
- To obtain the version with open source code for commercial purposes or free development access, you must contact the team and purchase the corresponding license.

- There are currently 3 types of license:


| Feature | 🆓 Free Pack | 🥇 Gold Pack | 💎 Diamond Pack |
| :--- | :---: | :---: | :---: |
| **Engine Management** | Basic | Full | Full |
| **Account Limit** | 10 Accounts | Unlimited | Unlimited |
| **Worlds** | 1 World | Multiple | Multiple |
| **Premium System** | ❌ | ✅ | ✅ |
| **License Validity** | 30 Days | Does Not Expire | Lifetime |
| **Updates** | ❌ | Sporadic | Priority |
| **Technical Support** | ❌ | Standard | Premium |
| **Multi-Account & Cheat Detector** | ❌ | ❌ | ✅ |
| **DB Backup (1-Click)** | ❌ | ❌ | ✅ |
| **SQL Console & DB Manager** | ❌ | ❌ | ✅ |
| **Bot Automation Panel** | ❌ | ❌ | ✅ |

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- ROADMAP -->
## Roadmap

A summary of the engine's development.

🧰**Phase 10: Improvements and Adjustments (Alpha 1.8.6+)**
 **Future adjustments:**

- **Fine-Tuning:** The engine will continue to be altered and modified for improvement.
- **Mobile compatibility:** Adjustments for mobile compatibility are planned.
- **Automations:** Improvements to the automatic systems are planned.
- **Bots:** Improvements are planned for the bot system, which already does almost everything perfectly.
- **Themes:** Improvements are planned for the engine's theme system, which will allow for better modification and customization.


🛞 **Phase 9: Improvements and Adjustments (Alpha 1.8.5 - 1.8.6)**
- **Fine-Tuning:** Targeted fixes in the engine and its features.
- **Admin Reorganization:** The administration panel has been redesigned and reorganized for better operation.
- **Map Fixes:** Loading failures and visual imperfections displayed on the map have been fixed.
- **Performance:** Unnecessary engine components have been optimized or removed, improving overall performance.
- **Engine Security:** The structure has been reorganized to isolate sensitive information inside the `app` folder, which is not externally accessible.
- **Bot:** The bot's structure has been adjusted so it no longer generates reports and no longer processes many tasks that block the engine.
- **Public Pages:** Adjustments to the public pages in terms of design and functions.

🛡️ **Phase 8: Advanced Protection and Improvements (Alpha 1.7 - 1.8.5)**
- **Code Protection:** A security layer has been implemented for the engine's main files, ensuring the integrity of the system.
- **New Trophy System:** An achievements and trophies system has been added that rewards players for important milestones in the game.
- **Map Improvements:** The map has been optimized, fixing loading issues and improving the accuracy of the information displayed.
- **New Defenses Interface:** Village defense management has been redesigned to be more intuitive and faster.
- **Fixes and Adjustments:** Several bugs have been resolved in the messaging system, the forum, and real-time notifications. The battle logic has been refined for greater accuracy.

🌟 **Phase 7: Recent Updates (Alpha 1.6)**<br>
Map Improvements: Critical fixes and optimizations for the map view.<br>
Language Expansion: Added several new translations throughout the interface.<br>
System Fixes: Fixed issues in messaging systems, tribe forum and various interface pages.<br>

⚔️ **Phase 6: Core Mechanics (Alpha 1.5)**<br>
Flag System: Full implementation and restoration of the flag mechanic.<br>
Command Sharing: Added support for players to share command information.<br>
Auto Updates: Resources are now updated dynamically without page reload.<br>
Controls: New options for flags, paladins and inventory on a per-world basis.<br>

🛡️ **Phase 5: Reliability and Security (Alpha 1.4)**<br>
Wiki System: Integrated internal help/wiki system.<br>
Improved Logic: Enhanced building point calculations and unit speed display.<br>
Security: Strengthened admin panel against potential vulnerabilities.<br>

⛪ **Phase 4: Gameplay Expansion (Alpha 1.2)**<br>
Paladin Mechanics: Introduced the item system for paladins.<br>
Church and Monks: Complete revision and implementation of the Church system.<br>
Economic Balance: Adjustments to market logic and new flag types for worlds.<br>

🏗️ **Phase 3: Engine Transition (Alpha 1.0)**<br>
Polish 8.3 Base: Established the main structure based on the refined Polish 8.3 engine.<br>
Tribalwars Design: Realigned structural and visual design for authenticity.<br>
Core Logic: Implemented primary page logic and game flow.<br>

💼 **Phase 2: Feature Development (Alpha 0.4 - 0.8)**<br>
Utility Tools: Built the Raid Assistant, Account Manager and Premium integrations.<br>
Core Systems: Implemented ranking systems, reports and basic combat logic.<br>
Social: Developed messaging systems and community reports.<br>

🌱 **Phase 1: Beginnings (Alpha 0.0 - 0.3)**<br>
Modernization: Removed legacy components like Smarty and old scheduled task handlers.<br>
Initial Logic: Basic troop, building and world evolution logic established.<br>
Planning: Defined the original project scope and feature mapping.<br>


<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- CONTRIBUTING -->
## About
- The entire engine was written only in PHP without crons and without Smarty for better development.
- All features and functions were rewritten from scratch for better implementation.
- If you like my work, help our NPED community grow. [Discord](https://discord.gg/CxTTt5F6Gj).

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<details align="center">
  <summary><b>Github Stats 📈</b></summary>
  
![Anurag's GitHub stats](https://github-readme-stats.vercel.app/api?username=ice41&show_icons=true&theme=dark)


<a href="https://git.io/streak-stats"><img src="https://streak-stats.demolab.com?user=ice41&theme=dark&hide_border=true&locale=pt_BR&date_format=j%20M%5B%20Y%5D" alt="GitHub Streak" /></a>

</details>
<p align="center">
  <a href="https://discord.com/users/261642084463804416/"><img src="https://discord.c99.nl/widget/theme-1/261642084463804416.png" /></a><br>
</p>




<h3 align="center"> NPED Contacts </h3>
<div id="nped" align="center">
  <a href="https://discord.gg/kUekVrKHp"><img src="https://discord.com/api/guilds/1074111566217220176/widget.png?style=banner4"></a>
<br>
</div>

  <div align="center">
    <table border="-10" style="border-collapse: collapse; border: none;">
      <tr>
         <td><a href="https://www.facebook.com/nped.pt.official/"><img src="https://img.shields.io/badge/Facebook-%231877F2.svg?style=for-the-badge&logo=Facebook&logoColor=white" alt="facebook NPED" title="Facebook NPED"></a></td>
        <td><a href="https://www.instagram.com/nped.pt/"><img src="https://img.shields.io/badge/Instagram-%23E4405F.svg?style=for-the-badge&logo=Instagram&logoColor=white" alt="Instagram NPED" title="Instagram NPED"></a></td>
        <td><a href="#"><img src="https://img.shields.io/badge/X-%23000000.svg?style=for-the-badge&logo=X&logoColor=white" alt="X NPED" title="X NPED"></a></td>
        <td><a href="https://discord.gg/kUekVrKHp"><img src="https://img.shields.io/badge/Discord-%235865F2.svg?style=for-the-badge&logo=discord&logoColor=white" alt="Discord Nped" title="Discord Nped"></a></td>
        <td><a href="https://github.com/npedpt"><img src="https://img.shields.io/badge/github-%23121011.svg?style=for-the-badge&logo=github&logoColor=white" alt="Github Nped" title="Github Nped"></a></td>
        <td><a href="https://whatsapp.com/channel/0029VaKsOhhKLaHjpiVDHY3q"><img src="https://img.shields.io/badge/WhatsApp-25D366?style=for-the-badge&logo=whatsapp&logoColor=white" alt="Whatsapp Group NPED" title="Whatsapp Group NPED"></a></td>
        <td><a href="#"><img src="https://img.shields.io/badge/YouTube-%23FF0000.svg?style=for-the-badge&logo=YouTube&logoColor=white" alt="Youtube" title="Youtube NPED"></a></td>
        <td><a href="https://nped.pt"><img src="https://img.shields.io/badge/web-%23123F6D.svg?style=for-the-badge&logo=ovh&logoColor=#123F6D"  alt="WebPage NPED" title="WebPage NPED"></a></td>
        <td><a href="https://steamcommunity.com/groups/Nped"><img src="https://img.shields.io/badge/steam-%23000000.svg?style=for-the-badge&logo=steam&logoColor=white" alt="Steam Group NPED" title="Steam Group NPED"></a></td>
      </tr>
    </table>
  </div>      </tr>
    </table>
  </div>

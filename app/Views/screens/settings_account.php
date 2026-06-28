<?php
/**
 * Consolidated Profile Settings View
 * Includes: Personal info, Email, Password, Username, Delete account
 */
?>

<!-- <?= __('screens.settings_account.change_language') ?> -->
<h2><?= __('screens.settings_account.language_title') ?></h2>
<p><?= __('screens.settings_account.language_description') ?></p>

<form method="post"
    action="game.php?village=<?= $village['id'] ?>&screen=settings&mode=account&action=change_language&h=<?= $hkey ?>">
    <table class="vis">
        <tbody>
            <tr>
                <td><?= __('screens.settings_account.current_language') ?></td>
                <td><b><?= locale_name(current_locale()) ?></b></td>
            </tr>
            <tr>
                <td><?= __('screens.settings_account.new_language') ?></td>
                <td>
                    <div class="language-selector">
                        <?php
                        $languages = [
                            'pt_PT' => ['name' => 'Português', 'flag' => 'pt.png'],
                            'en_US' => ['name' => 'English', 'flag' => 'gb.png'],
                            'es_ES' => ['name' => 'Español', 'flag' => 'es.png'],
                            'pl_PL' => ['name' => 'Polski', 'flag' => 'pl.png'],
                            'fr_FR' => ['name' => 'Français', 'flag' => 'fr.png'],
                        ];
                        $current = current_locale();
                        ?>

                        <input type="hidden" name="language" id="selected_language" value="<?= $current ?>">

                        <div class="language-dropdown">
                            <button type="button" class="language-current" id="languageButton">
                                <img src="/graphic/new/country/<?= $languages[$current]['flag'] ?>" alt="" class="flag">
                                <span class="name"><?= $languages[$current]['name'] ?></span>
                                <span class="arrow">▼</span>
                            </button>

                            <div class="language-options" id="languageOptions" style="display: none;">
                                <?php foreach ($languages as $code => $lang): ?>
                                    <div class="language-option <?= $code === $current ? 'selected' : '' ?>"
                                        data-lang="<?= $code ?>" data-flag="<?= $lang['flag'] ?>"
                                        onclick="selectLanguage('<?= $code ?>', '<?= $lang['flag'] ?>', '<?= $lang['name'] ?>')">
                                        <img src="/graphic/new/country/<?= $lang['flag'] ?>" alt="" class="flag">
                                        <span class="name"><?= $lang['name'] ?></span>
                                        <?php if ($code === $current): ?>
                                            <span class="checkmark">✓</span>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input class="btn btn-default"
                        value="<?= __('screens.settings_account.change_language_button') ?>" type="submit"></td>
            </tr>
        </tbody>
    </table>
</form>

<br><br>

<!-- <?= __('screens.settings_account.change_theme') ?> -->
<h2><?= __('screens.settings_account.theme_title') ?></h2>
<p><?= __('screens.settings_account.theme_description') ?></p>

<form method="post"
    action="game.php?village=<?= $village['id'] ?>&screen=settings&mode=account&action=change_theme&h=<?= $hkey ?>">
    <table class="vis">
        <tbody>
            <tr>
                <td><?= __('screens.settings_account.current_theme') ?></td>
                <td>
                    <?php
                    $current_theme = !empty($user['theme']) ? $user['theme'] : ($GLOBALS['conf']['ingame_theme'] ?? 'modern');
                    if ($current_theme === 'classic') {
                        $current_theme = 'new';
                    }

                    $themes = [];
                    $css_dir = __DIR__ . '/../../../public/css';
                    if (is_dir($css_dir)) {
                        $files = scandir($css_dir);
                        foreach ($files as $file) {
                            if (preg_match('/^game_([a-zA-Z0-9_\-]+)\.css$/', $file, $matches)) {
                                $code = $matches[1];
                                if ($code === 'new') {
                                    $trans = __('screens.settings_account.theme_classic');
                                    $themes[$code] = ['name' => ($trans === 'screens.settings_account.theme_classic' ? 'Clássico' : $trans)];
                                } elseif ($code === 'modern') {
                                    $trans = __('screens.settings_account.theme_modern');
                                    $themes[$code] = ['name' => ($trans === 'screens.settings_account.theme_modern' ? 'Moderno' : $trans)];
                                } else {
                                    $trans_key = "screens.settings_account.theme_{$code}";
                                    $trans = __($trans_key);
                                    $themes[$code] = ['name' => ($trans === $trans_key ? ucfirst(str_replace('_', ' ', $code)) : $trans)];
                                }
                            }
                        }
                    }

                    if (empty($themes)) {
                        $themes = [
                            'new' => ['name' => __('screens.settings_account.theme_classic', 'Clássico')],
                            'modern' => ['name' => __('screens.settings_account.theme_modern', 'Moderno')]
                        ];
                    }

                    $current_name = $themes[$current_theme]['name'] ?? ucfirst($current_theme);
                    ?>
                    <b><?= $current_name ?></b>
                </td>
            </tr>
            <tr>
                <td><?= __('screens.settings_account.new_theme') ?></td>
                <td>
                    <div class="theme-selector">
                        <input type="hidden" name="theme" id="selected_theme" value="<?= $current_theme ?>">

                        <div class="theme-dropdown">
                            <button type="button" class="theme-current" id="themeButton">
                                <span class="name"><?= $current_name ?></span>
                                <span class="arrow">▼</span>
                            </button>

                            <div class="theme-options" id="themeOptions" style="display: none;">
                                <?php foreach ($themes as $code => $th): ?>
                                    <div class="theme-option <?= $code === $current_theme ? 'selected' : '' ?>"
                                        data-theme="<?= $code ?>"
                                        onclick="selectTheme('<?= $code ?>', '<?= htmlspecialchars($th['name']) ?>')">
                                        <span class="name"><?= $th['name'] ?></span>
                                        <?php if ($code === $current_theme): ?>
                                            <span class="checkmark">✓</span>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input class="btn btn-default"
                        value="<?= __('screens.settings_account.change_theme_button') ?>" type="submit"></td>
            </tr>
        </tbody>
    </table>
</form>

<style>
    .language-selector {
        position: relative;
        width: 100%;
        max-width: 220px;
    }

    .language-dropdown {
        position: relative;
    }

    .language-current {
        width: 100%;
        padding: 6px 10px;
        background: linear-gradient(to bottom, #f8f4e8 0%, #e8dfc8 100%);
        border: 1px solid #7d510f;
        border-radius: 3px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 11px;
        font-family: Verdana, Arial, sans-serif;
        transition: all 0.2s ease;
        color: #5d3a0f;
    }

    .language-current:hover {
        background: linear-gradient(to bottom, #fff8e8 0%, #f0e8d0 100%);
        border-color: #5d3a0f;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .language-current .flag {
        width: 20px;
        height: 14px;
        object-fit: cover;
        border-radius: 2px;
        display: block;
    }

    .language-current .name {
        flex: 1;
        text-align: left;
        font-weight: normal;
        color: inherit;
    }

    .language-current .arrow {
        font-size: 8px;
        color: inherit;
        opacity: 0.8;
        transition: transform 0.2s ease;
    }

    .language-current.active .arrow {
        transform: rotate(180deg);
    }

    .language-options {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        margin-top: 2px;
        background: #f8f4e8;
        border: 1px solid #7d510f;
        border-radius: 3px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        overflow: hidden;
    }

    .language-option {
        padding: 6px 10px;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: background 0.15s ease;
        border-bottom: 1px solid #d4c4a8;
        font-size: 11px;
    }

    .language-option:last-child {
        border-bottom: none;
    }

    .language-option:hover {
        background: #fff8e8;
    }

    .language-option.selected {
        background: #e8dfc8;
    }

    .language-option .flag {
        width: 20px;
        height: 14px;
        object-fit: cover;
        border-radius: 2px;
        display: block;
    }

    .language-option .name {
        flex: 1;
        font-weight: normal;
        color: #5d3a0f;
    }

    .language-option .checkmark {
        color: #4a7c2f;
        font-weight: bold;
        font-size: 12px;
    }

    /* Theme selector styles */
    .theme-selector {
        position: relative;
        width: 100%;
        max-width: 220px;
    }

    .theme-dropdown {
        position: relative;
    }

    .theme-current {
        width: 100%;
        padding: 6px 10px;
        background: linear-gradient(to bottom, #f8f4e8 0%, #e8dfc8 100%);
        border: 1px solid #7d510f;
        border-radius: 3px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 11px;
        font-family: Verdana, Arial, sans-serif;
        transition: all 0.2s ease;
        color: #5d3a0f;
    }

    .theme-current:hover {
        background: linear-gradient(to bottom, #fff8e8 0%, #f0e8d0 100%);
        border-color: #5d3a0f;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .theme-current .name {
        flex: 1;
        text-align: left;
        font-weight: normal;
        color: inherit;
    }

    .theme-current .arrow {
        font-size: 8px;
        color: inherit;
        opacity: 0.8;
        transition: transform 0.2s ease;
    }

    .theme-current.active .arrow {
        transform: rotate(180deg);
    }

    .theme-options {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        margin-top: 2px;
        background: #f8f4e8;
        border: 1px solid #7d510f;
        border-radius: 3px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        overflow: hidden;
    }

    .theme-option {
        padding: 6px 10px;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: background 0.15s ease;
        border-bottom: 1px solid #d4c4a8;
        font-size: 11px;
    }

    .theme-option:last-child {
        border-bottom: none;
    }

    .theme-option:hover {
        background: #fff8e8;
    }

    .theme-option.selected {
        background: #e8dfc8;
    }

    .theme-option .name {
        flex: 1;
        font-weight: normal;
        color: #5d3a0f;
    }

    .theme-option .checkmark {
        color: #4a7c2f;
        font-weight: bold;
        font-size: 12px;
    }
</style>

<script>
    const languageButton = document.getElementById('languageButton');
    const languageOptions = document.getElementById('languageOptions');
    const selectedLanguageInput = document.getElementById('selected_language');

    languageButton.addEventListener('click', function (e) {
        e.preventDefault();
        const isOpen = languageOptions.style.display === 'block';
        languageOptions.style.display = isOpen ? 'none' : 'block';
        languageButton.classList.toggle('active', !isOpen);
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.language-selector')) {
            languageOptions.style.display = 'none';
            languageButton.classList.remove('active');
        }
    });

    function selectLanguage(code, flagFile, name) {
        selectedLanguageInput.value = code;

        // Update button display
        languageButton.querySelector('.flag').src = '/graphic/new/country/' + flagFile;
        languageButton.querySelector('.name').textContent = name;

        // Update selected state in options
        document.querySelectorAll('.language-option').forEach(opt => {
            opt.classList.remove('selected');
            const checkmark = opt.querySelector('.checkmark');
            if (checkmark) checkmark.remove();
        });

        const selectedOption = document.querySelector(`[data-lang="${code}"]`);
        selectedOption.classList.add('selected');
        const checkmark = document.createElement('span');
        checkmark.className = 'checkmark';
        checkmark.textContent = '✓';
        selectedOption.appendChild(checkmark);

        // Close dropdown
        languageOptions.style.display = 'none';
        languageButton.classList.remove('active');
    }

    // Theme selector JS
    const themeButton = document.getElementById('themeButton');
    const themeOptions = document.getElementById('themeOptions');
    const selectedThemeInput = document.getElementById('selected_theme');

    if (themeButton && themeOptions) {
        themeButton.addEventListener('click', function (e) {
            e.preventDefault();
            const isOpen = themeOptions.style.display === 'block';
            themeOptions.style.display = isOpen ? 'none' : 'block';
            themeButton.classList.toggle('active', !isOpen);
        });
    }

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.theme-selector')) {
            if (themeOptions) themeOptions.style.display = 'none';
            if (themeButton) themeButton.classList.remove('active');
        }
    });

    function selectTheme(code, name) {
        if (selectedThemeInput) selectedThemeInput.value = code;

        // Update button display
        if (themeButton) {
            themeButton.querySelector('.name').textContent = name;
        }

        // Update selected state in options
        document.querySelectorAll('.theme-option').forEach(opt => {
            opt.classList.remove('selected');
            const checkmark = opt.querySelector('.checkmark');
            if (checkmark) checkmark.remove();
        });

        const selectedOption = document.querySelector(`[data-theme="${code}"]`);
        if (selectedOption) {
            selectedOption.classList.add('selected');
            const checkmark = document.createElement('span');
            checkmark.className = 'checkmark';
            checkmark.textContent = '✓';
            selectedOption.appendChild(checkmark);
        }

        // Close dropdown
        if (themeOptions) themeOptions.style.display = 'none';
        if (themeButton) themeButton.classList.remove('active');
    }
</script>

<br><br>

<!-- <?= __('screens.settings_account.change_email') ?> -->
<h2><?= __('screens.settings_account.change_email') ?></h2>
<p><?= __('screens.settings_account.email_description') ?></p>
<p><?= __('screens.settings_account.email_warning') ?></p>

<form method="post" action="game.php?village=<?= $village['id'] ?>&screen=settings&action=change_email&h=<?= $hkey ?>">
    <table class="vis">
        <tbody>
            <tr>
                <td><?= __('screens.settings_account.current_email') ?></td>
                <td>
                    <span id="obfuscated_email"><b><?= htmlspecialchars(substr($user['email'], 0, 2) . '***' . substr($user['email'], strpos($user['email'], '@'))) ?></b></span>
                    <span id="full_email" style="display: none;"><b><?= htmlspecialchars($user['email']) ?></b></span>
                    <a href="#" id="show_email_link" onclick="document.getElementById('obfuscated_email').style.display='none'; document.getElementById('full_email').style.display='inline'; this.style.display='none'; return false;">(<?= __('screens.settings_account.show_full_email') ?>)</a>
                </td>
            </tr>
            <tr>
                <td><?= __('screens.settings_account.new_email') ?></td>
                <td><input name="new_email" type="text" size="30"></td>
            </tr>
            <tr>
                <td><?= __('screens.settings_account.password') ?></td>
                <td><input name="password" type="password" size="30"></td>
            </tr>
            <tr>
                <td colspan="2"><input class="btn btn-default" value="<?= __('screens.settings_account.confirm') ?>"
                        type="submit"></td>
            </tr>
        </tbody>
    </table>
</form>

<br><br>

<!-- <?= __('screens.settings_account.change_password') ?> -->
<h2><?= __('screens.settings_account.change_password') ?></h2>
<p><?= __('screens.settings_account.password_description') ?> <b><?= __('screens.settings_account.review_linked_accounts') ?></b>
</p>

<form method="post"
    action="game.php?village=<?= $village['id'] ?>&screen=settings&action=change_password&h=<?= $hkey ?>">
    <table class="vis">
        <tbody>
            <tr>
                <td><?= __('screens.settings_account.old_password') ?></td>
                <td><input name="old_password" type="password" size="30"></td>
            </tr>
            <tr>
                <td colspan="2"><a href="#"
                        onclick="document.getElementById('new_password_section').style.display='block'; return false;"><?= __('screens.settings_account.request_new_password') ?></a></td>
            </tr>
        </tbody>
    </table>

    <div id="new_password_section" style="display:none;">
        <table class="vis">
            <tbody>
                <tr>
                    <td colspan="2" style="background: none;"><br></td>
                </tr>
                <tr>
                    <td><?= __('screens.settings_account.new_password') ?></td>
                    <td><input name="new_password" type="password" size="30"></td>
                </tr>
                <tr>
                    <td><?= __('screens.settings_account.repeat_password') ?></td>
                    <td><input name="new_password_confirm" type="password" size="30"></td>
                </tr>
                <tr>
                    <td colspan="2"><input class="btn btn-default" value="<?= __('screens.settings_account.confirm') ?>" type="submit"></td>
                </tr>
            </tbody>
        </table>
    </div>
</form>

<br><br>

<!-- <?= __('screens.settings_account.change_username') ?> -->
<h2><?= __('screens.settings_account.change_username') ?></h2>
<p><?= __('screens.settings_account.username_description') ?></p>
<p><?= __('screens.settings_account.username_warning') ?></p>

<?php
$isViking = ($ingame_theme ?? $GLOBALS['conf']['ingame_theme'] ?? 'classic') === 'viking';
$infoBoxStyle = $isViking 
    ? 'background: rgba(20, 30, 45, 0.75); border: 1px solid #4a90e2; color: #e0f0ff; backdrop-filter: blur(5px);'
    : 'background: #fffacd; border: 1px solid #c1a264; color: #5d3a0f;';
?>
<div class="info_box" style="<?= $infoBoxStyle ?> padding: 10px; margin: 10px 0;">
    <img src="/graphic/icons/info.png" alt="" style="vertical-align: middle;">
    <?= __('screens.settings_account.username_cooldown') ?>
</div>

<p><?= __('screens.settings_account.username_cost') ?></p>

<form method="post"
    action="game.php?village=<?= $village['id'] ?>&screen=settings&action=change_username&h=<?= $hkey ?>">
    <table class="vis">
        <tbody>
            <tr>
                <td><?= __('screens.settings_account.password') ?></td>
                <td><input name="password" type="password" size="30"></td>
            </tr>
            <tr>
                <td><?= __('screens.settings_account.desired_username') ?></td>
                <td><input name="new_username" type="text" size="30" maxlength="20"></td>
            </tr>
            <tr>
                <td colspan="2"><input class="btn btn-default" value="<?= __('screens.settings_account.change_username_button') ?>" type="submit"></td>
            </tr>
        </tbody>
    </table>
</form>

<br><br>

<!-- <?= __('screens.settings_account.delete_account') ?> -->
<h2><?= __('screens.settings_account.delete_account') ?></h2>
<p><?= __('screens.settings_account.delete_description') ?></p>
<p><?= __('screens.settings_account.delete_warning') ?></p>

<form method="post" action="game.php?village=<?= $village['id'] ?>&screen=settings&action=delete_account&h=<?= $hkey ?>"
    onsubmit="return confirm('<?= __('screens.settings_account.delete_confirm') ?>');">
    <table class="vis">
        <tbody>
            <tr>
                <td><?= __('screens.settings_account.password') ?></td>
                <td><input name="password" type="password" size="30"></td>
            </tr>
            <tr>
                <td colspan="2"><input class="btn btn-default" value="<?= __('screens.settings_account.delete_account_button') ?>" type="submit"
                        style="background-color: #cc0000; color: white;"></td>
            </tr>
        </tbody>
    </table>
</form>
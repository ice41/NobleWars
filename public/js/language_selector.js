/**** language_selector.js ****/
/**
 * Language Selector Component
 * Allows users to switch between available languages
 */

if (typeof LanguageSelector === 'undefined') {
class LanguageSelector {
    constructor(containerId, currentLocale, availableLocales) {
        this.container = document.getElementById(containerId);
        this.currentLocale = currentLocale;
        this.availableLocales = availableLocales;
        this.isOpen = false;

        this.localeNames = {
            'pt_PT': 'Português',
            'en_US': 'English',
            'es_ES': 'Español',
            'pl_PL': 'Polski',
            'fr_FR': 'Français'
        };

        this.init();
    }

    init() {
        if (!this.container) {
            console.error('Language selector container not found');
            return;
        }

        this.render();
        this.attachEvents();
    }

    render() {
        const currentName = this.localeNames[this.currentLocale] || this.currentLocale;

        let html = `
            <div class="language-selector">
                <button class="language-selector-button" id="lang-selector-btn">
                    <span class="flag flag-${this.currentLocale}"></span>
                    <span class="lang-name">${currentName}</span>
                    <span class="arrow">▼</span>
                </button>
                <div class="language-dropdown" id="lang-dropdown">
        `;

        // Add language options - handle both array and object
        const locales = Array.isArray(this.availableLocales)
            ? this.availableLocales
            : Object.keys(this.availableLocales);

        for (const locale of locales) {
            const name = this.localeNames[locale] || locale;
            const isSelected = locale === this.currentLocale;

            html += `
                <div class="language-option ${isSelected ? 'selected' : ''}" data-locale="${locale}">
                    <span class="flag flag-${locale}"></span>
                    <span class="lang-name">${name}</span>
                </div>
            `;
        }

        html += `
                </div>
            </div>
        `;

        this.container.innerHTML = html;
    }

    attachEvents() {
        const button = document.getElementById('lang-selector-btn');
        const dropdown = document.getElementById('lang-dropdown');

        if (!button || !dropdown) return;

        // Toggle dropdown
        button.addEventListener('click', (e) => {
            e.stopPropagation();
            this.toggleDropdown();
        });

        // Select language
        const options = dropdown.querySelectorAll('.language-option');
        options.forEach(option => {
            option.addEventListener('click', (e) => {
                const locale = option.dataset.locale;
                this.changeLanguage(locale);
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!this.container.contains(e.target)) {
                this.closeDropdown();
            }
        });

        // Close on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeDropdown();
            }
        });
    }

    toggleDropdown() {
        const dropdown = document.getElementById('lang-dropdown');
        if (!dropdown) return;

        this.isOpen = !this.isOpen;
        dropdown.classList.toggle('active', this.isOpen);
    }

    closeDropdown() {
        const dropdown = document.getElementById('lang-dropdown');
        if (!dropdown) return;

        this.isOpen = false;
        dropdown.classList.remove('active');
    }

    changeLanguage(locale) {
        if (locale === this.currentLocale) {
            this.closeDropdown();
            return;
        }

        console.log('Changing language to:', locale);

        // Set cookie for persistence
        document.cookie = `locale=${locale}; path=/; max-age=31536000`; // 1 year

        console.log('Cookie set, reloading page...');

        // Reload page to apply new language
        window.location.reload();
    }
}
window.LanguageSelector = LanguageSelector;
}

// Auto-initialize if container exists
function initLanguageSelector() {
    const container = document.getElementById('language-selector-container');
    if (container) {
        const currentLocale = container.dataset.currentLocale || 'pt_PT';
        let availableLocales = [];

        try {
            const parsed = JSON.parse(container.dataset.availableLocales || '[]');
            availableLocales = Array.isArray(parsed) ? parsed : Object.keys(parsed);
        } catch (e) {
            availableLocales = ['pt_PT', 'en_US', 'es_ES', 'pl_PL', 'fr_FR'];
        }

        new LanguageSelector('language-selector-container', currentLocale, availableLocales);
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLanguageSelector);
} else {
    initLanguageSelector();
}



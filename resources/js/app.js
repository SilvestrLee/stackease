import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const root = document.documentElement;
    const body = document.body;

    const header = document.getElementById('seHeader');
    const themeToggle = document.getElementById('seThemeToggle');
    const menuToggle = document.getElementById('seMenuToggle');
    const mobileMenu = document.getElementById('seMobileMenu');

    const storageKey = 'stackease-theme';

    const applyTheme = (theme) => {
        root.classList.remove('theme-light', 'theme-dark');
        body.classList.remove('theme-light', 'theme-dark');

        root.classList.add(theme);
        body.classList.add(theme);

        localStorage.setItem(storageKey, theme);
    };

    const savedTheme = localStorage.getItem(storageKey);

    if (savedTheme === 'theme-dark' || savedTheme === 'dark') {
        applyTheme('theme-dark');
    } else {
        applyTheme('theme-light');
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            const isDark = root.classList.contains('theme-dark');

            applyTheme(isDark ? 'theme-light' : 'theme-dark');
        });
    }

    const updateHeader = () => {
        if (!header) return;

        if (window.scrollY > 20) {
            header.classList.add('se-header--scrolled');
        } else {
            header.classList.remove('se-header--scrolled');
        }
    };

    updateHeader();
    window.addEventListener('scroll', updateHeader);

    if (menuToggle && mobileMenu && header) {
        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('is-open');
            header.classList.toggle('is-open');

            const isOpen = mobileMenu.classList.contains('is-open');

            menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            mobileMenu.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
        });

        mobileMenu.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('is-open');
                header.classList.remove('is-open');

                menuToggle.setAttribute('aria-expanded', 'false');
                mobileMenu.setAttribute('aria-hidden', 'true');
            });
        });
    }
});
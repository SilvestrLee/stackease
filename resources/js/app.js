

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const root = document.documentElement;
    const header = document.getElementById('seHeader');
    const themeToggle = document.getElementById('seThemeToggle');
    const themeIcon = document.getElementById('seThemeIcon');
    const menuToggle = document.getElementById('seMenuToggle');
    const mobileMenu = document.getElementById('seMobileMenu');

    const savedTheme = localStorage.getItem('stackease-theme');

    if (savedTheme === 'dark') {
        root.classList.add('theme-dark');
    }

    const updateThemeIcon = () => {
        const isDark = root.classList.contains('theme-dark');

        if (themeIcon) {
            themeIcon.textContent = isDark ? '☀️' : '🌙';
        }
    };

    updateThemeIcon();

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            root.classList.toggle('theme-dark');

            const isDark = root.classList.contains('theme-dark');
            localStorage.setItem('stackease-theme', isDark ? 'dark' : 'light');

            updateThemeIcon();
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
        });
    }
});

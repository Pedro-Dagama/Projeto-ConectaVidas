const htmlElement = document.documentElement;
const themeButtons = document.querySelectorAll('.theme-toggle'); // todos os botões
const STORAGE_KEY = 'theme';
const LIGHT_THEME = 'light';
const DARK_THEME = 'dark';
const MOON_ICON = 'bi-moon-fill';
const SUN_ICON = 'bi-sun-fill';


function setTheme(theme) {
    if (!htmlElement) return;

    htmlElement.setAttribute('data-bs-theme', theme);
    localStorage.setItem(STORAGE_KEY, theme);

    themeButtons.forEach(button => {
        const iconElement = button.querySelector('i');
        if (!iconElement) return;
        if (theme === DARK_THEME) {
            iconElement.classList.remove(MOON_ICON);
            iconElement.classList.add(SUN_ICON);
        } else {
            iconElement.classList.remove(SUN_ICON);
            iconElement.classList.add(MOON_ICON);
        }
    });
}

/**
 * Retorna o tema preferido
 */
function getPreferredTheme() {
    const storedTheme = localStorage.getItem(STORAGE_KEY);
    if (storedTheme) return storedTheme;
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? DARK_THEME : LIGHT_THEME;
}

document.addEventListener('DOMContentLoaded', () => {
    setTheme(getPreferredTheme());
});

themeButtons.forEach(button => {
    button.addEventListener('click', () => {
        const currentTheme = htmlElement.getAttribute('data-bs-theme');
        const newTheme = currentTheme === LIGHT_THEME ? DARK_THEME : LIGHT_THEME;
        setTheme(newTheme);
    });
});

// Constantes para tema e ícones
const STORAGE_KEY = 'theme';
const LIGHT_THEME = 'light';
const DARK_THEME = 'dark';
const MOON_ICON = 'bi-moon-fill'; // Ícone para tema CLARO (Sugere mudar para ESCURO)
const SUN_ICON = 'bi-sun-fill';  // Ícone para tema ESCURO (Sugere mudar para CLARO)

let htmlElement;
let themeButtons;

/**
 * Aplica o tema especificado, salva em localStorage, atualiza ícones e redesenha gráficos.
 * @param {string} theme - 'light' ou 'dark'
 */
function setTheme(theme) {
    if (!htmlElement) return;

    // 1. Aplica o tema ao HTML e salva no localStorage
    htmlElement.setAttribute('data-bs-theme', theme);
    localStorage.setItem(STORAGE_KEY, theme);

    // 2. Atualiza o ícone de todos os botões de tema
    themeButtons.forEach(button => {
        const iconElement = button.querySelector('i');
        if (!iconElement) return;
        
        // Determina qual ícone remover e qual adicionar
        const removeIcon = theme === DARK_THEME ? MOON_ICON : SUN_ICON;
        const addIcon = theme === DARK_THEME ? SUN_ICON : MOON_ICON;
        
        iconElement.classList.remove(removeIcon);
        iconElement.classList.add(addIcon);
    });
    
    // 3. Redesenha os gráficos DEPOIS que o tema foi aplicado
    // Isso é crucial para que o Chart.js leia as novas cores CSS do tema
    if (window.desenharGraficos) {
        window.desenharGraficos();
    }
}

/**
 * Retorna o tema preferido (armazenado em localStorage ou preferência do sistema).
 * @returns {string} 'light' ou 'dark'
 */
function getPreferredTheme() {
    const storedTheme = localStorage.getItem(STORAGE_KEY);
    if (storedTheme) return storedTheme;
    // Padrão: usa a preferência do sistema
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? DARK_THEME : LIGHT_THEME;
}

// Configuração inicial e Listeners
document.addEventListener('DOMContentLoaded', () => {
    htmlElement = document.documentElement;
    // Seleciona todos os botões com a classe .theme-toggle (suporte a múltiplos botões)
    themeButtons = document.querySelectorAll('.theme-toggle'); 

    // 1. Configura o tema inicial ao carregar a página
    setTheme(getPreferredTheme());

    // 2. Adiciona listeners de click aos botões de tema
    themeButtons.forEach(button => {
        button.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === LIGHT_THEME ? DARK_THEME : LIGHT_THEME;
            
            // Chama setTheme, que cuida de tudo (aplicação, persistência e redesenho)
            setTheme(newTheme);
        });
    });
});

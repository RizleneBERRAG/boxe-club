// ========== Gestion du thème clair / sombre ==========
document.addEventListener('DOMContentLoaded', () => {
    const root = document.documentElement;
    const btn = document.getElementById('themeToggle');
    const icon = btn?.querySelector('.theme-toggle__icon');

    // Vérifie préférence stockée
    const saved = localStorage.getItem('theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const initial = saved || (systemPrefersDark ? 'dark' : 'light');
    root.setAttribute('data-theme', initial);
    updateIcon(initial);

    // Toggle au clic
    btn?.addEventListener('click', () => {
        const current = root.getAttribute('data-theme');
        const next = current === 'dark' ? 'light' : 'dark';
        root.setAttribute('data-theme', next);
        localStorage.setItem('theme', next);
        updateIcon(next);
    });

    function updateIcon(theme) {
        if (!icon) return;
        icon.textContent = theme === 'dark' ? '🌙' : '☀️';
    }
});

    (() => {
    const KEY = "tb_theme";
    const root = document.documentElement;
    const input = document.getElementById("themeToggle");

    // 1) Appliquer le thème préféré au chargement
    const saved = localStorage.getItem(KEY);
    const preferDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
    const initial = saved || (preferDark ? "dark" : "light");
    root.setAttribute("data-theme", initial);

    // synchronise le switch
    if (input) input.checked = (initial === "light");

    // 2) Toggle au clic + persistance
    function applyTheme(mode){
    root.setAttribute("data-theme", mode);
    localStorage.setItem(KEY, mode);
}
    input?.addEventListener("change", (e) => {
    applyTheme(e.currentTarget.checked ? "light" : "dark");
});

    // 3) Écoute les changements système (optionnel)
    try {
    const mq = window.matchMedia("(prefers-color-scheme: dark)");
    mq.addEventListener?.("change", (ev) => {
    if (!localStorage.getItem(KEY)) { // seulement si l’utilisateur n’a pas choisi manuellement
    applyTheme(ev.matches ? "dark" : "light");
    if (input) input.checked = !ev.matches;
}
});
} catch {}
})();

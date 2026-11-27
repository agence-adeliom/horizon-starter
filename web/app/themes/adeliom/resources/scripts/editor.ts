/**
 * Garde les barres d'outils flottantes de TinyMCE (fenêtre de saisie de lien des WYSIWYG ACF) dans l'écran.
 *
 * TinyMCE les positionne en absolu dans <body>. Dans la barre latérale de l'éditeur, trop étroite,
 * la fenêtre de lien déborde à droite : le focus de son champ fait défiler la page, TinyMCE la masque
 * au défilement puis la réaffiche 250 ms plus tard en redonnant le focus, et la boucle recommence.
 *
 * Le MutationObserver réagit avant le setTimeout qui donne le focus au champ : la fenêtre est
 * recalée avant que le navigateur ait besoin de faire défiler la page.
 */
const VIEWPORT_MARGIN = 8;

function clampToolbar(toolbar: HTMLElement): void {
    const rect = toolbar.getBoundingClientRect();

    if (rect.width === 0) {
        return;
    }

    const maxLeft = document.documentElement.clientWidth - rect.width - VIEWPORT_MARGIN;
    const left = Math.max(VIEWPORT_MARGIN, Math.min(rect.left, maxLeft));

    if (Math.abs(left - rect.left) > 1) {
        toolbar.style.left = `${left + window.scrollX}px`;
    }
}

new MutationObserver((mutations) => {
    for (const mutation of mutations) {
        const target = mutation.target;

        if (target instanceof HTMLElement && target.classList.contains('mce-inline-toolbar-grp')) {
            clampToolbar(target);
        }
    }
}).observe(document.documentElement, { attributes: true, attributeFilter: ['style'], subtree: true });

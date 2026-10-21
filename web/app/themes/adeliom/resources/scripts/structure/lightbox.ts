import GLightbox from 'glightbox';
import 'glightbox/dist/css/glightbox.css';

// Libellés du lecteur vidéo (Plyr), en anglais par défaut alors que la page est en français
const plyrI18n = {
    restart: 'Recommencer',
    rewind: 'Reculer de {seektime} s',
    play: 'Lire',
    pause: 'Pause',
    fastForward: 'Avancer de {seektime} s',
    seek: 'Rechercher',
    seekLabel: '{currentTime} sur {duration}',
    played: 'Lu',
    buffered: 'Chargé',
    currentTime: 'Temps écoulé',
    duration: 'Durée',
    volume: 'Volume',
    mute: 'Couper le son',
    unmute: 'Activer le son',
    enableCaptions: 'Activer les sous-titres',
    disableCaptions: 'Désactiver les sous-titres',
    download: 'Télécharger',
    enterFullscreen: 'Plein écran',
    exitFullscreen: 'Quitter le plein écran',
    frameTitle: 'Lecteur pour {title}',
    captions: 'Sous-titres',
    settings: 'Réglages',
    pip: 'Image dans l’image',
    menuBack: 'Revenir au menu précédent',
    speed: 'Vitesse',
    normal: 'Normale',
    quality: 'Qualité',
    loop: 'Boucle',
    start: 'Début',
    end: 'Fin',
    all: 'Tout',
    reset: 'Réinitialiser',
    disabled: 'Désactivés',
    enabled: 'Activés',
};

// La popin est un dialog : on lui donne un nom et on traduit ses boutons à chaque ouverture
const labelLightbox = (lightbox: ReturnType<typeof GLightbox>) => {
    document.getElementById('glightbox-body')?.setAttribute('aria-label', 'Visionneuse');

    const labels: Record<string, string> = { '.gclose': 'Fermer', '.gnext': 'Suivant', '.gprev': 'Précédent' };

    Object.entries(labels).forEach(([selector, label]) => {
        document.querySelectorAll(`#glightbox-body ${selector}`).forEach((button) => button.setAttribute('aria-label', label));
    });

    // Un seul média : précédent / suivant n'ont pas lieu d'être, ni à l'écran ni pour les lecteurs d'écran
    const single = lightbox.elements.length < 2;
    document.querySelectorAll('#glightbox-body .gnext, #glightbox-body .gprev').forEach((button) => button.toggleAttribute('hidden', single));
};

// GLightbox ne fait tourner le focus qu'entre ses propres boutons (les contrôles du lecteur sont inaccessibles)
// et capte les flèches dans toute la page : sa gestion clavier est remplacée par celle-ci, active seulement popin ouverte
const focusableSelector = 'a[href], button, input, select, textarea, [tabindex]:not([tabindex="-1"])';

const handleLightboxKeys = (lightbox: ReturnType<typeof GLightbox>) => (event: KeyboardEvent) => {
    const container = document.getElementById('glightbox-body');

    if (!container) {
        return;
    }

    if (event.key === 'Escape') {
        event.preventDefault();
        lightbox.close();
        return;
    }

    if (event.key === 'Tab') {
        const focusables = Array.from(container.querySelectorAll<HTMLElement>(focusableSelector)).filter(
            (element) => !element.hasAttribute('disabled') && !element.closest('[hidden], [inert]') && element.getClientRects().length > 0,
        );

        if (!focusables.length) {
            return;
        }

        const first = focusables[0];
        const last = focusables[focusables.length - 1];
        const outside = !container.contains(document.activeElement);

        if (event.shiftKey && (outside || document.activeElement === first)) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && (outside || document.activeElement === last)) {
            event.preventDefault();
            first.focus();
        }

        return;
    }

    // Flèches : changement de média, sauf dans le lecteur où elles servent à avancer, reculer et régler le volume
    if (lightbox.elements.length > 1 && !(event.target as HTMLElement).closest('.plyr')) {
        if (event.key === 'ArrowRight') {
            lightbox.nextSlide();
        } else if (event.key === 'ArrowLeft') {
            lightbox.prevSlide();
        }
    }
};

// Sous-titres d'une vidéo hébergée : GLightbox ne gère pas les pistes, on recharge la source du lecteur avec la piste
const addCaptions = (lightbox: ReturnType<typeof GLightbox>, index: number, attempt = 0) => {
    const trigger = lightbox.elements[index]?.node as HTMLElement | undefined;
    const captions = trigger?.dataset.captions;

    if (!captions) {
        return;
    }

    const player = lightbox.getSlidePlayerInstance(index);

    // Le lecteur est créé après le chargement de Plyr : on attend qu'il existe
    if (!player) {
        if (attempt < 50) {
            setTimeout(() => addCaptions(lightbox, index, attempt + 1), 100);
        }
        return;
    }

    if (player.media?.querySelector('track')) {
        return;
    }

    player.source = {
        type: 'video',
        sources: [{ src: trigger.getAttribute('href'), type: 'video/mp4' }],
        tracks: [{ kind: 'captions', label: trigger.dataset.captionsLabel || 'Français', srclang: trigger.dataset.captionsLang || 'fr', src: captions, default: true }],
    };
};

document.addEventListener('alpine:init', () => {
    window.Alpine.data('initLightbox', () => {
        return {
            init() {
                // Génère un identifiant unique pour chaque instance afin d'avoir des gallery lighbox distinctes
                const galleryId = `gallery-${Math.random().toString(36).substr(2, 9)}`;
                this.$el.setAttribute('data-gallery', galleryId);
                const lightbox = GLightbox({
                    selector: `[data-gallery="${galleryId}"] [data-glightbox]`,
                    keyboardNavigation: false,
                    plyr: {
                        config: {
                            ratio: '16:9',
                            i18n: plyrI18n,
                            captions: { active: true, language: 'fr' },
                        },
                    },
                });
                const onKeydown = handleLightboxKeys(lightbox);
                let trigger: HTMLElement | null = null;

                // Capture : le lecteur Plyr intercepte Échap avant que l'événement remonte
                lightbox.on('open', () => {
                    trigger = document.activeElement as HTMLElement;
                    labelLightbox(lightbox);
                    document.addEventListener('keydown', onKeydown, true);
                    requestAnimationFrame(() => document.querySelector<HTMLElement>('#glightbox-body .gclose')?.focus());
                });

                // Retour du focus sur le lien qui a ouvert la popin
                lightbox.on('close', () => {
                    document.removeEventListener('keydown', onKeydown, true);
                    trigger?.focus();
                });
                lightbox.on('slide_after_load', ({ index }) => addCaptions(lightbox, index));
            },
        };
    });
});

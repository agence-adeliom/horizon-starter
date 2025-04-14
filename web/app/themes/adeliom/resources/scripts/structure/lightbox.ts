import GLightbox from 'glightbox';
import 'glightbox/dist/css/glightbox.css';

document.addEventListener('alpine:init', () => {
    window.Alpine.data('initLightbox', () => {
        return {
            init() {
                // Génère un identifiant unique pour chaque instance afin d'avoir des gallery lighbox distinctes
                const galleryId = `gallery-${Math.random().toString(36).substr(2, 9)}`;
                this.$el.setAttribute('data-gallery', galleryId);
                const lightbox = GLightbox({
                    selector: `[data-gallery="${galleryId}"] [data-glightbox]`,
                });
            },
        };
    });
});

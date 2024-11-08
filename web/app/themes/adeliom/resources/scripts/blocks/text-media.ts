import GLightbox from 'glightbox';
import 'glightbox/dist/css/glightbox.css';

document.addEventListener('alpine:init', () => {
    window.Alpine.data('initMedia', () => {
        return {
            init() {
                console.log('hey');
                // Génère un identifiant unique pour chaque instance afin d'avoir des gallery lighbox distinctes
                const galleryId = `gallery-${Math.random().toString(36).substr(2, 9)}`;
                this.$refs.playMedia.setAttribute('data-gallery', galleryId);
                const lightbox = GLightbox({
                    selector: `[data-gallery="${galleryId}"]`,
                });
                console.log(lightbox);
            },
        };
    });
});

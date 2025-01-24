import focus from '@alpinejs/focus';


document.addEventListener('alpine:init', () => {
    window.Alpine.plugin(focus);
    window.Alpine.data('initModal', () => {
        return {
            open: false,
            openModal() {
                this.open = true;  
            },
            close() {
                this.open = false;
            },
        };
    });
});

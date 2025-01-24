import focus from '@alpinejs/focus';


document.addEventListener('alpine:init', () => {
    window.Alpine.plugin(focus);
    window.Alpine.data('initModal', () => {
        return {
            open: false,
            triggerElement: null, // Element that triggered the modal to open
            openModal() {
                this.triggerElement = document.activeElement;
                this.open = true;  
            },
            close() {
                this.open = false;

                // Focus the trigger element when the modal closes
                this.$nextTick(() => {
                    this.triggerElement && this.triggerElement.focus();
                });
            },
        };
    });
});

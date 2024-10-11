document.addEventListener('alpine:init', () => {
    window.Alpine.data('initPage', () => {
        return {
            scrollDown: false,
            mobileOpen: false,
            closeBanner: false,
        };
    });

    window.Alpine.store('submenu', false);
});

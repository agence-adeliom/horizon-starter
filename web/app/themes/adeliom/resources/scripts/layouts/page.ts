import  initCustomSelect  from '@scripts/components/select';

document.addEventListener('alpine:init', () => {
    window.Alpine.data('initPage', () => {
        return {
            scrollDown: false,
            mobileOpen: false,
            closeBanner: false,
            init() {
                initCustomSelect();
            },
            scrollToAnchor(anchorName) {
                const element = document.getElementById(anchorName);
                element &&
                    element.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start', 
                    });
                
            },
        };
    });

    window.Alpine.store('submenu', false);
});

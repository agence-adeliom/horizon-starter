
document.addEventListener('alpine:init', () => {
    window.Alpine.data('initPage', () => {
        return {
            scrollDown: false,
            mobileOpen: false,
            scrollToAnchor(anchorName) {
                const element = document.getElementById(anchorName);
                element &&
                    element.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start', 
                    });
                
            },
            setCookie(name: string, value: string, days: number) {
                const date = new Date();
                date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
                document.cookie = `${name}=${value}; path=/; expires=${date.toUTCString()}`;
            },
            getCookie(name: string) {
                return document.cookie.split('; ').some((c) => c.trim().startsWith(`${name}=`));
            }
        };
    });

    window.Alpine.store('submenu', false);
});

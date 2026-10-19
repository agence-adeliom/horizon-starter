document.addEventListener('alpine:init', () => {
    window.Alpine.data('initSubMenu', () => {
        return {
            openSubmenus: [] as Number[],
            toggleSubMenu(itemId: number): void {
                // Check if the submenu is already open
                if (this.openSubmenus.includes(itemId)) {
                    this.closeAllSubmenu();
                    return;
                }

                // Switching submenus: close first, then open on the next tick, otherwise x-trap.noscroll
                // releases the page scroll lock after the new submenu has set it
                if (this.openSubmenus.length) {
                    this.closeAllSubmenu();
                    this.$nextTick(() => this.openSubMenu(itemId));
                    return;
                }

                this.openSubMenu(itemId);
            },
            openSubMenu(itemId: number): void {
                this.openSubmenus.push(itemId);
                this.$store.submenu = true;
            },
            closeAllSubmenu() {
                this.openSubmenus = [];
                this.$store.submenu = false;
            },
        };
    });
});

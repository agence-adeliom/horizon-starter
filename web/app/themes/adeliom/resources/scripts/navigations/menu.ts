document.addEventListener('alpine:init', () => {
    window.Alpine.data('initSubMenu', () => {
        return {
            openSubmenus: [] as Number[],
            toggleSubMenu(itemId: number, parentId: number | null = null): void {
                // Check if the submenu is already open
                if (this.openSubmenus.includes(itemId)) {
                    this.closeAllSubmenu();
                    return;
                }

                // Entry of an open submenu: its own submenu is rendered inside the parent one, which stays open
                if (null !== parentId && this.openSubmenus.includes(parentId)) {
                    this.openSubmenus = [...this.openSubmenus.slice(0, this.openSubmenus.indexOf(parentId) + 1), itemId];
                    return;
                }

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
            // "Back" button of a nested submenu: closes the submenus opened above the given one
            backTo(itemId: number): void {
                const index = this.openSubmenus.indexOf(itemId);

                if (-1 === index) {
                    this.toggleSubMenu(itemId);
                    return;
                }

                this.openSubmenus = this.openSubmenus.slice(0, index + 1);
            },
            closeAllSubmenu() {
                this.openSubmenus = [];
                this.$store.submenu = false;
            },
        };
    });
});

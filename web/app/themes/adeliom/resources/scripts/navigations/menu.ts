document.addEventListener('alpine:init', () => {
    window.Alpine.data('initSubMenu', () => {
        return {
            openSubmenus: [] as Number[],
            // Desktop: the submenu is a disclosure (no focus trap). Mobile: a full-screen panel, focus kept inside.
            isDesktop: true,
            init(): void {
                const desktop = window.matchMedia('(min-width: 64rem)');

                this.isDesktop = desktop.matches;
                desktop.addEventListener('change', (event: MediaQueryListEvent) => (this.isDesktop = event.matches));
            },
            toggleSubMenu(itemId: number, parentId: number | null = null): void {
                // Check if the submenu is already open
                if (this.openSubmenus.includes(itemId)) {
                    this.closeSubMenu(itemId);
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

                const closedId = this.openSubmenus[index + 1];

                this.openSubmenus = this.openSubmenus.slice(0, index + 1);

                if (undefined !== closedId) {
                    this.focusOpener(closedId as number);
                }
            },
            // Closes a submenu and the ones opened inside it; with focusOpener, the focus goes back to its button
            closeSubMenu(itemId: number, focusOpener: boolean = false): void {
                const index = this.openSubmenus.indexOf(itemId);

                if (-1 === index) {
                    return;
                }

                this.openSubmenus = this.openSubmenus.slice(0, index);

                if (!this.openSubmenus.length) {
                    this.$store.submenu = false;
                }

                if (focusOpener) {
                    this.focusOpener(itemId);
                }
            },
            // Close button of a submenu: closes everything, the focus goes back to the first-level button
            closeAllAndFocus(): void {
                const rootId = this.openSubmenus[0];

                this.closeAllSubmenu();

                if (undefined !== rootId) {
                    this.focusOpener(rootId as number);
                }
            },
            focusOpener(itemId: number): void {
                this.$nextTick(() => (this.$root.querySelector(`[aria-controls="submenu-${itemId}"]`) as HTMLElement | null)?.focus());
            },
            closeAllSubmenu() {
                this.openSubmenus = [];
                this.$store.submenu = false;
            },
        };
    });
});

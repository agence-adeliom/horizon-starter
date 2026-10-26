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
                    this.scrollToTop(document.getElementById(`submenu-${parentId}`));
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

                const panel = this.$root.closest('.header-mix') as HTMLElement | null;

                this.scrollToTop(panel);

                if (!this.isDesktop && panel) {
                    panel.style.setProperty('--submenu-height', `${window.innerHeight - Math.max(0, panel.getBoundingClientRect().top)}px`);
                }
            },
            scrollToTop(container: Element | null): void {
                if (!this.isDesktop) {
                    container?.scrollTo({ top: 0 });
                }
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

// Header hidden while scrolling down, shown again while scrolling up (same behaviour as Aster).
// Its visible height is published on :root: the anchors bar sits right below it, and html's scroll-padding
// keeps focused elements out from under it.
document.addEventListener('alpine:init', () => {
    window.Alpine.data('initHeader', () => {
        return {
            hidden: false,
            hasFocus: false,
            lastScrollY: 0,
            frame: 0,
            init(): void {
                this.lastScrollY = window.scrollY;
                this.publishHeight();

                window.addEventListener(
                    'scroll',
                    () => {
                        if (!this.frame) {
                            this.frame = requestAnimationFrame(() => {
                                this.frame = 0;
                                this.onScroll();
                            });
                        }
                    },
                    { passive: true },
                );

                new ResizeObserver(() => this.publishHeight()).observe(this.$el);
                this.$watch('hidden', () => this.publishHeight());
                // Opened menu or submenu: the header stays on screen
                this.$watch('mobileOpen', (open: boolean) => open && (this.hidden = false));
                this.$watch('$store.submenu', (open: boolean) => open && (this.hidden = false));
            },
            onScroll(): void {
                const scrollY = Math.max(0, window.scrollY);

                // Small moves (trackpad inertia, rounding) don't toggle the header
                if (Math.abs(scrollY - this.lastScrollY) < 5) {
                    return;
                }

                const pinned = this.mobileOpen || this.$store.submenu || this.hasFocus;

                this.hidden = !pinned && scrollY > this.$el.offsetHeight && scrollY > this.lastScrollY;
                this.lastScrollY = scrollY;
            },
            // A focused link of the hidden header (Shift+Tab from the content) brings it back
            onFocusIn(): void {
                this.hasFocus = true;
                this.hidden = false;
            },
            onFocusOut(event: FocusEvent): void {
                this.hasFocus = this.$el.contains(event.relatedTarget as Node | null);
            },
            // Height of the stuck header: its sticky top is negative in desktop, where the top bar scrolls away
            publishHeight(): void {
                const height = Math.max(0, this.$el.offsetHeight + (parseFloat(getComputedStyle(this.$el).top) || 0));
                const root = document.documentElement.style;

                root.setProperty('--header-height', `${height}px`);
                root.setProperty('--header-offset', this.hidden ? '0px' : `${height}px`);
            },
        };
    });
});

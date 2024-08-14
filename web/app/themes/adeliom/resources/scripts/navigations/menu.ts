document.addEventListener('alpine:init', () => {
  window.Alpine.data('initSubMenu', () => {
    console.log('init sub menu');
    return {
      openSubmenus: [] as Number[],
      toggleSubMenu(itemId: number): void {
        // Check if the submenu is already open
        if (this.openSubmenus.includes(itemId)) {
          this.closeAllSubmenu();
          return;
        }

        // Open the clicked submenu
        this.closeAllSubmenu();
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

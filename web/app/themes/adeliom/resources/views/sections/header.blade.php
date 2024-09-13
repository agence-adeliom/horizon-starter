<header class="header">
    @include('navigations.header.mobile-bar')
    <div class="menu-overlay" :class="$store.submenu && 'is-open'" x-cloak></div>
    <div class="header-mix" :class="mobileOpen && 'is-open'">
        <div class="container">
            <div class="header-main">
                @if ($logo)
                    <div class="header-main__logo">
                        <a href="{{ home_url('/') }}" class="flex justify-center">
                            <x-media.img :image="$logo" size="medium" container-class="w-36 h-auto" />
                        </a>
                    </div>
                @endif

                @include('navigations.menu.main')

                @if ($headerCta)
                    <div class="header-main__cta">
                        <x-action.button :fields="$headerCta" />
                    </div>
                @endif
            </div>
        </div>
        <div id="submenu-teleport"></div>
    </div>
</header>

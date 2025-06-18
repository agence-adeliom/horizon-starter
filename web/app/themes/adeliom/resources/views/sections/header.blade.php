<header role="banner" class="header">
    @include('navigations.header.mobile-bar')
    <div class="menu-overlay" :class="$store.submenu && 'is-open'" x-cloak></div>
    <div class="header-mix" :class="mobileOpen && 'is-open'">
        <div class="w-full flex flex-col-reverse lg:flex-col">
            <x-navigation.top-navigation />
            <div class="container">
                <div class="header-main">
                    @if ($logo)
                        <div class="header-main__logo">
                            <a href="{{ home_url('/') }}" class="flex justify-center"
                                aria-label="Retour à la page d'accueil">
                                <x-media.img :image="$logo" size="medium" container-class="w-36 lg:h-auto" />
                            </a>
                        </div>
                    @endif

                    @include('navigations.menu.main')

                    @if ($headerCta)
                        <div class="header-main__cta">
                            <x-action.button :fields="$headerCta" class="max-lg:w-full" />
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div id="submenu-teleport"></div>
    </div>
</header>

<div class="mobile-bar">
    <div class="mobile-bar__wrapper">
        @if ($logo)
            <a href="{{ home_url('/') }}" class="flex justify-center" aria-label="Retour à la page d'accueil">
                <x-media.img :image="$logo" size="medium" container-class="h-10 lg:h-auto lg:w-36"
                    class="max-h-full w-auto" />
            </a>
        @endif

        <div class="flex flex-col items-center">
            <button class="mobile-bar__burger" @click="mobileOpen = !mobileOpen" :class="mobileOpen && 'is-active'"
                :aria-label="mobileOpen ? 'Fermeture du menu' : 'Ouverture du menu'">
                <x-far-bars class="icon-20 burger-icon scale-100 is-active:scale-0" />
                <x-far-xmark class="icon-20 burger-icon scale-0 is-active:scale-100" />
            </button>
            {{-- <span class="text-sm font-bold uppercase">{{ __('menu') }}</span> --}}
        </div>
    </div>
</div>

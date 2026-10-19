<div class="mobile-bar">
    <div class="mobile-bar-container">
        @if ($logo)
            <a href="{{ home_url('/') }}" class="flex justify-center" aria-label="{{ __('Retour à la page d\'accueil', 'sage') }}">
                <x-media.img :image="$logo" size="medium" container-class="h-10 lg:h-auto lg:w-36"
                    class="max-h-full w-auto" />
            </a>
        @endif

        <div class="flex flex-col items-center">
            <button type="button" class="burger-wrapper" @click="mobileOpen = !mobileOpen" :class="mobileOpen && 'is-active'"
                aria-label="{{ __('Menu', 'sage') }}" aria-controls="header-menu"
                aria-expanded="false" :aria-expanded="mobileOpen.toString()">
                <x-far-bars class="icon-5 burger-icon scale-100 is-active:scale-0" aria-hidden="true" />
                <x-far-xmark class="icon-5 burger-icon scale-0 is-active:scale-100" aria-hidden="true" />
            </button>
            {{-- <span class="text-sm font-bold uppercase">{{ __('menu') }}</span> --}}
        </div>
    </div>
</div>

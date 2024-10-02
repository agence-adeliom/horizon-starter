<div class="mobile-bar">
    <div class="mobile-bar__wrapper">
        @if ($logo)
            <a href="{{ home_url('/') }}" class="flex justify-center">
                <x-media.img :image="$logo" size="medium" container-class="h-14 lg:h-auto lg:w-36" class="max-h-full w-auto" />
            </a>
        @endif

        <div class="flex flex-col items-center">
            <button class="mobile-bar__burger" @click="mobileOpen = !mobileOpen" :class="mobileOpen && 'is-active'">
                <x-typography.icon icon="bars" class="burger-icon scale-100 is-active:scale-0" />
                <x-typography.icon icon="xmark" class="burger-icon scale-0 is-active:scale-100" />
            </button>
            {{-- <span class="text-sm font-bold uppercase">{{ __('menu') }}</span> --}}
        </div>
    </div>
</div>
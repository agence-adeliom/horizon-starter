<header class="header">
    @include('navigations.header.mobile-bar')
    <div class="header-mix">
        <div class="container">
            <div class="flex items-center justify-between lg:gap-x-5xlarge">
                @if ($logo)
                    <a href="{{ home_url('/') }}" class="flex justify-center">
                        <x-media.img :image="$logo" size="medium" container-class="w-36 h-auto" />
                    </a>
                @endif

                @include('navigations.menu.main')

                @if ($headerCta)
                    <x-action.button :fields="$headerCta" />
                @endif
            </div>
        </div>
    </div>
</header>

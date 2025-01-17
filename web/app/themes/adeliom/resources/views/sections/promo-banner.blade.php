@if ($isActive)
    <section class="{{ $isDark ? 'bg-primary' : 'bg-neutral-100' }}" x-data="{ isHidden: getCookie('promo_banner_hidden') }" x-cloak x-show="!isHidden"
        aria-hidden="isHidden">
        <div @class([
            'promo-banner p-medium relative flex items-start justify-start',
            'awc-theme-dark' => $isDark,
        ])>
            <div class="flex flex-col gap-4 items-start justify-center flex-grow md:flex-row md:items-center">
                @isset($bannerTitle)
                    <x-typography.text :content="$bannerTitle" class="text-text-primary" />
                @endisset

                @isset($bannerLink)
                    <a href="{{ $bannerLink['url'] }}" target="{{ $bannerLink['target'] }}" @class(['link text-small', 'text-tertiary' => $isDark])
                        class="">{{ $bannerLink['title'] }}</a>
                @endisset
            </div>

            <button class="ml-4 p-1" x-on:click="setCookie('promo_banner_hidden', 'true', 7); isHidden = true">
                <x-fas-xmark class="icon-16 text-text-primary" />
            </button>
        </div>
    </section>
@endif

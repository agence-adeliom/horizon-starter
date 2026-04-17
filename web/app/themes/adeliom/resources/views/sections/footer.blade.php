@php use Adeliom\HorizonTools\ViewModels\Menu\MenuViewModel; @endphp

<div class="bg-neutral-100 py-section-mobile lg:py-section-desktop">
    <footer role="contentinfo" class="container mx-auto px-4 md:px-8">
        <div class="flex flex-col justify-between gap-6 border-b pb-6 md:flex-row md:items-center">
            <div class="flex flex-col gap-1 w-full">
                @if ($footerTitle)
                    <x-typography.text :content="$footerTitle" class="text-xl font-semibold text-text-primary" />
                @endif

                @if ($footerText)
                    <x-typography.text :content="$footerText" />
                @endif
            </div>

            @if ($socialNetworks)
                <ul class="flex gap-2 text-sm">
                    @foreach ($socialNetworks as $item)
                        @if ($item['link'] && $item['icon'])
                            <li>
                                <x-action.button :url="$item['link']" target="_blank" rel="noopener"
                                    aria-label="Visitez notre page {{ $item['title'] ?? '' }} (Ouvrir dans un nouvel onglet)"
                                    type="secondary" iconOnly>
                                    <x-ui.icon :icon="$item['icon']" class="icon-4" />
                                </x-action.button>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="grid gap-6 border-b border-neutral-300 py-8 md:grid-cols-2 lg:grid-cols-4 lg:py-10">
            <div class="flex flex-col gap-6 md:col-span-2 lg:col-span-1 lg:pr-10">
                <a href="/" aria-label="{{ __('Retour à la page d\'accueil', 'sage') }}">
                    @if ($logoFooter)
                        <x-media.img :image="$logoFooter" size="medium" />
                    @endif
                </a>
                @if ($clientBaseline)
                    <x-typography.text :content="$clientBaseline" />
                @endif
            </div>

            @php
                $navItemClass = 'text-neutral-600 font-semibold transition-colors hover:text-primary';
            @endphp

            <div>
                @if ($primaryFooterMenu instanceof MenuViewModel && $primaryFooterMenu->items)
                    @if ($primaryNavTitle)
                        <x-typography.text id="primary-footer-navigation-title" :content="$primaryNavTitle"
                            class="text-xl font-semibold text-text-primary mb-4" />
                    @endif
                    <ul class="flex flex-col gap-4 md:gap-2">
                        @foreach ($primaryFooterMenu->items as $item)
                            <li>
                                <a @class($navItemClass) href="{{ $item->url }}"
                                    @if ($item->target) target="{{ $item->target }}" @endif>{{ $item->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div>
                @if ($secondaryFooterMenu instanceof MenuViewModel && $secondaryFooterMenu->items)
                    @if ($secondNavTitle)
                        <x-typography.text id="secondary-footer-navigation-title" :content="$secondNavTitle"
                            class="text-xl font-semibold text-text-primary mb-4" />
                    @endif
                    <ul class="flex flex-col gap-4 md:gap-2">
                        @foreach ($secondaryFooterMenu->items as $item)
                            <li>
                                <a @class($navItemClass) href="{{ $item->url }}"
                                    @if ($item->target) target="{{ $item->target }}" @endif>{{ $item->title }}</a>
                            </li>
                        @endforeach
                    </ul>

                @endif
            </div>

            <div class="flex flex-col gap-6 border border-card bg-white p-card h-fit md:col-span-2 lg:col-span-1">
                @if ($titleHighlight)
                    <x-typography.text :content="$titleHighlight" class="text-xl font-semibold text-text-primary" />
                @endif
                @if ($btnHighlight)
                    <x-action.button :fields="$btnHighlight" class="w-full" />
                @endif
            </div>
        </div>

        @include('sections.footer-bottom')
    </footer>
</div>

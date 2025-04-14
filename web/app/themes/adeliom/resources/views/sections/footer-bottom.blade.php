<div
    class="text-text-secondary text-xsmall col-span-full flex flex-row flex-wrap gap-4 lg:gap-0 items-center justify-center lg:justify-between py-0 pt-6 lg:py-6 ">
    <div>
        <p>{{ date('Y') }} © {{ $clientName }} - Tous droits réservés</p>
    </div>
    <nav class="flex flex-row gap-4 justify-center max-lg:flex-wrap">
        @if ($legalsMenu)
            @foreach ($legalsMenu->items as $item)
                <a href="{{ $item->url }}" class="text-hover">{{ $item->title }}</a>
            @endforeach
        @endif
        <button class="text-hover">Gestion des cookies</button>
    </nav>

    <div class="md:flex-end">
        <a href="https://adeliom.com/" target="_blank" rel="noopener nofollow" class="text-hover flex items-center gap-1">
            <span class="text-xsmall">Conception</span>
            <x-icon-adeliom class="icon-3" />
            <span class="text-xs">Agence Adeliom</span>
        </a>
    </div>
</div>

<div
    class="text-text-secondary text-xsmall col-span-full flex flex-row flex-wrap gap-4 lg:gap-0 items-center justify-center lg:justify-between py-0 pt-6 lg:py-6 ">
    <div>
        <p>{{ date('Y') }} © {{ $clientName }} </p>
    </div>
    <nav class="flex flex-row gap-4 justify-center max-lg:flex-wrap">
        @if ($legalsMenu)
            @foreach ($legalsMenu->items as $item)
                <a href="{{ $item->url }}">{{ $item->title }}</a>
            @endforeach
        @endif
        <span>Gestion des cookies</span>
    </nav>

    <div class="md:flex-end">
        <a href="https://adeliom.com/" target="_blank" rel="noopener nofollow" class=" flex items-center gap-1">
            <span class="text-xsmall">Conception</span>
            <img src="@asset('images/adeliom_favicon.svg')">
            <span class="text-xs">Agence Adeliom</span>
        </a>
    </div>
</div>

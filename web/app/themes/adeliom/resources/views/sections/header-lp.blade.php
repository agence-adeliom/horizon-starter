<header class="banner bg-white b-bottom border-card py-4">
    <div class="container">
        @if ($logo)
            <a href="{{ home_url('/') }}" class="mx-auto flex justify-center">
                <img src="{{ $logo['sizes']['large'] }}" alt="Logo" class="w-24 h-auto">
            </a>
        @endif
    </div>
</header>

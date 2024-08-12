<footer class="footer-lp bg-primary py-section-mobile lg:py-section-desktop">
    <div class="container awc-theme-dark flex flex-col">
        @if ($logoFooter)
            <div class="border-b border-primary-light w-full pb-8 md:pb-5xlarge">
                <a href="{{ home_url('/') }}" class="mx-auto flex justify-center">
                    <img src="{{ $logoFooter['sizes']['large'] }}" alt="Logo" class="w-24 h-auto">
                </a>
            </div>
        @endif
        @include('sections.footer-bottom')
    </div>
</footer>

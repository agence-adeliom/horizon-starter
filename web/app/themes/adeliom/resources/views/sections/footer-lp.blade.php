<footer class="footer-lp bg-primary py-section-mobile lg:py-section-desktop ">
    <div class="container awc-theme-dark flex flex-col">
        @if($logoFooter)
            <img src="{{ $logoFooter['sizes']['large'] }}" alt="" class="mx-auto">
        @endif
        @include("sections.footer-bottom")
    </div>
</footer>
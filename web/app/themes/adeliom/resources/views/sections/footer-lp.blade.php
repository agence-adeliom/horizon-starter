<footer class="footer-lp">
    @if($logoFooter)
        <img src="{{ $logoFooter['sizes']['large'] }}" alt="">
    @endif
    @include("sections.footer-bottom")
</footer>
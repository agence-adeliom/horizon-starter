<footer class="content-info">
    <div class="container">

      @if($logoFooter)
        <img src="{{ $logoFooter['sizes']['large'] }}" alt="">
      @endif

        <p>{{ date('Y') }} © {{$clientName}} </p>

        @if($legalsMenu)
            @dump($legalsMenu)
        @endif
        <span>Gestion des cookies</span>
        <div class="flex items-center gap-1">
            <span class="text-xs">Conception</span>
            <img src="@asset('images/adeliom_favicon.svg')">

            <span class="text-xs">Agence Adeliom</span>
        </div>

    </div>
</footer>

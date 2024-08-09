<header class="banner bg-white b-bottom border-card py-4">
  <div class="container">
    <a class="brand" href="{{ home_url('/') }}">
      @if($logo)
        <img src="{{ $logo['sizes']['large'] }}" alt="" class="mx-auto">
      @endif
    </a>
  </div>

</header>
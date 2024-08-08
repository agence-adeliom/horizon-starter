<header class="banner">
  <div class="container">
    <a class="brand" href="{{ home_url('/') }}">
      @if($logo)
        <img src="{{ $logo['sizes']['large'] }}" alt="">
      @endif
    </a>
  </div>

</header>

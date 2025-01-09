@if($enabled)
  <div class="{{ $containerClass }}">
    @if($withReviews)
      <div class="reviews">
        {{ sprintf('%s/%d', number_format($reviewsAverage, '1', ',', ' '), 5) }}
        @if($allReviewsLink && $allReviewsLabel)
          <a href="{{ $allReviewsLink }}">{{ $allReviewsLabel }}</a>
        @endif
      </div>
    @endif
    @if($links || $withSearch)
      <div class="flex">
        @if($links)
          <div class="links">
            @foreach($links as $link)
              <x-navigation.link :fields="$link"/>
            @endforeach
          </div>
        @endif

        @if($withSearch)
          <div class="search">
            <x-typography.icon icon="magnifying-glass"/>
            <span>Rechercher</span>
          </div>
        @endif
      </div>
    @endif
  </div>
@endif

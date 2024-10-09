@php use Adeliom\HorizonTools\ViewModels\Menu\MenuViewModel; @endphp

<div class="bg-neutral-100 py-section-mobile lg:py-section-desktop">
  <footer class="container mx-auto px-4 md:px-8 text-paragraph">
    <div class="flex flex-col items-center justify-between gap-6 border-b py-6 md:flex-row">
      <div class="w-full flex flex-col sm:flex-row gap-6 sm:items-center sm:justify-between">
        <div>
          <span class="font-bold tracking-widest text-title">
            @if ($footerTitle)
              {{ $footerTitle }}
            @endif
          </span>
          <p class="text-paragraph">
            @if ($footerText)
              {{ $footerText }}
            @endif
          </p>
        </div>

      </div>

      <div class="">
        <!-- social - start -->
        @if ($socialNetworks)
          <ul class="flex gap-2 text-sm">
            @foreach ($socialNetworks as $item)
              <li>
                <a href="{{ $item['link'] }}" target="_blank"
                   class="p-medium border border-states-outlined-border rounded-button text-primary hover:border-primary-800 h-6xlarge">
                  <x-typography.icon icon="{{$item['icon']->id}}" variant="brand"/>
                </a>
              </li>
            @endforeach
          </ul>
        @endif
        <!-- social - end -->
      </div>
    </div>
    <div
      class="border-b border-neutral-300 pb-8 md:pb-5xlarge grid gap-4 md:gap-12 pt-10 md:grid-cols-3 lg:grid-cols-5 lg:gap-8 lg:pt-12">
      <div class="col-span-full lg:col-span-2 lg:pr-12 mb-6">
        <!-- logo - start -->
        <div class="mb-4 lg:-mt-2">
          <a href="/" class="inline-flex items-center gap-2 text-xl font-bold text-primary md:text-2xl"
             aria-label="logo">
            @if ($logoFooter)
              <img src="{{ $logoFooter['sizes']['large'] }}" alt="">
            @endif
          </a>
        </div>
        <!-- logo - end -->
        @if ($clientBaseline)
          <p class="mb-6 sm:pr-8">
            {{ $clientBaseline }}
          </p>
        @endif
      </div>
      <!-- nav - start -->
      <div>
        @if ($primaryFooterMenu instanceof MenuViewModel && $primaryFooterMenu->items)
          <div class="mb-2 font-semibold text-lg tracking-widest text-title">
            @if ($primaryNavTitle)
              {{ $primaryNavTitle }}
            @endif
          </div>
          <nav class="flex flex-col gap-4">
            <ul>
              @foreach ($primaryFooterMenu->items as $item)
                <li><a href="{{ $item->url }}">{{ $item->title }}</a></li>
              @endforeach
            </ul>
          </nav>
        @endif
      </div>
      <!-- nav - end -->

      <!-- nav - start -->
      <div>
        @if ($secondaryFooterMenu instanceof MenuViewModel && $secondaryFooterMenu->items)
          <div class="mb-2 font-semibold text-lg tracking-widest text-title">
            @if ($secondNavTitle)
              {{ $secondNavTitle }}
            @endif

          </div>
          <nav class="flex flex-col gap-4">
            <ul>
              @foreach ($secondaryFooterMenu->items as $item)
                <li><a href="{{ $item->url }}">{{ $item->title }}</a></li>
              @endforeach
            </ul>
          </nav>
        @endif
      </div>
      <!-- nav - end -->

      <!-- highlight - start -->
      <div class="bg-white p-card flex flex-col gap-6 border border-card">
        <div class="mb-2 font-semibold text-lg tracking-widest text-title ">
          @if ($titleHighlight)
            {{ $titleHighlight }}
          @endif
        </div>

        @if ($btnHighlight)
          <x-action.button :object="$btnHighlight" class="w-full"/>
        @endif
      </div>
      <!-- highlight - end -->
    </div>

    @include('sections.footer-bottom')
  </footer>
</div>

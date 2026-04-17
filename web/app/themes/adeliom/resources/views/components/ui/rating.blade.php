<div @class(['rating flex items-center gap-2', $class])>
    <div class="flex space-x-1 text-orange-400" aria-hidden="true">
        @foreach ($stars() as $star)
            @if ($star === 'full')
                <x-fas-star class="icon-5" />
                {{-- <x-fas:sharp-star-sharp class="icon-5" /> --}}
            @elseif ($star === 'half')
                <x-fas-star-half-stroke class="icon-5" />
                {{-- <x-far:sharp-star-sharp-half-stroke class="icon-5" /> --}}
            @elseif ($star === 'empty')
                <x-far-star class="icon-5 " />
                {{-- <x-far:sharp-star-sharp class="icon-5" /> --}}
            @endif
        @endforeach
    </div>
    @if ($showScore)
        <x-typography.text :content="sprintf('%s/%d', number_format($score, '1', ',', ' '), 5)" />
    @endif
</div>

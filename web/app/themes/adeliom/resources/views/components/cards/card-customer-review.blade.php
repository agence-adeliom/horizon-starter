<div class="relative rounded-card p-card border-card flex flex-col gap-card {{ $attributes['class'] ?? '' }}">

    @php
        $reviewInfo = $review['review'] ?? null;
        $reviewer = $review['reviewer'] ?? null;
    @endphp

    @isset($reviewInfo['rating'])
        <awc-rating label="Rating" value="{{ $reviewInfo['rating'] }}" readonly precision="0.5"
            style="--symbol-color-active: var(--awc-color-orange-400);"></awc-rating>
    @endisset

    @isset($reviewInfo['review'])
        <p>{{ $reviewInfo['review'] }}</p>
    @endisset

    <div class="flex items-center gap-small">
        @if (@isset($reviewer['avatar']) && $reviewer['avatar'] !== false)
            <x-media.img :image="$reviewer['avatar']" class="flex-none rounded-pill w-10 h-10" size="thumbnail" />
        @else
            <div
                class="flex-none bg-gray-400 rounded-pill w-10 h-10 flex items-center justify-center text-large uppercase text-white">
                {{ !empty($reviewer['firstname']) ? substr($reviewer['firstname'], 0, 1) : '' }}{{ !empty($reviewer['lastname']) ? substr($reviewer['lastname'], 0, 1) : '' }}
            </div>
        @endif
        <div class="text-small">
            <p class="font-semibold">
                {{ !empty($reviewer['firstname']) ? $reviewer['firstname'] : '' }}{{ !empty($reviewer['lastname']) ? ', ' . $reviewer['lastname'] : '' }}
            </p>

            @if (!empty($reviewer['job']))
                <p>{{ $reviewer['job'] }}</p>
            @endif
        </div>
    </div>

</div>
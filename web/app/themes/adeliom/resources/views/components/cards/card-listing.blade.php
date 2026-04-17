@if ($content)
    @php
        $thumbnail = get_the_post_thumbnail($content->ID, 'medium', ['class' => 'cover-full']);
        $date = get_the_date('d/m/Y', $content->ID);
    @endphp
    <div
        class="flex flex-col relative rounded border border-neutral-300 overflow-hidden hover:shadow-lg transition-shadow duration-200">
        <div class="aspect-3/2 relative flex items-center justify-center bg-neutral-100 text-neutral-400">
            @if ($thumbnail)
                {!! $thumbnail !!}
            @else
                <x-fas-image class="w-10 h-10" aria-hidden="true" />
            @endif
        </div>


        <div class="bg-white flex flex-col items-start gap-4 p-4 flex-1">
            <div>
                @if ($date)
                    <span class="text-xs text-neutral-400 mt-2">{{ $date }}</span>
                @endif
                <x-typography.heading :content="$content->title" size="5" />
            </div>

            @if ($content->post_excerpt)
                <p>{{ $content->post_excerpt }}</p>
            @endif

            <x-action.button url="{{ get_permalink($content->ID) }}" type="tertiary" class="mt-auto" full-link="true">
                Voir plus
                <x-fas-arrow-right class="icon-4" aria-hidden="true" />
            </x-action.button>
        </div>
    </div>
@endif

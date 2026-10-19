@if ($content)
    @php
        $thumbnail = get_the_post_thumbnail($content->ID, 'medium', ['class' => 'cover-full', 'alt' => '']);
        $date = get_the_date('d/m/Y', $content->ID);
    @endphp
    <article
        class="group flex flex-col relative rounded border border-neutral-300 overflow-hidden hover:shadow-lg focus-within:shadow-lg transition-shadow duration-200">
        <div class="bg-white flex flex-col items-start gap-4 p-4 flex-1">
            <div class="flex flex-col items-start gap-2">
                <{{ $headingTag }} class="heading heading-5">
                    <a href="{{ get_permalink($content->ID) }}"
                        class="after:absolute after:inset-0 after:rounded focus-visible:outline-none focus-visible:after:outline-2 focus-visible:after:outline-solid focus-visible:after:-outline-offset-2 focus-visible:after:outline-primary">
                        {{ $content->title }}
                    </a>
                    </{{ $headingTag }}>

                    @if ($date)
                        <time datetime="{{ get_the_date('Y-m-d', $content->ID) }}"
                            class="-order-1 text-xs text-neutral-500">{{ $date }}</time>
                    @endif
            </div>

            @if ($content->post_excerpt)
                <p>{{ $content->post_excerpt }}</p>
            @endif

            <div class="mt-auto" aria-hidden="true">
                <x-action.button type="tertiary">
                    {{ __('Voir plus', 'sage') }}
                    <x-fas-arrow-right class="icon-4" />
                </x-action.button>
            </div>
        </div>

        <div
            class="-order-1 pointer-events-none aspect-3/2 relative flex items-center justify-center bg-neutral-100 text-neutral-400">
            @if ($thumbnail)
                {!! $thumbnail !!}
            @else
                <x-fas-image class="w-10 h-10" />
            @endif
        </div>
    </article>
@endif

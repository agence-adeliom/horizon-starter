@if ($fields && $fields['items'])
    @php
        $type = $fields['type'] ?? 'default';
        $withBg = $type === 'with_bg';
        $framed = $type === 'framed';
    @endphp


    <x-block :fields="$fields">
        <div class="flex flex-col items-center pb-section-mobile">
            @isset($fields['uptitle'])
                <x-typography.uptitle :content="$fields['uptitle']"/>
            @endisset

            @isset($fields['title'])
                <x-typography.heading :fields="$fields['title']" :size="3"/>
            @endisset

            @isset($fields['wysiwyg'])
                <x-typography.text :content="$fields['wysiwyg']" class="mt-4 text-center text-large"/>
            @endisset
        </div>

        <div class="flex flex-wrap justify-around {{ $withBg ? "p-xlarge bg-neutral-100" : ""}}">
            @foreach ($fields['items'] as $item)
                <div class="basis-full md:basis-1/2 lg:basis-1/{{ count($fields['items'])  }} flex flex-col items-center gap-medium {{$framed ? 'bg-neutral-100 p-xlarge'  :""}}">
                    @if (@isset($item['icon']) && $item['icon'])
                        <div class="text-5xlarge text-primary">
                            {!! $item['icon'] !!}
                        </div>
                    @endisset

                    @if (@isset($item['data']) && $item['data'])
                        <div class="heading-2 font-semibold">
                            {{ $item['data'] }}
                        </div>
                    @endisset

                    @if (@isset($item['title']) && $item['title'])
                        <div class="text-large text-text-secondary">
                            {{ $item['title'] }}
                        </div>
                    @endisset
                </div>
            @endforeach
        </div>
    </x-block>
@endif
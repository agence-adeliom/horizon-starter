@if ($fields && $fields['items'])
    @php
        $type = $fields['type'] ?? 'default';
        $withBg = $type === 'with_bg';
        $framed = $type === 'framed';

        $direction = $fields['direction'] ?? 'column';
        $isColumn = $direction === 'column';

    @endphp

    <x-block :fields="$fields">
        <div class="flex flex-col items-center text-center pb-section-mobile">
            @isset($fields['uptitle'])
                <x-typography.uptitle :content="$fields['uptitle']" />
            @endisset

            @isset($fields['title'])
                <x-typography.heading :fields="$fields['title']" :size="3" />
            @endisset

            @isset($fields['wysiwyg'])
                <x-typography.text :content="$fields['wysiwyg']" class="mt-4 text-large" />
            @endisset
        </div>

        <div @class([
            'grid grid-cols-2 md:grid-cols-4 lg:grid-cols-' .
            count($fields['items']) * 2 .
            ' lg:gap-6',
            'max-lg:gap-4' => !$withBg,
            'bg-neutral-100' => $withBg,
        ])>
            @foreach ($fields['items'] as $item)
                <div @class([
                    'col-span-2 flex items-center',
                    'md:max-lg:col-start-2' =>
                        count($fields['items']) === 3 && $loop->index === 2,
                    'bg-neutral-100' => $framed,
                    'p-xlarge' => $framed || $withBg,
                    'flex-col gap-title-text-mobile lg:gap-title-text-desktop' => $isColumn,
                    'flex-row gap-large' => !$isColumn,
                    'p-small lg:p-xlarge' => !$framed && !$withBg && !$isColumn,
                ])>
                    @if (@isset($item['icon']) && $item['icon'])
                        <div @class(['text-3xl text-primary', 'lg:text-5xlarge' => $isColumn])>
                            {!! $item['icon'] !!}
                        </div>
                    @endisset

                    @if (@isset($item['data']) && $item['data'])
                        <div @class(['heading-2 font-semibold', 'heading-3' => !$isColumn])>
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

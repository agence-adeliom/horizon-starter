@if ($fields && $fields['items'])
    @php
        $type = $fields['type'] ?? 'default';
        $light = $type === 'light';
    @endphp

    <x-block :fields="$fields">
        @isset($fields['uptitle'])
            <x-typography.uptitle :content="$fields['uptitle']" />
        @endisset

        @isset($fields['title'])
            <x-typography.heading :fields="$fields['title']" />
        @endisset

        {{-- md:grid-cols-3 md:grid-cols-4 --}}
        <div class="flex flex-wrap">
            @foreach ($fields['items'] as $item)
                <div
                    class="basis-full md:basis-1/2 lg:basis-1/{{ count($fields['items']) }} {{ $light ? 'basis-full flex flex-row items-center gap-medium p-xlarge max-md:justify-center' : '' }}">
                    @if (@isset($item['icon']) && $item['icon'])
                        <div class="text-3xl text-primary">
                            {!! $item['icon'] !!}
                        </div>
                    @endisset

                    @if (@isset($item['data']) && $item['data'])
                        <div>
                            data
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

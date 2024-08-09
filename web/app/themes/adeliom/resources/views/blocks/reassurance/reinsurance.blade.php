@if ($fields['items'])
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
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-{{ count($fields['items']) }}">
            @foreach ($fields['items'] as $item)
                <div class="{{ $light ? 'flex flex-row' : '' }}">
                    @isset($item['icon'])
                        <div>
                            {!! $item['icon'] !!}
                        </div>
                    @endisset

                    @isset($item['data'])
                        <div>
                            {{ $item['data'] }}
                        </div>
                    @endisset

                    @isset($item['title'])
                        <div>
                            {{ $item['title'] }}
                        </div>
                    @endisset
                </div>
            @endforeach
        </div>
    </x-block>
@endif

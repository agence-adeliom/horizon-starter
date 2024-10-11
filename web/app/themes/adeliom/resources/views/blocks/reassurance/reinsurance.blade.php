@if ($fields && $fields['items'])
    <x-block :fields="$fields">
        <div class="flex flex-wrap">
            @foreach ($fields['items'] as $item)
                <div class="basis-1/2 lg:basis-1/{{ count($fields['items'])  }} flex flex-row items-baseline gap-medium p-small md:p-xlarge">
                    @if (@isset($item['icon']) && $item['icon'])
                        <div class="text-xl text-primary lg:text-2xl">
                            {!! $item['icon'] !!}
                        </div>
                    @endisset

                    @if (@isset($item['data']) && $item['data'])
                        <div class="heading-4">
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
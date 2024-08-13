<x-block :fields="$fields">
    <div class="grid-12">
        <div class="lg:col-span-full">
            @isset($fields['uptitle'])
                <x-typography.heading :content="$fields['uptitle']" size="headline" />
            @endisset
            @isset($fields['title'])
                <x-typography.heading :fields="$fields['title']" size="3" />
            @endisset
        </div>
        <div class="lg:col-span-full">
            <div class="flex gap-6">
                @if (isset($fields['steps']) && $fields['steps'])
                    @foreach ($fields['steps'] as $step)
                        <x-cards.card-step :step="$step" />
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-span-full flex justify-center">
            @isset($fields['button'])
                <x-action.button :object="$fields['button']" size="large" type="tertiary" />
            @endisset
        </div>

    </div>
</x-block>

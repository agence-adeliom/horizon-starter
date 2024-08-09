<x-block :fields="$fields">
    <div class="grid-12">
        <div class="lg:col-span-full">
            <x-typography.heading :content="$fields['uptitle']" size="headline"/>
            <x-typography.heading :fields="$fields['title']" size="3" />
        </div>
        <div class="lg:col-span-full">
            <div class="flex gap-6">
            @if(isset($fields['steps']) && $fields['steps'])
                @foreach($fields['steps'] as $step)
                    <x-cards.card-step :step="$step"/>
                @endforeach
            @endif
            </div>
        </div>
        <div class="col-span-full flex justify-center">
            <x-action.button :object="$fields['button']" size="large" type="tertiary"/>
        </div>

    </div>
</x-block>
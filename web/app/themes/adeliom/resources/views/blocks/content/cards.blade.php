<x-block :fields="$fields">
    <div class="grid-12">
        @foreach($fields['cards'] as $card)
            <x-cards.card-basic :card="$card"/>
        @endforeach
    </div>
</x-block>
<div>
    <div>
        {{-- Champ permettant de modifier la recherche --}}
        <input type="text" wire:model.live.debounce="searchQuery">
    </div>
    @if(!empty($results))
        @if($separateResultsByType)
            <x-search-engine.separated-results :display-type-filters="$displayTypeFilters"
                                               :type-choices="$typeChoices" :results="$results" />
        @else
            <x-search-engine.merged-results :display-type-filters="$displayTypeFilters" :type-choices="$typeChoices"
                                            :results="$results" :type-choice="$typeChoice" />
        @endif
    @else
        @if(empty($searchQuery))
            Veuillez saisir une requête de recherche.
        @else
            Aucun résultat trouvé pour "{{ $searchQuery }}".
        @endif
    @endif
</div>

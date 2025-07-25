@php use Adeliom\HorizonTools\Services\StringService;use App\Livewire\Listing\SearchEngineResults; @endphp

<div search-results-container="merged">
    @if($displayTypeFilters && $typeChoices)
        {{-- Affichage du filtre par type de résultat --}}
        <div class="results-filters">
            @foreach($typeChoices as $typeSlug => $typeName)
                @if($typeSlug === SearchEngineResults::VALUE_ALL_TYPE || in_array($typeSlug, $foundPostTypes))
                    <label for="type_{{$typeSlug}}">{{$typeName}}</label>
                    <input id="type_{{$typeSlug}}" type="radio" wire:model.live="typeChoice" value="{{$typeSlug}}"
                           @if($typeChoice === $typeSlug) checked="checked" @endif>
                @endif
            @endforeach
        </div>
    @endif

    <p>
        {{ $results['total'] }} {{ StringService::singularOrPlural($results['total'], 'résultat', 'résultats') }}
    </p>

    {{-- Conteneur des résultats non-séparés par type --}}
    <div class="grid grid-cols-4 gap-4">
        @foreach($results['items'] as $item)
            @if($item->card)
                <x-dynamic-component :component="$item->card" :content="$item" />
            @endif
        @endforeach
    </div>

    <x-horizon.pagination :data="$results" handle="setPage" :has-buttons="true" />
</div>

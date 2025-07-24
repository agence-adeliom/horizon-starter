@php use Adeliom\HorizonTools\Services\StringService; @endphp

<div search-results-container="merged">
    @if($displayTypeFilters && $typeChoices)
        {{-- Affichage du filtre par type de résultat --}}
        @foreach($typeChoices as $typeSlug => $typeName)
            <label for="type_{{$typeSlug}}">{{$typeName}}</label>
            <input id="type_{{$typeSlug}}" type="radio" wire:model.live="typeChoice" value="{{$typeSlug}}"
                   @if($typeChoice === $typeSlug) checked="checked" @endif>
        @endforeach
    @endif

    <p>
        {{ $results['total'] }} {{ StringService::singularOrPlural($results['total'], 'résultat', 'résultats') }}
    </p>

    {{-- Conteneur des résultats non-séparés par type --}}
    <div class="grid grid-cols-4 gap-4">
        @foreach($results['items'] as $item)
            @dump($item)
        @endforeach
    </div>

    <x-horizon.pagination :data="$results" handle="setPage" :has-buttons="true" />
</div>

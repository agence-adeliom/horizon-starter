@php use Adeliom\HorizonTools\Services\StringService; @endphp
<div>
    @if($separateResultsByType)
        <div class="grid grid-cols-1 gap-4">
            @foreach($results as $postTypeSlug => $postTypeData)
                <div>
                    <div class="flex gap-2">
                        {{-- Titre de la section de résultats --}}
                        <h2>{{$postTypeData['title']}}</h2>

                        {{-- Nombre de résultats --}}
                        <div class="h-4 w-4">
                            {{$postTypeData['total']}}
                        </div>
                    </div>

                    {{-- Affichage des résultats --}}
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($postTypeData['items'] as $item)
                            @dump($item)
                        @endforeach
                    </div>

                    <x-horizon.pagination :data="$postTypeData" handle="setPage"
                                          :extra-handle-params="$postTypeData['extraHandleParams']"
                                          :has-buttons="true" />
                </div>
            @endforeach
        </div>
    @else
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

        <div class="grid grid-cols-4 gap-4">
            @foreach($results['items'] as $item)
                @dump($item)
            @endforeach
        </div>

        <x-horizon.pagination :data="$results" handle="setPage" :has-buttons="true" />
    @endif
</div>

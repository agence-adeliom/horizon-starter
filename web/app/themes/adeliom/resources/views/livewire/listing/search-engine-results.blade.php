@php use Adeliom\HorizonTools\Services\StringService; @endphp
<div>
    <div>
        {{-- Champ permettant de modifier la recherche --}}
        <input type="text" wire:model.live.debounce="searchQuery">
    </div>
    @if(!empty($results))
        @if($separateResultsByType)
            <div search-results-container="separated">
                @if($displayTypeFilters)
                    {{-- Affichage du filtre par type de résultat --}}
                    @foreach($typeChoices as $typeSlug => $typeName)
                        <label for="type_{{$typeSlug}}">{{$typeName}}</label>
                        <input id="type_{{$typeSlug}}" type="radio" name="type_filter"
                               @if($loop->first) checked="checked"
                            @endif>

                        @if($typeSlug !== 'all')
                            {{-- Style permettant de masquer en fonction du type --}}
                            <style>
                                [search-results-container="separated"]:has(#type_{{$typeSlug}}[name="type_filter"]:checked) [search-results]:not([search-results="{{$typeSlug}}"]) {
                                    display: none;
                                }
                            </style>
                        @endif
                    @endforeach
                @endif
                {{-- Conteneur des résultats séparés par type --}}
                <div class="grid grid-cols-1 gap-4">
                    @foreach($results as $postTypeSlug => $postTypeData)
                        <div search-results="{{$postTypeSlug}}">
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
            </div>
        @else
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
        @endif
    @else
        @if(empty($searchQuery))
            Veuillez saisir une requête de recherche.
        @else
            Aucun résultat trouvé pour "{{ $searchQuery }}".
        @endif
    @endif
</div>

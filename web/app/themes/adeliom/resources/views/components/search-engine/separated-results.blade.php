@php use Adeliom\HorizonTools\Services\StringService;use App\Livewire\Listing\SearchEngineResults; @endphp

<div search-results-container="separated">
    @if($displayTypeFilters)
        {{-- Affichage du filtre par type de résultat --}}
        <div class="results-filters">
            @foreach($typeChoices as $typeSlug => $typeName)
                <label for="type_{{$typeSlug}}">
                    {{$typeName}}

                    @if($typeSlug!==SearchEngineResults::VALUE_ALL_TYPE&&!empty($totalPerType[$typeSlug]))
                        <span>
              {{-- Nombre de résultats par type --}}
                            {{$totalPerType[$typeSlug]}}
            </span>
                    @endif
                </label>
                <input id="type_{{$typeSlug}}" type="radio" name="type_filter"
                       wire:model.live="typeChoice" value="{{$typeSlug}}"
                       @if($typeChoice === $typeSlug) checked="checked" @endif>

                @if($typeSlug !== 'all')
                    {{-- Style permettant de masquer en fonction du type --}}
                    <style>
                        [search-results-container="separated"]:has(#type_{{$typeSlug}}[name="type_filter"]:checked) [search-results]:not([search-results="{{$typeSlug}}"]) {
                            display: none;
                        }

                        [search-results-container="separated"]:has(#type_{{$typeSlug}}[name="type_filter"]:checked) [search-results] [search-results-title] {
                            display: none;
                        }
                    </style>
                @endif
            @endforeach
        </div>
    @endif
    {{-- Conteneur des résultats séparés par type --}}
    <div class="grid grid-cols-1 gap-4">
        @foreach($results as $postTypeSlug => $postTypeData)
            <div search-results="{{$postTypeSlug}}" class="@if(!$loop->first) mt-8 @endif">
                <div search-results-title class="flex gap-2">
                    {{-- Titre de la section de résultats --}}
                    <h2>{{$postTypeData['title']}}</h2>

                    {{-- Nombre de résultats --}}
                    <div class="h-4 w-4">
                        {{$postTypeData['total']}}
                    </div>
                </div>

                {{-- Affichage des résultats --}}
                <div class="grid grid-cols-4 gap-4 transition-all" wire:loading.class="blur"
                     wire:target="searchQuery, setTypePage">
                    @foreach($postTypeData['items'] as $item)
                        @if($item->card)
                            <x-dynamic-component :component="$item->card" :content="$item" />
                        @endif
                    @endforeach
                </div>

                <x-horizon.pagination :data="$postTypeData"
                                      handle="setTypePage"
                                      :extra-handle-params="$postTypeData['extraHandleParams']"
                                      :extra-handle-params-first="true"
                                      :has-buttons="true" />
            </div>
        @endforeach
    </div>
</div>

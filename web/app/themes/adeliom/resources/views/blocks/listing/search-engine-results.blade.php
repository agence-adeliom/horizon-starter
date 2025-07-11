@php use Adeliom\HorizonTools\Services\SearchEngineService; @endphp

@if(SearchEngineService::canSearchEngineBeUsed())
    <x-block :fields="$fields" :block="$block">
        <div class="grid-12">
            <div class="col-span-12">
                <livewire:listing.search-engine-results />
            </div>
        </div>
    </x-block>
@endif

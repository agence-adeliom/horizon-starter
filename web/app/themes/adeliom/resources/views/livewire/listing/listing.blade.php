<div class="mt-4" id="listing">
    <form wire:change="handleFilters">
        @if ($filters)
            <div class="flex flex-col gap-4 md:flex-row md:gap-2 md:items-end" wire:ignore>
                @foreach ($filters as $type => $filter)
                    <x-horizon.filter :value="$filter" :model="'filterFields.' . $filter['name']" />
                @endforeach
                <div class="md:mb-2 ml-auto">
                    <x-action.button wire:click.prevent="resetFilters" type="tertiary" class="ml-8" tag="button">
                        <x-fas-rotate class="icon-16" />
                        Réinitialiser
                    </x-action.button>
                </div>
            </div>
        @endif

        <div class="flex items-center justify-between mt-8 lg:mt-10">
            <x-horizon.results-counter :value="$data" singular="élément" plural="éléments" />
            <x-horizon.sort model="order" :options="$sortOptions" />
        </div>
    </form>


    @if (!empty($data['items']))
        <div class="results mt-4 transition-opacity lg:mt-6" wire.loading.delay wire:loading.class="opacity-50">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 md:gap-6">
                @foreach ($data['items'] as $post)
                    <x-dynamic-component :component="$card" :content="$post" />
                @endforeach
            </div>
        </div>
    @else
        <div class="py-10 flex flex-col items-center text-center lg:py-20">
            <x-fas-magnifying-glass class="w-10 h-10 text-primary lg:w-20 lg:h-20" />
            <x-typography.heading class="mt-8 lg:mt-10" content="Aucun résultat" size="3" />
            <x-typography.text class="mt-4"
                content="Nous n’avons pas trouvé de ressource correspondant à vos critères." />
            <x-action.button type="secondary" url="/" class="mt-6 max-sm:w-full">
                Retour à l'accueil
            </x-action.button>
        </div>
    @endif

    <div class="mt-4 lg:mt-10">
        <x-horizon.pagination :data="$data" handle="setPage" :has-buttons="true" />
    </div>

    @script
        <script>
            $wire.on('filters-reset', () => {
                // Ré-écriture de l'URL
                window.history.pushState({}, '', '');
            });
        </script>
    @endscript
</div>

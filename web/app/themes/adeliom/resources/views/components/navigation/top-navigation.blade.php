@if ($enabled)
    <div class="top-navigation">
        <div class="{{ $containerClass }}">
            @if ($withReviews)
                <div class="reviews">
                    <x-ui.rating :score="$reviewsAverage" showScore />
                    @if ($allReviewsLink)
                        <x-action.button :fields="$allReviewsLink" icon="fas-arrow-right" type="tertiary" />
                    @endif
                </div>
            @endif
            @if ($links || $withSearch)
                <div class="flex flex-col lg:flex-row">
                    @if ($links)
                        <div class="links">
                            @foreach ($links as $link)
                                <x-navigation.link :fields="$link" class="top-item top-item--link" />
                            @endforeach
                        </div>
                    @endif

                    @if ($withSearch)
                        <span class="flex" x-data="initModal()">
                            <button class="top-item top-item--search" x-on:click="openModal()">
                                <x-fas-magnifying-glass class="icon-16" />
                                Rechercher
                            </button>

                            <template x-teleport="body">
                                <x-structure.drawer position='top' class="h-auto py-20">
                                    <div class="container">
                                        <div class="max-w-2xl mx-auto flex flex-col gap-6">
                                            <x-typography.heading content="Que recherchez-vous?" class="text-center"
                                                size="3" />
                                            <x-form.search isModal />
                                        </div>
                                    </div>
                                </x-structure.drawer>
                            </template>
                        </span>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endif

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
                                <x-structure.drawer position='top' class="h-auto flex flex-col">
                                    <div @class([
                                        'bg-white w-full pb-10 pt-20 lg:py-20',
                                        '!pb-20' => !$searchInfos,
                                    ])>
                                        <div class="container">
                                            <div class="max-w-2xl mx-auto flex flex-col gap-6">
                                                <x-typography.heading content="Que recherchez-vous?" class="text-center"
                                                    size="3" />
                                                <x-form.search isModal />
                                            </div>
                                        </div>
                                    </div>
                                    @if ($searchInfos)
                                        <div class="bg-neutral-100 w-full py-10 lg-py-20">
                                            <div class="container">
                                                <div class="max-w-2xl mx-auto grid gap-6 md:grid-cols-2">
                                                    @foreach ($searchInfos as $searchInfo)
                                                        <div class="flex flex-col items-start">
                                                            @if ($searchInfo['title'])
                                                                <x-typography.text :content="$searchInfo['title']"
                                                                    class="text-xl font-semibold" />
                                                            @endif
                                                            @if ($searchInfo['description'])
                                                                <x-typography.text :content="$searchInfo['description']" class="mt-2" />
                                                            @endif

                                                            @if (isset($searchInfo['button']) && $searchInfo['button']['link'])
                                                                <x-action.button :fields="$searchInfo['button']"
                                                                    class="mt-4 max-md:w-full lg:mt-6"
                                                                    type="secondary" />
                                                            @endisset
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </x-structure.drawer>
                        </template>
                    </span>
                @endif
            </div>
        @endif
    </div>
</div>
@endif

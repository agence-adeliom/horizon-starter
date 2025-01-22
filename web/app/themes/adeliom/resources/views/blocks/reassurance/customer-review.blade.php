@if ($fields)
    <x-block :fields="$fields" class="overflow-hidden">

        <div class="flex w-full flex-col gap-text-image-mobile lg:gap-text-image-desktop">
            <div class="grid-12">
                <div class="col-span-full flex flex-col items-center text-center lg:col-span-8 lg:col-start-3">
                    @isset($fields['uptitle'])
                        <x-typography.uptitle :content="$fields['uptitle']"
                            class="mb-headline-title-mobile lg:mb-headline-title-desktop" />
                    @endisset

                    @isset($fields['title'])
                        <x-typography.heading :fields="$fields['title']" size="3" />
                    @endisset

                    @isset($fields['wysiwyg'])
                        <x-typography.text :content="$fields['wysiwyg']"
                            class="mt-title-text-mobile text-large lg:mt-title-text-desktop" />
                    @endisset

                    @if (@isset($context['global-rating']) || @isset($context['btn-reviews']))

                        <div
                            class="mt-title-text-mobile flex flex-col items-center gap-medium lg:mt-title-text-desktop lg:flex-row lg:gap-xlarge">
                            @if (@isset($context['global-rating']) && $context['global-rating'])
                                <x-ui.rating :score="$context['global-rating']" showScore />
                            @endisset

                            @if (@isset($context['btn-reviews']) && $context['btn-reviews']['link'])
                                <x-action.button :fields="$context['btn-reviews']" icon="fas-arrow-right" type="tertiary" />
                            @endif
                    </div>
                @endisset
        </div>
    </div>


    <div class="col-span-full" x-data="initReviewsSlider()">
        <div class="swiper w-full overflow-visible" x-ref="swiperContainer">
            <div class="swiper-wrapper cursor-grab">
                @if (isset($fields['reviews']) && $fields['reviews'])
                    @foreach ($fields['reviews'] as $review)
                        @if (is_object($review) && property_exists($review, 'ID'))
                            <x-cards.card-customer-review :review="get_fields($review->ID)" class="swiper-slide" />
                        @endif
                    @endforeach
                @endif
            </div>

            <div x-ref="swiperPagination" class="mt-6 flex justify-center gap-2"></div>
        </div>
    </div>
</div>
</x-block>
@endif

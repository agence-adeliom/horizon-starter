@if ($fields)
    <x-block :fields="$fields">

        <div class="grid-12">

            <div class="flex flex-col items-center text-center col-span-full lg:col-span-8 lg:col-start-3">
                @isset($fields['uptitle'])
                    <x-typography.uptitle :content="$fields['uptitle']" class="mb-headline-title-mobile lg:mb-headline-title-desktop" />
                @endisset

                @isset($fields['title'])
                    <x-typography.heading :fields="$fields['title']" size="3" />
                @endisset

                @isset($fields['wysiwyg'])
                    <x-typography.text :content="$fields['wysiwyg']" class="text-large mt-title-text-mobile lg:mt-title-text-desktop" />
                @endisset

                @if (@isset($context['global-rating']) || @isset($context['btn-reviews']))

                    <div
                        class="flex flex-col items-center gap-medium mt-title-text-mobile lg:mt-title-text-desktop lg:gap-xlarge">
                        @if (@isset($context['global-rating']) && $context['global-rating'])
                            <awc-rating label="Rating" value="{{ $context['global-rating'] }}" readonly show-rate
                                precision="0.5" style="--symbol-color-active: var(--awc-color-orange-400);"></awc-rating>
                        @endisset

                        @if (@isset($context['btn-reviews']) && $context['btn-reviews']['link'])
                            <x-action.button :object="$context['btn-reviews']" class="w-full" />
                        @endif
                </div>
            @endisset

    </div>

    <div class="lg:col-span-full">
        <div class="flex gap-6">
            @if (isset($fields['reviews']) && $fields['reviews'])
                @foreach ($fields['reviews'] as $review)
                    @if (is_object($review) && property_exists($review, 'ID'))
                        <x-cards.card-customer-review :review="get_fields($review->ID)" />
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</div>
</x-block>
@endif

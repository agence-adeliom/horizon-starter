<x-block :fields="$fields" class="bg-color-02-50 relative" background="none">
    <div class="grid-12">
        <div class="lg:col-span-6">
            <x-typography.heading :fields="$fields['title']" size="1" />
            <x-typography.text :content="$fields['wysiwyg']" class="mt-6 list-check" />

            @if ($fields['offer'])
                <x-offer :fields="$fields['offer']" class="mt-3xlarge nested " />
            @endif

        </div>

        <div class="bg-background p-5xlarge rounded-card lg:col-span-6">
            <x-typography.heading :fields="$fields['form-title']" size="5" />

            @if ($fields['desc'])
                <x-typography.text :content="$fields['desc']" class="mt-title-text-mobile lg:mt-title-text-desktop" />
            @endif

            @if ($fields['form_id'])
                <div class="mt-button-text-mobile lg:mt-button-text-desktop">
                    @php
                        echo do_shortcode(
                            '[gravityform id="' .
                                $fields['form_id'] .
                                '" title="false" description="false" ajax="true"]',
                        );
                    @endphp
                </div>
            @endif
        </div>
    </div>
</x-block>

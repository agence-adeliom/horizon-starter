<x-block :fields="$fields">
    <div
        class="flex flex-col items-start gap-6 p-3xlarge bg-primary rounded-xlarge lg:flex-row lg:items-center lg:justify-between lg:gap-7xlarge lg:p-6xlarge">
        <div class="flex flex-col gap-title-text-mobile lg:gap-title-text-desktop awc-theme-dark">
            @isset($fields['title'])
                <x-typography.heading :fields="$fields['title']" size="5" />
            @endisset

            @isset($fields['wysiwyg'])
                <x-typography.text :content="$fields['wysiwyg']" />
            @endisset
        </div>
        @isset($fields['button'])
            <x-action.button :object="$fields['button']" type="tertiary" size="large" />
        @endisset
    </div>
</x-block>

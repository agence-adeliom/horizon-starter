<x-block :fields="$fields" class="bg-color-02-50 relative" background="none">
    <div class="grid-12">
        <div class="lg:col-span-5">
            <x-typography.heading :fields="$fields['title']" size="5"/>

            @if($fields['desc'])
                <x-typography.text :content="$fields['desc']" />
            @endif

            <div class="wysiwyg">
                {!! $fields['wysiwyg'] !!}
            </div>

            @if ($fields['offer'] && $fields['offer']['enable'])
                <x-offer :fields="$fields['offer']" />
            @endif

        </div>

        <div class="lg:col-span-7">
            <x-typography.heading :fields="$fields['form-title']" />

            @if ($fields['form_id'])
                @php
                    echo do_shortcode(
                        '[gravityform id="' . $fields['form_id'] . '" title="false" description="false" ajax="true"]',
                    );
                @endphp
            @endif
        </div>
    </div>
</x-block>
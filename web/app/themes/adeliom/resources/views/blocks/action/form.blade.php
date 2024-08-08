<x-block :fields="$fields">
    <div class="container">
        <div class="grid gap-6 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <x-heading :fields="$fields['title']"/>
            </div>

            <div class="lg:col-span-7">
                @if($fields['offer'] && $fields['offer']['enable'])
                    <x-offer :fields="$fields['offer']"/>
                @endif

                @if($fields['form_id'])
                    @php
                        echo do_shortcode('[gravityform id="'.$fields['form_id'].'" title="false" description="false" ajax="true"]');
                    @endphp
                @endif
            </div>
        </div>
    </div>
</x-block>
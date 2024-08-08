<x-block :fields="$fields">
    <div class="grid-12">
        <div class="lg:col-span-5">
            <x-heading :fields="$fields['title']" />
            <x-heading tag="h4" content="Custom heading" />
        </div>

        <div class="lg:col-span-7">
            //wysiwyg
        </div>
    </div>
</x-block>
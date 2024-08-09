<x-block :fields="$fields">
    <div class="grid-12">
        <div class="lg:col-span-5">
            <x-typography.heading :fields="$fields['title']" />
        </div>
        <div class="lg:col-span-7">
            <x-typography.text :content="$fields['wysiwyg']" />
        </div>
    </div>
</x-block>

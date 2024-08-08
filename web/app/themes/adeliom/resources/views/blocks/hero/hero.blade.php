<x-block :fields="$fields">
    <div class="grid-12">

        <div class="lg:col-span-5">

            //bredcrumb
            <img src="{{$fields['main_image']["sizes"]["large"]}}" alt="">
        </div>

        <div class="lg:col-span-7">
            @isset($fields['uptitle'])
                <x-uptitle :content="$fields['uptitle']"/>
            @endisset

            @isset($fields['title'])
                <x-heading :fields="$fields['title']"/>
            @endisset

            <div class="wysiwyg">
                {!! $fields['wysiwyg'] !!}
            </div>


            <x-action.button :object="$fields['buttons']"/>
        </div>
    </div>
</x-block>
@php
 $positionClass = $fields['position'] != 'left' ? 'lg:col-start-3' : '';
  $bgType = $fields['bg-type'] ?? 'bg-color-type';
  $bgColor = $bgType  === "bg-color-type" ? "bg-color-02-50" : "";
  $bgImage = ($bgType === "bg-image-type" && isset($fields['bg-image'])) ? $fields['bg-image']['sizes']['large'] : "";
@endphp

<x-block :fields="$fields" class="{{$bgColor}} relative" background="none">
    @if($bgImage)
        <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('{{ $bgImage }}')"></div>
    @endif
    <div class="container z-10 relative">
        <div class="grid-12">
            <div class="lg:col-span-8 {{$positionClass}}">
                <div class="bg-white rounded-card p-10">
                    <x-typography.heading :fields="$fields['title']" size="5"/>

                    @if($fields['desc'])
                        <x-typography.text :content="$fields['desc']" />
                    @endif
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
    </div>
</x-block>
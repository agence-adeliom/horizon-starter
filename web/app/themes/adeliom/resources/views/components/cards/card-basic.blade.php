<div class="col-span-6 bg-full pt-24 relative rounded-card"
     style="background-image: url({{$card['img']['sizes']['large']}})">
    <div class="absolute-full bg-linear rounded-card"></div>
    <div class="p-card flex flex-col items-start gap-card shadow-small-blur relative z-10">
        <x-heading :fields="$card['title']" :size="5" class="awc-theme-dark"/>
        {{-- Passer en composant --}}
        <div class="wysiwyg">
            {!! $card['wysiwyg'] !!}
        </div>
        <x-action.button :object="$card['button']"/>
    </div>
</div>
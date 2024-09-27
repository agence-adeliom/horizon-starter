<div class="col-span-6 flex bg-full min-h-80 relative rounded-card overflow-hidden awc-theme-dark">

    <x-media.img :image="$card['img']" class="cover-full" size="medium" container-class="absolute-full" />
    <div class="absolute-full bg-linear rounded-card"></div>
    <div class="p-card flex flex-col items-start gap-card shadow-small-blur relative z-10 mt-auto">
        @isset($card['title'])
            <x-typography.heading :fields="$card['title']" :size="5" class="awc-theme-dark" />
        @endisset
        @isset($card['wysiwyg'])
            <x-typography.text :content="$card['wysiwyg']" class="" />
        @endisset
        @isset($card['button'])
            <x-action.button :object="$card['button']" />
        @endisset
    </div>
</div>

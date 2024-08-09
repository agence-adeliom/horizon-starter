<div class="relative rounded-card bg-primary overflow-hidden">
    <x-media.img :image="$step['img']" class="cover-full" size="medium" container-class="aspect-[1.75] md:apect-[2] w-full"/>
    <div class="p-card flex flex-col items-start awc-theme-dark">
        <x-typography.heading :content="$step['uptitle']" size="headline"/>

        <x-typography.heading :content="$step['title']" size="5" />
        {{-- Passer en composant --}}
        <div class="wysiwyg">
            {!! $step['content'] !!}
        </div>
    </div>
</div>
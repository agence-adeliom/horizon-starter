<div @if ($containerClass) class="{{ $containerClass }}" @endif>
    <div @if ($contentClass) class="{{ $contentClass }}" @endif>
        @if ($uptitle)
            <x-typography.uptitle :content="$uptitle" />
        @endif

        @if ($title)
            <x-typography.heading :fields="$title" size="3"
                class="mt-headline-title-mobile lg:mt-headline-title-desktop" />
        @endif

        @if ($content)
            <x-typography.text :content="$content" class="mt-title-text-mobile lg:mt-title-text-desktop" />
        @endif

        @isset($buttons)
            <x-action.buttons :buttons="$buttons" class="mt-button-text-mobile max-md:w-full lg:mt-button-text-desktop" />
        @endisset
    </div>

    <div @class(['relative', $mediaClass]) x-data="initMedia()">
        @if ($isImage)
            <x-media.img :image="$image" @class(['rounded-image', 'cover-full' => $ratioClass]) :ratio="$ratioClass" size="large" />
        @elseif($isVideo || $isYouTube)
            @php
                $videoUrl =
                    $isVideo && $video && isset($video['url'])
                        ? $video['url']
                        : 'https://www.youtube.com/embed/' . $idYouTube;
            @endphp
            <x-media.img :image="$thumbnail" @class(['w-full rounded-image', 'cover-full' => $ratioClass]) :ratio="$ratioClass" />

            <a href="{{ $videoUrl }}" data-glightbox x-ref="playMedia"
                class="absolute-full group flex items-center justify-center">
                <div class="btn btn--play">
                    <x-typography.icon icon="play" variant="solid" class="ml-1" />
                </div>
            </a>
        @endif
    </div>
</div>

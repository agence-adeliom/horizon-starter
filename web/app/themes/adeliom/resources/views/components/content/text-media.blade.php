<div @if($containerClass) class="{{ $containerClass }}"@endif>
  <div @if($contentClass) class="{{ $contentClass }}"@endif>
    @if($uptitle)
      <x-typography.uptitle :content="$uptitle"/>
    @endif

    @if($title)
      <x-typography.heading :fields="$title"/>
    @endif

    @if($content)
      <x-typography.text :content="$content"/>
    @endif
  </div>

  <div @if($mediaClass) class="{{ $mediaClass }}"@endif>
    @if($isImage)
      <x-media.img :image="$image" class="cover-full rounded-image" :ratio="$ratioClass"/>
    @elseif($isVideo)
      <x-media.img :image="$thumbnail" class="cover-full" :ratio="$ratioClass"/>
      <x-media.video :video="$video" class="cover-full" :ratio="$ratioClass"/>
    @elseif($isYouTube)
      <x-media.img :image="$thumbnail" class="cover-full" :ratio="$ratioClass"/>
      <x-media.youtube :id="$idYouTube"/>
    @endif
  </div>
</div>

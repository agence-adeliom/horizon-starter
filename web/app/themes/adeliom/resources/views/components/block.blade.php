<section class="{{ $fullClass }}" @if($anchor) id="{{$anchor}}" @endif>
	@isset ($bgImage)
		<x-media.img :image="$bgImage" class="cover-full" size="full" container-class="absolute-full"/>
	@endisset
	@isset($outContainer)
		{{$outContainer}}
	@endisset
	<div class="{{$containerClass}}">
		{{$slot}}
	</div>
</section>
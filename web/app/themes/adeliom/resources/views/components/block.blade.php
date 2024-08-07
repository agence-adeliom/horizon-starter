<section class="{{ $fullClass }}" @if($anchor) id="{{$anchor}}" @endif>
    @isset($outContainer)
    {{$outContainer}}
    @endisset
    <div class="{{$containerClass}}">
        {{$slot}}
    </div>
</section>
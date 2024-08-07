<section class="{{ $fullClass }}" @if($anchor) id="{{$anchor}}" @endif>
    {{$outContainer}}
    <div class="{{$containerClass}}">
        {{$slot}}
    </div>
</section>
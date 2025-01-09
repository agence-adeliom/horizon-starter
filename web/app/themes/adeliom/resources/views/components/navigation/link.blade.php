@if($url && $title)
  <a href="{{ $url }}" @if($target) target="{{ $target }}" @endif>
    @if($icon)
      {!! $icon !!}
    @endif
    <span>
      {{ $title }}
    </span>
  </a>
@endif

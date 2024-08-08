<{{ $tag }}
  class="{{ $fullClass }}"
@if($url)
  href="{{ $url }}"
@endif
@if($id)
  id="{{ $id }}"
@endif
@if($ariaLabel)
  aria-label="{{ $ariaLabel }}"
@endif
@if($target)
  target="{{ $target }}"
@endif>

@if($label)
  {{ $label }}
@endif

</{{ $tag }}>
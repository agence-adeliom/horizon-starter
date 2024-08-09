@if($url)
  <video width="{{ $width }}"
         height="{{ $height }}"
         @if($autoplay) autoplay @endif
         @if($controls) controls @endif>
    <source src="{{ $url }}" @if($mimeType) type="{{ $mimeType }}" @endif>
    @if($unsupportedMessage)
      {{ $unsupportedMessage }}
    @endif
  </video>
@endif

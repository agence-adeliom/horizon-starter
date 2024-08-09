@if($url)
  <div class="{{ $containerClass }}">
    <video width="{{ $width }}"
           height="{{ $height }}"
           @if($class) class="{{ $class }}" @endif
           @if($autoplay) autoplay @endif
           @if($controls) controls @endif>
      <source src="{{ $url }}" @if($mimeType) type="{{ $mimeType }}" @endif>
      @if($unsupportedMessage)
        {{ $unsupportedMessage }}
      @endif
    </video>
  </div>
@endif

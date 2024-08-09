@if($id)
  <div>
    <iframe width="{{ $width }}"
            height="{{ $height }}"
            src="https://www.youtube.com/embed/{{ $id }}"
            @if($title)
              title="{{ $title }}"
            @endif
            frameborder="0"
            @if($allowAttribute)
              allow="{{ $allowAttribute }}"
            @endif
            @if($referrerPolicy)
              referrerpolicy="{{ $referrerPolicy }}"
            @endif
            @if($allowFullscreen) allowfullscreen @endif></iframe>
  </div>
@endif

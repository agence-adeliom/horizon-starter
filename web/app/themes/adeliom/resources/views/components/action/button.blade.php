<{{ $tag }} @class([$fullClass, $attributes['class']]) @if ($url) href="{{ $url }}" @endif
    @if ($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
    @if ($target) target="{{ $target }}" @endif
    @if ($submit) type="submit" @endif {{ $attributes->except(['class']) }}>

    @if ($slot->isEmpty() && $label)
        {{ $label }}
        @if ($icon)
            @svg($icon)
        @endif
    @else
        {{ $slot }}
    @endif
    @if ($fullLink)
        <div class="absolute inset-0"></div>
    @endif

    </{{ $tag }}>

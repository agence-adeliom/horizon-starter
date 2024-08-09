<{{ $tag }} class="{{ $fullClass }}{{ $attributes['class'] ? ' ' . $attributes['class'] : '' }}"
    @if ($url) href="{{ $url }}" @endif
    @if ($id) id="{{ $id }}" @endif
    @if ($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
    @if ($target) target="{{ $target }}" @endif>

    @if ($label)
        {{ $label }}
    @endif

    @if ($icon)
        <x-typography.icon icon="{{ $icon }}" class="{{ $iconClass }}" />
    @endif

    </{{ $tag }}>

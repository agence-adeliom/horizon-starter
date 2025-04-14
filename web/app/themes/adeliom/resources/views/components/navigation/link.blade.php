@if ($url && $title)
    <a href="{{ $url }}" @if ($target) target="{{ $target }}" @endif
        @class(['', $attributes['class']])>
        @if ($icon)
            <x-ui.icon :icon="$icon" class="icon-4" />
        @endif
        {{ $title }}
    </a>
@endif

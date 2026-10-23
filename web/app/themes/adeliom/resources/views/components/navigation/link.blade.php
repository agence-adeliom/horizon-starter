@if ($url && $title)
    <a href="{{ $url }}" @if ($target) target="{{ $target }}" @endif @if ($target === '_blank') rel="noopener" @endif
        @class(['', $attributes['class']])>
        @if ($icon)
            <x-ui.icon :icon="$icon" class="icon-4" />
        @endif
        {{ $title }}
    </a>
@endif

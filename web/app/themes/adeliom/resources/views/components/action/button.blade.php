<x-a
    :tag="$tag"
    class="{{ implode(' ', [$fullClass, $attributes['class'] ?? '']) }}"
    :href="$url"
    :aria-label="$ariaLabel"
    :target="$target"
    :type="$submit ? 'submit' : null"
    :wire-click="$wireClick"
    :handle-livewire-loading="$handleLivewireLoading"
    :tabindex="$tabindex"
    :role="$role"
    :wire-target="$wireTarget"
    :open-auth-form="$openAuthForm"
    :open-newsletter-form="$openNewsletterForm"
    :id="$id"
    :title="$title"
    :obfuscate="$obfuscate"
    :at-click="$atClick"
    :x-show="$xShow"
>
    @if ($handleLivewireLoading)
        <span class="lw-loader animate-spin">
            <x-ui.icon icon="spinner-third" />
        </span>
    @endif

    @if ($slot->isEmpty() && ($label || $iconOnly))
        @if (! $iconOnly)
            <span>{{ $label }}</span>
        @endif

        @if ($icon)
            <x-ui.icon :icon="$icon" :class="$iconClass" />
        @endif
    @else
        {{ $slot }}
    @endif
    @if ($fullLink)
        <div class="absolute inset-0"></div>
    @endif
</x-a>

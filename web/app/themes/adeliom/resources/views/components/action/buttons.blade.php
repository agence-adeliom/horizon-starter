@if ($buttons)
    <div class="{{ $baseClass }}{{ $attributes['class'] ? ' ' . $attributes['class'] : null }}">
        @foreach ($buttons as $button)
            @if ($isLinkFields)
                <x-action.button
                    :link="$button"
                    :type="$loop->first ? $firstButtonType : $secondButtonType"
                    :class="$loop->first ? $firstButtonClass : $secondButtonClass"
                />
            @elseif (! empty($button['link']))
                <x-action.button
                    :fields="$button"
                    :type="$loop->first ? $firstButtonType : $secondButtonType"
                    :class="$loop->first ? $firstButtonClass : $secondButtonClass"
                    :obfuscate="$button['link']['obfuscate'] ?? '0'"
                />
            @endif
        @endforeach
    </div>
@endif

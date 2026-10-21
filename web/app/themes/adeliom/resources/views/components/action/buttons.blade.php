@if ($buttons)
    @php($isList = count($buttons) > 1)

    <{{ $isList ? 'ul' : 'div' }} @if ($isList) role="list" @endif
        class="{{ $baseClass }}{{ $attributes['class'] ? ' ' . $attributes['class'] : null }}">
        @foreach ($buttons as $button)
            @if ($isList)
                <li class="flex flex-col">
            @endif

            @if ($isLinkFields)
                <x-action.button :link="$button" :type="$loop->first ? $firstButtonType : $secondButtonType" :class="$loop->first ? $firstButtonClass : $secondButtonClass" />
            @else
                <x-action.button :fields="$button" :type="$loop->first ? $firstButtonType : $secondButtonType" :class="$loop->first ? $firstButtonClass : $secondButtonClass" :obfuscate="$button['link']['obfuscate'] ?? '0'" />
            @endif

            @if ($isList)
                </li>
            @endif
        @endforeach
        </{{ $isList ? 'ul' : 'div' }}>
@endif

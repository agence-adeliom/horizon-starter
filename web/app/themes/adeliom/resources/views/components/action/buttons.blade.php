@if ($buttons)
    <div class="flex flex-col md:flex-row gap-4{{ $attributes['class'] ? ' ' . $attributes['class'] : null }}">
        @foreach ($buttons as $button)
            @if ($button['link'])
                <x-action.button :object="$button" :type="$loop->first ? 'primary' : 'secondary'" />
            @endif
        @endforeach
    </div>
@endif

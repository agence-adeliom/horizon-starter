@if ($buttons)
    <div class="flex flex-wrap gap-4 {{ $attributes['class'] ? ' ' . $attributes['class'] : null }}">
        @foreach ($buttons as $button)
            @if ($loop->first)
                <x-action.button :object="$button" type="primary" class="max-lg:flex-1" />
            @else
                <x-action.button :object="$button" type="secondary" class="max-lg:flex-1" />
            @endif
        @endforeach
    </div>
@endif

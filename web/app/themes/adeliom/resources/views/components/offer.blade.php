@if ($fields && $fields['enable'])
    <div class="bg-secondary flex items-baseline gap-2 rounded-card p-card w-full {{ $attributes['class'] ?? '' }}">
        <x-far-clock class="flex-none icon-5" />
        <div class="flex-1">
            @if ($fields['uptitle'])
                <x-typography.text :content="$fields['uptitle']" class="text-medium font-semibold mb-2xsmall" />
            @endif
            @if ($fields['wysiwyg'])
                <x-typography.text :content="$fields['wysiwyg']" class="" />
            @endif
        </div>
    </div>
@endif

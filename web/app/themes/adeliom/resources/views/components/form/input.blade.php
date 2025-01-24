<div @class(['input-group', $wrapperClass])>
    <!-- Label -->

    <label for="{{ $id }}" @class([
        'block text-sm font-medium text-gray-700',
        'sr-only' => $hideLabel,
    ])>
        {{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    <!-- Input -->
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => $class]) }} />
</div>

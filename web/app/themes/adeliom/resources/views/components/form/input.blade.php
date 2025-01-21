<div @class(['form-group', $wrapperClass])>
    <!-- Label -->
    @if ($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <!-- Input -->
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => $class]) }} />
</div>

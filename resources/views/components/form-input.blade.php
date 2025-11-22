@props([
    'name' => '',
    'label' => '',
    'type' => 'text',
    'required' => false,
    'value' => '',
    'placeholder' => '',
    'error' => null,
    'urduLabel' => '',
])

<div class="mb-6 relative">
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        class="ultra-input {{ $error ? 'border-red-500 focus:ring-red-500/20' : '' }}"
        {{ $attributes }}
        x-data="{ value: '{{ old($name, $value) }}' }"
        x-model="value"
        @input="value = $event.target.value; $el.classList.toggle('has-value', value.length > 0)"
    />
    
    @if($label)
        <label for="{{ $name }}" class="ultra-floating-label">
            {{ $label }}
            @if($urduLabel)
                <span class="urdu-text text-gray-medium font-normal text-xs">({{ $urduLabel }})</span>
            @endif
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <i data-lucide="check-circle" class="ultra-validation-icon check"></i>
    <i data-lucide="x-circle" class="ultra-validation-icon x"></i>
    
    @if($error)
        <p class="mt-2 text-sm text-red-600 flex items-center">
            <i class="fas fa-exclamation-circle mr-1.5"></i>
            {{ $error }}
        </p>
    @endif
</div>

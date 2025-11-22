@props([
    'type' => 'text',
    'name' => '',
    'label' => '',
    'urduLabel' => '',
    'placeholder' => '',
    'required' => false,
    'value' => '',
    'error' => null,
    'important' => false,
    'icon' => null,
])

@php
    $inputId = $name ?: uniqid('input_');
    $baseClasses = 'w-full px-4 py-3 bg-white border-2 rounded-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2';
    $borderClasses = $error 
        ? 'border-accent-coral focus:border-accent-coral focus:ring-accent-coral/20' 
        : ($important 
            ? 'border-accent-gold focus:border-accent-gold focus:ring-accent-gold/20' 
            : 'border-gray-200 focus:border-primary-green focus:ring-primary-green/20');
    $classes = $baseClasses . ' ' . $borderClasses;
@endphp

<div class="form-group relative mb-6">
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-semibold text-gray-700 mb-2">
            {{ $label }}
            @if($urduLabel)
                <span class="urdu-text text-gray-600 font-normal">({{ $urduLabel }})</span>
            @endif
            @if($required)
                <span class="text-accent-coral">*</span>
            @endif
        </label>
    @endif
    
    <div class="relative">
        @if($icon)
            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
            </div>
        @endif
        
        <input
            type="{{ $type }}"
            id="{{ $inputId }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => $classes . ($icon ? ' pl-10' : '')]) }}
            x-data="{ value: '{{ old($name, $value) }}' }"
            x-model="value"
            @input="value = $event.target.value"
        />
        
        @if($error)
            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-accent-coral">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
            </div>
        @endif
    </div>
    
    @if($error)
        <p class="mt-1 text-sm text-accent-coral flex items-center gap-1">
            <i data-lucide="alert-circle" class="w-4 h-4"></i>
            {{ $error }}
        </p>
    @endif
</div>


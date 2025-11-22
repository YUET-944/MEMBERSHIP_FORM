@props([
    'variant' => 'default', // default, glass, premium
    'padding' => 'p-6',
    'hover' => true,
])

@php
    $baseClasses = 'rounded-lg transition-all duration-300';
    
    $variantClasses = [
        'default' => 'ultra-card',
        'glass' => 'glass-ultra',
        'premium' => 'ultra-card gold-signature',
    ];
    
    $classes = $baseClasses . ' ' . $variantClasses[$variant];
    
    if ($hover) {
        $classes .= ' magnetic-card';
    }
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    <div class="{{ $padding }}">
        {{ $slot }}
    </div>
</div>


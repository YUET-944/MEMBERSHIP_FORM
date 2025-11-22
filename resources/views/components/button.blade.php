@props([
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, tertiary, coral
    'size' => 'md', // sm, md, lg
    'loading' => false,
    'disabled' => false,
    'href' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-semibold transition-all duration-300 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed';
    
    $variantClasses = [
        'primary' => 'ultra-btn-primary',
        'secondary' => 'ultra-btn-secondary',
        'tertiary' => 'ultra-btn-tertiary',
        'coral' => 'coral-action',
    ];
    
    $sizeClasses = [
        'sm' => 'px-4 py-2.5 text-sm',
        'md' => 'px-6 py-3.5 text-base',
        'lg' => 'px-8 py-4 text-lg',
    ];
    
    $classes = $baseClasses . ' ' . $variantClasses[$variant] . ' ' . $sizeClasses[$size];
@endphp

@if($href)
    <a 
        href="{{ $href }}"
        {{ $attributes->merge(['class' => $classes . ' magnetic-hover']) }}
    >
        {{ $slot }}
    </a>
@else
    <button 
        type="{{ $type }}"
        {{ $attributes->merge(['class' => $classes]) }}
        @if($disabled || $loading) disabled @endif
    >
        @if($loading)
            <span class="ultra-loading mr-2"></span>
        @endif
        {{ $slot }}
    </button>
@endif


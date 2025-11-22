@props([
    'type' => 'success', // success, error, warning, info
    'message' => '',
    'duration' => 5000,
])

@php
    $typeClasses = [
        'success' => 'bg-accent-green text-white border-accent-green',
        'error' => 'bg-accent-coral text-white border-accent-coral',
        'warning' => 'bg-yellow-400 text-dark border-yellow-400',
        'info' => 'bg-primary-green text-white border-primary-green',
    ];
    
    $icons = [
        'success' => 'check-circle',
        'error' => 'x-circle',
        'warning' => 'alert-triangle',
        'info' => 'info',
    ];
@endphp

<div 
    x-data="{ show: false }"
    x-init="
        show = true;
        setTimeout(() => { show = false; }, {{ $duration }});
    "
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-2"
    class="fixed top-4 right-4 z-50 max-w-md w-full"
    style="display: none;"
>
    <div class="bg-white rounded-lg shadow-2xl border-2 {{ $typeClasses[$type] }} p-4 flex items-center gap-3">
        <i data-lucide="{{ $icons[$type] }}" class="w-6 h-6 flex-shrink-0"></i>
        <p class="flex-1 font-medium">{{ $message }}</p>
        <button 
            @click="show = false"
            class="flex-shrink-0 hover:opacity-75 transition-opacity"
        >
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>
</div>


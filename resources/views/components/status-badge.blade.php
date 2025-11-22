@props(['status' => 'pending'])

@php
    $classes = [
        'approved' => 'ultra-badge-success',
        'pending' => 'ultra-badge-warning',
        'rejected' => 'ultra-badge-danger',
        'active' => 'ultra-badge-success',
        'inactive' => 'ultra-badge-info',
    ];
    
    $icons = [
        'approved' => 'check-circle',
        'pending' => 'clock',
        'rejected' => 'times-circle',
        'active' => 'check-circle',
        'inactive' => 'pause-circle',
    ];
    
    $labels = [
        'approved' => 'Approved',
        'pending' => 'Pending',
        'rejected' => 'Rejected',
        'active' => 'Active',
        'inactive' => 'Inactive',
    ];
@endphp

<span class="ultra-badge {{ $classes[$status] ?? 'ultra-badge-info' }}">
    <i class="fas fa-{{ $icons[$status] ?? 'info-circle' }} mr-1.5"></i>
    {{ $labels[$status] ?? ucfirst($status) }}
</span>

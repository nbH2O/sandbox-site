@props([
    'label' => null,
    'value' => null
])

<div>
    <span class="text-muted font-bold mb-1 text-sm sm:text-base">
        {{ $label }}
    </span>
    <h4 class="text-base sm:text-h4">
        {{ $value }}
    </h4>
</div>
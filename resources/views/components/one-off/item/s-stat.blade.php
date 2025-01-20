@props([
    'label' => null,
    'value' => null
])

<div>
    <span class="text-muted font-bold mb-1">
        {{ $label }}
    </span>
    <h4>
        {{ $value }}
    </h4>
</div>
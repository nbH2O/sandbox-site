@props([
    'label' => null,
    'value' => null
])

<p class="flex items-center justify-between">
    <span class="text-muted uppercase font-bold">
        {{ $label }}
    </span>
    <span>
        {{ $value }}
    </span>
</p>
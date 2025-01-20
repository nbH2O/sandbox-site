@props([
    'label' => null,
    'value' => null
])

<p class="flex items-center justify-between gap-12">
    <span class="text-muted font-bold">
        {{ $label }}
    </span>
    <span>
        {{ $value }}
    </span>
</p>
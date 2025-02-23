@props([
    'icon' => null,
    'outerClass' => 'text-muted'
])

<div class="relative {{ $outerClass }}">
    <x-input {{ $attributes->merge(['class' => 'w-full']) }} />
    <div class="absolute right-0 top-0 h-full flex items-center px-3">
        @svg($icon, [
            'class' => 'size-5'
        ])
    </div>
</div>
@props([
    'icon' => null,
    'label' => null
])

<a {!! $attributes->merge([
    'class' => 'cursor-pointer flex gap-2 items-center px-2 h-9'
]) !!}>
    @svg($icon, [
        'class' => 'size-5'
    ])
    <span>{{ $label }}</span>
</a>
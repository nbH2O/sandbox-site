@props([
    'icon' => null,
    'title' => null,
])

<a {!! $attributes->merge([
    'class' => 'flex justify-center items-center h-9 grow border-b border-b-4 font-bold select-none cursor-pointer border-border-light dark:border-border-dark data-[active]:border-primary data-[disabled]:text-muted-2'
]) !!}>
    @if ($icon)
        @svg($icon, [
            'class' => 'size-5 me-2 -ms-0.5'
        ])
    @endif
    <span>
        {{ $title }}
    </span>
</a>

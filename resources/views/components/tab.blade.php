@props([
    'icon' => null,
    'title' => null,
    'style' => 'underline',
    'styleVals' => [
        'underline' => 'border-b border-b-4 font-bold border-border-light dark:border-border-dark data-[active]:border-primary',
        'solid' => 'px-3 data-[active]:bg-primary'
    ]
])

<a {!! $attributes->merge([
    'class' => $styleVals[$style].' flex justify-center items-center h-9 grow  select-none cursor-pointer   data-[disabled]:text-muted-2'
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

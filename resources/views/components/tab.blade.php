@props([
    'icon' => null,
    'title' => null,
    'active' => false,
    'activeVals' => [
        true => 'border-b-[#00a9fe]',
        false => 'border-border-light dark:border-border-dark'
    ]
])

<a {!! $attributes->merge([
    'class' => 'flex justify-center items-center h-10 grow border-b border-b-4 font-bold select-none cursor-pointer '.$activeVals[$active]
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

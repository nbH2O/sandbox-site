@props([
    'icon' => null,
    'label' => null,

    'badgeColor' => 'blue',
    'badgeColorVals' => [
        'primary' => 'bg-primary',
        'blue' => 'bg-blue',
        'green' => 'bg-green',
        'yellow' => 'bg-yellow',
        'red' => 'bg-red',
        'gray' => 'bg-[#455A7E]',
        'transparent' => ''
    ],
])

<span {!! $attributes->merge([
    'class' => 'cursor-pointer h-full pe-2.5 flex justify-center items-center'
]) !!}>
    <span class="relative">
        <span>
            @svg($icon, [
                'class' => 'size-6'
            ])
        </span>
        @if ($label)
            <span class="w-0 absolute bottom-[50%] left-[50%]">
                <span class=" flex justify-center items-center border-[#19191c] border-2 {{ $badgeColorVals[$badgeColor] }} text-xs  w-6 h-5">
                    {{ $label }}
                </span>
            </span>
        @endif
    </span>
</span>
@props([
    'icon' => null,
    'label' => null,

    'badgeColor' => 'blue',
    'badgeColorVals' => [
        'primary' => 'from-[#b166fb] to-[#9333EA]',
        'blue' => 'from-[#00A9FE] to-[#007CDC]',
        'green' => 'from-[#00ba42] to-[#007F22]',
        'yellow' => 'from-[#f5ba00] to-[#e99500]',
        'red' => 'from-[#fb3d3e] to-[#c90e16]',
        'gray' => 'dark:from-[#43434a] dark:to-[#2f2f33] to-[#52525b] from-[#71717a]'
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
                <span class="rounded-[0.2rem] flex justify-center items-center border-[#19191c] border-2 {{ $badgeColorVals[$badgeColor] }} text-xs bg-gradient-to-b w-6 h-5">
                    {{ $label }}
                </span>
            </span>
        @endif
    </span>
</span>
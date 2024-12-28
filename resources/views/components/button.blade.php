@props([
    'size' => 'md',
    'sizeVals' => [
        'sm' => [
            'outer' => 'h-9',
            'inner' => 'px-3',
            'busy' => 'size-6'
        ],
        'md' => [
            'outer' => 'h-10',
            'inner' => 'px-4',
            'busy' => 'size-7'
        ],
        'lg' => [
            'outer' => 'h-11',
            'inner' => 'px-5',
            'busy' => 'size-8'
        ],
    ],

    'color' => 'blue',
    'colorVals' => [
        'primary' => 'from-[#b166fb] to-[#9333EA]',
        'blue' => 'from-[#00A9FE] to-[#007CDC]',
        'green' => 'from-[#00ba42] to-[#007F22]',
        'yellow' => 'from-[#f5ba00] to-[#e99500]',
        'red' => 'from-[#fb3d3e] to-[#c90e16]',
        'gray' => 'from-[#43434a] to-[#2f2f33]'
    ],

    'type' => 'solid',
    'typeVals' => [
        'solid' => null,
        'outline' => 'bg-body text-body'
    ],

    'busy' => false
])
<a class="{{ $colorVals[$color].' '.$sizeVals[$size]['outer'] }} cursor-pointer select-none text-dark rounded-sm bg-gradient-to-b p-[4px]">
    <span {!! $attributes->merge([
        'class' => 'w-full h-full relative flex justify-center items-center rounded-sm '.$typeVals[$type].' '.$sizeVals[$size]['inner']
    ]) !!}>
        @if ($busy == true || $busy == 'true')
            <x-ri-loader-5-fill class="drop-shadow absolute m-auto animate-spin {{ $sizeVals[$size]['busy'] }}" />
        @endif
        <span class="drop-shadow uppercase {{ $busy ? 'opacity-0' : null }}">
            {{ $slot }}
        </span>
    </span>
</a>
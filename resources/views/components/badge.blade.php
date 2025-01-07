@props([
    'innerClass' => null,

    'size' => 'md',
    'sizeVals' => [
        'md' => [
            'outer' => 'h-5 px-2 text-xs',
            'busy' => 'size-5'
        ],
        'lg' => [
            'outer' => 'h-6 px-2.5 text-xs',
            'busy' => 'size-5'
        ]

    ],

    'color' => 'blue',
    'colorVals' => [
        'primary' => 'bg-primary',
        'blue' => 'bg-blue',
        'green' => 'bg-green',
        'yellow' => 'bg-yellow',
        'red' => 'bg-red',
        'gray' => 'bg-[#455A7E]',
        'transparent' => ''
    ],

])

<a {!! $attributes->merge([
    'class' => $sizeVals[$size]['outer'].' '.$colorVals[$color].' flex justify-center items-center cursor-pointer select-none text-dark rounded-full group'
]) !!}>
        <x-ri-loader-5-fill class="hidden group-data-[busy]:block  absolute m-auto animate-spin {{ $sizeVals[$size]['busy'] }}" />
        <span class="h-full w-full group-data-[busy]:opacity-0 flex justify-center items-center {{ $innerClass }}">
            {{ $slot }}
        </span>
</a>
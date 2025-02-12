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
        'primary' => 'bg-primary text-dark',
        'blue' => 'bg-blue text-dark',
        'green' => 'bg-green text-dark',
        'yellow' => 'bg-yellow text-dark',
        'red' => 'bg-red text-dark',
        'gray' => 'bg-[#455A7E] text-dark',
        'transparent' => '',
        'special' => 'bg-special text-light'
    ],

])

<a {!! $attributes->merge([
    'class' => $sizeVals[$size]['outer'].' '.$colorVals[$color].' flex justify-center items-center cursor-pointer select-none group'
]) !!}>
        <x-ri-loader-5-fill class="hidden group-data-[busy]:block  absolute m-auto animate-spin {{ $sizeVals[$size]['busy'] }}" />
        <span class="h-full w-full group-data-[busy]:opacity-0 flex justify-center items-center {{ $innerClass }}">
            {{ $slot }}
        </span>
</a>
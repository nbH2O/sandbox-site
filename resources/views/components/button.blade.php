@props([
    'aspect' => false,

    'size' => 'md',
    'sizeVals' => [
        'sm' => [
            's' => [
                true => 'size-7',
                false => 'px-3 h-7'
            ],
            'main' => 'text-sm',
            'busy' => 'size-5'
        ],
        'md' => [
            's' => [
                true => 'size-9',
                false => 'px-4 h-9'
            ],
            'main' => '',
            'busy' => 'size-7'
        ],
        'lg' => [
            's' => [
                true => 'size-12',
                false => 'px-5 h-12'
            ],
            'main' => 'text-lg',
            'busy' => 'size-9'
        ],
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
    'class' => $sizeVals[$size]['s'][$aspect].' '.$sizeVals[$size]['main'].' '.$colorVals[$color].' flex justify-center cursor-pointer select-none text-dark  p-[4px] group'
]) !!}>
        <x-ri-loader-5-fill class="hidden group-data-[busy]:block  absolute m-auto animate-spin {{ $sizeVals[$size]['busy'] }}" />
        <span class="h-full w-full group-data-[busy]:opacity-0 flex justify-center items-center">
            {{ $slot }}
        </span>
</a>
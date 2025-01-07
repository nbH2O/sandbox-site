@props([

    'size' => 'md',
    'sizeVals' => [
        'sm' => [
            'outer' => 'h-8',
            'inner' => 'px-3 text-sm',
            'busy' => 'size-5'
        ],
        'md' => [
            'outer' => 'h-10',
            'inner' => 'px-4',
            'busy' => 'size-7'
        ],
        'lg' => [
            'outer' => 'h-12',
            'inner' => 'px-5 text-lg',
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
    'class' => $sizeVals[$size]['outer'].' '.$sizeVals[$size]['inner'].' '.$colorVals[$color].' flex justify-center cursor-pointer select-none text-dark rounded-sm  p-[4px] group'
]) !!}>
        <x-ri-loader-5-fill class="hidden group-data-[busy]:block  absolute m-auto animate-spin {{ $sizeVals[$size]['busy'] }}" />
        <span class="h-full w-full group-data-[busy]:opacity-0  uppercase flex justify-center items-center">
            {{ $slot }}
        </span>
</a>
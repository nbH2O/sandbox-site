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
        'primary' => 'from-[#b166fb] to-[#9333EA]',
        'blue' => 'from-[#00A9FE] to-[#007CDC]',
        'green' => 'from-[#00ba42] to-[#007F22]',
        'yellow' => 'from-[#f5ba00] to-[#e99500]',
        'red' => 'from-[#fb3d3e] to-[#c90e16]',
        'gray' => 'dark:from-[#43434a] dark:to-[#2f2f33] to-[#52525b] from-[#71717a]',
        'transparent' => ''
    ],

])
<a {!! $attributes->merge([
    'class' => $sizeVals[$size]['outer'].' '.$sizeVals[$size]['inner'].' '.$colorVals[$color].' flex justify-center cursor-pointer select-none text-dark rounded-sm bg-gradient-to-b p-[4px] group'
]) !!}>
        <x-ri-loader-5-fill class="hidden group-data-[busy]:block drop-shadow absolute m-auto animate-spin {{ $sizeVals[$size]['busy'] }}" />
        <span class="h-full w-full group-data-[busy]:opacity-0 drop-shadow uppercase flex justify-center items-center">
            {{ $slot }}
        </span>
</a>
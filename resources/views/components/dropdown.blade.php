@props([
    'align' => 'left',
    'alignVals' => [
        'left' => 'left-[-0.1rem]',
        'right' => 'right-[-0.1rem]',
        'center' => 'left-[50%] -translate-x-[50%]'
    ],

    'innerClick' => true,
    'yAdjust' => true
])

<div {!! $attributes->merge(['class' => 'relative overflow-visible']) !!} x-data="{ open: false }">
    <div class="cursor-pointer flex" x-on:click="open = !open">
        {{ $trigger }}
    </div>


    @svg('ri-triangle-fill', [
        'class' => 'text-[#222226] dark:text-[#19191c] absolute top-full size-[1rem] left-[50%] -translate-x-[50%]',
        'x-show' => 'open'
    ])
    <div x-on:click="{{ $innerClick ? 'open = !open' : null }}" x-on:click.away="open = false" class="{{ $alignVals[$align] }} z-[1000] {{ $yAdjust ? 'py-0.5' : null }} min-w-44 bg-[#222226] dark:bg-header rounded-sm absolute top-[calc(100%_+_0.84rem)]" x-show="open">
        {{ $slot }}
    </div>
</div>
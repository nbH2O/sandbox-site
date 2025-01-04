@props([
    'size' => 'md',
    'sizeVals' => [
        'md' => 'w-96'
    ],

    'title' => null
])

<div class="overflow-visible" x-data="{ open: {{ isset($trigger) ? 'false' : 'true' }} }">
    @if (isset($trigger))
        <div class="cursor-pointer" x-on:click="open = !open">
            {{ $trigger }}
        </div>
    @endif

    <template x-teleport="body">
        <div class="z-[50000000000] absolute top-0 left-0 w-screen h-screen flex justify-center items-center" x-show="open">
            <div {!! $attributes->merge(['class' => $sizeVals[$size].' flex flex-col z-10 max-w-full rounded-sm bg-body p-3']) !!}>
                <div class="px-1 flex justify-between items-center">
                    <h4>{{ $title }}</h4>
                    @svg('ri-close-fill', [
                        'x-on:click' => 'open = !open',
                        'class' => 'size-6 text-muted-2 cursor-pointer'
                    ])
                </div>
                <div class="px-1 pt-2 flex-1">
                    {{ $slot }}
                </div>
                @if (isset($actions))
                    <div class="flex gap-3 mt-2 justify-end">
                        {{ $actions }}
                    </div>
                @endif
            </div>
            <div x-on:click="open = !open" class="backdrop-blur-[1px] w-full h-full bg-black/20 absolute top-0 left-0">

            </div>
        </div>
    </template>
    
</div>
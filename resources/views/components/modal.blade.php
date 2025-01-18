@props([
    'size' => 'md',
    'sizeVals' => [
        'md' => 'w-96'
    ],

    'title' => null
])

<div class="overflow-visible" x-data="{ open: {{ isset($trigger) ? 'false' : 'true' }} }">
    @if (isset($trigger))
        <div class="cursor-pointer flex" x-on:click="open = !open">
            {{ $trigger }}
        </div>
    @endif

    <template x-teleport="body">
        <div class="z-[50000000000] absolute top-0 left-0 w-screen h-screen flex justify-center items-center" x-show="open">
            <div {!! $attributes->merge(['class' => $sizeVals[$size].' flex flex-col z-10 max-w-full rounded-[1.25rem] overflow-hidden bg-body']) !!}>
                <div class="dark bg-header p-2 flex justify-between items-center">
                    <h5 class="ms-1">{{ $title }}</h5>
                    <x-button color="red" size="sm" :aspect="true" x-on:click="open = false">
                        <span class="text-lg mb-[0.1rem] me-[0.05rem]">x</span>
                    </x-button>
                </div>
                <div class="px-3 pb-2 pt-3 flex-1">
                    {{ $slot }}
                </div>
                @if (isset($actions))
                    <div class="flex gap-2 p-2 justify-end">
                        {{ $actions }}
                    </div>
                @endif
            </div>
            <div x-on:click="open = !open" class="backdrop-blur-[1px] w-full h-full bg-black/20 absolute top-0 left-0">

            </div>
        </div>
    </template>
    
</div>
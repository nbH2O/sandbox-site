<div class="flex flex-col gap-4">
    <div class="relative bg-header" x-data="{ mode: 'preview' }">
        <img wire:loading.class="opacity-50" class="w-full" x-bind:class="(mode != 'preview' ? 'opacity-0' : null)" src="{{ $url }}" >
        <div x-bind:class="(mode != 'preview' ? 'flex' : 'hidden')" class="absolute top-0 left-0 w-full h-full flex-col gap-1 justify-center items-center">
            <input type="color" class="size-[4.5rem] p-0 rounded" value="{{ $properties->head_color }}" x-on:change="$wire.changeColor('head', $el.value)" />
            <div class="flex gap-1 justify-center">
                <input type="color" class="h-32 w-16 rounded" value="{{ $properties->arm_right_color }}" x-on:change="$wire.changeColor('arm_right', $el.value)" />
                <input type="color" class="size-32 rounded" value="{{ $properties->torso_color }}" x-on:change="$wire.changeColor('torso', $el.value)" />
                <input type="color" class="h-32 w-16 rounded" value="{{ $properties->arm_left_color }}" x-on:change="$wire.changeColor('arm_left', $el.value)" />
            </div>
            <div class="flex gap-1 justify-center">
                <input type="color" class="h-32 w-16 rounded" value="{{ $properties->leg_right_color }}" x-on:change="$wire.changeColor('leg_right', $el.value)" />
                <input type="color" class="h-32 w-16 rounded" value="{{ $properties->leg_left_color }}" x-on:change="$wire.changeColor('leg_left', $el.value)" />
            </div>
        </div>
        <div class="absolute bottom-0 left-0 m-2 flex gap-2">
            <x-button color="green" x-on:click.prevent="$wire.saveAvatar()" wire:loading.attr="data-busy">
                @svg('ri-loop-right-line', [
                    'class' => 'size-6'
                ])
            </x-button>
            <x-button color="yellow" x-on:click="(mode == 'palette') ? mode = 'preview' : mode = 'palette'">
                @svg('ri-palette-fill', [
                    'class' => 'size-6'
                ])
            </x-button>
        </div>
    </div>
    @if ($rateLimited)
        <div class="bg-red p-4">
            <h5 class="mb-2">{{ __('Slow down!') }}</h5>
            <p>{{ __('You have been rendering your avatar too frequently, please wait a few minutes until you try again.') }}</p>
        </div>
    @endif
</div>
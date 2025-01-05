@props([
    'size' => 'lg',
    'sizeVals' => [
        // this is really only for login dropdown on header
        'md' => [
            'form' => 'gap-2',
            'error' => 'text-xs font-bold block'
        ],
        'lg' => [
            'form' => 'gap-4',
            'error' => 'text-sm'
        ]
    ]
])

<form class="{{ $sizeVals[$size]['form'] }} [&>*]:w-full flex flex-col">
    {{ csrf_field() }}
    <div>
        <x-input wire:model="username" class="w-full" name="username" size="{{ $size }}" placeholder="{{ __('Username') }}" />
        @error('username')
            <span class="text-red {{ $sizeVals[$size]['error'] }}">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <x-input wire:model="password" class="w-full" name="password" size="{{ $size }}" placeholder="{{ __('Password') }}" />
        @error('password')
            <span class="text-red {{ $sizeVals[$size]['error'] }}">{{ $message }}</span>
        @enderror
    </div>
    <x-checkbox 
        wire:model="remember"
        name="remember"
        label="{{ __('Remember Me') }}"
    />
    <div>
        @error('general')
            <span class="text-red {{ $sizeVals[$size]['error'] }}">{{ $message }}</span>
        @enderror
        <div class="flex">
            <x-button x-on:click="$wire.submit()" wire:loading.attr="data-busy" outerClass="grow" color="green" size="{{ $size }}">{{ __('Submit') }}</x-button>
        </div>
    </div>
</form>

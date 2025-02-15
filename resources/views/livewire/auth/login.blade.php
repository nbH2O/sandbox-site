@props([
    'size' => 'lg',
    'sizeVals' => [
        // this is really only for login dropdown on header
        'md' => [
            'form' => 'gap-2',
            'error' => 'text-xs font-bold block',
            'extras' => false
        ],
        'lg' => [
            'form' => 'gap-4',
            'error' => 'text-sm',
            'extras' => true
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
        <x-button class="w-full" x-on:click.prevent="$wire.submit()" wire:loading.attr="data-busy" color="green" size="{{ $size }}">{{ __('Submit') }}</x-button>
    </div>
    <div>
        @if ($sizeVals[$size]['extras'])
            <p class="mb-2">{{ __('Looking for something else?') }}</p>
        @endif
        <div class="flex gap-4 [&>*]:grow">
            @if ($sizeVals[$size]['extras'])
                <x-button href="{{ route('register') }}" size="md" color="primary">{{ __('Join') }}</x-button>
            @endif
            <x-modal title="{{ __('Login Help') }}">
                <x-slot name="trigger">
                    <x-button class="w-full" x-on:click.prevent size="{{ $sizeVals[$size]['extras'] ? 'md' : 'sm' }}" color="{{ $sizeVals[$size]['extras'] ? 'gray' : 'transparent' }}">{{ __('Help') }}</x-button>
                </x-slot>

                <div class="flex flex-col gap-4">
                    <div>
                        <p>{{ __('Forgot Password?') }}</p>
                        <x-button class="ms-auto" color="blue">{{ __('Recover Password') }}</x-button>
                    </div>
                    <div>
                        <p>{{ __('Forgot Username?') }}</p>
                        <x-button class="ms-auto" color="blue">{{ __('Recover Username') }}</x-button>
                    </div>
                    <div>
                        <p>{{ __('Forgot Password?') }}</p>
                        <x-button class="ms-auto" color="blue">{{ __('Contact Us') }}</x-button>
                    </div>
                </div>
            </x-modal>
        </div>
    </div>
</form>

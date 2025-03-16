<div class="flex flex-col md:flex-row gap-6">
    <form class="gap-6 [&>*]:w-full flex flex-col basis-full md:basis-1/2">
        {{ csrf_field() }}
        <div>
            <p class="mb-2">{{ __('Username') }}</p>
            <x-input wire:model.live.debounce.300ms="username" class="w-full" name="username" size="{{ $size }}" placeholder="{{ __('Username') }}" />
            @error('username')
                <span class="text-red text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <p class="mb-2">{{ __('Email') }}</p>
            <x-input wire:model="email" class="w-full" name="email" size="{{ $size }}" placeholder="{{ __('Email') }}" />
            @error('email')
                <span class="text-red text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <p class="mb-2">{{ __('Password') }}</p>
            <x-input wire:model="password" type="password" class="w-full" name="password" size="{{ $size }}" placeholder="{{ __('Password') }}" />
            @error('password')
                <span class="text-red text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <p class="mb-2">{{ __('Confirm Password') }}</p>
            <x-input wire:model="password_confirmation" type="password" class="w-full" name="password_confirmation" size="{{ $size }}" placeholder="{{ __('Confirm Password') }}" />
            @error('password_confirmation')
                <span class="text-red text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            @error('general')
                <span class="text-red text-sm">{{ $message }}</span>
            @enderror
            <x-button class="w-full" x-on:click.prevent="$wire.submit()" wire:loading.attr="data-busy" color="green" size="{{ $size }}">{{ __('Submit') }}</x-button>
        </div>
    </form>
    <div class="basis-full md:basis-1/2 flex flex-col gap-5">
        <div class="border-[2px] border-primary">
            <div class="px-4 py-3 bg-primary">
                <h4>{{ __('Choosing a Username') }}</h4>
            </div>
            <div class="px-4 py-3">
                <ul>
                    <li>{{ __('Can contain letters, numbers') }}</li>
                    <li>{{ __('Can contain 1 of each: space, underscore, dash, period') }}</li>
                    <li>{{ __('Minimum 3 characters') }}</li>
                    <li>{{ __('Maximum 20 characters') }}</li>
                </ul>
            </div>
        </div>
        <div class="border-[2px] border-blue">
            <div class="px-4 py-3 bg-blue">
                <h4>{{ __('Use a real email!') }}</h4>
            </div>
            <div class="px-4 py-3">
                <p>{{ __('Accounts without a verified email can be deleted, and many features require a verified email!') }}</p>
            </div>
        </div>
    </div>
</div>

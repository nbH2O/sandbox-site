<form class="[&>*]:mb-4 [&>*]:w-full">
    {{ csrf_field() }}
    <div>
        <x-input wire:model="username" class="w-full" name="username" size="lg" placeholder="{{ __('Username') }}" />
        @error('username')
            <span class="text-red text-sm">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <x-input wire:model="password" class="w-full" name="password" size="lg" placeholder="{{ __('Password') }}" />
        @error('password')
            <span class="text-red text-sm">{{ $message }}</span>
        @enderror
    </div>
    <x-checkbox 
        wire:model="remember"
        name="remember"
        label="{{ __('Remember Me') }}"
    />
    @error('general')
        <span class="text-red text-sm">{{ $message }}</span>
    @enderror
    <div class="flex">
        <x-button x-on:click="$wire.submit()" wire:loading.attr="data-busy" outerClass="grow" color="green" size="lg">{{ __('Submit') }}</x-button>
    </div>
</form>

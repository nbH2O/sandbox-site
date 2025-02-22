<div class="flex flex-col sm:flex-row gap-4" x-data="{ tab: 'profile' }">
    <div>
        <x-tab-list :vertical="true" class="w-full sm:w-48">
            <x-tab 
                style="solid"
                x-on:click="tab = 'profile'"
                x-bind:data-active="tab == 'profile'"
                title="{{ __('Profile') }}"
            />
            <x-tab 
                style="solid"
                x-on:click="tab = 'account'"
                x-bind:data-active="tab == 'account'"
                title="{{ __('Account') }}"
            />
        </x-tab-list>
    </div>
    <div class="bg-border-light dark:bg-border-dark h-[2px] sm:h-auto sm:w-[2px]"></div>
    <div x-show="tab == 'profile'" class="flex flex-col gap-4">
        <div class="flex gap-4">
            <div>
                <p>{{ __('Username') }}</p>
                <x-input disabled value="{{ Auth::user()->name }}" />
            </div>
            <div>
                <p>{{ __('Password') }}</p>
                <x-input disabled type="password" value="the j the j j" />
            </div>
        </div>
        <div x-data="{ description: '{{ Auth::user()->description }}' }">
            <p>{{ __('Description') }}</p>
            <x-textarea x-model="description">
                <x-button 
                    x-on:click="$wire.saveDescription(description)"
                    wire:loading.attr="data-busy" 
                    class="absolute bottom-0 right-0 m-2" 
                    size="sm" color="blue"
                >
                    {{ __('Save') }}
                </x-button>
            </x-textarea>
            @error('newDescription')
                <small class="text-red">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>

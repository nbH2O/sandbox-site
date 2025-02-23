<x-layout.app
    title="{{ __('Settings') }}"
    :pageTitle="true"
    containerClass="w-[50rem]"
>
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
                @livewire('user.settings.change-password')
            </div>
            @livewire('user.settings.change-description')
        </div>
    </div>
</x-layout.app>
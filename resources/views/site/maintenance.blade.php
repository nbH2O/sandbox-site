<x-layout.app
    title="Under Maintenace"
>
    <div class="max-w-full w-[30rem]">
        <h3 class="mb-1">{{ __('Under Maintenance') }}</h3>
        <p class="mb-3">{{ $message ?? __('The site is currently under maintenance') }}</p>

        <x-modal title="{{ __('Log in') }}">
            <x-slot name="trigger">
                <x-button>
                    {{ __('Bypass') }}
                </x-button>
            </x-slot>
    
            @livewire('auth.login')
        </x-modal>
    </div>
</x-layout.app>
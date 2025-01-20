<x-layout.app
    title="{{ __('Log in') }}"
>
    <div class="flex justify-center max-w-full w-[21rem]">
        <div class="flex-1 flex flex-col gap-4">
            <h2>{{ __('Log in') }}</h2>
            @livewire('auth.login')
        </div>
    </div>
</x-layout.app>
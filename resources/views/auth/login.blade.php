<x-layout.app>
    <div class="flex justify-center max-w-full w-[20rem]">
        <div class="flex-1 flex flex-col gap-2">
            <h2>{{ __('Log in') }}</h2>
            @livewire('auth.login')
        </div>
    </div>
</x-layout.app>
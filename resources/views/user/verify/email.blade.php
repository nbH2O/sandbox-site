<x-layout.app
    title="{{ __('Verify Email') }}"
    :pageTitle="true"
    containerClass="w-[40rem]"
>
    <div class="flex flex-col gap-4">
        @if($success === true)
            <h5>{{ __('Verificaton successful!') }}</h5>
        @else
            <h5>{{ __('Verificaton was not successful') }}</h5>
        @endif
        
        <div class="flex">
            <x-button color="blue" href="/">Home</x-button>
        </div>
    </div>
</x-layout.app>
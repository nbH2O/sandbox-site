<x-layout.app
    title="{{ __('Feature Disabled') }}"
>
    <div class="max-w-full w-[30rem]">
        <h3 class="mb-1">{{ __('Feature Disabled') }}</h3>
        <p>{{ $message ?? __('This feature is currently disabled') }}</p>
    </div>
</x-layout.app>
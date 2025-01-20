<x-layout.app
    title="{{ __('Banned') }}"
>
    <div class="max-w-full w-[50rem]">
        <h3 class="mb-1">{{ __("Your account is suspended") }}</h3>
        <p class="mb-2">
            {{ __('We have found that your account is in violation of our Terms of Service.') }}
            {{ __('Further violations will result in a termination of your account.') }}
        </p>
        <x-card>
            <p>
                <span class="font-bold">{{ __('Suspension expires:') }}</span>
                &nbsp;
                {{ $ban->expired_at->diffForHumans() }}
            </p>
            <p class="mt-3">
                <span class="font-bold">{{ __('Message:') }}</span>
                &nbsp;
                {{ $ban->comment }}
            </p>
        </x-card>
        <p class="mt-2">
            {{ __('Please be sure to read the Terms of Service when your suspension expires.') }}
            <br />
            {{ __('If you would like to appeal, visit the') }}
            <a href="" class="text-blue hover:underline">{{ __('contact page.') }}</a>
        </p>
    </div>
</x-layout.app>
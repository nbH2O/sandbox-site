<x-layout.app>
    <div class="max-w-full w-[50rem] flex-wrap flex flex-col md:flex-row">
        <div class="w-full md:w-[calc(50%_-_calc(1px_+0.75rem))] flex flex-col bg-glow">
            <h3 class="flex items-center gap-2"><x-ri-circle-fill class="{{ ($user->online_at > now()->subMinutes(4)) ? 'text-[#00A437]' : 'text-border-light dark:text-border-dark' }} size-2.5" />{{ $user->name }}</h3>
            <div class="flex flex-1 flex-col items-center gap-4">
                <img class="w-3/4 aspect-square" src="{{ $user->avatar_hash ?? Vite::asset('resources/assets/default_renders/user.png') }}" />
                <div class="flex gap-4">
                    <x-button color="green">{{ __('Friend') }}</x-button>
                    <x-button color="blue">{{ __('Message') }}</x-button>
                    <x-button color="yellow">{{ __('Trade') }}</x-button>
                </div>
            </div>
            @if ($user->roles)
                <div class="flex gap-4 items-center justify-center mt-4">
                    @foreach ($user->roles as $role)
                        <div class="flex gap-1 items-center justify-center">
                            @svg($role->icon, [
                                'style' => 'color: '.$role->color,
                                'class' => 'h-7'
                            ])
                            <h6 class="uppercase">{{ $role->name }}</h6>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="w-full h-[2px] md:w-[2px] md:h-auto mt-3 md:mt-0 md:mx-3 bg-border-light dark:bg-border-dark"></div>
        <div class="order-3 md:order-none w-full md:w-[calc(50%_-_calc(1px_+0.75rem))] flex flex-col gap-4">
            <x-one-off.user.profile-snippet title="{{ __('Awards') }}">

            </x-one-off.user.profile-snippet>
            <x-one-off.user.profile-snippet title="{{ __('Groups') }}">

            </x-one-off.user.profile-snippet>
            <x-one-off.user.profile-snippet title="{{ __('Friends') }}">

            </x-one-off.user.profile-snippet>
        </div>
        @if ($user->description)
            <div class="w-full py-4">
                <h4 class="mb-1">{{ __('Description') }}</h4>
                <p>{{ $user->description }}</p>
            </div>
        @endif
    </div>
</x-layout.app>
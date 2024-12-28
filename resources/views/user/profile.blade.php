<x-layout.app>
    <div class="max-w-full w-[50rem]">
        <div class="flex gap-3.5">
            <div class="basis-1/2 flex flex-col bg-glow">
                <h3 class="flex items-center gap-2"><x-ri-circle-fill class="text-[#00A437] size-2.5" />{{ $user->name }}</h3>
                <div class="flex flex-1 flex-col items-center gap-4">
                    <img class="w-3/4 aspect-square" src="{{ $user->avatar_hash ?? Vite::asset('resources/assets/default_renders/user.png') }}" />
                    <div class="flex gap-4">
                        <x-button color="green">{{ __('Friend') }}</x-button>
                        <x-button color="blue">{{ __('Message') }}</x-button>
                        <x-button color="yellow">{{ __('Trade') }}</x-button>
                    </div>
                </div>
                @if ($user->role || $user->membership)
                    <div class="flex gap-4 items-center justify-center mt-4">
                        @if ($user->role)
                            <div class="flex gap-1 items-center justify-center">
                                @svg($user->role->icon, [
                                    'style' => 'color: '.$user->role->color,
                                    'class' => 'size-7'
                                ])
                                <h6 class="uppercase">{{ $user->role->name }}</h6>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
            <div class="w-[2px] bg-[#333]"></div>
            <div class="basis-1/2 flex flex-col gap-4">
                <x-one-off.user.profile-snippet title="{{ __('Awards') }}">

                </x-one-off.user.profile-snippet>
                <x-one-off.user.profile-snippet title="{{ __('Groups') }}">

                </x-one-off.user.profile-snippet>
                <x-one-off.user.profile-snippet title="{{ __('Friends') }}">

                </x-one-off.user.profile-snippet>
            </div>
        </div>
        @if ($user->description)
            <div class="py-4">
                <h4 class="mb-1">{{ __('Description') }}</h4>
                <p>{{ $user->description }}</p>
            </div>
        @endif
    </div>
</x-layout.app>
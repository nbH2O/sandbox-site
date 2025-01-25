<x-layout.app
    title="{{ $user->getName() }}"
>
    <div class="max-w-full w-[50rem] flex-wrap flex flex-col md:flex-row">
        <div class="w-full md:w-[calc(50%_-_calc(1px_+0.75rem))] flex flex-col bg-glow">
            <h3 class="flex items-center gap-2"><x-ri-circle-fill class="{{ ($user->online_at > now()->subMinutes(4)) ? 'text-[#00A437]' : 'text-border-light dark:text-border-dark' }} size-2.5" />{{ $user->getName() }}</h3>
            <div class="flex flex-1 flex-col items-center gap-4">
                <img class="w-3/4 aspect-square" src="{{ $user->getRender() }}" />
                @if (Auth::user())
                    @if ($user->id != Auth::user()->id)
                        <div class="flex gap-3">
                            @livewire('user.friend-button', [
                                'user' => $user
                            ])
                            <x-button color="blue">@svg('ri-discuss-fill', ['class' => 'size-5'])</x-button>
                            <x-button color="yellow">@svg('ri-swap-2-fill', ['class' => 'size-5'])</x-button>
                        </div>
                    @endif
                @endif
            </div>
            @if ($user->roles)
                <div class="flex gap-4 items-center justify-center mt-4">
                    @foreach ($user->roles as $role)
                        <x-one-off.user.role 
                            :role="$role"
                        />
                    @endforeach
                </div>
            @endif
        </div>
        <div class="w-full h-[2px] md:w-[2px] md:h-auto mt-3 md:mt-0 md:mx-3 bg-border-light dark:bg-border-dark"></div>
        <div class="[&>*]:h-1/3 order-3 md:order-none w-full md:w-[calc(50%_-_calc(1px_+0.75rem))] flex flex-col gap-4">
            <x-one-off.user.profile-snippet title="{{ __('Awards') }}">

            </x-one-off.user.profile-snippet>
            <x-one-off.user.profile-snippet title="{{ __('Groups') }}">

            </x-one-off.user.profile-snippet>
            <x-one-off.user.profile-snippet title="{{ __('Friends') }}">
                @foreach ($user->friends as $friend)
                    <div class="w-1/4 flex flex-col justify-center relative">
                        <a class="absolute top-0 left-0 h-full w-full" href="{{ $friend->getLink() }}">
                        </a>
                        <img class="bg-glow" src="{{ $friend->getRender() }}" />
                        <p class="flex gap-1 items-center justify-center">
                            @if ($friend->primaryRole)
                                <span>
                                    @svg($friend->primaryRole->icon, [
                                        'style' => 'color:'.$friend->primaryRole->color,
                                        'class' => 'size-5'
                                    ])
                                </span>
                            @endif
                            <span>
                                {{ $friend->name }}
                            </span>
                        </p>
                    </div>
                @endforeach
            </x-one-off.user.profile-snippet>
        </div>
        @if ($user->description)
            <div class="w-full py-4">
                <h4 class="mb-1">{{ __('Description') }}</h4>
                <p>{{ $user->getDescription() }}</p>
            </div>
        @endif
        <div class="w-full mt-2" x-data="{ tab: 'comments', inventoryTabLoaded: false }">
            <x-tab-list>
                <x-tab 
                    x-on:click="tab = 'comments'"
                    x-bind:data-active="tab == 'comments'"
                    icon="ri-chat-poll-fill"
                    title="{{ __('Wall') }}"
                />
                <x-tab 
                    x-on:click="tab = 'inventory'; (inventoryTabLoaded == false) ? ($dispatch('inventoryTab'), inventoryTabLoaded = true) : false;"
                    x-bind:data-active="tab == 'inventory'"
                    icon="ri-briefcase-4-fill"
                    title="{{ __('Inventory') }}"
                />
                <x-tab 
                    x-on:click="tab = 'stats'"
                    x-bind:data-active="tab == 'stats'"
                    icon="ri-line-chart-fill"
                    title="{{ __('Stats') }}"
                />
            </x-tab-list>
            <div x-show="tab == 'comments'">
                @livewire('comments', [
                    'model' => $user
                ])
            </div>
            <div class="mt-4" x-show="tab == 'inventory'">
                @livewire('user.inventory', [
                    'user' => $user
                ])
            </div>
        </div>
    </div>
</x-layout.app>
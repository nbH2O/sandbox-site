<header class="dark z-[1000] text-[#ededf1] z-10 bg-header h-11  px-2 overflow-visible flex">
    <div class="flex justify-between max-w-full w-[60rem] mx-auto">
        <div class="flex">
            <a href="/">
                <img class="max-h-full p-2 block lg:hidden" src="/images/logo/small.png" />
                <img class="max-h-full !ps-0 p-2 hidden lg:block" src="/images/logo/large.png" />
            </a>
            <nav class="hidden sm:flex">
                <x-one-off.header.link
                    title="{{ __('Worlds') }}"
                    icon="ri-planet-fill"
                    href="{{ route('worlds') }}"
                />
                <x-one-off.header.link
                    title="{{ __('Market') }}"
                    icon="ri-shopping-basket-fill"
                    href="{{ route('market') }}"
                />
                <x-one-off.header.link
                    title="{{ __('Members') }}"
                    icon="ri-user-5-fill"
                    href="{{ route('members') }}"
                    active="true"
                />
            </nav>
        </div>
        
            @if (Auth::user())
                <div class="flex items-center gap-2">
                    @if (Auth::user()->hasPanelAccess())
                        <a href="/admin/panel">
                        <x-one-off.header.badged-icon 
                            class="text-red"
                            icon="ri-auction-fill"
                            badgeColor="red"
                        />
                        </a>
                    @endif
                    <x-one-off.header.bi-dropdown
                        function=""
                        icon="ri-chat-4-line"
                        title="{{ __('Chats') }}"
                        pings=""
                    >
                        <x-slot name="actions">
                            <x-button size="sm" color="gray" href="{{ route('chats') }}">
                                {{ __('See all') }}
                            </x-button>
                            <x-button size="sm">
                                @svg('ri-check-double-fill', [
                                    'class' => 'h-6 w-5'
                                ])
                            </x-button>
                        </x-slot>

                        @if (false)

                        @else
                            <x-one-off.header.bid-no-results
                                icon="ri-chat-off-line"
                                message="{{ __('You have no unread chats!') }}"
                            />
                        @endif

                    </x-one-off.header.bi-dropdown>
                    <x-one-off.header.bi-dropdown
                        function="$wire.getNotifications()"
                        icon="ri-notification-2-line"
                        title="{{ __('Notifications') }}"
                        pings="{{ $notifications ? $notifications->count() : session('previousNotificationCount') }}"
                    >
                        <x-slot name="actions">
                            <x-button size="sm" color="gray" href="{{ route('notifications') }}">
                                {{ __('See all') }}
                            </x-button>
                            <x-button 
                                size="sm"
                                x-on:click="$wire.setNotificationsRead(); $wire.getNotifications();"
                                wire:loading.attr="data-busy"
                            >
                                @svg('ri-check-double-fill', [
                                    'class' => 'h-6 w-5'
                                ])
                            </x-button>
                        </x-slot>

                        @if (isset($notifications[0]))
                            @foreach($notifications as $noti)
                                <p>{{ $noti->id }}</p>
                            @endforeach
                        @else
                            <x-one-off.header.bid-no-results
                                icon="ri-notification-off-line"
                                message="{{ __('You have no unread notifications!') }}"
                            />
                        @endif

                    </x-one-off.header.bi-dropdown>

                    <a href="{{ route('transactions') }}" class="dark bg-primary px-2.5 flex gap-2 items-center">
                        @svg('ri-vip-diamond-fill', [
                            'class' => 'size-4'
                        ])
                        <span>{{ Number::format(Auth::user()->currency) }}</span>
                    </a>

                    <x-dropdown class="ms-2" align="right">
                        <x-slot name="trigger">
                            <div class="flex items-center gap-1.5">
                                <p>{{ Auth::user()->getName() }}</p>
                                @svg('ri-arrow-down-s-line', [
                                    'class' => 'size-5'
                                ])
                            </div>
                        </x-slot>

                        <x-dropdown-item
                            icon="ri-profile-fill"
                            label="{{ __('Profile') }}"
                            href="{{ Auth::user()->getLink() }}"
                        />
                        <x-dropdown-item
                            class="text-primary"
                            icon="ri-user-5-fill"
                            label="{{ __('Avatar') }}"
                            href="{{ route('avatar') }}"
                        />
                        <x-dropdown-item 
                            class="text-yellow"
                            icon="ri-settings-4-fill"
                            label="{{ __('Settings') }}"
                            href="{{ route('settings') }}"
                        />
                        <x-dropdown-item 
                            class="text-red"
                            icon="ri-logout-box-fill"
                            label="{{ __('Log out') }}"
                            x-on:click="$wire.destroySession()"
                        />
                    </x-dropdown>
                    
                </div>
            @else
                <div class="flex items-center gap-2">
                    <x-dropdown :innerClick="false" align="center">
                        <x-slot name="trigger">
                            <x-button color="blue" size="sm" outerClass="w-9">
                                <x-ri-login-box-line class="size-5" />
                            </x-button>
                        </x-slot>

                        <div class="p-2 w-60">
                            @livewire('auth.login', [
                                'size' => 'md',
                                'redirect' => false
                            ])
                        </div>
                    </x-dropdown>
                    
                    <x-button color="primary" size="sm" href="{{ route('register') }}" outerClass="group">
                        <x-ri-user-5-line class="-ms-1.5 me-1.5 size-5 group-hover:animate-bounce" />
                        <span class="font-bold">{{ __('Join') }}</span>
                    </x-button>
                </div>
            @endif

    </div>
</header>
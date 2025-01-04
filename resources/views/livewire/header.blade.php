<header class="z-[1000] text-[#ededf1] z-10 bg-header h-12 shadow px-2 overflow-visible flex">
    <div class="flex justify-between max-w-full w-[70rem] mx-auto">
        <div class="flex">
            <img class="max-h-full p-2.5 me-4" src="https://web.archive.org/web/20230905100829im_/https://blog.brkcdn.com/2023/04/full_final_trademark_o--1-.png" />
            <nav class="flex">
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
                        <x-one-off.header.badged-icon 
                            class="text-red"
                            icon="ri-auction-fill"
                            badgeColor="red"
                        />
                    @endif
                    <x-one-off.header.badged-icon 
                        icon="ri-chat-4-line"
                        label="hi"
                        badgeColor="red"
                    />
                    <x-one-off.header.badged-icon 
                        icon="ri-notification-2-line"
                        label="77"
                        badgeColor="red"
                    />
                    <x-dropdown class="ms-2">
                        <x-slot name="trigger">
                            <div class="flex items-center gap-1.5">
                                <p>{{ Auth::user()->name }}</p>
                                @svg('ri-arrow-down-s-line', [
                                    'class' => 'size-5'
                                ])
                            </div>
                        </x-slot>

                        <x-dropdown-item 
                            icon="ri-user-5-fill"
                            label="{{ __('Profile') }}"
                            href="{{ '/@'.Auth::user()->name }}"
                        />
                        <x-dropdown-item 
                            class="text-yellow"
                            icon="ri-settings-4-fill"
                            label="{{ __('Settings') }}"
                            href="/my/settings"
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
                    <x-button href="{{ route('login') }}" color="blue" size="sm" outerClass="w-9">
                        <x-ri-login-box-line class="size-5" />
                    </x-button>
                    <x-button color="primary" size="sm" class="flex gap-1.5" outerClass="group">
                        <x-ri-user-5-line class="-ms-1.5 size-5 group-hover:animate-bounce" />
                        <span class="font-bold">{{ __('Join') }}</span>
                    </x-button>
                </div>
            @endif

    </div>
</header>
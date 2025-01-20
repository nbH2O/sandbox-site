<x-layout.app
    title="{{ $item->getName() }}"
>
    <div class="max-w-full w-[60rem]">
        <h3 class="mb-3">{{ $item->getName() }}</h3>
        <div class="flex gap-4">
            <x-card class="basis-4/12 bg-glow aspect-square relative">
                <img src="{{ $item->getRender() }}" />
                <div class="absolute m-2 top-0 left-0 flex gap-2">
                    @if ($item->isMaxCopies() && !$item->isSoldOut())
                        <x-badge color="red" innerClass="flex items-center gap-1.5">
                            @svg('ri-shopping-bag-3-fill', [
                                'class' => 'size-3.5'
                            ])
                            {{ Number::format($item->max_copies - $item->getCopies()) }} {{ __('left') }}
                        </x-badge>
                    @endif
                    @if ($item->isScheduled())
                        <x-one-off.item.timer-badge
                            :from="$item->available_from"
                            :to="$item->available_to"
                        />
                    @endif
                </div>
                <div class="absolute p-2 bottom-0 left-0 flex gap-2 w-full justify-between">
                    <div></div>
                    @if ($item->isTradeable())
                        @if ($item->with('cheapestReseller') && $item->cheapestReseller)
                            <x-badge color="primary" innerClass="flex items-center gap-1.5">
                                @svg('ri-vip-diamond-fill', [
                                    'class' => 'size-3.5'
                                ])
                                {{ $item->cheapestReseller->resale_price > 0 ? $item->cheapestReseller->resale_price : __('Free') }}
                            </x-badge>
                        @endif
                    @else
                        <div>
                        </div>
                    @endif
                    @if ($item->is_special)
                        <x-badge color="special" innerClass="flex items-center gap-1.5">
                            @svg('ri-bard-fill', [
                                'class' => 'size-3.5'
                            ])
                        </x-badge>
                    @endif
                </div>
            </x-card>
            <div class="basis-8/12 flex flex-col gap-2">
                <div class="flex gap-3 h-28">
                    <div>
                        <img class="h-full" src="{{ $item->creator->getRender() }}" />
                    </div>
                    <div>
                        <x-one-off.item.stat
                            label="{{ __('Creator') }}"
                        >
                            <x-slot name="value">
                                <a class="flex" href="{{ '/@'.$item->creator->id }}">
                                    @if ($item->creator->id === config('site.main_account_id'))
                                        @svg('ri-planet-fill', [
                                            'class' => 'size-5 text-primary me-1'
                                        ])
                                    @endif
                                    {{ $item->creator->getName() }}
                                </a>
                            </x-slot>
                        </x-one-off.item.stat>
                        <x-one-off.item.stat
                            label="{{ __('Created') }}"
                            value="{{ $item->created_at->diffForHumans() }}"
                        />
                        <x-one-off.item.stat
                            label="{{ __('Updated') }}"
                            value="{{ $item->updated_at?->diffForHumans() ?? $item->created_at->diffForHumans() }}"
                        />
                        <x-one-off.item.stat
                            label="{{ __('Copies') }}"
                            value="{{ Number::format($item->getCopies()) }}"
                        />
                    </div>
                </div>
                <div class="h-[2px] bg-border-light dark:bg-border-dark mb-2"></div>
                <div class="flex gap-2">
                    @if ($item->isPurchasable())
                        <x-button color="primary" class="font-bold">
                            @if ($item->isFree())
                                {{ __('Free') }}
                            @else
                                @svg('ri-vip-diamond-fill', [
                                    'class' => 'size-5 me-2 -ms-1'
                                ])
                                {{ $item->price }}
                            @endif
                        </x-button>
                    @elseif ($item->isTradeable())
                        @if ($item->with('cheapestReseller') && $item->cheapestReseller)
                            <x-button color="primary" class="font-bold">
                                @svg('ri-vip-diamond-fill', [
                                    'class' => 'size-5 me-2 -ms-1'
                                ])
                                {{ $item->cheapestReseller->resale_price }}
                            </x-button>
                            <x-button color="transparent">
                                See More
                            </x-button>
                        @endif
                    @endif
                </div>
                <div>
                    <p>{{ $item->getDescription() }}</p>
                </div>
            </div>
        </div>
        <div class="mt-2" x-data="{ tab: 'comments', economyTabLoaded: false }">
            <x-tab-list>
                <x-tab 
                    x-on:click="tab = 'comments'"
                    x-bind:data-active="tab == 'comments'"
                    icon="ri-chat-poll-fill"
                    title="{{ __('Comments') }}"
                />
                <x-tab
                    x-on:click="tab = 'owners'"
                    x-bind:data-active="tab == 'owners'"
                    icon="ri-briefcase-4-fill"
                    title="{{ __('Owners') }}"
                />
                @if ($item->isTradeable())
                    <x-tab
                        x-on:click="tab = 'economy'; (economyTabLoaded == false) ? ($dispatch('economyTab'), economyTabLoaded = true) : false;"
                        x-bind:data-active="tab == 'economy'"
                        icon="ri-list-check-2"
                        title="{{ __('Economy') }}"
                    />
                @else
                    <x-tab
                        icon="ri-list-check-2"
                        title="{{ __('Economy') }}"
                        data-disabled
                    />
                @endif
            </x-tab-list>
            <div x-show="tab == 'comments'">
                @livewire('comments', [
                    'model' => $item
                ])
            </div>
            @if ($item->isTradeable())
                <div x-show="tab == 'economy'" class="flex flex-col gap-8 pt-8">
                    <div class="flex justify-around flex-wrap">
                        <x-one-off.item.s-stat 
                            label="{{ __('You own') }}"
                            value="{{ Auth::user() ? $item->getOwnedCopies(Auth::user()->id) : __('N/A') }}"
                        />
                        <x-one-off.item.s-stat 
                            label="{{ __('Recent avg. price') }}"
                            value="0"
                        />
                        <x-one-off.item.s-stat 
                            label="{{ __('Hoarded copies') }}"
                            value="0"
                        />
                    </div>
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="basis-full md:basis-1/2">
                            @livewire('item.resellers', [
                                'item' => $item
                            ])
                        </div>
                        <div class="w-full h-[2px] md:w-[2px] md:h-auto bg-border-light dark:bg-border-dark"></div>
                        <div class="basis-full md:basis-1/2">
                            <div class="flex gap-2 justify-between">
                                <h4>{{ __('Orders') }}</h4>
                                <x-button size="sm">
                                    {{ __('Place order') }}
                                </x-button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layout.app>
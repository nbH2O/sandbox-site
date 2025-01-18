<x-layout.app>
    <div class="max-w-full w-[60rem]">
        <div class="flex gap-4">
            <x-card class="basis-4/12 bg-glow aspect-square">
                <img src="{{ $item->getRender() }}" />
            </x-card>
            <div class="basis-8/12 flex flex-col">
                <h3 class="mb-2.5">{{ $item->getName() }}</h3>
                <div class="flex grow">
                    <div class="basis-7/12 flex flex-col gap-2">
                        <div class="flex flex-col mb-2.5">
                            <div class="flex gap-2">
                                @if ($item->isSoldOut() && !$item->isTradeable())
                                    <p class="font-bold uppercase text-muted">{{ __('Sold Out') }}</p>
                                @elseif ($item->isPurchasable())
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
                                    @else
                                        <p class="font-bold uppercase text-muted">{{ __('No Resellers') }}</p>
                                    @endif
                                @else
                                    <p class="font-bold uppercase text-muted">{{ __('Offsale') }}</p>
                                @endif
                            </div>
                            @if (($item->isMaxCopies() && !$item->isSoldOut()) || $item->isScheduled())
                                <div class="flex gap-2 mt-1 -mb-1.5">
                                    @if ($item->isMaxCopies() && !$item->isSoldOut())
                                        <span class="text-red text-sm font-bold">{{ Number::format($item->max_copies - $item->getCopies()) }} {{ __('of') }} {{ $item->max_copies }} {{ __('left') }}</span>
                                    @endif
                                    @if ($item->isScheduled())
                                        <x-one-off.item.timer-snippet
                                            :from="$item->available_from"
                                            :to="$item->available_to"
                                        />
                                    @endif
                                </div>
                            @endif
                        </div>
                        <x-one-off.item.stat 
                            label="{{ __('Type') }}"
                            value="{{ __($item->type->name) }}"
                        />
                        <x-one-off.item.stat 
                            label="{{ __('Created') }}"
                            value="{{ $item->created_at->diffForHumans() }}"
                        />
                        <x-one-off.item.stat 
                            label="{{ __('Sold') }}"
                            value="{{ $item->getCopies() }}"
                        />
                        <div>
                            <x-one-off.item.stat 
                                label="{{ __('Tags') }}"
                            />
                        </div>
                    </div>
                    <div class="basis-5/12 flex items-center flex-col ">
                        <img class="px-4" src="{{ $item->creator->getRender() }}" />
                        <p class="flex items-center gap-1">
                            @if ($item->creator->id === config('site.main_account_id'))
                                @svg('ri-planet-fill', [
                                    'class' => 'text-primary size-5'
                                ])
                            @endif
                            {{ $item->creator->getName() }}
                        </p>
                    </div>
                </div>
                <div class="py-2.5 border-y-2 border-border-light dark:border-border-dark">

                </div>
            </div>
        </div>
        @if ($item->description)
            <div class="mt-3.5">
                <h4 class="mb-1">{{ __('Description') }}</h4>
                <p>{{ $item->getDescription() }}</p>
            </div>
        @endif
        <div class="mt-2" x-data="{ tab: 'comments' }">
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
                @if ($item->cheapestReseller)
                    <x-tab
                        x-on:click="tab = 'resellers'"
                        x-bind:data-active="tab == 'resellers'"
                        icon="ri-list-check-2"
                        title="{{ __('Resellers') }}"
                    />
                @else
                    <x-tab
                        icon="ri-list-check-2"
                        title="{{ __('Resellers') }}"
                        data-disabled
                    />
                @endif
            </x-tab-list>
            <div x-show="tab == 'comments'">
                @livewire('comments', [
                    'model' => $item
                ])
            </div>
        </div>
    </div>
</x-layout.app>
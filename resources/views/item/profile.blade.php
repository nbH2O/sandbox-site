<x-layout.app
    title="{{ $item->getName() }}"

    description="{{ $item->getDescription() }}"
    image="{{ $item->getRender() }}"
    imageSize="lg"
>
    @php
        $copies = $item->getCopies();
        $hoardedCopies = $item->getHoardedCopies();
        if (Auth::user()) {
            $ownedCopies = $item->getOwnedCopies(Auth::user()->id);
            $isOwned = $item->isOwnedBy(Auth::user()->id);
        } else {
            $ownedCopies = null;
            $isOwned = false;
        }
    @endphp

    @error('unexpectedPrice')
        <x-modal
            title="{{ __('Price changed') }}"
        >
            <p>{{ __('The price on the item has changed.') }}</p>
            <p>{{ __('It was not purchased.') }}</p>

            <x-slot name="actions">
                <x-button x-on:click="open = false" color="gray">
                    {{ __('Okay') }}
                </x-button>
            </x-slot>
        </x-modal>
    @enderror
    @error('highPrice')
        <x-modal
            title="{{ __('Not enough gems') }}"
        >
            <p>{{ __("You don't have enough gems.") }}</p>
            <p>{{ __('Item was not purchased.') }}</p>

            <x-slot name="actions">
                <x-button x-on:click="open = false" color="gray">
                    {{ __('Okay') }}
                </x-button>
            </x-slot>
        </x-modal>
    @enderror

    <div  x-data="{ open: false }">
        <x-modal 
            x-ref="resale"
            title="{{ __('Purchase from reseller') }}"
        >
            <x-slot name="trigger">
            </x-slot>
        </x-modal>
    </div>

    <div class="max-w-full w-[60rem]">
        <h3 class="mb-3">{{ $item->getName() }}</h3>
        <div class="flex flex-col sm:flex-row gap-4">
            <x-card class="basis-full sm:basis-1/2 md:basis-4/12 bg-glow aspect-square relative {{ $isOwned ? '!border-green' : null }}">
                <img src="{{ $item->getRender() }}" />
                <div class="absolute m-2 top-0 left-0 flex gap-2">
                    @if ($item->isMaxCopies() && !$item->isSoldOut())
                        <x-badge color="red" innerClass="flex items-center gap-1.5">
                            @svg('ri-shopping-bag-3-fill', [
                                'class' => 'size-3.5'
                            ])
                            {{ Number::format($item->max_copies - $copies) }} {{ __('left') }}
                        </x-badge>
                    @endif
                    @if ($item->isScheduled())
                        <x-one-off.item.timer-badge
                            :from="$item->available_from"
                            :to="$item->available_to"
                        />
                    @endif
                    @if ($item->is_special)
                        <x-badge color="special" innerClass="flex items-center gap-1.5">
                            @svg('ri-bard-fill', [
                                'class' => 'size-3.5'
                            ])
                        </x-badge>
                    @endif
                </div>
                @if ($isOwned)
                    <div class="w-full absolute bottom-0 left-0 bg-green h-10 flex justify-center items-center gap-3">
                        @svg('ri-emotion-happy-fill', [
                            'class' => 'size-5'
                        ])
                        <p>{{ __('You own this item') }}</p>
                    </div>
                @elseif ($item->isPurchasable())
                    <div class="absolute bottom-0 left-0 m-2">
                        <x-badge color="primary" innerClass="flex items-center gap-1.5">
                            @svg(config('site.currency_icon'), [
                                'class' => 'size-3.5'
                            ])
                            {{ $item->price > 0 ? Number::format($item->price) : __('Free') }}
                        </x-badge>
                    </div>
                @endif
            </x-card>
            <div class="basis-full sm:basis-1/2 md:basis-8/12 flex flex-col">
                <div class="grow">
                    <p>{!! UserString::withBreaks($item->getDescription()) !!}</p>
                </div>
                @if ($item->isPurchasable() && !$isOwned)
                    <div class="h-[2px] bg-border-light dark:bg-border-dark mb-4 mt-3"></div>
                @endif
                <div class="flex justify-end gap-4">
                    @if ($item->isPurchasable() && !$isOwned)
                        <x-modal
                            title="Purchase item"
                        >
                            <x-slot name="trigger">
                                <x-button size="lg" color="green" class="font-bold">
                                    {{ __('Purchase') }}
                                </x-button>
                            </x-slot>

                            <form x-ref="purchaseForm" method="POST" action="{{ route('item.purchase', ['id' => $item->id]) }}" class="hidden">
                                {{ csrf_field() }}
                                <input name="item_id" value={{ $item->id }} />
                                <input name="price" value="{{ $item->price }}" />
                            </form>

                            <p class="">
                                {{ __('Are you sure you want to purchase') }}
                                {{ $item->getName() }}
                                {{ __('for') }}
                                <span class="text-primary font-bold items-center inline-flex pt-1">
                                    @svg(config('site.currency_icon'), [
                                        'class' => 'size-4 me-2'
                                    ])
                                    {{ Number::format($item->price) }}
                                </span>
                                {{ __('?') }}
                            </p>

                            <x-slot name="actions">
                                <x-button x-on:click="open = false" color="red">
                                    {{ __('No') }}
                                </x-button>
                                <x-button x-on:click="$refs.purchaseForm.submit()" color="green">
                                    {{ __('Yes') }}
                                </x-button>
                            </x-slot>
                        </x-modal>
                    @endif
                </div>
            </div>
        </div>
        <div class="mb-7 mt-8 flex gap-4 justify-around flex-wrap">
            <x-one-off.item.s-stat
                label="{{ __('Creator') }}"
            >
                <x-slot name="value">
                    <a class="flex" href="{{ route('user.profile', ['id' => $item->creator->id]) }}">
                        @if ($item->creator->id === config('site.main_account_id'))
                            @svg('ri-planet-fill', [
                                'class' => 'size-6 text-primary me-1'
                            ])
                        @endif
                        {{ $item->creator->getName() }}
                    </a>
                </x-slot>
            </x-one-off.item.s-stat>
            <x-one-off.item.s-stat 
                label="{{ __('Copies') }}"
                value="{{ Number::format($item->getCopies()) }}"
            />
            <x-one-off.item.s-stat 
                label="{{ __('Created') }}"
                value="{{ $item->created_at->diffForHumans() }}"
            />
            <x-one-off.item.s-stat 
                label="{{ __('Updated') }}"
                value="{{ $item->updated_at?->diffForHumans() ?? $item->created_at->diffForHumans() }}"
            />
            
        </div>
        @if (in_array($item->type->name, config('site.bundle_item_types')))
            <div class="my-4">
            <h4>{{ __('Contents') }}</h4>

            </div>
        @endif
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
                        >
                            <x-slot name="value">
                                @if (Auth::user())
                                    <span class="flex gap-3 items-end">
                                        <span>{{ Number::format($ownedCopies) }}</span>
                                        <span class="text-muted-2 text-sm mb-0.5">{{ ($copies > 0) ? (($ownedCopies/$copies)*100).'%' : null }}</span>
                                    </span>
                                @else
                                    {{ __('N/A') }}
                                @endif
                            </x-slot>
                        </x-one-off.item.s-stat>
                        <x-one-off.item.s-stat 
                            label="{{ __('Average price') }}"
                            value="{{ $item->average_price ? Number::format($item->average_price) : ($item->price ? Number::format($item->price) : __('N/A')) }}"
                        />
                        <x-one-off.item.s-stat 
                            label="{{ __('Hoarded copies') }}"
                        >
                            <x-slot name="value">
                                <span class="flex gap-3 items-end">
                                    <span>{{ Number::format($hoardedCopies) }}</span>
                                    <span class="text-muted-2 text-sm mb-0.5">{{ ($copies > 0) ? (($hoardedCopies/$copies)*100).'%' : null }}</span>
                                </span>
                            </x-slot>
                        </x-one-off.item.s-stat>
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
                            <x-one-off.header.bid-no-results
                                icon="ri-code-ai-fill"
                                message=""
                            />
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function openResale(id, name, price) {
            // Access the Alpine component via the x-ref and change 'open' to true
            const modalComponent = document.querySelector('[x-ref="resale"]');
            Alpine.data(modalComponent).__x.$data.open = true;
        }
    </script>
</x-layout.app>
<div>
    <div class="flex gap-4 mb-4">
        <x-input 
            wire:model="query"
            x-on:keyup.enter="$wire.$refresh()"
            placeholder="Search..."
        />
        <x-select wire:model.change="sort">
            <option value="updated">{{ __('Recently Updated') }}</option>
            <option value="newest">{{ __('Newest') }}</option>
            <option value="oldest">{{ __('Oldest') }}</option>
            <option value="cheapest">{{ __('Cheapest') }}</option>
            <option value="priciest">{{ __('Priciest') }}</option>
        </x-select>
        <x-button
            x-on:click="$wire.$refresh()"
            wire:loading.attr="data-busy"
        >
            <x-ri-search-line class="size-6 me-2 -ms-1" />
            {{ __('Search') }}
        </x-button>
    </div>
    <div class="flex flex-col md:flex-row">
        <div class="flex flex-col gap-3 w-56 pb-4 mb-4 border-b-2 md:!pb-0 md:!mb-0 md:!border-b-0 md:pe-4 md:me-4 md:border-r-2 border-border-light dark:border-border-dark">
            <h5 class="text-muted uppercase">{{ __('Filter') }}</h5>

        </div>
        <div class="flex flex-col gap-4 flex-1">
            <x-tab-list x-data="{ active: 'all' }">
                <x-tab
                    icon="ri-asterisk"
                    title="{{ __('All') }}"
                    x-bind:data-active="active == 'all'"
                    x-on:click="$wire.updateType('all'); active = 'all';"
                />
                <x-tab
                    title="{{ __('Accessories') }}"
                    x-bind:data-active="active == 'accessory'"
                    x-on:click="$wire.updateType('accessory'); active = 'accessory';"
                />
                <x-tab
                    icon="ri-t-shirt-2-fill"
                    title="{{ __('Clothing') }}"
                    x-bind:data-active="active == 'clothing'"
                    x-on:click="$wire.updateType('clothing'); active = 'clothing';"
                />
                <x-tab
                    icon="ri-box-2-fill"
                    title="{{ __('Packs') }}"
                    x-bind:data-active="active == 'pack'"
                    x-on:click="$wire.updateType('pack'); active = 'pack';"
                />
                <x-tab
                    icon="ri-body-scan-fill"
                    title="{{ __('Body Parts') }}"
                    x-bind:data-active="active == 'body'"
                    x-on:click="$wire.updateType('body'); active = 'body';"
                />
            </x-tab-list>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @if ($items[0])
                    @foreach($items as $item)
                        <div class="flex flex-col relative">
                            <x-card class="!p-0 relative">
                                <img class="w-full bg-glow aspect-square" src="{{ $item->getRender() }}" />
                                <a class="absolute top-0 left-0 w-full h-full" href="{{ '/$'.$item->id }}"></a>
                            </x-card>
                            <a class="text-h5" href="{{ '/$'.$item->id }}">{{ $item->name }}</a>
                            <p class="flex gap-1 text-muted -mt-1 text-sm items-center">
                                by 
                                @if ($item->creator->id === config('site.main_account_id'))
                                        @svg('ri-planet-fill', [
                                            'class' => 'text-primary size-4'
                                        ])
                                    @endif
                                <a class="z-50" href="{{ '/@'.$item->creator->name }}">
                                    {{ $item->creator->name }}
                                </a>
                            </p>
                            @if ($item->isSoldOut() && !$item->isTradeable())
                                <p class="font-bold uppercase text-muted">{{ __('Sold Out') }}</p>
                            @elseif ($item->isPurchasable())
                                @if ($item->isFree())
                                <p class="font-bold uppercase text-primary">{{ __('Free') }}</p>
                                @else
                                    <span class="text-primary font-bold text-lg flex items-center gap-1">
                                        @svg('ri-vip-diamond-fill', [
                                            'class' => 'size-4'
                                        ])
                                        {{ $item->price }}
                                    </span>
                                @endif
                            @elseif ($item->isTradeable())
                                @if ($item->with('cheapestReseller') && $item->cheapestReseller)
                                    <p class="flex gap-2 items-center">
                                        <span class="text-primary font-bold text-lg flex items-center gap-1">
                                            @svg('ri-vip-diamond-fill', [
                                                'class' => 'size-4'
                                            ])
                                            {{ $item->cheapestReseller->resale_price }}
                                        </span>
                                        <span class="text-muted text-sm">from <a class="z-50" href="{{ '/@'.$item->cheapestReseller->user->name }}">{{ $item->cheapestReseller->user->name }}</a></span>
                                    </p>
                                @else
                                    <p class="font-bold uppercase text-muted">{{ __('No Resellers') }}</p>
                                @endif
                            @else
                                <p class="font-bold uppercase text-muted">{{ __('Offsale') }}</p>
                            @endif
                            @if ($item->isMaxCopies() && !$item->isSoldOut())
                                    <span class="text-red text-sm font-bold">{{ $item->max_copies - $item->getCopies() }} {{ __('of') }} {{ $item->max_copies }} {{ __('left') }}</span>
                            @elseif ($item->isScheduled())
                                <x-one-off.item.timer-snippet
                                    :from="$item->available_from"
                                    :to="$item->available_to"
                                />
                            @endif
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">{{ __('No Results') }}</p>
                @endif
            </div>
            {{ $items->links() }}
        </div>
    </div>
</div>

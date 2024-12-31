<div>
    <div class="flex gap-4 mb-4">
        <x-input 
            placeholder="Search..."
        />
        <x-button>
            <x-ri-search-line class="size-6 me-2 -ms-1" />
            {{ __('Search') }}
        </x-button>
    </div>
    <div class="flex">
        <div class="flex flex-col gap-3 w-56 pe-4 me-4 border-r-2 border-border-light dark:border-border-dark">
            <h5 class="text-muted uppercase">{{ __('Filter') }}</h5>

        </div>
        <div class="flex flex-col gap-4 flex-1">
            <x-tab-list>
                <x-tab
                    icon="ri-asterisk"
                    title="{{ __('All') }}"
                    :active="true"
                />
                <x-tab
                    title="{{ __('Accessories') }}"
                />
                <x-tab
                    icon="ri-t-shirt-2-fill"
                    title="{{ __('Clothing') }}"
                />
                <x-tab
                    icon="ri-body-scan-fill"
                    title="{{ __('Body Parts') }}"
                />
                <x-tab
                    title="{{ __('Outfits') }}"
                />
            </x-tab-list>
            <div class="grid grid-cols-4 gap-4">
                @if ($items)
                    @foreach($items as $item)
                        <div class="flex flex-col">
                            <x-card class="p-0">
                                <img class="w-full bg-glow aspect-square" />
                            </x-card>
                            <h5>{{ $item->name }}</h5>
                            <p class="text-muted -mt-1">
                                by 
                                <a href="{{ '/@'.$item->creator->name }}">{{ $item->creator->name }}</a>
                            </p>
                            @if ($item->isSoldOut())
                                <p class="font-bold uppercase">{{ __('Sold Out') }}</p>
                            @elseif (!$item->isPurchasable())
                                <p class="font-bold uppercase">{{ __('Offsale') }}</p>
                            @else
                                <p class="text-primary font-bold text-lg">{{ $item->isFree() ? __('Free') : $item->price }}</p>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">{{ __('No Results') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

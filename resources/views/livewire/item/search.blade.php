<div>
    <div class="flex flex-col sm:flex-row gap-4 mb-4">
        <div class="grow">
            <x-input 
                wire:model="query"
                x-on:keyup.enter="$wire.$refresh()"
                placeholder="Search..."
            />
        </div>
        <div class="flex gap-4 [&>*]:grow sm:[&>*]:grow-0">
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
                <x-ri-search-line class="size-5 -ms-1.5 me-2" />
                {{ __('Search') }}
            </x-button>
        </div>
    </div>
    <div class="flex flex-col md:flex-row">
        <div class="flex flex-col gap-4 flex-1">
            <x-tab-list x-data="{ active: 'all' }" class="flex-col sm:flex-row">
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
                        <x-one-off.item.card :item="$item" />
                    @endforeach
                @else
                    <p class="text-muted">{{ __('No Results') }}</p>
                @endif
            </div>
            {{ $items->links() }}
        </div>
    </div>
</div>

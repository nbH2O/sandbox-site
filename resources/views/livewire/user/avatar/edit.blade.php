<div class="flex flex-col md:flex-row gap-4">
    <div class="basis-2/5">
        @livewire('user.avatar.save', [
            'properties' => $properties 
        ])
    </div>
    <div class="basis-3/5">
        <x-tab-list x-data="{ active: 'accessory' }" class="flex-col sm:flex-row mb-3">
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
                icon="ri-body-scan-fill"
                title="{{ __('Body Parts') }}"
                x-bind:data-active="active == 'body'"
                x-on:click="$wire.updateType('body'); active = 'body';"
            />
        </x-tab-list>
        @if ($inventory[0])
            <div class="flex gap-4 grid grid-cols-3 sm:grid-cols-4">
                @foreach($inventory as $inv)
                    <x-one-off.item.card
                        x-on:click.prevent="$wire.equip({{ $inv->item->id }})"
                        :item="$inv->item"
                        :badges="false"
                        :info="false"
                    />
                @endforeach
            </div>
        @else
            <p class="text-muted">{{ __('No Results') }}</p>
        @endif
        <div class="flex justify-center mt-2">
            {{ $inventory->links() }}
        </div>
        <h4 class="mt-4 mb-3">{{ __('Currently Equipped') }}</h4>
        @if (isset($equipped[0]))
            <div class="flex gap-4 grid grid-cols-3 sm:grid-cols-4">
                @foreach ($equipped as $e)
                    <x-one-off.item.card 
                        x-on:click.prevent="$wire.unequip({{ $e->id }})"
                        :item="$e" 
                        :badges="false" 
                        :info="false"
                    />
                @endforeach
            </div>
        @else
            <p class="text-muted">{{ __('No Results') }}</p>
        @endif
    </div>
</div>
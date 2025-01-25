<div class="flex gap-4">
    <div>
        <x-tab-list x-data="{ tab: 'accessories' }" :vertical="true">
            <x-tab 
                style="solid"
                x-bind:data-active="tab == 'accessories'"
                title="{{ __('Accessories') }}"
            />
            <x-tab 
                style="solid"
                x-bind:data-active="tab == 'clothing'"
                title="{{ __('Clothing') }}"
            />
            <x-tab 
                style="solid"
                x-bind:data-active="tab == 'packs'"
                title="{{ __('Packs') }}"
            />
            <x-tab 
                style="solid"
                x-bind:data-active="tab == 'bodyparts'"
                title="{{ __('Body Parts') }}"
            />
        </x-tab-list>
    </div>
    <div>
        @if ($inventory)
            <div class="flex gap-4 grid grid-cols-4">
                @foreach($inventory as $inv)
                    <x-one-off.item.card
                        :item="$inv->item"
                    />
                @endforeach
            </div>
            {{ $inventory->links() }}
        @endif
    </div>
</div>

<div class="flex gap-4">
    <div class="basis-1/4">
        <x-button x-on:click.prevent="$wire.saveAvatar()">test render</x-button>
        <div class="bg-white">hi</div>
    </div>
    <div class="basis-3/4">
        @if ($inventory[0])
            <div class="flex gap-4 grid grid-cols-4">
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
        <div class="flex justify-center">
            {{ $inventory->links() }}
        </div>
        <h4>{{ __('Currently Equipped') }}</h4>
        <div class="flex gap-4 grid grid-cols-4">
            @foreach ($equipped as $e)
                <x-one-off.item.card 
                    x-on:click.prevent="$wire.unequip({{ $e->id }})"
                    :item="$e" 
                    :badges="false" 
                    :info="false"
                />
            @endforeach
        </div>
    </div>
</div>
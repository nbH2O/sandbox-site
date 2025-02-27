<div class="flex gap-4">
    <div class="basis-1/4">
        <x-button x-on:click.prevent="$wire.saveAvatar()">test render</x-button>
        <div class="bg-white">hi</div>
    </div>
    <div class="basis-3/4">
        <h4>{{ __('Currently Equipped') }}</h4>
        <div class="flex gap-4 grid grid-cols-4">
            @foreach ($equipped as $e)
                <x-one-off.item.card :item="$e" />
            @endforeach
        </div>
    </div>
</div>
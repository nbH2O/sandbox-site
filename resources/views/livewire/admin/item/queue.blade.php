<div>
    <div class="flex grid grid-cols-4 gap-4">
        @foreach($items as $item)
            <div class="flex flex-col gap-1">
                <x-card class="!p-0">
                    <img src="{{ config('site.file_url').'/'.$item->file_ulid.'.png' }}">
                </x-card>
                <h6>{{ $item->getName() }}</h6>
                <div class="flex gap-1">
                    <x-button color="green" x-on:click="$wire.accept({{ $item->id }})">Yes</x-button>
                    <x-button color="red" x-on:click="$wire.decline({{ $item->id }})">No</x-button>
                </div>
            </div>
        @endforeach
    </div>
    {{ $items->links() }}
</div>
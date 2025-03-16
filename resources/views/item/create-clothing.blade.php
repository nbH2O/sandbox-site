@php
    $itemTypeIDs = array_flip(config('site.item_types'));
@endphp

<x-layout.app
    title="{{ __('Create Clothing') }}"
    :pageTitle="true"
    containerClass="w-[25rem]"

    description="Create unique clothing to style your avatar"
>
    @if ($success = session('success'))
        @if ($success === true)
            <div class="mb-4 px-4 py-3 bg-green">
                <p>{{ __('Clothing created successfully!') }}</p>
            </div>
        @elseif ($success === false)
            <div class="mb-4 px-4 py-3 bg-red">
                <p>{{ __('Something went wrong') }}</p>
            </div>
        @endif
    @endif
    <form method="POST" enctype="multipart/form-data" class="max-w-full [&>*]:w-full flex flex-col gap-4">
        @csrf
        <div>
            <x-input 
                type="file"
                name="file"
            />
            @error('file') <small class="text-red">{{ $message }}</small> @enderror
        </div>
        <div>
            <p>{{ __('Type') }}</p>
            <x-select name="type_id" class="w-full">
                <option value="{{ $itemTypeIDs['shirt'] }}">{{ __('Shirt') }}</option>
                <option value="{{ $itemTypeIDs['pants'] }}">{{ __('Pants') }}</option>
                <option value="{{ $itemTypeIDs['suit'] }}">{{ __('Suit') }}</option>
            </x-select>
            @error('type_id') <small class="text-red">{{ $message }}</small> @enderror
        </div>
        <div>
            <p>{{ __('Name') }}</p>
            <x-input
                name="name"
                placeholder="{{ __('My Clothing') }}"
            />
            @error('name') <small class="text-red">{{ $message }}</small> @enderror
        </div>
        <div>
            <p>{{ __('Description') }}</p>
            <x-textarea
                name="description"
                placeholder="{{ __('My Clothing') }}"
            />
            @error('description') <small class="text-red">{{ $message }}</small> @enderror
        </div>
        <div>
            <p>{{ __('Price') }}</p>
            <x-input
                type="number"
                name="price"
                placeholder="{{ __('Price') }}"
            />
            @error('price') <small class="text-red">{{ $message }}</small> @enderror
        </div>
        <div class="flex gap-4">
                <x-checkbox 
                        name="is_onsale"
                        label="Is Onsale"
                />
                @error('is_onsale') <small class="text-red">{{ $message }}</small> @enderror
        </div>
        <x-button color="green">{{ __('Submit') }}</x-button>
    </form>
</x-layout.app>
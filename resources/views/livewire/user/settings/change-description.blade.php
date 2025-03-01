<div 
    x-data="{ description: @entangle('description'), newDescription: '' }"
    x-init="newDescription = JSON.parse($refs.description.textContent);"
>
    <script x-ref="description">@json(Auth::user()->description)</script>
    <p>{{ __('Description') }}</p>
    <x-textarea x-model="newDescription">
        <div class="absolute m-2 right-0 bottom-0 flex">
            <x-button 
                x-on:click="$wire.saveDescription(newDescription)"
                x-show="newDescription != description"
                wire:loading.attr="data-busy" 
                size="sm" color="blue"
            >
                {{ __('Save') }}
            </x-button>
        </div>
    </x-textarea>
    @error('newDescription')
        <small class="text-red">{{ $message }}</small>
    @enderror
    @if (session()->has('newDescription'))
        <small class="text-green">{{ session('newDescription') }}</small>
    @endif
</div>
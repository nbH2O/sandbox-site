<x-layout.app
    title="{{ __('Market') }}"
    :pageTitle="true"
    containerClass="w-[60rem]"
>
    <x-slot name="actions">
        <x-button color="green">
            @svg('ri-add-fill', [
                'class' => 'size-6 -ms-2 me-1.5'
            ])
            {{ __('Create') }}
        </x-button>
    </x-slot>
    @livewire('item.search')
</x-layout.app>
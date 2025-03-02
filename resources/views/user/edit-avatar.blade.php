<x-layout.app
    title="{{ __('My Avatar') }}"
    :pageTitle="true"
    containerClass="w-[60rem]"
>
    @livewire('user.avatar.edit')
</x-layout.app>
<x-layout.app
    title="{{ __('Members') }}"
    :pageTitle="true"
    containerClass="w-[40rem]"

    description="View who is on Lunoba"
>
    @livewire('user.search')
</x-layout.app>
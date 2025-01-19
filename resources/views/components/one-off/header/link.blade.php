@props([
    'title' => null,
    'icon' => null,
    'href' => null
])

<a href="{{ $href }}" class="select-none cursor-pointer h-full px-4 flex gap-2 items-center justify-center font-black uppercase transition duration-100 ease-in-out  {{ ($href == request()->url() || (request()->url() == url('/livewire/update') && url()->previous() == $href)) ? 'border-b border-primary border-b-4 pt-[4px]' : 'border-transparent hover:border-primary hover:border-b-2 hover:pt-[2px]' }}">
    @svg($icon, [
        'class' => 'size-6 md:size-5'
    ])
    <span class="hidden md:block">
        {{ $title }}
    </span>
</a>
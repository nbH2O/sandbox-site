@props([
    'title' => null,
    'active' => false
])

<a class="select-none cursor-pointer h-full px-4 flex items-center justify-center font-bold uppercase transition duration-100 ease-in-out  {{ $active ? 'border-b border-[#00a9fe] border-b-4 pt-[4px]' : 'border-transparent hover:border-[#00a9fe] hover:border-b-2 hover:pt-[2px]' }}">
    {{ $title }}
</a>
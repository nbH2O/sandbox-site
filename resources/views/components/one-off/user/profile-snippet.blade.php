@props([
    'title' => null,
    'href' => null,

])

<div class="flex-1">
    <div class="flex justify-between items-center">
        <h5>{{ $title }}</h5>
        <x-button size="sm" color="gray" href="{{ $href }}">
            See All
        </x-button>
    </div>
    <div class="flex gap-4">
        {{ $slot }}
    </div>
</div>
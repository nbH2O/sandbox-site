@props([
    'title' => null,
    'pings' => null,
    'icon' => null,
    'function' => null
])

@php
        $notiCount = null;

        if ($pings > 9) {
            $notiCount = '9+';
        } else {
            $notiCount = $pings;
        }
@endphp

<x-dropdown align="center" :innerClick="false" :yAdjust="false" {{ $attributes }}>
    

    <x-slot name="trigger">
        <x-one-off.header.badged-icon 
            icon="{{ $icon }}"
            label="{{ $notiCount }}"
            badgeColor="red"
            x-init="{{ $function }}"
        />
    </x-slot>

    <div class="flex flex-col w-96">
        <div class="flex justify-between pt-2 px-2 gap-3 items-center">
            <h6>{{ $title }}</h6>
            <div class="flex gap-2">
                @if ($actions)
                    {{ $actions }}
                @endif
            </div>
        </div>
        <div class="m-2  bg-body">
            {{ $slot }}
        </div>
    </div>
</x-dropdown>
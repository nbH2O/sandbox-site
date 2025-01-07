@props([
    'from' => null,
    'to' => null,
    'size' => 'md'
])

@php
    if($from?->isFuture()) {
        $color = 'yellow';
        $ico = "ri-calendar-schedule-fill";
    } else {
        $color = 'red';
        $ico = "ri-timer-flash-fill";
    }
@endphp

<x-badge color="{{ $color }}" size="{{ $size }}" {{ $attributes->merge(['innerClass' => 'flex gap-1 items-center']) }}>
    @svg($ico, [
        'class' => $size == 'lg' ? 'size-5' : 'size-4'
    ])
    <span x-init="window.timeUntil($el, '{{ $from }}', '{{ $to }}')"></span>
</x-badge>
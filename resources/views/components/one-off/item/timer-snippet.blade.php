@props([
    'from' => null,
    'to' => null
])

@php
    if($from?->isFuture()) {
        $color = 'text-yellow';
        $msg = __('until');
    } else {
        $color = 'text-red';
        $msg = __('left');
    }
@endphp

<span class="flex {{ $color }} items-center font-bold">
    @svg('ri-time-line', [
        'class' => ' size-4 me-1'
    ])
    <span class="leading-2 text-sm" x-init="window.timeUntil($el, '{{ $from }}', '{{ $to }}')">
    </span>
    <span class="text-sm">
        &nbsp;{{ $msg }}
    </span>
</span>
@props([
    'vertical' => false,
    'vVals' => [
        true => 'flex flex-col',
        false => 'flex'
    ]
])

<div {!! $attributes->merge(['class' => $vVals[$vertical].' gap-2 ']) !!}>
    {{ $slot }}
</div>
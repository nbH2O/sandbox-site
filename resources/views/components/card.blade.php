

<div {!! $attributes->merge([
    'class' => 'p-4 border border-2 border-[#333] rounded-sm '
]) !!}>
    {{ $slot }}
</div>
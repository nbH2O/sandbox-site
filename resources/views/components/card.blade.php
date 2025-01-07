

<div {!! $attributes->merge([
    'class' => 'p-4 border border-2 border-border-light dark:border-border-dark rounded-[1.25rem] '
]) !!}>
    {{ $slot }}
</div>
@props([
    'value' => null
])

<div class="relative flex">
    <textarea {!! $attributes->merge([
        'class' => "min-h-24 px-4 py-2 flex-1 bg-body  h-10 border border-2 border-border-light dark:border-border-dark px-3"
    ]) !!}>{{ $value }}</textarea>
    {{ $slot }}
</div>
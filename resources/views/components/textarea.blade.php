
<div class="relative flex">
    <textarea {!! $attributes->merge([
        'class' => "min-h-20 px-4 py-2 flex-1 bg-body rounded-sm h-10 border border-2 border-border-light dark:border-border-dark px-3"
    ]) !!}></textarea>
    {{ $slot }}
</div>
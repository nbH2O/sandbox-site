@props([
    'size' => 'md',
    'sizeVals' => [
        'sm' => 'px-3 text-sm h-8',
        'md' => 'h-9 px-4',
        'lg' => 'h-12 px-5 text-lg'
    ],
])

<input {!! $attributes->merge([
    'class' => $sizeVals[$size]." !rounded-full flex-1 bg-body rounded-sm h-10 border border-2 border-border-light dark:border-border-dark px-3"
]) !!} />
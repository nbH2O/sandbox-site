@props([
    'size' => 'md',
    'sizeVals' => [
        'md' => [
            'c' => 'size-5',
            'l' => 'text-sm',
            'i' => 'size-4'
        ],
        'lg' => [
            'c' => 'size-8',
            'l' => '',
            'i' => 'size-6'
        ]
    ],

    'label' => null,
    'name' => null
])

@php
    $rand_id = bin2hex(random_bytes(7))
@endphp

<div class="flex gap-2">
    <div class="relative">
        <input 
            id="{{ $rand_id }}" 
            type="checkbox" 
            class="peer {{ $sizeVals[$size]['c'] }} opacity-0" 
            name="{{ $name }}"
            {{-- gotta be here for stuff like wire:model --}}
            {!! $attributes !!}
        />
        <div class="-z-10 [&>*]:hidden peer-checked:[&>*]:block  flex items-center justify-center absolute top-0 left-0 {{ $sizeVals[$size]['c'] }} border-border-light dark:border-border-dark border-2 bg-body">
            @svg('ri-check-fill', [
                'class' => 'text-primary '.$sizeVals[$size]['i']
            ])
        </div>
    </div>
    <label for="{{ $rand_id }}" class="text-muted {{ $sizeVals[$size]['l'] }}">
        {{ $label }}
    </label>
</div>
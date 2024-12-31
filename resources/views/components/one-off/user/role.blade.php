@props([
    'role' => null,
    'textClass' => null
])

<div class="flex gap-1 items-center justify-center">
    @svg($role->icon, [
        'style' => 'color: '.$role->color,
        'class' => 'h-7'
    ])
    <h6 class="uppercase {{ $textClass }}">{{ $role->name }}</h6>
</div>
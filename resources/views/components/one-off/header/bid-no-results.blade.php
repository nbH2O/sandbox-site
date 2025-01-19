@props([
    'icon' => null,
    'message' => null
])

<div class="w-full p-4 flex gap-4 text-muted-2 items-center">
    @svg($icon, [
        'class' => 'size-16'
    ])
    <div class="flex flex-col gap-1">
        <h6 class="text-muted">No Results</h6>
        <small>{{ $message }}</small>
    </div>
</div>
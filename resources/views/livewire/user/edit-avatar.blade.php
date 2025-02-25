<div class="flex gap-4">
    <div class="basis-1/5">
        
    </div>
    <div class="basis-4/5">
        <h4>{{ __('Currently Equipped') }}</h4>
        <div class="flex gap-4">
            @foreach ($equipped as $e)
                <div class="border-border-light dark:border-border-dark">
                    <img src="{{ url('storage/'.$e['render_ulid'].'.png') }}" >
                </div>
            @endforeach
        </div>
    </div>
</div>
<div>
    @if (true)
        <x-textarea placeholder="{{ __('Comment...') }}" class="relative mt-2">
            <x-button size="sm" outerClass="absolute m-2 right-0 bottom-0">
                {{ __('Send') }}
            </x-button>
        </x-textarea>
    @endif
    <div class="flex flex-col gap-2 mt-2">
        @foreach ($comments as $comment)
            <div class="h-[2px] bg-border-light dark:bg-border-dark"></div>
            <div class="flex gap-4">
                <img class="w-26 md:w-32 bg-glow" src="{{ $comment->user->getRender() }}" />
                <div class="flex flex-col gap-1">
                    <div>
                        <h6 class="mb-1 flex gap-2 items-center">
                            @svg($comment->user->primaryRole->icon, [
                                'style' => 'color:'.$comment->user->primaryRole->color,
                                'class' => 'size-6'
                            ])
                            {{ $comment->user->name }}
                        </h6>
                        <p>{{ $comment->content }}</p>
                    </div>
                    <p class="text-sm">{{ $comment->created_at->diffForHumans() }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>

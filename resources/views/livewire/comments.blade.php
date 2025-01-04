<div>
    @if (Auth::user())
        <x-textarea wire:model="newComment" placeholder="{{ __('Comment...') }}" class="relative mt-2">
            <div class="absolute m-2 right-0 bottom-0 flex">
                <x-button wire:loading.attr="data-busy" x-on:click="$wire.addNewComment()" size="sm">
                    {{ __('Send') }}
                </x-button>
            </div>
        </x-textarea>
        @error('newComment')
            <span class="text-sm text-red">{{ $message }}</span>
        @enderror
    @endif
    <div class="flex flex-col gap-2 mt-2">
        @foreach ($comments as $comment)
            <div class="h-[2px] bg-border-light dark:bg-border-dark"></div>
            <div class="flex gap-4">
                <div class="shrink-0">
                    <img class="w-26 md:w-32 bg-glow" src="{{ $comment->user->getRender() }}" />
                </div>
                <div class="flex flex-1 flex-col gap-1">
                    <div class="flex-1">
                        <div class="flex justify-between mb-1 items-center">
                            <a href="{{ '/@'.$comment->user->name }}" class="text-h6 flex gap-2 items-center">
                                @if ($comment->user->primaryRole)
                                    @svg($comment->user->primaryRole->icon, [
                                        'style' => 'color:'.$comment->user->primaryRole->color,
                                        'class' => 'size-6'
                                    ])
                                @endif
                                {{ $comment->user->name }}
                            </a>
                            <x-dropdown align="right">
                                <x-slot name="trigger">
                                    @svg('ri-more-2-fill', [
                                        'class' => 'size-5 text-muted-2 rotate-90'
                                    ])
                                </x-slot>

                                @if ($comment->user_id == Auth::user()->id)
                                    <x-dropdown-item 
                                        class="text-red"
                                        icon="ri-delete-bin-2-fill"
                                        label="{{ __('Delete') }}"
                                        x-on:click="$wire.deleteComment({{ $comment->id }})"
                                    />
                                @else
                                    <x-dropdown-item 
                                        class="text-yellow"
                                        icon="ri-triangular-flag-fill"
                                        label="{{ __('Report') }}"
                                        href="{{ route('report') }}?model=Comment&id={{ $comment->id }}"
                                    />
                                @endif
                            </x-dropdown>
                        </div>
                        <p>{!! UserString::withBreaks($comment->content) !!}</p>
                    </div>
                    <p class="text-sm text-muted-2">{{ $comment->created_at->diffForHumans() }}</p>
                </div>
            </div>
        @endforeach
    </div>
    {{ $comments->links() }}
</div>

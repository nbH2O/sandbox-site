<div class="flex flex-col">
    <div class="flex gap-4 mb-2">
        <x-input 
            wire:model="query"
            x-on:keyup.enter="$wire.$refresh()"
            placeholder="Search..."
        />
        <x-button
            x-on:click="$wire.$refresh()"
            wire:loading.attr="data-busy"
        >
            <x-ri-search-line class="size-6 me-2 -ms-1" />
            Search
        </x-button>
    </div>
    <div class="flex flex-col">
        @if ($users[0])
            @foreach ($users as $user)
                <div class="my-2 h-[2px] bg-border-light dark:bg-border-dark"></div>
                <div class="flex gap-4 relative">
                    <a class="absolute top-0 left-0 w-full h-full z-10" href="{{ '/@'.$user->name }}"></a>
                    <img class="w-1/3 md:w-40 aspect-square bg-glow" src="{{ $user->getRender() }}" />
                    <div class="flex flex-col gap-2 min-h-full">
                        <h4 class="flex items-center gap-2"><x-ri-circle-fill class="{{ ($user->online_at > now()->subMinutes(4)) ? 'text-[#00A437]' : 'text-border-light dark:text-border-dark' }} size-2.5" />{{ $user->name }}</h4>
                        <p class="grow">
                            {{ $user->description }}
                        </p>
                        @if ($user->roles)
                            <div class="flex gap-4 items-center justify-center mt-4">
                                @foreach ($user->roles as $role)
                                    <x-one-off.user.role 
                                        textClass="text-muted"
                                        :role="$role"
                                    />
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-muted">{{ __('No Results') }}</p>
        @endif
    </div>
    {{ $users->links() }}
</div>

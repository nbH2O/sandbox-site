<div class="flex flex-col">
    <div class="flex gap-4 mb-2">
        <x-input 
            placeholder="Search..."
        />
        <x-button>
            <x-ri-search-line class="size-6 me-2 -ms-1" />
            Search
        </x-button>
    </div>
    <div class="flex flex-col">
        @foreach ($users as $user)
            <div class="my-2 h-[2px] bg-border-light dark:bg-border-dark"></div>
            <div class="flex gap-4 relative">
                <a class="absolute top-0 left-0 w-full h-full z-10" href="{{ '/@'.$user->name }}"></a>
                <img class="w-1/3 md:w-40 aspect-square bg-glow" src="{{ $user->getRender() }}" />
                <div class="flex flex-col gap-2 min-h-full">
                    <h4 class="flex items-center gap-1">
                        <span>
                            {{ $user->name }}
                        </span>
                    </h4>
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
    </div>
</div>

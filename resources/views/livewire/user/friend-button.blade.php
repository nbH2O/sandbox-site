<div class="flex gap-3">
    @if ($action == 'send')
        <x-button x-on:click="$wire.doAction()" wire:loading.attr="data-busy" color="green">
            @svg('ri-user-add-fill', ['class' => 'size-5'])
        </x-button>
    @elseif ($action == 'cancel')
        <x-button x-on:click="$wire.doAction()" wire:loading.attr="data-busy" color="red">
            @svg('ri-user-forbid-fill', ['class' => 'size-5'])
        </x-button>
    @elseif ($action == 'decline')
        <x-button x-on:click="$wire.doAction('accept')" wire:loading.attr="data-busy" color="green">
            @svg('ri-user-follow-fill', ['class' => 'size-5'])
        </x-button>
        <x-button x-on:click="$wire.doAction()" wire:loading.attr="data-busy" color="red">
            @svg('ri-user-unfollow-fill', ['class' => 'size-5'])
        </x-button>
    @elseif ($action == 'remove')
        <x-modal title="{{ __('Are you sure?') }}">
            <x-slot name="trigger">
                <x-button color="red">
                    @svg('ri-user-minus-fill', ['class' => 'size-5'])
                </x-button>
            </x-slot>

            <p>{{ __('Are you sure that you want to remove') }} {{ $user_name }} {{ __('from your friends list?') }}</p>

            <x-slot name="actions">
                <x-button x-on:click="open = false" color="gray">
                    {{ __('Nevermind') }}
                </x-button>
                <x-button x-on:click="$wire.doAction()" wire:loading.attr="data-busy" color="red">
                    {{ __("I'm sure") }}
                </x-button>
            </x-slot>
        </x-modal>
    @endif
</div>
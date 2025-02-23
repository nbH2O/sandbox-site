<div>
    <p>{{ __('Password') }}</p>
    <x-modal x-on:password-changed.window="open = false" title="{{ __('Change Password') }}" size="sm">
        <x-slot name="trigger">
            <x-icon-input 
                outerClass="text-muted" 
                icon="ri-edit-2-line" 
                disabled 
                type="password" 
                value="the j the j j" 
            />
        </x-slot>

        <form wire:submit="submit" id="changePasswordForm" class="flex flex-col gap-3">
            <div>
                <x-input wire:model="currentPassword" type="password" placeholder="{{ __('Current Password') }}" />
                @error('currentPassword')<small class="text-red">{{ $message }}</small>@enderror
            </div>
            <div>
                <x-input wire:model="newPassword" type="password" placeholder="{{ __('New Password') }}" />
                @error('newPassword')<small class="text-red">{{ $message }}</small>@enderror
            </div>
            <div>
                <x-input wire:model="confirmNewPassword" type="password" placeholder="{{ __('Confirm New Password') }}" />
                @error('confirmNewPassword')<small class="text-red">{{ $message }}</small>@enderror
            </div>
            <div class="flex gap-3 justify-end">
                <x-button color="gray" x-on:click.prevent="open = false">{{ __('Cancel') }}</x-button>
                <x-button color="green" type="submit" wire:loading.attr="data-busy" >{{ __('Confirm') }}</x-button>
            </div>
        </form>
    </x-modal>

    <x-modal x-on:password-changed.window="open = true" title="{{ __('Password Changed') }}">
        <x-slot name="trigger"></x-slot>
        <p>{{ session('newPassword') }}</p>

        <x-slot name="actions">
            <x-button x-on:click="open = false">{{ __('Okay') }}</x-button>
        </x-slot>
    </x-modal>

    @script
        <script>
            $wire.on('password-changed', () => {
                document.querySelectorAll('#changePasswordForm input').forEach((el) => {
                    el.value = null;
                })
            })
        </script>
    @endscript
</div>
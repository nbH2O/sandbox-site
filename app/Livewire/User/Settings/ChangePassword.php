<?php

namespace App\Livewire\User\Settings;

use App\Models\User\User;

use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ChangePassword extends Component
{
    public $currentPassword = '';

    public $newPassword = '';

    public $confirmNewPassword = '';

    public function submit()
    {
        $validated = $this->validate([
            'currentPassword' => 'required|current_password',
            'newPassword' => 'required|min:8',
            'confirmNewPassword' => 'required|same:newPassword'
        ]);

        $user = Auth()->user();

        if (!Hash::check($validated['newPassword'], $user->password)) {
            $user->password = Hash::make($validated['newPassword']);
            $user->save();

            session()->flash('newPassword', __('Your password was updated successfully!'));
            $this->dispatch('password-changed');
        } else {
            $this->addError('newPassword', 'The new password field must not match your current password.');
        }
    }

    public function render()
    {
        return view('livewire.user.settings.change-password');
    }
}

<?php

namespace App\Livewire\User;

use App\Models\User\User;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class Settings extends Component
{
    public function saveDescription($newDescription)
    {   
        if (!Auth()->check()) {
            $this->addError('newDescription', __("You're session has expired. Please log in"));
        } else {
            $user = Auth()->user();

            if ($user->description == $newDescription) {
                $this->addError('newDescription', __("This is already your description"));
            } else {
                $validator = Validator::make(['description' => $newDescription], [
                    'description' => 'nullable|max:255',
                ]);
        
                \Barryvdh\Debugbar\Facades\Debugbar::error('Error!');
        
                if ($validator->fails()) {
                    $this->addError('newDescription', __("Max 255 characters"));
                } else {
                    $user->description = $newDescription;
                    $user->save();
                    session()->flash('newDescription', __("Successfully updated"));
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.user.settings');
    }
}

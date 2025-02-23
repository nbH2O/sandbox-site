<?php

namespace App\Livewire\User\Settings;

use App\Models\User\User;

use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class ChangeDescription extends Component
{
    public $description = '';

    public function mount()
    {
        $this->description = Auth()->user()->description;
    }

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
        
                if ($validator->fails()) {
                    $this->addError('newDescription', __("Max 255 characters"));
                } else {
                    $this->description = $newDescription;
                    $user->description = $newDescription;
                    $user->save();
                    session()->flash('newDescription', 'Successfully updated!');
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.user.settings.change-description');
    }
}

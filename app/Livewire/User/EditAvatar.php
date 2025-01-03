<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User\User;
use App\Jobs\RenderImage;

class EditAvatar extends Component
{
    public $query = null;

    public function render()
    {
        return view('livewire.user.edit-avatar');
    }

    public function saveAvatar()
    {
        RenderImage::dispatch(User::find(1));
    }
}

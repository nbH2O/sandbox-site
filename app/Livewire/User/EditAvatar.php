<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User\User;
use App\Models\User\Avatar;
use App\Jobs\RenderImage;

use App\Events\UserRegistered;

class EditAvatar extends Component
{
    public $query = null;

    public function render()
    {
        $user = Auth()->user();

        if (!$user->avatar_id) {
            $newAvatar = Avatar::create();
            $user->avatar_id = $newAvatar->id;
            $user->save();
        }

        $inventory = $user->inventory()->with('item')->simplePaginate(8);
        $avatar = $user->getAvatar();


        return view('livewire.user.edit-avatar', [
            'inventory' => $inventory,
            'equipped' => $avatar->equipped
        ]);
    }

    public function saveAvatar()
    {
        if (! $user = Auth()->user())
            dd('no login');

        //event(new UserRegistered($user));
        $user->doRender();
    }
}

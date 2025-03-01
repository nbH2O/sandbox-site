<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User\User;
use App\Models\User\Avatar;
use Livewire\WithPagination;
use App\Jobs\RenderImage;

use App\Events\UserRegistered;

class EditAvatar extends Component
{
    use WithPagination;

    public $query = null;

    public function render()
    {
        $user = Auth()->user();

        if (!$user->avatar_id) {
            $newAvatar = Avatar::create();
            $user->avatar_id = $newAvatar->id;
            $user->save();
        }

        $avatar = $user->getAvatar();
        $equippedIDs = [];
        foreach ($avatar->equipped as $equippedItem) {
            array_push($equippedIDs, $equippedItem->id);
        }

        $inventory = $user->inventory()->whereNotIn('item_id', $equippedIDs)->groupBy('id', 'item_id')->distinct()->with('item')->simplePaginate(8);

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

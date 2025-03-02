<?php

namespace App\Livewire\User;

use Livewire\Component;

use App\Models\User\User;
use App\Models\User\Avatar;
use App\Models\User\AvatarItem;
use App\Models\Item\Inventory;
use App\Models\Item\Item;

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
        $itemTypeIDs = array_flip(config('site.item_types'));

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

        $inventory = $user->inventory()
                        ->whereNotIn('item_id', $equippedIDs)
                        ->groupBy('id', 'item_id')
                        ->distinct()
                        ->whereDoesntHave('item', function ($query) use ($itemTypeIDs) {
                            $query->whereIn('type_id', [$itemTypeIDs['figure'], $itemTypeIDs['pack']]);
                        })
                        ->simplePaginate(8);

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

    public function unequip($id) 
    {
        $user = Auth()->user();
        $itemTypeIDs = array_flip(config('site.item_types'));
        
        $avatar = $user->avatar;
        $item = Item::where('id', $id)->first();

        if (in_array($item->type_id, [$itemTypeIDs['hat']])) {
            AvatarItem::where(['avatar_id' => $user->avatar_id, 'item_id' => $id])->delete();
        } else {
            $avatar->{config('site.item_types')[$item->type_id].'_id'} = null;
            $avatar->save();
        }
    }

    public function equip($id)
    {   
        $user = Auth()->user();
        $itemTypeIDs = array_flip(config('site.item_types'));
        
        if ($inv = $user->inventory()->with('item')->where('item_id', $id)->first()) {
            $item = $inv->item;
            $avatar = $user->avatar;

            if (in_array($item->type->id, [$itemTypeIDs['hat']])) {
                $avatarItems = $avatar->items();

                if ($avatarItems->count() <= config('site.max_avatar_items')) {
                    if (! AvatarItem::where(['avatar_id' => $user->avatar_id, 'item_id' => $id])->first()) {
                        AvatarItem::insert([
                            'item_id' => $id,
                            'avatar_id' => $user->avatar_id
                        ]);
                    }
                }
            } else {
                $avatar->{$item->type->name.'_id'} = $id;
                $avatar->save();
            }
        }
    }
}

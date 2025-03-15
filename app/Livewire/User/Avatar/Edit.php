<?php

namespace App\Livewire\User\Avatar;

use Livewire\Component;

use App\Models\User\User;
use App\Models\User\Avatar;
use App\Models\User\AvatarItem;
use App\Models\Item\Inventory;
use App\Models\Item\Item;

use Livewire\WithPagination;
use App\Jobs\RenderImage;

use App\Events\UserRegistered;

class Edit extends Component
{
    use WithPagination;

    public $query = null;

    public $type = 'accessory';

    public function updateType($val)
    {
        $this->type = $val;
    }

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

        $typeIDs = [];

        switch ($this->type) {
            case 'clothing':
                $typeIDs = [$itemTypeIDs['shirt'], $itemTypeIDs['pants'], $itemTypeIDs['suit']];
                break;
            case 'body':
                $typeIDs = [
                    $itemTypeIDs['head'], $itemTypeIDs['face'],
                    $itemTypeIDs['torso'],
                    $itemTypeIDs['arm_left'], $itemTypeIDs['arm_right'],
                    $itemTypeIDs['leg_left'], $itemTypeIDs['leg_right']
                ];
                break;
            case 'accessory':
            default:
                $typeIDs = [$itemTypeIDs['hat']];
                break;
        }

        $inventory = $user->inventory()
                        ->whereNotIn('item_id', $equippedIDs)
                        ->groupBy('id', 'item_id')
                        ->distinct()
                        ->whereHas('item', function ($query) use ($itemTypeIDs, $typeIDs) {
                            $query->whereIn('type_id', $typeIDs)
                                ->where('is_pending', 0)
                                ->where('is_accepted', 1);
                        })
                        ->simplePaginate(8);

        return view('livewire.user.avatar.edit', [
            'inventory' => $inventory,
            'equipped' => $avatar->equipped,
            'properties' => $avatar->properties
        ]);
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

            if (in_array($item->type->id, [$itemTypeIDs['hat'], $itemTypeIDs['shirt'], $itemTypeIDs['pants'], $itemTypeIDs['suit']])) {
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

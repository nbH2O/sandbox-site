<?php

namespace App\Livewire\Admin\Item;

use Livewire\Component;
use App\Models\Item\Item;
use App\Models\User\User;
use Livewire\WithPagination;

class Queue extends Component
{
    use WithPagination;

    public function accept(int $id) {
        $item = Item::find($id);

        if($item->is_pending == 1) {
            $item->is_accepted = 1;
            $item->is_pending = 0;
            $item->save();

            $user = User::find($item->creator_id);
            $item->grantTo($user, true);

            $item->doRender();
        }
    }

    public function decline(int $id) {
        $item = Item::find($id);

        if($item->is_pending == 1) {
            $item->is_accepted = 0;
            $item->is_pending = 0;
            $item->save();
        }
    }

    public function render()
    {      
        $items = Item::where('is_pending', 1)->simplePaginate(8);
        
        return view('livewire.admin.item.queue', [
            'items' => $items
        ]);
    }
}

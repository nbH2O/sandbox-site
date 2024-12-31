<?php

namespace App\Livewire\Item;

use Livewire\Component;
use App\Models\Item;

class Search extends Component
{
    public $query = null;

    public function render()
    {
        $sql = Item::with(['creator', 'type' => function ($query) {
                        $query->where('is_public', true);
                    }])
                    ->where('name', 'LIKE', '%'.$this->query.'%')
                    ->paginate(16);
        return view('livewire.item.search', [
            'items' => $sql
        ]);
    }
}

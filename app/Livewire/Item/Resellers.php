<?php

namespace App\Livewire\Item;

use Livewire\Component;
use App\Models\Item\Item;
use Livewire\WithPagination;
use Livewire\Attributes\On; 

class Resellers extends Component
{
    use WithPagination;

    #[Locked]
    public $item;
    
    public $tabbed = false;
    #[Locked]
    public $loaded = false;

    public function mount(Item $item)
    {
        // Proper initialization
        $this->item = $item;
    }

    #[On('economyTab')]
    public function setTabbed()
    {
        $this->tabbed = true;
    }

    public function render()
    {
        $resellers = null;

        if ($this->tabbed == true) {
            $resellers = $this->item->resellers()->simplePaginate(6);
        }

        return view('livewire.item.resellers', [
            'resellers' => $resellers
        ]);
    }
}

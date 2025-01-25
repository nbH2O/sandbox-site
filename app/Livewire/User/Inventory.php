<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User\User;
use Livewire\WithPagination;
use Livewire\Attributes\On; 

class Inventory extends Component
{
    use WithPagination;

    #[Locked]
    public $user;
    
    public $tabbed = false;
    #[Locked]
    public $loaded = false;

    public function mount(User $user)
    {
        // Proper initialization
        $this->user = $user;
    }

    #[On('inventoryTab')]
    public function setTabbed()
    {
        $this->tabbed = true;
    }

    public function render()
    {
        $inventory = null;

        if ($this->tabbed == true) {
            $inventory = $this->user->inventory()->with('item')->simplePaginate(8);
        }

        return view('livewire.user.inventory', [
            'inventory' => $inventory
        ]);
    }
}

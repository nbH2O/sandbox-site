<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;

class Search extends Component
{
    public $query = null;

    public function render()
    {
        return view('livewire.user.search', [
            'users' => User::where('name', 'LIKE', '%'.$this->query.'%')->paginate(12),
        ]);
    }
}

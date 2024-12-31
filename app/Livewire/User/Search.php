<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User\User;

class Search extends Component
{
    public $query = null;

    public function render()
    {
        return view('livewire.user.search', [
            'users' => User::with(['roles' => function ($query) {
                $query->limit(3); // Add condition to filter the relationship
            }])->where('name', 'LIKE', '%'.$this->query.'%')->paginate(12),
        ]);
    }
}

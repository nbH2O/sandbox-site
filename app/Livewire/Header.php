<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Header extends Component
{
    public function destroySession()
    {
        Auth::logout();
 
        session()->invalidate();
        session()->regenerateToken();
    
        return $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.header');
    }
}

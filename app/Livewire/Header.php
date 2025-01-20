<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

use App\Models\User\Notification;

class Header extends Component
{
    #[Locked]
    public Collection $notifications;

    public function mount()
    {
        $this->notification = collect();
    }

    public function destroySession()
    {
        Auth::logout();
 
        session()->invalidate();
        session()->regenerateToken();
    
        return $this->redirect('/');
    }

    public function getNotifications()
    {
        $res = Auth::user()->unreadNotifications()->limit(6)->get();
        $this->notifications = $res;
    }
    public function setNotificationsRead()
    {
        Auth::user()->unreadNotifications()->update(['read_at' => now()]);
    }

    public function render()
    {
        return view('livewire.header');
    }
}

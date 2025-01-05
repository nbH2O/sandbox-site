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
        $res = Auth::user()->notifications()->limit(6)->get();
        if ($res) {
            session(['previousNotificationCount' => $res->count()]);
        }
        $this->notifications = $res;
    }
    public function setAllNotificationsRead()
    {
        Notification::where('user_id', Auth::user()->id)->update(['is_read', true]);
    }

    public function render()
    {
        return view('livewire.header');
    }
}

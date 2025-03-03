<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User\UserFriendship;
use App\Models\User\User;

use App\Notifications\FriendRequestReceived;

class FriendButton extends Component
{
    // commentable
    #[Locked]
    public $user;
    #[Locked]
    public $action;

    public function mount(User $user)
    {
        // Proper initialization
        $this->user = $user;
    }

    private function getFriendshipAction()
    {
        $au = Auth()->user();

        $res = UserFriendship::where(function ($q) use ($au) {
            $q->where('sender_id', $this->user->id)
                ->orWhere('sender_id', $au->id);
        })
        ->andWhere(function ($q) use ($au) {
            $q->where('receiver_id', $this->user->id)
                ->orWhere('receiver_id', $au->id);
        })->first();

        if ($this->user->id == $au->id)
            return null;

        if (!$res) {
            return 'send';
        } else if ($res->is_accepted == true) {
            return 'remove';
        } else if ($res->sender_id == $au->id) {
            return 'cancel';
        } else if ($res->receiver_id == $au->id) {
            return 'decline';
        }

        return null;
    }

    public function doAction($action = null) // only used for accept
    {
        if (!$au = Auth()->user()) {
            return $this->redirect(route('login'));
        }

        $fa = $this->getFriendshipAction();

        if ($action == 'accept') {
            UserFriendship::where('sender_id', $this->user->id)
                            ->where('receiver_id', $au->id)
                            ->update(['is_accepted' => true]);
        } else if ($fa == 'remove' || $fa == 'cancel' || $fa == 'decline') {
            UserFriendship::where(function ($q) use ($au) {
                $q->where('sender_id', $this->user->id)
                    ->orWhere('sender_id', $au->id);
            })
            ->orWhere(function ($q) use ($au) {
                $q->where('receiver_id', $this->user->id)
                    ->orWhere('receiver_id', $au->id);
            })->delete();
        } else if ($fa == 'send') {
            UserFriendship::insert([
                'sender_id' => Auth()->user()->id,
                'receiver_id' => $this->user->id,
                'is_accepted' => false
            ]);
            
            $this->user->notify(new FriendRequestReceived(Auth()->user()));
        }
    }

    public function render()
    {
        $this->action = $this->getFriendshipAction();

        return view('livewire.user.friend-button', [
            'action' => $this->action,
            'name' => $this->user->name
        ]);
    }
}

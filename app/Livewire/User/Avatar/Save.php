<?php

namespace App\Livewire\User\Avatar;

use Livewire\Component;

use App\Models\User\User;
use Illuminate\Support\Facades\Session;

class Save extends Component
{
    public $url = null;

    public $rateLimited = false;
    
    public $properties;

    public function mount()
    {
        $this->url = Auth()->user()->getRender();
    }

    public function render()
    {
        return view('livewire.user.avatar.save', [
            'url' => $this->url,
            'properties' => $this->properties,
            'rateLimited' => $this->rateLimited
        ]);
    }

    public function changeColor($part, $newColor)
    {
        if (! $user = Auth()->user())
            dd();

        if (! preg_match('/^#[a-fA-F0-9]{6}$/', $newColor))
            dd();

        $user->avatar->{$part.'_color'} = $newColor;
        $user->avatar->save();
    }

    public function saveAvatar()
    {
        if (! $user = Auth()->user())
            dd();

        function storeEvent()
        {
            // Get the current time
            $timestamp = now(); 
            // Get the current events from the session, or initialize an empty array
            $events = Session::get('renderEvents', []);
            // Add the new event with its timestamp
            array_push($events, $timestamp);
            // Store the updated events array back in the session
            Session::put('renderEvents', $events);
        }
        function countEventsWithin5Minutes()
        {
            // Get the current events from the session
            $events = Session::get('renderEvents', []);
            // Filter events that happened within the last 5 minutes
            $fiveMinutesAgo = now()->subMinutes(5);
            $recentEvents = array_filter($events, function ($event) use ($fiveMinutesAgo) {
                return $event >= $fiveMinutesAgo;
            });
            // Return the count of events that happened in the last 5 minutes
            return count($recentEvents);
        }

        if(countEventsWithin5Minutes() < 5) {
            storeEvent();
            $this->rateLimited = false;
            //event(new UserRegistered($user));
            $user->doRender(true);

            $sql = User::where('id', Auth()->user()->id)->select('render_ulid')->first();

            $this->url = url('storage/'.$sql->render_ulid.'.png');
        } else {
            $this->rateLimited = true;
        }
    }
}

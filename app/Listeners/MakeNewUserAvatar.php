<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\User\Avatar;

class MakeNewUserAvatar
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        $colors = ['#5DA93D', '#009BEE', '#E02D2D', '#FFA10B'];
        $na = Avatar::create([
            'head_color' => '#ffd92e',
            'arm_left_color' => '#ffd92e',
            'arm_right_color' => '#ffd92e',

            'torso_color' => $colors[array_rand($colors)],
            'leg_left_color' => '#141414',
            'leg_right_color' => '#141414'
        ]);
        $event->user->avatar_id = $na->id;
        $event->user->save();

        $event->user->doRender();
    }
}

<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

use App\Models\User\VerificationToken;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;

class SendVerificationEmail
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
        $token = VerificationToken::create([
            'user_id' => $event->user->id,
            'token' => Str::uuid(),
            'expires_at' => now()->addDays(1)
        ]);

        Mail::to($event->user)
            ->send(new VerifyEmail($token));
    }
}

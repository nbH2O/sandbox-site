<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User\User;
use App\Models\User\VerificationToken;

class UserController extends Controller
{
    public function profile(int $id)
    {
        return view('user.profile', [
            'user' => User::with(['roles' => function ($query) {
                $query->limit(3); // Add condition to filter the relationship
            }, 'friends' => function ($query) {
                $query->limit(4);
            }])->where('id', $id)->firstOrFail()
        ]);
    }

    public function banned()
    {
        $ban = Auth()->user()
                ->bans()
                ->notExpired()
                ->orderBy('expired_at', 'DESC')
                ->get();
    
        if (isset($ban[0])) {
            return view('user.banned', [
                'ban' => $ban[0]
            ]);
        } else {
            return redirect('/');
        }
    }

    public function verify(int $id, string $token)
    {
        if ($id && $token) {
            $token = VerificationToken::where(['id' => $id, 'token' => $token])->first();

            if ($token && $token->expires_at >= now()) {
                $user = User::find($token->user_id);
                $user->email_verified_at = now();
                $user->save();

                $token->delete();

                return view('user.verify.email', [
                    'success' => true
                ]);
            }
        }

        return view('user.verify.email', [
            'success' => false
        ]);
    }
}

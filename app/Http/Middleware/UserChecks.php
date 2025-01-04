<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;
use App\Models\User\User;

class UserChecks
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($user = Auth::user()) {
            // ban
            if ($user->isBanned()) {
                return redirect(route('banned'));
            }
            // daily reward
            if($user->rewarded_at <= now()->subHours(24)) {
                if ($user->hasVerifiedEmail()) {
                    $user->increment('currency', 2);
                    $user->rewarded_at = now();
                    $user->save();
                    $request->session()->flash('userRewarded', true);
                } else {
                    $request->session()->flash('userRewarded', false);
                }
            }
        }

        return $next($request);
    }
}

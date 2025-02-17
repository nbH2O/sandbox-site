<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;
use App\Models\User\User;

use Carbon\Carbon;

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
            if ($user->online_at < now()->subMinutes(3)) {
                $user->online_at = now();
                $user->save();
            }
            // ban
            if ($user->isBanned()) {
                if ($request->route()->getName() == 'banned' 
                    // for appealz
                    || $request->route()->getName() == 'contact'
                ) {
                    return $next($request);
                } else {
                    return redirect(route('banned'));
                }
            }
            // daily reward
            if($user->rewarded_at <= now()->subHours(24)) {
                $do = true;
                if (session('userRewardFailed') && !$user->hasVerifiedEmail()) {
                    if (Carbon::parse(session('userRewardFailed'))->addHours(12)->isFuture() ) {
                        $do = false;
                    }
                }

                if ($do == true) {
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
        }

        return $next($request);
    }
}

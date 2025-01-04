<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MinPower
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, int $minPower): Response
    {
        if ($user = $request->user()) {
            if ($role = $user->anyRoles()->first()) {
                if ($role->power >= $minPower) {
                    return $next($request);
                }
            }
        }

        // this 1 wont show a page
        return abort(404);
    }
}

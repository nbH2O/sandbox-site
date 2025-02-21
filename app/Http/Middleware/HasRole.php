<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $name, $bypassPower): Response
    {
        if ($user = $request->user()) {
            if (
                $role = $user->anyRoles()->where('name', $name)->first()
                || $user->anyRoles()->first()->power >= $bypassPower
            ) {
                return $next($request);
            }
        }

        // this 1 wont show a page
        return abort(404);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Site\SoftMaintenance as Model;

class SoftMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
            if ($res = Model::orderBy('id', 'DESC')->first()) {
                if ($res->is_bypassable && $res->min_power) {
                    // allow livewire to bypass
                    if ($request->route()->getName() === 'livewire.update') {
                        return $next($request);
                    }
                    if ($user = $request->user()) {
                        if ($role = $user->anyRoles()->first()) {
                            if ($role->power >= $res->min_power) {
                                return $next($request);
                            }
                        }
                    }
                }

                return response(view('site.maintenance', [
                    'message' => $res->message
                ]));
            }

        return $next($request);
    }
}

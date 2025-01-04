<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Site\FeatureStatus as Model;

class FeatureStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($name = $request->route()->getName()) {
            $res = Model::where('name', $name)->first();

            if ($res) {
                if ($res->is_enabled == false) {
                    return response(view('site.feature-disabled', [
                        'message' => $res->message
                    ]));
                }
            }
        }

        return $next($request);
    }
}

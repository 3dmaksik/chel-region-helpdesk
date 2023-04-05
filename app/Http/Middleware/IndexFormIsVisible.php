<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IndexFormIsVisible
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (config('settings.startForm') == false) {
            return abort(404);
        }

        return $next($request);
    }
}

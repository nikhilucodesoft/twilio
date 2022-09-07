<?php

namespace App\Http\Middleware;

use Closure;

class StarReturnMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->input('Digits') === '*') {
            return redirect()->route('welcome');
        }
        return $next($request);
    }
}

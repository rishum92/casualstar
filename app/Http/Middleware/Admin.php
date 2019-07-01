<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::user()->title == 'ADMIN') {
            return $next($request);
        } else {
            if(Auth::check()) {
                return redirect()->route('dashboard')->with('message', 'Unauthorized.')->with('messageType','danger');
            } else {
                return redirect()->route('index')->with('message', 'Unauthorized.')->with('messageType','danger');
            }
        }

    }
}

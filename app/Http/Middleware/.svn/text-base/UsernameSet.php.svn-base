<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UsernameSet
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
        if(Auth::check()) {
            if($request->route()->getName() !== 'logout') {
                if(is_null(Auth::user()->username)) {
                    return redirect()->route('set.username')->with('message', 'Welcome! Please choose your username to access the website.')->with('messageType','success');
                }
            }
        }

        return $next($request);
    }
}

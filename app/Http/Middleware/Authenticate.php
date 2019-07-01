<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Lang;

class Authenticate
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

        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('/');
            }
        } else {
            if(Auth::check()) {
                if(Auth::user()->status == -1) {
                    Auth::logout();
                    return redirect()->route('index')->with('messageType', 'danger')->with('message', Lang::get('messages.accountLocked'))->with('toggleLogin', false);
                }
            }
        }
    
        return $next($request);
    }
}

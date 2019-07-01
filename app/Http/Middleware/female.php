<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class female
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
        $gender = Auth::user()->gender;
        if ( $gender AND strtoupper($gender)!='FEMALE') {
            return redirect('dashboard')->with('message', 'You are not allowed in this page.')->with('messageType','danger');;
        }
       // echo Auth::user()->gender;
        
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Role;
use App\User;

class CheckAdmin
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
        if (! Auth::user()->roles()->where('name','=','admin')->exists()) {
            
            return redirect('/')->withErrors(['Ne moze CREATE kad nisi JA', 'The Message']);

        }

        return $next($request);
    }
}

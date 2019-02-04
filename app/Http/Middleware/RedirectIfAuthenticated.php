<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
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
        /*if (Auth::guard($guard)->check()) {
            return redirect('/home');
        }*/

        

        switch ($guard) {
            case 'admin':
                if(Auth::guard($guard)->check()) {
                    return redirect()->route('admin.dashboard');
                }
                
                break;

            case 'teacher':
                if(Auth::guard($guard)->check()) {
                    return redirect()->route('teacher.dashboard');
                }
                
                break;
            
            case 'student':
                if(Auth::guard($guard)->check()) {
                    return redirect()->route('student.sections');
                }
                
                break;
        }

        return $next($request);
    }
}

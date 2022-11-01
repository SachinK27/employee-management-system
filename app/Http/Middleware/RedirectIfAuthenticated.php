<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // return redirect(RouteServiceProvider::HOME);
                $roles = Auth::user()->role; 
            
                switch ($roles) {
                    case 1:
                        return redirect('/admin/dashboard');
                        break;
                    case 2:
                        return redirect('/l1/dashboard');
                        break;
                    case 3:
                        return redirect('/l2/dashboard');
                        break;
                    case 4:
                        return redirect('/l3/dashboard');
                        break;
                    // default:
                    //     return redirect('/home'); 
                    //     break;
                }
            }
        }

        return $next($request);
    }
}

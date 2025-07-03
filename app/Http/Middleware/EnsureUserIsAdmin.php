<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if(auth()->check() && auth()->user()->hasRole('Admin')){
            // return $next($request);
        // }else{
        //     auth()->user()->logout();
        //     redirect()->route('login');
        // }

        // if (!auth()->check()) {
        //     return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à l\'administration');
        // }

        return $next($request);

    }
}

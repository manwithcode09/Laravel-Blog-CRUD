<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     * This is custom middleware for admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    //Method handle berfungsi untuk menjalankan semua logicnya
    public function handle(Request $request, Closure $next)
    {
        //jika user belum login, atau yg login bukan admin
        if(auth()->guest() || !auth()->user()->is_admin) {

            //maka tampilkan forbidden
            abort(403);
        }

        return $next($request);
    }
}

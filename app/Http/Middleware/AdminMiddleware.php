<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {

    
// -----------------------------
        // 1. Check wach l-user m-connecti
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. ILA KAN ADMIN - Daz (Dkhel l-dashboard)
        if (Auth::user()->role === 'admin') {
            return $next($request);
        }

        // 3. ILA KAN CLIENT - "RETURN" Hwa l-ghalta li kanet 3ndek
        // Darori t-koun "return" bach i-hbess l-request o i-redirect-i
        return redirect()->route('dashboard')->with('error', 'Ma-3ndekch l-haqq t-dkhel hna!');

// ------------------------        
        // test==>wach kayfre9 bin lclient oadmin 

        // dd(Auth::user()->role);

        // if (Auth::user()->role === 'admin') {
        //     return $next($request);
        // }
        // return redirect('/dashboard');
    }
}

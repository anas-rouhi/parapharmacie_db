<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // إيلا مكانش مسجل أولا كان الدور ديالو ماشي admin، كيبلوكا وكيطلع ليه خطأ 403
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Accès interdit. Réservé à l\'administrateur.');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role_id === 1) {
            return $next($request); // Permite acesso ao admin
        }

        return redirect('/')->with('error', 'Acesso negado!'); // Redireciona se não for admin
    }
}

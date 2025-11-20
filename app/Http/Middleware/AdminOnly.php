<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        // Si l'admin n'est pas marqué en session → on renvoie au login
        if (! $request->session()->get('is_admin')) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}

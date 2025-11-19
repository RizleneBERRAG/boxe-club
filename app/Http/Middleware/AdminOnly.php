<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Non connecté → vers login admin
        if (!$user) {
            return redirect()->route('admin.login');
        }

        // Connecté mais pas admin → vers home
        if (!$user->is_admin) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}

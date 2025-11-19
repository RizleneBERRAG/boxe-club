<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identifier' => 'required|string',
            'password'   => 'required|string',
        ]);

        $login    = $credentials['identifier'];
        $password = $credentials['password'];
        $remember = false;

        // Tentative par email
        $ok = Auth::attempt([
            'email'    => $login,
            'password' => $password,
            'is_admin' => 1,
        ], $remember);

        // Si échec, tentative par name (nom d'utilisateur)
        if (!$ok) {
            $ok = Auth::attempt([
                'name'     => $login,
                'password' => $password,
                'is_admin' => 1,
            ], $remember);
        }

        if ($ok) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()
            ->withErrors(['identifier' => 'Identifiants invalides.'])
            ->withInput($request->only('identifier'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}

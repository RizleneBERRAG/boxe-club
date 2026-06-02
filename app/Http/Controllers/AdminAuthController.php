<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        // Les 2 champs de ton formulaire : name="login" et name="password"
        $credentials = $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $login    = $credentials['login'];
        $password = $credentials['password'];

        // On compare avec config/admin.php
        if (
            $login === config('admin.login') &&
            hash_equals(config('admin.password'), $password)
        ) {
            // On marque l'admin comme connecté
            $request->session()->put('is_admin', true);
            $request->session()->regenerate();

            // Va sur le dashboard
            return redirect()->intended(route('admin.dashboard'));
        }

        // Sinon on revient au formulaire avec un message
        return back()
            ->withErrors(['login' => 'Identifiants incorrects.'])
            ->withInput($request->only('login'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget('is_admin');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}

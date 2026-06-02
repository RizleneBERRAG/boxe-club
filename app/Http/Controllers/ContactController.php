<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => ['required','string','max:120'],
            'email' => ['required','email','max:150'],
            'message' => ['required','string','max:2000'],
            'rgpd'  => ['accepted'],
        ]);

        // TODO: envoyer un mail – pour l’instant on log
        Log::info('Contact form', $data);

        return back()->with('ok', 'Merci ! Votre message a été envoyé.');
    }
}

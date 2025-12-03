<?php

namespace App\Http\Controllers;

use App\Models\GeneratedTicket;
use Illuminate\Http\Request;

class TicketCheckinController extends Controller
{
    public function verify($uuid)
    {
        // On recherche le ticket avec l’UUID scanné
        $ticket = GeneratedTicket::where('uuid', $uuid)->first();

        if (!$ticket) {
            return response()->json([
                'status' => 'error',
                'message' => 'Billet introuvable.',
            ], 404);
        }

        // Si déjà scanné, on empêche l’entrée
        if ($ticket->scanned_at !== null) {
            return response()->json([
                'status' => 'already_used',
                'message' => 'Ce billet a déjà été utilisé.',
                'scanned_at' => $ticket->scanned_at,
            ]);
        }

        // Sinon, on marque comme scanné maintenant
        $ticket->update([
            'scanned_at' => now(),
            'status'     => 'used',
        ]);

        return response()->json([
            'status' => 'valid',
            'message' => 'Billet valide 👍 Entrée autorisée.',
        ]);
    }
}

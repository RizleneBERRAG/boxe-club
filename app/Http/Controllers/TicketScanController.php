<?php

namespace App\Http\Controllers;

use App\Models\GeneratedTicket;
use Illuminate\Http\Request;

class TicketScanController extends Controller
{
    public function verify(string $uuid, Request $request)
    {
        $ticket = GeneratedTicket::where('uuid', $uuid)->first();

        // Pas trouvé
        if (!$ticket) {
            return $this->respond(
                $request,
                'invalid',
                "Billet introuvable ❌",
                null
            );
        }

        // Déjà utilisé
        if ($ticket->status !== 'valid' || $ticket->scanned_at) {
            return $this->respond(
                $request,
                'already_used',
                "Ce billet a déjà été utilisé.",
                $ticket
            );
        }

        // OK → on marque comme utilisé
        $ticket->update([
            'status'     => 'used',
            'scanned_at' => now(),
        ]);

        return $this->respond(
            $request,
            'valid',
            "Billet valide 👍 Entrée autorisée.",
            $ticket
        );
    }

    /**
     * Si ?json=1 → JSON (pour une app / scanner).
     * Sinon → jolie page HTML.
     */
    protected function respond(Request $request, string $status, string $message, ?GeneratedTicket $ticket)
    {
        // Mode API / JSON
        if ($request->query('json') == 1) {
            return response()->json([
                'status'     => $status,
                'message'    => $message,
                'ticket'     => $ticket,
                'scanned_at' => $ticket?->scanned_at,
            ]);
        }

        // Mode navigateur
        return view('gala.ticket-status', [
            'status'  => $status,
            'message' => $message,
            'ticket'  => $ticket,
        ]);
    }
}

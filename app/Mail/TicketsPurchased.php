<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketsPurchased extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order->load('items.ticketType', 'items.generatedTickets');
    }

    public function build()
    {
        $email = $this->subject('Tes billets – Team Bafounta')
            ->view('emails.tickets-purchased', [
                'order' => $this->order,
            ]);

        // ➜ On attache **tous les QR codes** générés
        foreach ($this->order->items as $item) {
            foreach ($item->generatedTickets as $ticket) {
                if (! $ticket->qr_code_path) {
                    continue;
                }

                $email->attachFromStorageDisk(
                    'public',                      // le disk
                    $ticket->qr_code_path,        // ex: qrcodes/xxx.svg
                    'billet-'.$ticket->uuid.'.svg',
                    ['mime' => 'image/svg+xml']
                );
            }
        }

        return $email;
    }
}

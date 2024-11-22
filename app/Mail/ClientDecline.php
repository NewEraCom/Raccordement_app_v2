<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientDecline extends Mailable
{
    use Queueable, SerializesModels;

    public $client, $old_technicien, $old_blocage;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($client,$old_technicien,$old_blocage)
    {
        $this->client = $client;
        $this->old_technicien = $old_technicien;
        $this->old_blocage = $old_blocage;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.client-decline', [
            'client' => $this->client,
            'technicien' => $this->old_technicien,
            'blocage' => $this->old_blocage,
        ])->subject('Feedback de client : ' . $this->client->sip.'//'.$this->client->name)->from("declaration@neweracom.ma", "Contrôle Qualité");
    }
}

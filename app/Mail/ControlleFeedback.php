<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ControlleFeedback extends Mailable
{
    use Queueable, SerializesModels;

    public $client,$note;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($client,$note)
    {
        $this->client = $client;
        $this->note = $note;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.controlle-feedback', [
            'client' => $this->client,
            'note' => $this->note,
        ])->subject('Retard d\'installation pour le client : ' . $this->client->sip.'//'.$this->client->name)->from("declaration@neweracom.ma", "Contrôle Qualité");
    }
}

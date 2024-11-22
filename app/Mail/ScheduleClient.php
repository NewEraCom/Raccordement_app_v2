<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScheduleClient extends Mailable
{
    use Queueable, SerializesModels;

    public $client, $old_technicien, $old_blocage,$new_date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($client,$old_technicien,$old_blocage,$new_date)
    {
        $this->client = $client;
        $this->old_technicien = $old_technicien;
        $this->old_blocage = $old_blocage;
        $this->new_date = $new_date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.schedule-client', [
            'client' => $this->client,
            'technicien' => $this->old_technicien,
            'blocage' => $this->old_blocage,
            'new_date' => $this->new_date,
        ])->subject('Planification de client : ' . $this->client->sip.'//'.$this->client->name)->from("declaration@neweracom.ma", "Contrôle Qualité");
    }
}

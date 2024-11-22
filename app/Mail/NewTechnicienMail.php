<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewTechnicienMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.new-technicien-email', [
            'user' => $this->user, 'password' => $this->password
        ])->subject('Notification de création d\'un nouveau technicien')->from("racco@neweraconnect.ma", "Neweracom_racco");
    }
}

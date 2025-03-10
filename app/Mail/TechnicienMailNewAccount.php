<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TechnicienMailNewAccount extends Mailable
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
        return $this->markdown('emails.technicien-new-account-email',[
            'user' => $this->user,'password' => $this->password
        ])->subject('Notification de création de votre compte technicien')->from("declaration@neweracom.ma", "Neweracom");
    }
}

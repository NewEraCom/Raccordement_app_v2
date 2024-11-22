<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeclarationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $declaration;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($declaration)
    {
        $this->declaration = $declaration;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.declaration-email', [
            'user' => $this->declaration
        ])->subject('Declaration NEWERACOM')->from("declaration@neweracom.ma", "Declaration Neweracom");
    }
}

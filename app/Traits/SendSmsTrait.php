<?php

declare(strict_types=1);

namespace App\Traits;

use Twilio\Rest\Client;

trait SendSmsTrait
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(
            env('TWILIO_SID'), 
            env('TWILIO_AUTH_TOKEN')
        );
    }

    public function sendSms($to, $message)
    {
        try {
            return $this->twilio->messages->create($to, [
                'from' => env('TWILIO_PHONE_NUMBER'),
                'body' => $message
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

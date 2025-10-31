<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriberWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function build()
    {
        return $this->subject('🎉 Thank you for subscribing!')
            ->view('emails.subscriber_welcome')
            ->with([
                'email' => $this->email,
            ]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNewSubscriberMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function build()
    {
        return $this->subject('📨 New Subscriber Alert')
            ->view('emails.admin_new_subscriber')
            ->with([
                'email' => $this->email,
            ]);
    }
}

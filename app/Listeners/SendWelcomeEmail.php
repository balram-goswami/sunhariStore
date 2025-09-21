<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserWelcomeMail;

class SendWelcomeEmail
{
    public function handle(Registered $event)
    {
        
        Mail::to($event->user->email)
            ->send(new \App\Mail\UserWelcomeMail($event->user));
    }
}

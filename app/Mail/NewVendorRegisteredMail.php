<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewVendorRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $vendor;

    public function __construct(User $vendor)
    {
        $this->vendor = $vendor;
    }

    public function build()
    {
        return $this->subject('New Vendor Registered')
                    ->view('Email.new-vendor-registered');
    }
}

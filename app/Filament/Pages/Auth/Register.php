<?php

namespace App\Filament\Pages\Auth;

use App\Mail\NewVendorRegisteredMail;
use App\Models\Enums\UserRoles;
use App\Models\User;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class Register extends BaseRegister
{
    protected function handleRegistration(array $data): User
    {
        $data['role'] = UserRoles::Manager->value;

        $user = User::create($data);

        // Fire the registration event - this sends the verification email
        event(new Registered($user));

        // Notify admin about new vendor
        Mail::to('admin@example.com')->send(new NewVendorRegisteredMail($user));

        return $user; 
    }

    protected function getRedirectUrl(): string
    {
        return route('verification.notice'); // Redirect to verification notice first
        // OR return dashboard if you handle the check in login
        // return route('filament.pages.vendor-dashboard');
    }
}

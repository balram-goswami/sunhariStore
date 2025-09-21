<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Login extends BaseLogin
{
    public function getUser(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        $credentials = $this->form->getState();

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        if (! $user->hasVerifiedEmail()) {
            $this->notify('danger', 'Please verify your email before logging in.');
            return null;
        }

        return $user;
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function show()
    {
        $view = "Templates.Register";
        return view('Front', compact('view'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'confirmed', // ensures password_confirmation matches
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
            ],
        ]);

        // Create user securely
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => \App\Models\Enums\UserRoles::User->value, // default frontend user
            'status' => \App\Models\Enums\UserStatus::Pending, // default status
        ]);

        // Fire email verification event
        event(new Registered($user));

        // Login user securely using web guard
        auth()->guard('web')->login($user);

        // Regenerate session to prevent session fixation
        $request->session()->regenerate();

        return redirect()->route('homePage')->with('success', 'Account created! Please verify your email.');
    }
}

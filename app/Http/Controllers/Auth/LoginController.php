<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        $view = "Templates.Login"; 
        return view('Front', compact('view'));
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Only active users
            if (auth()->user()->status !== \App\Models\Enums\UserStatus::Active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account is not active yet.']);
            }

            return redirect()->route('profile');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }
}

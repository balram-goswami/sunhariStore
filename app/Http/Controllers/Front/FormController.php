<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Query;

class FormController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'number' => 'required|max:20',
            'message' => 'required|string|max:1000',
        ]);

        Query::create([
            'query_type' => 'chatbot',
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'message' => $request->message,
        ]);

        return response()->json(['success' => true]);
    }
}

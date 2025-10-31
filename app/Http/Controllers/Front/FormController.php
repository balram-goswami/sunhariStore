<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Validator, DateTime, Config, Helpers, Hash, DB, Session, Auth, Redirect;
use GuzzleHttp\Client;
use App\Mail\SubscriberWelcomeMail;
use App\Mail\AdminNewSubscriberMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUserMail;
use App\Mail\AdminContactNotificationMail;
use App\Mail\ChatUserMail;
use App\Mail\AdminChatNotificationMail;


use App\Models\Query;

class FormController extends Controller
{
    public function saveChat(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'number' => 'required|max:20',
                'message' => 'required|string|max:1000',
            ]);

            $data = $request->only('name', 'email', 'number', 'message');

            Query::create([
                'query_type' => 'chatbot',
                'name' => $data['name'],
                'email' => $data['email'],
                'number' => $data['number'],
                'message' => $data['message'],
            ]);

            // Send confirmation to user
            Mail::to($data['email'])->send(new ChatUserMail($data['name']));

            // Notify admin
            Mail::to('sunhari.in2025@gmail.com')->send(new AdminChatNotificationMail($data));

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Chatbot Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function contactUsForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'number' => 'required|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        try {
            $data = $request->only('name', 'email', 'number', 'subject', 'message');

            $form = new Query();
            $form->query_type = 'contact';
            $form->name = $data['name'];
            $form->email = $data['email'];
            $form->number = $data['number'];
            $form->subject = $data['subject'];
            $form->message = $data['message'];
            $form->save();

            // Send thank-you to user
            Mail::to($data['email'])->send(new ContactUserMail($data['name']));

            // Send notification to admin
            Mail::to('sunhari.in2025@gmail.com')->send(new AdminContactNotificationMail($data));

            return response()->json(['message' => 'Thanks for connecting', 'action' => 'success'], 200);
        } catch (\Exception $e) {
            \Log::error('Contact Form Error: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred. Please try again later.'], 500);
        }
    }


    public function subscribeForm(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        try {
            $existingUser = Query::where('email', $request->email)
                ->where('query_type', 'subscribe')
                ->first();

            if ($existingUser) {
                return response()->json(['message' => 'This email is already subscribed'], 422);
            }

            // Save new subscriber
            $form = new Query;
            $form->name = 'subscribe';
            $form->query_type = 'subscribe';
            $form->email = $request->email;
            $form->save();

            // Send emails
            Mail::to($request->email)->send(new SubscriberWelcomeMail($request->email));

            // Admin email (update with your admin email)
            Mail::to('sunhari.in2025@gmail.com')->send(new AdminNewSubscriberMail($request->email));

            return response()->json(['message' => 'Thank you for subscribing!'], 200);
        } catch (\Exception $e) {
            \Log::error('Subscription Error: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while processing your request. Please try again later.'], 500);
        }
    }

    public function formsave()
    {
        $breadcrumbs = [
            'title' => 'Thank you',
            'metaTitle' => 'Thank you',
            'metaDescription' => 'Thank you',
            'metaKeyword' => 'Thank you',
            'links' => [
                ['url' => url('/'), 'title' => 'Home']
            ]
        ];
        $view = 'Templates.FormSave';
        return view('Front', compact('view', 'breadcrumbs'));
    }
}

<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use GuzzleHttp\Client;
use App\Models\{Product, SiteSetting};


use Illuminate\Support\Facades\Http;
use Validator, DateTime, Config, Helpers, Hash, DB, Session, Auth, Redirect;

class HomeController extends Controller
{

  public function homePage()
  {
    $view = "Templates.Home"; 
    $product = Product::where('status', 2)->get(); 

    $breadcrumbs = [
      'title' => '',
      'metaTitle' => '',
      'metaDescription' => '',
      'metaKeyword' => '',
      'links' => [
        ['url' => url('/'), 'title' => 'Home']
      ]
    ];

    return view('Front', compact('view', 'product'));
  }
  
  public function profile()
  {
    $view = "Templates.Profile";

    return view('Front', compact('view'));
  }

  public function contuctUs()
  {
    $view = "Templates.ContactUs";
    $contact = SiteSetting::first();

    return view('Front', compact('view', 'contact'));
  }

  public function aboutUs()
  {
    $view = "Templates.AboutUs";


    return view('Front', compact('view'));
  }

  
  private function mailAddress()
  {
    return [
      'to' => 'admin@example.com',
      'cc' => ['support@example.com'],
    ];
  }

  public function contactUsForm(Request $request)
  {
    // Validation
    $validator = Validator::make($request->all(), [
      'query_from' => 'nullable|string',
      'fake_entry' => 'nullable',
      'name' => 'required|string|max:255',
      'email' => 'required|email|max:255',
      'mobile' => 'nullable|numeric',
      'subject' => 'required|string|max:255',
      'message' => 'required|string',
    ]);

    // Honeypot bot protection
    if ($request->filled('fake_entry')) {
      return response()->json(['message' => 'You are a Robot'], 422);
    }

    if ($validator->fails()) {
      return response()->json(['message' => $validator->errors()->first()], 422);
    }

    try {
      // Optional: check for duplicate email
      $existingUser = Enquiry::where('email', $request->email)->latest()->first();
      if ($existingUser) {
        return response()->json(['message' => 'This email has already submitted a request'], 422);
      }

      // Save to database
      $form = new Enquiry();
      $form->query_from = $request->query_from;
      $form->name = $request->name;
      $form->email = $request->email;
      $form->mobile = $request->mobile;
      $form->location = $request->subject;
      $form->message = $request->message;
      $form->save();

      // Send email
      // $emails = $this->mailAddress();
      // $emailTo = $emails['to'];
      // $email_cc = $emails['cc'];

      // $emailSubject = 'New Subscriber Request Received';
      // $emailBody = 'Please note there is a new subscription request.';

      // $this->communicationService->mail($emailTo, $emailSubject, $emailBody, [], '', '', $email_cc);

      // Session::flash('success', "Mail Sent.");
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
        'email' => 'required|email',
        'fake_entry' => 'nullable'
      ]
    );

    if ($validator->fails()) {
      return response()->json(['message' => $validator->errors()->first()], 422);
    }
    if ($request->filled('fake_entry')) {
      return response()->json(['message' => 'You are a Robot'], 422);
    }

    try {
      // Check for existing subscriber
      $existingUser = Subscibers::where('email', $request->email)->first();
      if ($existingUser) {
        return response()->json(['message' => 'This email is already subscribed'], 422);
      }

      // Save new subscriber
      $form = new Subscibers;
      $form->email = $request->email;
      $form->save();

      // Prepare and send email
      // $emails = $this->mailAddress();
      // $emailTo = $emails['to'];
      // $email_cc = $emails['cc'];

      // $emailSubject = 'New Subscriber Request Received';
      // $emailBody = 'Please note there is a new subscription request.';

      // $this->communicationService->mail($emailTo, $emailSubject, $emailBody, [], '', '', $email_cc);

      // Session::flash('success', "Mail Sent.");

      return response()->json(['message' => 'Thank you for subscribing!'], 200);
    } catch (\Exception $e) {
      // Log the error if necessary for debugging
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

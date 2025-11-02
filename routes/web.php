<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Auth\{RegisterController, LoginController};
use App\Http\Controllers\Front\{
    HomeController,
    ProductController,
    CartController,
    WishlistController,
    PaymentController,
    ShopController,
    OrderController,
    GoogleSheetExportController,
    FormController
};

// Home & Static Pages
Route::get('/', [HomeController::class, 'homePage'])->name('homePage');
Route::get('contact-us', [HomeController::class, 'contuctUs'])->name('contuct-us');
Route::get('about-us', [HomeController::class, 'aboutUs'])->name('about-us');

// Products / Shop
Route::get('products', [ShopController::class, 'products'])->name('products');
Route::get('product/{slug}', [ShopController::class, 'product'])
    ->name('product')
    ->where('slug', '[a-zA-Z0-9-]+');


// Contact & Subscription Forms
Route::post('contactus-form', [FormController::class, 'contactUsForm'])->name('contactus.form');
Route::post('subscribe-form', [FormController::class, 'subscribeForm'])->name('subscribe.form');

// Misc
Route::get('form-save', [FormController::class, 'formsave'])->name('form.save');

Route::get('cart', [CartController::class, 'cart'])->name('cart');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
Route::post('/cart/remove', [CartController::class, 'removeItem'])->name('cart.removeItem');
Route::post('/cart/header', [CartController::class, 'cartHeader'])->name('cart.header');

// WishList 
Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
Route::post('/wishlist/remove', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');

Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/return-refund', [HomeController::class, 'returnRefund'])->name('return.refund');

// --------------------
// Authenticated & Verified User Routes
// --------------------
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('checkout/process', [OrderController::class, 'doOrder'])->name('checkout.process');
    Route::get('thank-you', [OrderController::class, 'thankyou'])->name('thank.you');

    // Payment
    Route::post('/create-payment-intent', [PaymentController::class, 'createPaymentIntent']);
});

// Order WhatsApp
Route::get('/order-whatsapp/{order}', [ShopController::class, 'orderOnWhatsapp']);
Route::post('/chatbotSave', [FormController::class, 'saveChat'])->name('chatbot.save');


// --------------------
// Email Verification Routes
// --------------------
Route::middleware('auth')->group(function () {
    // Verification notice
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    // Handle verification link
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/')->with('success', 'Email verified successfully!');
    })->middleware(['signed'])->name('verification.verify');

    // Resend verification email
    Route::post('/email/verification-notification', function () {
        request()->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->name('verification.send');
});

// --------------------
// Admin / Misc Routes
// --------------------
Route::get('/admin/notifications', function () {
    return 'Notifications page coming soon!';
})->name('admin.notifications');

Route::get('/test-email', function () {
    Mail::raw('This is a test email', function ($message) {
        $message->to('theroyalgoswami@gmail.com')
            ->from('theroyalgoswami@gmail.com')
            ->subject('Test Email');
    });
    return 'Test email sent';
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/export-products', [GoogleSheetExportController::class, 'export']);
    Route::get('profile', [HomeController::class, 'profile'])->name('profile');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/sitemap.xml', function () {
    return response()->file(public_path('sitemap.xml'));
});

// route to view email templates
Route::get('/preview-welcome', function () {
    $user = (object)['name' => 'Test User'];
    $name = 'Test User';
    $data = siteSetting();
    $email = 'example@gmai.com';
    return view('emails.subscriber_welcome', compact('user', 'data', 'email', 'name'));
});
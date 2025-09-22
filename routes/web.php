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
    OrderController
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

// Auth (Login/Register)
Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'store'])->name('login.store');
Route::get('register', [RegisterController::class, 'show'])->name('register');
Route::post('register', [RegisterController::class, 'store'])->name('register.store');

// Contact & Subscription Forms
Route::post('contactus-form', [HomeController::class, 'contactUsForm'])->name('contactus.form');
Route::post('subscribe-form', [HomeController::class, 'subscribeForm'])->name('subscribe.form');

// Misc
Route::get('form-save', [HomeController::class, 'formsave'])->name('form.save');

Route::get('profile', [HomeController::class, 'profile'])->name('profile');

Route::get('cart', [CartController::class, 'cart'])->name('cart');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
Route::post('/cart/remove', [CartController::class, 'removeItem'])->name('cart.removeItem');
Route::post('/cart/header', [CartController::class, 'cartHeader'])->name('cart.header');

// WishList 
Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
Route::post('/wishlist/remove', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');

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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

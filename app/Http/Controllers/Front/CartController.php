<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Session;
use App\Models\{
    Product,
    CustomerAddress
};
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Services\Cart\CartService;
use Cart;

class CartController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function cart()
    {
        $cartItems  = Cart::instance('shopping')->content();
        $subtotal   = Cart::instance('shopping')->subtotal();
        $total      = Cart::instance('shopping')->total();
        $count      = Cart::instance('shopping')->count();

        return view('Front', [
            'view'      => "Templates.Cart",
            'cartItems' => $cartItems,
            'subtotal'  => $subtotal,
            'total'     => $total,
            'count'     => $count,
        ]);
    }

    public function cartHeader()
    {
        $cart = $this->cartService->cartSummary();
        return response()->json([
            'success'   => true,
            'message'   => 'Cart summary fetched successfully.',
            'data' => $cart,
        ]);
    }

    public function addToCart(Request $request)
    {
        try {
            $cart = $this->cartService->addProduct($request);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Product added to cart successfully.',
            'data' => $cart,
        ]);
    }

    public function updateQuantity(Request $request)
    {
        try {
            $cart = $this->cartService->updateProduct($request);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Product updated in cart successfully.',
            'data' => $cart,
        ]);
    }

    public function removeItem(Request $request)
    {
        try {
            $cart = $this->cartService->removeProduct($request);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Product updated in cart successfully.',
            'data' => $cart,
        ]);
    }


    public function checkout()
    {
        $cartItems  = Cart::instance('shopping')->content();
        $subtotal   = Cart::instance('shopping')->subtotal();
        $total      = Cart::instance('shopping')->total();

        $view = "Templates.Checkout";

        return view('Front', compact('view', 'cartItems', 'subtotal', 'total'));
    }



    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('code');
        $coupon = ProductCoupon::where('code', $couponCode)->first();

        $customerId = Auth::guard('customer')->id();
        $cartItems = Cart::instance('shopping')->content();
        $subtotal = (float) $cartItems->sum('sub_total');

        // ADD LOGGING HERE to debug values
        \Log::info('Coupon Validation Debug', [
            'subtotal'          => $subtotal,
            'coupon_code'       => $couponCode,
            'expire'            => $coupon?->expire,
            'minimum_amount'    => $coupon?->minimum_amount,
            'maximum_amount'    => $coupon?->maximum_amount,
            'now' => now(),
        ]);

        if (!$coupon || !$coupon->isValid($subtotal)) {
            return response()->json(['success' => false, 'message' => 'Coupon is not valid for this cart total.']);
        }

        $discount = $coupon->calculateDiscount($subtotal);
        $total = $subtotal - $discount;

        session([
            'coupon'                => $couponCode,
            'discount'              => $discount,
            'total_after_discount'  => $total,
        ]);

        return response()->json([
            'success' => true,
            'totals' => [
                'subtotal'  => number_format($subtotal, 2),
                'discount'  => number_format($discount, 2),
                'total'     => number_format($total, 2),
            ]
        ]);
    }
}

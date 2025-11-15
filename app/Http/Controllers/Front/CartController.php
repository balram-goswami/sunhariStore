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

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully.',
                'data' => $cart,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
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
        $user       = Auth()->id(); 
        $cartItems  = Cart::instance('shopping')->content();
        $subtotal   = Cart::instance('shopping')->subtotal();
        $total      = Cart::instance('shopping')->total();
        $address    = CustomerAddress::where('customer_id', $user)->get()->all();

        $view = "Templates.Checkout";
        return view('Front', compact('view', 'cartItems', 'subtotal', 'total', 'address'));
    }

    public function applyCoupon(Request $request) 
    {

    }
}

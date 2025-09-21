<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Product,
    ProductVariation,
    SubVariation,
    Cart
};
use Validator, DateTime, Config, Helpers, Hash, DB, Session, Auth, Redirect;


class CartController extends Controller
{
    

    public function index()
    {
        $breadcrumbs = [
            'title' => 'Cart',
            'metaTitle' => 'Cart',
            'metaDescription' => 'Cart',
            'metaKeyword' => 'Cart',
            'links' => [
                ['url' => url('/'), 'title' => 'Home']
            ]
        ];
        
        $view = 'Templates.Cart';
        return view('Front', compact('view', 'breadcrumbs'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $variation = $request->variation_id ? ProductVariation::findOrFail($request->variation_id) : null;

        if (Auth::check()) {
            $user = getCurrentUser();
            $visitor = null;
        } else {
            $user = null;
            $visitor = getCurrentVisitor();
        }

        $query = Cart::where('post_id', $product->id)
            ->when($variation, fn($q) => $q->where('variation_id', $variation->id));

        if ($user) {
            $query->where('user_id', $user->user_id);
        } elseif ($visitor) {
            $query->where('visitor_id', $visitor->id);
        }

        $existingCart = $query->first();

        if ($existingCart) {
            $existingCart->quantity += $request->quantity;
            $existingCart->save();
        } else {
            $saveCart = new Cart();
            $saveCart->user_id      = $user ? $user->user_id : null;
            $saveCart->visitor_id   = $visitor ? $visitor->id : null;
            $saveCart->post_id      = $product->id;
            $saveCart->quantity     = $request->quantity;
            $saveCart->save();
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart',
                'cart_count' => Cart::when($user, fn($q) => $q->where('user_id', $user->id))
                    ->when($visitor, fn($q) => $q->where('visitor_id', $visitor->id))
                    ->count()
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart');
    }

    public function removeFromCart($itemId, Request $request)
    {
        $cart = Session::get('cart', []);


        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Product removed from cart',
                'cart_count' => count($cart),
                'cart' => $cart
            ]);
        }

        return redirect()->back()->with('success', 'Product removed from cart');
    }

    public function updateCart(Request $request)
    {
        $cart = Session::get('cart', []);
        if ($request->cartItems) {
            foreach ($request->cartItems as $itemId => $quantity) {
                if (isset($cart[$itemId])) {
                    $cart[$itemId]['quantity'] = $quantity;
                }
            }
        }
        Session::put('cart', $cart);

        Session::flash('success', 'Cart updated');
        return redirect()->back();
    }



    public function checkout()
    {
        $breadcrumbs = [
            'title' => 'Checkout',
            'metaTitle' => 'Checkout',
            'metaDescription' => 'Checkout',
            'metaKeyword' => 'Checkout',
            'links' => [
                ['url' => url('/'), 'title' => 'Home']
            ]
        ];
        $view = 'Templates.Checkout';
        $countries = $this->commonService->getCountry();
        return view('Front', compact('view', 'breadcrumbs', 'countries'));
    }
}

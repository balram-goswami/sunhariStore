<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function add(Request $request) {
        Wishlist::create([
            'product_id' => $request->product_id,
        ]);
        return redirect()->back();
    }
    
}

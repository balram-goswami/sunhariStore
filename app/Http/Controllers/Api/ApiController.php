<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    Order
};

class ApiController extends Controller
{
    public function myAccountData(Request $request)
    {
        $user = $request->user();
        $products = $user->products()->get();
        $customers = $user->customers()->get();

        $orders = $customers->isNotEmpty()
            ? Order::whereIn('customer_id', $customers->pluck('id'))->get()
            : collect();

        return response()->json([
            'status' => true,
            'data' => [
                'products' => $products,
                'customers' => $customers,
                'orders' => $orders,
            ]
        ], 200);
    }
}

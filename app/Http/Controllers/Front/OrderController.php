<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, DateTime, Config, Helpers, Hash, DB, Session, Auth, Redirect;
use JWTAuth;
use App\Models\{User, CustomerAddress, Order};
use App\Services\OrderService;


class OrderController extends Controller
{

    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function doOrder(Request $request, OrderService $orderService)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'nullable|string',
            'lname' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            "line1" => 'nullable|string',
            "city" => 'nullable|string',
            "state" => 'nullable|string',
            "postal_code" => 'nullable|string',
            "country" => 'nullable|string',
            "note" => 'nullable|string',
            "payment_method" => 'nullable|string',
            "address_id" =>  'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $result = $orderService->placeOrder($request);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 500);
        }

        return redirect()->route('order.complete', [
            'order_id' => $result['order']->id,
            'password' => $request->password, // SEND PASSWORD TO THANK YOU PAGE
        ]);
    }

    public function orderComplete(Request $request)
    {
        $order = Order::where('id', $request->order_id)->first();
        $password = $request->password;
        $customer = User::where('id', $order->user_id)->get()->first();

        if (!$order) {
            abort(404);
        }

        $view = "Templates.OrderComplete";
        return view('Front', compact('view', 'order', 'password', 'customer'));
    }

    public function orderView($id)
    {
        $order = Order::with(['products', 'customer', 'billing', 'shipping'])->findOrFail($id);

        $view = "profile.order-view";
        return view('Front', compact('view', 'order'));
    }

    public function downloadInvoice($id)
    {
        $order = Order::with('products', 'customer')->findOrFail($id);

        $pdf = \PDF::loadView('profile.invoice', compact('order'))
            ->setPaper('a4')
            ->setOption('margin-bottom', 5);

        return $pdf->download('Invoice-' . $order->id . '.pdf');
    }
}

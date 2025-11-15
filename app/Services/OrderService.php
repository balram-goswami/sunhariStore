<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderFee;
use App\Models\OrderCoupon;
use App\Models\OrderShipping;
use App\Models\CustomerAddress;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Cart;

class OrderService
{
    public function placeOrder($request)
    {
        DB::beginTransaction();

        try {
            // LOGGED IN USER
            if (auth()->check()) {
                $user = auth()->user();
                $password = null;
                $billing = CustomerAddress::where('id', $request->address_id)->where('customer_id', $user->id)->first();
            } else {
                // GUEST USER CHECKOUT
                $password = $request->fname . '@' . substr($request->phone, -4);
                $user = User::firstOrCreate(
                    ['email' => $request->email],
                    [
                        'name'     => $request->fname . ' ' . $request->lname,
                        'phone'    => $request->phone,
                        'email_verified_at'    => now(),
                        'password' => bcrypt($password),
                    ]
                );

                $billing = CustomerAddress::create([
                    'customer_id' => $user->id,
                    'type'        => 'billing',
                    'fname'       => $request->fname,
                    'lname'       => $request->lname,
                    'email'       => $request->email,
                    'phone'       => $request->phone,
                    'line1'       => $request->line1,
                    'line2'       => $request->line2,
                    'city'        => $request->city,
                    'state'       => $request->state,
                    'postal_code' => $request->postal_code,
                    'country'     => $request->country,
                    'is_default'  => 1,
                ]);
            }

            // CART
            $items = Cart::instance('shopping')->content();
            $count = Cart::instance('shopping')->count();

            if ($count == 0) {
                return ['success' => false, 'message' => 'Cart is empty'];
            }

            $subTotal = 0;

            // CREATE ORDER
            $order = Order::create([
                'user_id'        => $user->id,
                'customer_id'    => $user->id,
                'ip'             => request()->ip(),
                'charge_tax'     => 0,
                'discount'       => 0,
                'coupon'       => 0,
                'billing_id'     => $billing->id,
                'shipping_id'    => $billing->id,
                'note'           => $request->note ?? '',
                'payment_type'   => $request->payment_method,
                'transaction_id' => uniqid(),
                'status'         => 0,
            ]);

            foreach ($items as $item) {

                $product = Product::find($item->id);

                if (!$product || $product->qty < $item->qty) {
                    return [
                        'success' => false,
                        'message' => "Stock not available for: {$product->name}"
                    ];
                }

                $lineTotal = $item->price * $item->qty;

                OrderProduct::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'name'       => $product->name,
                    'sku'        => $product->sku,
                    'price'      => $item->price,
                    'qty'        => $item->qty,
                    'total'      => $lineTotal,
                ]);

                $subTotal += $lineTotal;

                $product->decrement('qty', $item->qty);
            }

            // SHIPPING
            $shipping = 100;

            OrderShipping::create([
                'order_id' => $order->id,
                'name'     => 'Standard Shipping',
                'charge'   => $shipping,
                'method'   => 1,
                'tax'       => 0,
            ]);

            // UPDATE TOTALS
            $order->update([
                'net_sub_total'       => $subTotal,
                'net_shipping_amount' => $shipping,
                'net_total'           => $subTotal + $shipping,
            ]);

            Cart::instance('shopping')->destroy();

            DB::commit();

            return [
                'success'  => true,
                'order'    => $order,
                'password' => $password,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}

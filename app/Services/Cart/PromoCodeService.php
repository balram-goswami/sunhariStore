<?php

namespace App\Services\Cart;

use App\Models\ProductCoupon;
use Spatie\Multitenancy\Models\Tenant;

class PromoCodeService
{
    public function applyPromoCode(string $code)
    {
        $promo = $this->verifyPromoCode($code);

        $cart = Cart::instance('shopping');

        // Percentage discount
        if ($promo->type === 'percentage') {
            $cart->setGlobalDiscount($promo->value);
        }

        // Fixed discount
        if ($promo->type === 'fixed') {
            $condition = new \Darryldecode\Cart\CartCondition([
                'name' => $promo->code,
                'type' => 'promo',
                'target' => 'subtotal',
                'value' => '-' . $promo->value,
            ]);
            $cart->condition($condition);
        }

        return;
    }

    private function verifyPromoCode(string $code)
    {
        $promo = ProductCoupon::where('code', $code)->first();

        return (object)['value' => 10, 'type' => 'percentage'];
    }
}

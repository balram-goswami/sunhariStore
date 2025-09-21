<?php

namespace App\Services\Cart;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Spatie\Multitenancy\Models\Tenant;

class CartService
{
    protected $promoCodeService;

    public function __construct(PromoCodeService $promoCodeService)
    {
        $this->promoCodeService = $promoCodeService;
    }

    public function addProduct($request)
    {
        $product = $this->getProduct($request);

        Cart::instance('shopping')->add(
            $product['id'],
            $product['name'],
            $request->qty ?? 1,
            $product['final_price'],
            0,
            [
                'sku'        => $product['sku'],
                'image'      => $product['image'],
                'variant_id' => $product['variant_id'],
                'price'      => $product['price'],
                'sale_price' => $product['sale_price'],
                'attributes' => $product['attributes'],
            ]
        )->setTaxRate(0);

        return $this->cartSummary();
    }

    public function updateProduct($request)
    {
        Cart::instance('shopping')->update($request->rowId, $request->qty);
        return $this->cartSummary();
    }

    public function removeProduct($request)
    {
        Cart::instance('shopping')->remove($request->rowId);
        return $this->cartSummary();
    }

    public function applyPromoCode($request)
    {
        $this->promoCodeService->applyPromoCode($request->code);
        return $this->cartSummary();
    }

    public function getProduct($request): array
    {
        // Base product
        $product = Product::where('qty', '>=', $request->qty ?? 1)
            ->findOrFail($request->product_id);

        $variant = null;
        if ($request->variant_id) {
            $variant = $product
                ->variations()
                ->where('id', $request->variant_id)
                ->where('is_available', true)
                ->firstOrFail();
        }

        // Decide price & meta info
        $price = $variant ? $variant->price : $product->price;
        $salePrice = $variant ? $variant->sale_price : $product->sale_price;
        $sku = $variant ? $variant->sku : $product->sku;
        $attributes = $variant ? $variant->attributes : null;

        return [
            'id' => $product->id,
            'name' => $product->name,
            'final_price' => $salePrice > 0 ? $salePrice : $price,
            'price' => $price,
            'sale_price' => $salePrice,
            'variant_id' => $variant?->id,
            'sku' => $sku,
            'image' => $product->image ? $product->image_url : null,
            'attributes' => $attributes,
        ];
    }

    public function cartSummary()
    {
        $cart = Cart::instance('shopping');
        return [
            'currency' => 'USD',
            'symbol' => '$',
            'count' => $cart->count(),
            'total' => [
                'subtotal' => $cart->subtotal(2, '.', ','),
                'total' => $cart->total(2, '.', ','),
                'discount' => $cart->discount(2, '.', ','),
                'tax' => $cart->tax(2, '.', ','),
            ],
            'items' => $cart->content(),
        ];
    }
}

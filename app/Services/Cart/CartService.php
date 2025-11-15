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
        $productQty = Product::findOrFail($request->product_id);
        $qty = (int) $request->qty;

        // ✅ Check stock
        if ($qty > $productQty->qty) {
            throw new \Exception("Only {$productQty->qty} units available in stock.");
        }

        // ✅ Check if product already in cart
        $cartItems = Cart::instance('shopping')->content();
        $existingItem = $cartItems->first(function ($item) use ($product) {
            return $item->id == $product['id'] &&
                ($item->options->variant_id ?? null) == ($product['variant_id'] ?? null);
        });

        if ($existingItem && $existingItem->qty <= 2) {
            throw new \Exception("Product already added to cart.");
        }

        // ✅ Add to cart
        Cart::instance('shopping')->add(
            $product['id'],
            $product['name'],
            $qty ?? 1,
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

        // 🖼️ Image handling fix — if image is an array, take the first one
        $image = null;
        if (is_array($product->image)) {
            $image = $product->image[0] ?? null;
        } else {
            $image = $product->image;
        }

        // Optional: if you have image_url accessor or helper
        $imageUrl = $image ? (is_string($image) ? $image : $product->image_url) : null;

        return [
            'id' => $product->id,
            'name' => $product->name,
            'final_price' => $salePrice > 0 ? $salePrice : $price,
            'price' => $price,
            'sale_price' => $salePrice,
            'variant_id' => $variant?->id,
            'sku' => $sku,
            'image' => $imageUrl,
            'attributes' => $attributes,
        ];
    }

    public function cartSummary()
    {
        $cart = Cart::instance('shopping');
        return [
            'currency' => 'INR',
            'symbol' => '₹',
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

<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Cart;
use Exception;

class WishlistController extends Controller
{
    /**
     * ➕ Add Product to Wishlist
     */
    public function addToWishlist(Request $request)
    {
        try {
            $product = $this->getProduct($request);

            // Check if already in wishlist
            $exists = Cart::instance('wishlist')->search(function ($cartItem, $rowId) use ($product) {
                return $cartItem->id === $product['id'] && $cartItem->options->variant_id === $product['variant_id'];
            });

            if ($exists->isNotEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This product is already in your wishlist.',
                ]);
            }

            Cart::instance('wishlist')->add(
                $product['id'],
                $product['name'],
                1,
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

            return response()->json([
                'success' => true,
                'message' => 'Product added to your wishlist.',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * ❌ Remove Product from Wishlist
     */
    public function removeFromWishlist(Request $request)
    {
        try {
            $rowId = $request->input('rowId');
            $productId = $request->input('product_id');

            $wishlist = Cart::instance('wishlist')->content();

            // Find the item either by rowId or product_id
            $item = $wishlist->first(function ($wishlistItem) use ($rowId, $productId) {
                return $wishlistItem->rowId === $rowId || $wishlistItem->id == $productId;
            });

            if ($item) {
                Cart::instance('wishlist')->remove($item->rowId);

                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from wishlist.',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Item not found in wishlist.',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * 🧾 Extract & prepare product data
     */
    protected function getProduct(Request $request): array
    {
        $product = Product::where('qty', '>=', $request->qty ?? 1)
            ->findOrFail($request->product_id);

        $variant = null;
        if ($request->variant_id) {
            $variant = $product->variations()
                ->where('id', $request->variant_id)
                ->where('is_available', true)
                ->firstOrFail();
        }

        // Compute price and other meta
        $price = $variant->price ?? $product->price;
        $salePrice = $variant->sale_price ?? $product->sale_price;
        $sku = $variant->sku ?? $product->sku;
        $attributes = $variant->attributes ?? null;

        // Image handling
        $image = is_array($product->image)
            ? ($product->image[0] ?? null)
            : $product->image;

        $imageUrl = $image
            ? (is_string($image) ? asset('storage/' . $image) : ($product->image_url ?? null))
            : asset('images/default.jpg');

        return [
            'id'          => $product->id,
            'name'        => $product->name,
            'final_price' => $salePrice > 0 ? $salePrice : $price,
            'price'       => $price,
            'sale_price'  => $salePrice,
            'variant_id'  => $variant?->id,
            'sku'         => $sku,
            'image'       => $imageUrl,
            'attributes'  => $attributes,
        ];
    }
}

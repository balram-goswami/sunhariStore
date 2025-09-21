<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Models\{
    Product,
    ProductBrand,
    ProductCategory,
    ProductReview,
    ProductVariant
};
use Binafy\LaravelCart\LaravelCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Multitenancy\Models\Tenant;
use App\Services\Product\ProductService;

class ShopController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function products(Request $request)
    {
        if ($request->header('X-Ajax-Request') && $request->header('X-CSRF-TOKEN') == csrf_token()) {

            try {
                $products = $this->productService->getProducts($request);

                return response()->json([
                    'products' => $this->productService->getProductsCards($products),
                    'last_page' => $products->lastPage(),
                    'total_pages' => $products->total(),
                    'current_page' => $products->currentPage(),
                    'from' => $products->firstItem(),
                    'to' => $products->lastItem(),
                ]);
            } catch (\Exception $e) {
                Log::error($e);
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
        try {
            $brands = ProductBrand::where('status', 1)->get();
            $categories = ProductCategory::where('status', 1)->get();
            $products = $this->productService->getProducts($request);

            $view = 'Templates.Shop';
            return view('Front', compact('view', 'products', 'brands', 'categories'));
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function product(string $slug)
    {
        $product = Product::with([
            'variations',
            'reviews' => function ($query) {
                $query->where('is_approved', true)->with('customer');
            }
        ])
            ->where('status', 2)
            ->where('slug', $slug)
            ->first();

        if (!$product) {
            return redirect()->route('products', [], 301)->with('error', 'Product not found');
        }

        $categories = ProductCategory::whereIn('id', $product->category_id)->get();

        $relatedProduct = Product::where('status', 2)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->inRandomOrder()
            ->orderBy('id', 'desc')
            ->get();

        if ($product->has_variants) {
            $variants = $product->variations->map(function ($item) use ($product) {
                if ($item->is_available) {
                    return [
                        'id' => $product->id,
                        'variant_id' => $item->id,
                        'sku' => $item->sku,
                        'attributes' => collect($item->attributes ?? [])->mapWithKeys(function ($val, $key) {
                            return [strtolower($key) => strtolower($val)];
                        }),
                        'image' => $product->image_url,
                        'regularPrice' => (float) $item->price,
                        'salePrice' => (float) $item->sale_price,
                        'stock' => (int) $item->stock,
                    ];
                }
            })->values();
        } else {
            $variants = [
                'id' => $product->id,
                'sku' => $product->sku,
                'image' => $product->image_url,
                'regularPrice' => (float) $product->price,
                'salePrice' => (float) $product->sale_price,
                'stock' => (int) $product->qty,
            ];
        }

        $allproduct = Product::where('status', 2)->get();
        $view = 'Templates.ShopSingle';
        return view('Front', compact('view', 'product', 'relatedProduct', 'variants', 'categories', 'allproduct'));
    }

    public function reviewPost(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            return redirect()->route('customer.login')->with('danger', 'You must be logged in to leave a review.');
        }

        $existing = ProductReview::where('product_id', $request->product_id)
            ->where('customer_id', $customer->id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'You have already submitted a review for this product.');
        }

        ProductReview::create([
            'product_id' => $request->product_id,
            'customer_id' => $customer->id,
            'rating' => $request->rating,
            'review' => $request->review,
            'is_approved' => 0,
        ]);

        return redirect()->back()->with('success', 'Thank you for your review! It will appear after approval.');
    }

    public function orderOnWhatsapp($productId)
{
    try {
        $product = \App\Models\Product::findOrFail($productId);

        // Decide price
        $price = ($product->sale_price && $product->sale_price > 0) 
                 ? $product->sale_price 
                 : $product->price;

        // Friendly message
        $message = "✨ *New Order Alert!* ✨\n\n"
                 . "🛍 *Product:* {$product->name}\n"
                 . "🔢 *Quantity:* 1\n"
                 . "💰 *Price:* ₹{$price}\n";

        // Image handle
        $images = $product->image;
        if (is_string($images)) {
            $images = json_decode($images, true);
        }

        if (!empty($images) && is_array($images)) {
            $firstImage = asset('storage/' . ltrim($images[0], '/'));
            $message .= "\n🖼 *Product Image:* {$firstImage}\n";
        }

        $message .= "Confirm this Order by clicking on link \nThank you! 🙏";

        // WhatsApp link
        $link = "https://wa.me/919416497772?text=" . urlencode($message);

        return redirect()->away($link);

    } catch (\Exception $e) {
        \Log::error("WhatsApp order error: " . $e->getMessage());
        return redirect()->back()->with('error', 'Unable to send order on WhatsApp.');
    }
}

}

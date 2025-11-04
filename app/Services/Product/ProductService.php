<?php

namespace App\Services\Product;

use App\Models\Product;

class ProductService
{
    protected $sort_by_list = [
        'price_low_to_high' => ['price', 'asc'],
        'price_high_to_low' => ['price', 'desc'],
        'new_to_old' => ['id', 'desc'],
        'old_to_new' => ['id', 'asc'],
    ];

    protected $default_sort_by = 'new_to_old';

    public function getProducts($request)
    {
        $sort_by = $request->sort_by && isset($this->sort_by_list[$request->sort_by])
            ? $request->sort_by
            : $this->default_sort_by;

        return Product::
            //select('id', 'name', 'price', 'image', 'slug')
            where('status', 2)
            ->where(function ($query) use ($request) {
                if ($request->has('search')) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                }
                if ($request->has('categories') && $categories = explode(',', $request->categories)) {
                    foreach ($categories as $category) {
                        $query->whereJsonContains('category_id', (string) $category);
                    }
                }
                if ($request->has('brands') && $brands = explode(',', $request->brands)) {
                    foreach ($brands as $brand) {
                        $query->where('brand_id', (string) $brand);
                    }
                }
            })
            ->orderBy($this->sort_by_list[$sort_by][0], $this->sort_by_list[$sort_by][1])
            ->paginate(12);
    }

    public function getProductsCards($products)
    {
        if ($products->count() == 0) {
            return '';
        }
        return $products->map(function ($product) {
            return view('components.product-card', ['items' => $product])->render();
        })->join('');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductBrand extends Model
{
    protected $guarded = ['id'];
    protected $table = 'products_brands';

    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->title);
                $product->parent = 0;
                $product->counts = 0;
                $product->position = 0;
            }
        });

        static::updating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->title);
            }
        });

    }
}

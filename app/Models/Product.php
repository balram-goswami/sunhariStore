<?php

namespace App\Models;

use App\Models\Enums\ProductFeaturedStatus;
use App\Models\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->title);
            }
        });

        static::updating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->title);
            }
        });
    }

    protected $casts = [
        'sale_links'    => 'array',
        'category_id'   => 'array',
        'domain_ids'    => 'array',
        'brand_logo'    => 'array',
        'image'         => 'array',
        'spec'          => 'array',
        'tag'           => 'array',
        'featured'      => ProductFeaturedStatus::class,
        'status'        => ProductStatus::class
    ];

   

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function getCategoryNamesAttribute()
    {
        if (empty($this->category_id)) {
            return null;
        }

        return ProductCategory::whereIn('id', $this->category_id)
            ->pluck('name')
            ->implode(', ');
    }

    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'products_cats', 'category_id', 'product_id');
    }

    public function attributes()
    {
        return $this->hasMany(\App\Models\ProductAttribute::class);
    }

    public function variations()
    {
        return $this->hasMany(\App\Models\ProductVariation::class);
    }

    public function variantAttributeValues()
    {
        return $this->hasMany(ProductVariantAttributeValue::class, 'product_id', 'id');
    }

    public function getImageArrayAttribute()
    {
        return json_decode($this->attributes['image'] ?? '[]', true) ?: [];
    }
     public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCoupon extends Model
{
    protected $guarded = ['id'];
    protected $table = 'products_coupons';

    protected $fillable = [
        'user_id',
        'code',
        'about',
        'amount',
        'discount_type',
        'expire',
        'minimum_amount',
        'maximum_amount',
        'products',
        'exclude_products',
        'product_cat',
        'exclude_cat',
        'user_limit',
        'coupon_limit',
        'domain_id'
    ];
}

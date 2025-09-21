<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductShippingMethod extends Model
{
    protected $guarded = ['id'];
    protected $table = 'shipping_methods';

    public function zone()
    {
        return $this->belongsTo(ProductShippingZone::class, 'zone_id');
    }
}

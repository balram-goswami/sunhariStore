<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductShippingRegion extends Model
{
    protected $guarded = ['id'];
    protected $table = 'shipping_regions';

    public function zone()
    {
        return $this->belongsTo(ProductShippingZone::class, 'zone_id');
    }
}   

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductShippingZone extends Model
{
    protected $guarded = ['id'];
    protected $table = 'shipping_zones';

    public function regions()
    {
        return $this->hasMany(ProductShippingRegion::class, 'zone_id');
    }

    public function methods()
    {
        return $this->hasMany(ProductShippingMethod::class, 'zone_id');
    }
}

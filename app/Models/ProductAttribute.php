<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $fillable = ['product_id', 'attribute_id'];

    public function values()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    protected $fillable = ['product_attribute_id', 'attribute_value_id'];

    public function value()
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantAttributeValue extends Model
{
    protected $table = 'product_variant_attribute_value';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'attribute_value_id' => 'array',
    ];

    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class);
    }
}

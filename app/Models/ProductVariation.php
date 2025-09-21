<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $table = 'product_variants';

    protected $guarded = ['id'];

    protected $casts = [
        'attributes' => 'array',
        'dimensions' => 'array',
        'is_available' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected $appends = ['is_edited', 'is_deleted', 'is_outdated'];

    public function getIsEditedAttribute()
    {
        return true;
    }

    public function getIsDeletedAttribute()
    {
        return false;
    }

    public function getIsOutdatedAttribute()
    {
        return false;
    }
}

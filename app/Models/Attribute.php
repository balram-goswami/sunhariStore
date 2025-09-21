<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Attribute extends Model
{
    protected $guarded = ['id'];
    
    protected static function booted()
    {
        static::creating(function ($attribute) {
            $attribute->user_id = Auth::id();
        });

        static::updating(function ($attribute) {
            $attribute->user_id = Auth::id();
        });
    }

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
}

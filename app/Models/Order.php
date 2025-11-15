<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function billing()
    {
        return $this->belongsTo(CustomerAddress::class, 'billing_id');
    }

    public function shipping()
    {
        return $this->belongsTo(CustomerAddress::class, 'shipping_id');
    }
}

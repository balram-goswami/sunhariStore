<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function vendor()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function orders()
{
    return $this->hasMany(Order::class);
}
}

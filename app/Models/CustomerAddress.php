<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $table = 'customer_address';
    protected $fillable = [
        'customer_id',
        'type',
        'fname',
        'lname',
        'email',
        'phone',
        'line1',
        'line2',
        'city',
        'state',
        'postal_code',
        'country',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

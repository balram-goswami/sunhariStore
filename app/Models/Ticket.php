<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
   
    protected $fillable = [
        'user_id',
        'customer_id',
        'subject',
        'message',
        'response',
        'status',
        'domain_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

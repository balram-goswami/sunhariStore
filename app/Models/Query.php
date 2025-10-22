<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    protected $table = 'queries';

    protected $fillable = [
        'query_type',
        'user_id',
        'customer_id',
        'name',
        'email',
        'message',
        'number'
    ];
}

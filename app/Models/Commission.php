<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $table = 'commissions';
    protected $fillable = [
        'user_id',
        'type',
        'value',
        'min_amount',
        'max_amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

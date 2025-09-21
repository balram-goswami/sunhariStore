<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtForm extends Model
{
    protected $table = 'art_form';

    protected $fillable = [
        'title',
        'description',
        'qty',
        'status',
        'image',
        'user_id'
    ];

    protected $casts = [
        'image' => 'array',
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

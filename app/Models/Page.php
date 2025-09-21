<?php

namespace App\Models;

use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';
    protected $fillable = [
        'vendor_id',
        'title',
        'layout',
        'slug'
    ];

    protected $casts = [
        'layout' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }
}

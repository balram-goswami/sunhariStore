<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePageData extends Model
{
    protected $table = 'home_page_data';

    protected $fillable = [
        'user_id',
        
        'slider1_title',
        'slider1_header',
        'slider1_text',
        'slider1_image',
        'slider1_button_text',
        'slider1_button_url',

        'slider2_title',
        'slider2_header',
        'slider2_text',
        'slider2_image',
        'slider2_button_text',
        'slider2_button_url',
    ];

    protected $casts = [
        'slider1_image' => 'array',
        'slider2_image' => 'array',
    ];
}

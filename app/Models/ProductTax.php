<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTax extends Model
{
    protected $guarded = ['id'];
    protected $table = 'products_taxs';
}

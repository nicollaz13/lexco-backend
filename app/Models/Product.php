<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // los campos que se pueden llenar
    protected $fillable = [
        'name',
        'category',
        'description',
        'price',
        'stock'
    ];
}

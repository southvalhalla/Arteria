<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Products_sales extends Model
{
    protected $table = 'products_sales';
    protected $fillable = [
        'product_id',
        'sale_id',
        'name',
        'price',
        'quantity'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];


}

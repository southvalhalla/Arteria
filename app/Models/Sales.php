<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sales extends Model
{
    protected $table = 'sales';
    protected $fillable = [
        'cod',
        'date',
        'client_id',
        'status',
        'methods_payment_id',
        'products_from',
        'total',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    // public function sales_products(){
    //     return $this->belongsToMany(Products_sales::class,  'products_sales', 'sales_id');
    // }

    public function client(){
        return $this->belongsTo(Clients::class,  'client_id');
    }

    public function methods_payment(){
        return $this->belongsTo(Methods_payment::class, 'methods_payment_id');
    }

    public function products(){
        return $this->belongsToMany(Products::class, 'products_sales', 'sale_id', 'product_id')
        ->withPivot('quantity');
    }
}

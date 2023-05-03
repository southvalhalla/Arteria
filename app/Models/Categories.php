<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Products;

class Categories extends Model
{
    // use HasFactory;
    protected $fillable = [
        'category',
        'characteristics',
    ];

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function products(){
        return $this->hasMany(Products::class, 'category_id');
    }
}

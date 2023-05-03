<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Categories;

class Products extends Model
{
    protected $fillable = [
        'cod',
        'name',
        'trademark',
        'in_inventary',
        'category_id',
        'description',
        'price',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function category(){
        return $this->belongsTo(Categories::class);
    }
}

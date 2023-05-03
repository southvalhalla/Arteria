<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Sales;

class Methods_payment extends Model
{
    protected $fillable = [
        'type',
        'name',
        'lastName',
        'bank',
        'number_account',
        'expirate_date',
        'security_cod',
        'card_type',
    ];

    protected $table = 'methods_payment';
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function sales(){
        return $this->hasMany(Sales::class, 'methods_payment_id');
    }

}

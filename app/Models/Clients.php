<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Users;
use App\Models\Sales;
use App\Models\Document_type;

class Clients extends Model
{
    protected $fillable = [
        'document_type_id',
        'document_number',
        'names',
        'lastnames',
        'email',
        'phone',
        'address',
        'city',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    function users(){
        return $this->hasOne(Users::class, 'client_id');
    }

    function sales(){
        return $this->hasMany(Sales::class, 'client_id');
    }

    function document_type(){
        return $this->belongsTo(Document_type::class, 'document_type_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use  Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Users;

class Employees extends Model
{
    protected $table = 'employees';
    protected $fillable = [
        'document_type_id',
        'document_number',
        'names',
        'lastnames',
        'email',
        'phone',
        'job_id',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    function users(){
        return $this->hasOne(Users::class, 'employee_id');
    }
}

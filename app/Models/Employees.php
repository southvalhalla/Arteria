<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use  Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Users;
use App\Models\Document_Type;
use App\Models\Job;

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

    function document_type(){
        return $this->belongsTo(Document_Type::class, 'document_type_id');
    }

    function job(){
        return $this->belongsTo(Job::class, 'job_id');
    }
}

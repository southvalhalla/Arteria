<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Clients;

class Users extends Model
{
    protected $table = 'users';
    protected $fillable = [
        'client_id',
        'employee_id',
        'role_id',
        'email',
        'password',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function client(){
        return $this->belongsTo(Clients::class, 'client_id');
    }

    public function employee(){
        return $this->belongsTo(Employees::class, 'employee_id');
    }

    public function role(){
        return $this->belongsTo(Roles::class, 'role_id');
    }
}

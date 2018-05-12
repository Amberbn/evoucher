<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'frm_user_roles';

    protected $fillable = [
        'user_name',
        'roles_code',
        'created_by_user_name',
    ];
}

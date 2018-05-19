<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'frm_user_roles';
    protected $primaryKey = 'user_roled_id';

    protected $fillable = [
        'user_id',
        'roles_id',
        'created_by_user_name',
    ];
}

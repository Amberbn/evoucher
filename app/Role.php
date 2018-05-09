<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'frm_roles';

    protected $fillable = [
        'roles_code',
        'roles_description',
        'data_sort',
        'isactive',
        'isdelete',
        'created_by_user_name'
    ];
}

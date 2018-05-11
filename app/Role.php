<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'frm_roles';
    public $timestamps = false;

    protected $fillable = [
        'roles_code',
        'roles_description',
        'data_sort',
        'isactive',
        'isdelete',
        'created_by_user_name'
    ];

    public function scopeActive($query)
    {
        return $query->where('isactive','=',true);
    }
}

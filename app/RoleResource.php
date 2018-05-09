<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleResource extends Model
{
    protected $table = 'frm_roles_resources';

    protected $fillable = [
        'resources_code',
        'roles_code',
        'resources_reference',
        'resources_reference_id',
        'resource_operation',
        'created_by_user_name'
    ];
}

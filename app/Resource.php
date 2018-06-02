<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = 'frm_resources';
    public $timestamps = false;
    protected $primaryKey = 'resources_id';

    protected $fillable = [
        'roles_id',
        'resources_group',
        'resources_object',
        'resources_type',
        'resources_event',
        'resources_isallow',
        'resources_helper',
        'resources_description'
    ];
}

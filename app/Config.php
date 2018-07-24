<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'frm_config';
    protected $primaryKey = 'config_id';

    protected $fillable = [
        'config_name',
        'config_group_name',
        'config_value',
        'created_by_user_name',
        'last_updated_by_user_name',
    ];
}

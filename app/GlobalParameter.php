<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GlobalParameter extends Model
{
    protected $table = 'frm_global_parameters';

    protected $fillable = [
        'client_code',
        'parameters_type',
        'parameters_code',
        'parameters_value_datatype',
        'parameters_value',
        'parameters_parent_id',
        'data_sort',
        'isactive',
        'isdelete',
        'created_by_user_name',
        'last_updated_by_user_name',
    ];

    public function scopeActive($query)
    {
        return $query->where('isactive','=',true);
    }
}

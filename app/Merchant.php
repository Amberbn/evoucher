<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $table = 'mch_merchant';
    protected $primaryKey = 'merchant_id';

    protected $fillable = [
        'merchant_code',
        'client_id',
        'merchant_title',
        'merchant_bussiness_category_pid',
        'merchant_description',
        'merchant_tags',
        'data_sort',
        'isactive',
        'isdelete',
        'create_by_user_name',
        'user_password_force_reset_on_login',
        'user_password_is_intial',
        'created_by_user_name',
        'last_updated_by_user_name',
    ];
}

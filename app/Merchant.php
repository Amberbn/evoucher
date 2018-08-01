<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $table = 'mch_merchant';
    protected $primaryKey = 'merchant_id';

    protected $fillable = [
        'merchant_code',
        'merchant_logo_image_url',
        'merchant_client_id',
        'merchant_title',
        'merchant_bussiness_category_pid',
        'merchant_description',
        'merchant_socmed_url_facebook',
        'merchant_socmed_url_twitter',
        'merchant_socmed_url_linkedin',
        'merchant_socmed_url_instagram',
        'merchant_socmed_url_line',
        'merchant_socmed_url_pinterest',
        'merchant_tags',
        'data_sort',
        'isactive',
        'isdelete',
        'created_by_user_name',
        // 'user_password_force_reset_on_login',
        // 'user_password_is_intial',
        'last_updated_by_user_name',
    ];

    public function scopeActive($query)
    {
        return $query->where('isactive', '=', true);
    }
}

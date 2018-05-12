<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'bsn_client';
    protected $primaryKey = 'client_id';

    protected $fillable = [
        'client_code',
        'client_category_pid',
        'client_is_also_merchant',
        'client_allow_postpaid',
        'client_name',
        'client_tax_no',
        'client_billing_address_line_1',
        'client_billing_address_line_2',
        'client_billing_address_state_province_pid',
        'client_billing_address_city_pid',
        'client_billing_address_postal_code',
        'client_industry_category_pid',
        'client_employee_size_category_pid',
        'client_outstanding_limit',
        'isactive',
        'isdelete',
        'created_by_user_name',
        'last_updated_by_user_name',
    ];

    public function scopeActive($query)
    {
        return $query->where('isactive', '=', true);
    }

}

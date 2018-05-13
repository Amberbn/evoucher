<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $table = "mch_outlets";
    protected $primaryKey = "merchant_id";

    protected $fillable = [
        'client_id',
        'outlets_title',
        'outlets_email',
        'outlets_phone',
        'outlets_description',
        'outlets_address_line',
        'outlets_address_province_pid',
        'outlets_address_city_pid',
        'client_billing_address_region_pid',
        'outlets_location_coordinates',
        'outlets_auth_code',
        'data_sort',
        'isactive',
        'isdelete',
        'create_by_user_name',
        'last_modified_by_user_name',
    ];
}

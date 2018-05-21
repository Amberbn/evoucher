<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = "vou_voucher";
    protected $primaryKey = "voucher_id";

    protected $fillable = [
        'voucher_catalog_id',
        'voucher_catalog_revision_no',
        'campaign_id',
        'merchant_client_id',
        'voucher_sku_code',
        'voucher_title',
        'voucher_main_image_url',
        'voucher_information',
        'voucher_terms_and_condition',
        'voucher_instruction_customer',
        'voucher_instruction_outlet',
        'voucher_valid_start_date',
        'voucher_valid_end_date',
        'voucher_tags',
        'voucher_amount',
        'voucher_value_point',
        'voucher_unit_price_amount',
        'voucher_unit_price_point',
        'voucher_status',
        'data_sort',
        'isactive',
        'isdelete',
        'created_by_user_name',
        'last_updated_by_user_name',
    ];
}

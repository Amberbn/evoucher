<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherCatalog extends Model
{
    protected $table = "vou_voucher_catalog";
    protected $primaryKey = "voucher_catalog_id";

    protected $fillable = [
        'voucher_catalog_revision_no',
        'merchant_client_id',
        'voucher_catalog_sku_code',
        'voucher_catalog_title',
        'voucher_catalog_main_image_url',
        'voucher_catalog_information',
        'voucher_catalog_terms_and_condition',
        'voucher_catalog_instruction_customer',
        'voucher_catalog_instruction_outlet',
        'voucher_catalog_valid_start_date',
        'voucher_catalog_valid_end_date',
        'voucher_catalog_tags',
        'voucher_catalog_value_amount',
        'voucher_catalog_value_point',
        'voucher_catalog_unit_price_amount',
        'voucher_catalog_unit_price_point',
        'voucher_catalog_stock_level',
        'voucher_status',
        'data_sort',
        'isactive',
        'isdelete',
        'created_by_user_name',
        'last_updated_by_user_name',
    ];
}

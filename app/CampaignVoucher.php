<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignVoucher extends Model
{
    protected $table = 'bsn_campaign_vouchers';
    protected $primaryKey = 'campaign_voucher_id';
    public $timestamps = false;

    protected $fillable = [
        'voucher_catalog_id',
        'campaign_id',
        'client_id',
        'voucher_catalog_revision_no',
        'merchant_client_id',
        'campaign_voucher_sku_code',
        'campaign_voucher_title',
        'campaign_voucher_main_image_url',
        'campaign_voucher_information',
        'campaign_voucher_terms_and_condition',
        'campaign_voucher_instruction_customer',
        'campaign_voucher_instruction_outlet',
        'campaign_voucher_valid_start_date',
        'campaign_voucher_valid_end_date',
        'campaign_voucher_tags',
        'campaign_voucher_unit_quantity',
        'campaign_voucher_unit_cogs_amount',
        'campaign_voucher_value_amount',
        'campaign_voucher_value_point',
        'campaign_voucher_unit_price_amount',
        'campaign_voucher_unit_price_point',
        'campaign_sms_charge_amount_subtotal',
        'campaign_sms_charge_point_subtotal',
        'campaign_voucher_value_amount_subtotal',
        'campaign_voucher_value_point_subtotal',
        'campaign_voucher_unit_price_amount_subtotal',
        'campaign_voucher_unit_price_point_subtotal',
        'data_sort',
        'created_at',
        'created_by_user_name',
        'campaign_voucher_isforclientonly',
        'campaign_voucher_category_pid',
        'campaign_voucher_short_information'
    ];

}

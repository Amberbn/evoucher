<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignVoucher extends Model
{
    protected $table = 'bsn_campaign_vouchers';
    protected $primaryKey = 'campaign_voucher_id';

    protected $fillable = [
        'voucher_catalog_id',
        'voucher_catalog_revision_no',
        'campaign_id',
        'client_id',
        'merchant_client_id',
        'campaign_voucher_unit_quantity',
        'campaign_voucher_value_amount',
        'campaign_voucher_value_point',
        'campaign_voucher_unit_price_amount',
        'campaign_voucher_unit_price_point',
        'campaign_voucher_value_amount_subtotal',
        'campaign_voucher_value_point_subtotal',
        'campaign_voucher_unit_price_amount_subtotal',
        'campaign_voucher_unit_price_point_subtotal',
    ];

}

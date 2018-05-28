<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignVoucherOutlet extends Model
{
    protected $table = 'bsn_campaign_voucher_outlets';
    protected $primaryKey = 'campaign_voucher_outets_id';
    public $timestamps = false;

    protected $fillable = [
        'campaign_voucher_id',
        'voucher_catalog_id',
        'campaign_id',
        'outlets_id',
        'merchant_id',
        'created_at',
        'created_by_user_name',
    ];

}

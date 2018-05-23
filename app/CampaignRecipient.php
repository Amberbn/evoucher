<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignRecipient extends Model
{
    protected $table = 'bsn_campaign_recipient';
    protected $primaryKey = 'campaign_recipient_id';

    protected $fillable = [
        'voucher_catalog_voucher_id',
        'campaign_id',
        'client_id',
        'campaign_recipient_salutation',
        'campaign_recipient_name',
        'campaign_recipient_phone',
        'campaign_recipient_email',
    ];

}

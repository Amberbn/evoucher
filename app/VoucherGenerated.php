<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherGenerated extends Model
{
    protected $table = 'vou_voucher_generated';
    protected $primaryKey = 'voucher_generated_id';
    public $timestamps = false;

    protected $fillable = [
        'campaign_voucher_id',
        'voucher_generated_no',
        'campaign_id',
        'client_id',
        'campaign_recipient_id',
        'campaign_recipient_salutation',
        'campaign_recipient_name',
        'campaign_recipient_phone',
        'campaign_recipient_email',
        'voucher_generated_is_redeemed',
        'voucher_generated_redeem_id',
        'voucher_generated_locked_till',
    ];

}

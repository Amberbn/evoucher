<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Redeem extends Model
{
    protected $table = "vou_redeem";
    protected $primaryKey = "redeem_id";

    protected $fillable = [
        'redeem_id',
        'voucher_generated_id',
        'voucher_generated_no',
        'redeem_is_approved',
        'outlets_id',
        'merchant_id',
        'redeem_request_id',
        'redeem_status_code',
        'redeem_failure_code',
    ];    
}

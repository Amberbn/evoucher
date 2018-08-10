<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherDistributionTracker extends Model
{
    protected $table = 'vou_voucher_distribution_tracker';
    protected $primaryKey = 'voucher_distribution_tracker_id';

    protected $fillable = [
        'voucher_generated_id',
        'voucher_id',
        'voucher_generated_no',
        'voucher_distribution_type',
        'voucher_distribution_execution_timestamp',
        'voucher_distribution_reference_id',
        'voucher_distribution_respond_code',
        'voucher_distribution_respond_message',
        'voucher_distributionrespond_timestamp',
        'created_by_user_name',
        'last_updated_by_user_name',
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table = 'bsn_campaign';
    protected $primaryKey = 'campaign_id';

    protected $fillable = [
        'campaign_code',
        'client_id',
        'campaign_category_pid',
        'campaign_wizzard_current_step',
        'campaign_pay_using_point',
        'campaign_title',
        'campaign_message_title',
        'campaign_message_body',
        'campaign_message_sms',
        'campaign_method_is_postpaid',
        'campaign_period_start_date',
        'campaign_period_end_date',
        'campaign_distribute_by_email',
        'campaign_distribute_by_sms',
        'campaign_total_sms_charge_amount',
        'campaign_total_sms_charge_point',
        'campaign_voucher_unit_quantity_grandtotal',
        'campaign_voucher_value_amount_grandtotal',
        'campaign_voucher_value_point_grandtotal',
        'campaign_voucher_unit_price_amount_grandtotal',
        'campaign_voucher_unit_price_point_grandtotal',
        'campaign_status',
        'data_sort',
        'isactive',
        'isdelete',
        'created_by_user_name',
        'last_updated_by_user_name',
    ];

}

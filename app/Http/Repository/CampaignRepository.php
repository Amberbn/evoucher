<?php
namespace App\Repository;

use App\Campaign;
use App\CampaignRecipient;
use App\Campaignvoucher;

class CampaignRepository
{
    use \App\Http\Controllers\Contract\UserTrait;

    public function __construct()
    {
        $this->model = new Campaign;
        $this->campaignVoucher = new CampaignVoucher;
        $this->campaignRecipient = new CampaignRecipient;
    }

    public function store($request)
    {
        $campaign = $this->campaign;
        $campaign->campaign_code = $request->input('campaign_code');
        $campaign->client_id = $request->input('client_id');
        $campaign->campaign_category_pid = $request->input('campaign_category_pid');
        $campaign->campaign_wizzard_current_step = $request->input('campaign_wizzard_current_step');
        $campaign->campaign_pay_using_point = $request->input('campaign_pay_using_point') ?: false;
        $campaign->campaign_title = $request->input('campaign_title');
        $campaign->campaign_message_title = $request->input('campaign_message_title');
        $campaign->campaign_message_body = $request->input('campaign_message_body');
        $campaign->campaign_message_sms = $request->input('campaign_message_sms');
        $campaign->campaign_method_is_postpaid = $request->input('campaign_method_is_postpaid') ?: false;
        $campaign->campaign_period_start_date = $request->input('campaign_period_start_date') ?: NOW();
        $campaign->campaign_period_end_date = $request->input('campaign_period_end_date');
        $campaign->campaign_distribute_by_email = $request->input('campaign_distribute_by_email') ?: false;
        $campaign->campaign_distribute_by_sms = $request->input('campaign_distribute_by_sms') ?: false;
        $campaign->campaign_total_sms_charge_amount = $request->input('campaign_total_sms_charge_amount') ?: 0;
        $campaign->campaign_total_sms_charge_point = $request->input('campaign_total_sms_charge_point') ?: 0;
        $campaign->campaign_voucher_unit_quantity_grandtotal = 0;
        $campaign->campaign_voucher_value_amount_grandtotal = 0;
        $campaign->campaign_voucher_value_point_grandtotal = 0;
        $campaign->campaign_voucher_unit_price_amount_grandtotal = 0;
        $campaign->campaign_voucher_unit_price_point_grandtotal = 0;
        $campaign->status = 'DRAFT';
        $campaign->data_sort = $request->input('data_sort') ?: 1000;
        $campaign->isactive = $request->input('isactive') ?: true;
        $campaign->isdelete = $request->input('isdelete') ?: false;
        $campaign->created_by_user_name = $this->loginUsername();
        $campaign->save();
    }
}

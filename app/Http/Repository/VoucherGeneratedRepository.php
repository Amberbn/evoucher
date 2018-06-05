<?php
namespace App\Repository;

use App\Repository\BaseRepository;
use App\VoucherGenerated;
use DB;

class VoucherGeneratedRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new VoucherGenerated;
    }

    public function getVoucherGenerated($campaignId)
    {
        try {
            DB::beginTransaction();

            $vouchers = DB::table('vw_voucher_generated')
                ->where('campaign_id', $campaignId)->get();

            foreach ($vouchers as $voucher) {
                $vouchergenerate = new VoucherGenerated;
                $vouchergenerate->campaign_voucher_id = $voucher->campaign_voucher_id;
                $vouchergenerate->voucher_generated_no = $voucher->voucher_generated_no;
                $vouchergenerate->campaign_id = $voucher->campaign_id;
                $vouchergenerate->client_id = $voucher->client_id;
                $vouchergenerate->campaign_recipient_id = $voucher->campaign_recipient_id;
                $vouchergenerate->campaign_recipient_salutation = $voucher->campaign_recipient_salutation;
                $vouchergenerate->campaign_recipient_name = $voucher->campaign_recipient_name;
                $vouchergenerate->campaign_recipient_phone = $voucher->campaign_recipient_phone;
                $vouchergenerate->campaign_recipient_email = $voucher->campaign_recipient_email;
                $vouchergenerate->voucher_generated_is_redeemed = $voucher->voucher_generated_is_redeemed;
                $vouchergenerate->voucher_generated_redeem_id = $voucher->voucher_generated_redeem_id;
                $vouchergenerate->voucher_generated_locked_till = $voucher->voucher_generated_locked_till;
                $vouchergenerate->save();
            }

            DB::commit();
            return $this->sendCreated();

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->throwErrorException($e);

        }

    }

}
